<?php
/*************************************************************************************/
/*      Copyright (c) Franck Allimant, CQFDev                                        */
/*      email : thelia@cqfdev.fr                                                     */
/*      web : http://www.cqfdev.fr                                                   */
/*                                                                                   */
/*      For the full copyright and license information, please view the LICENSE      */
/*      file that was distributed with this source code.                             */
/*************************************************************************************/

declare(strict_types=1);

namespace MondialRelay\Controller\BackOffice;

use MondialRelay\Form\DeleteForm;
use MondialRelay\Form\PriceCreateForm;
use MondialRelay\Form\PricesUpdateForm;
use MondialRelay\Model\MondialRelayDeliveryPrice;
use MondialRelay\Model\MondialRelayDeliveryPriceQuery;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\FlashBagAwareSessionInterface;
use Thelia\Controller\Admin\BaseAdminController;
use Thelia\Core\Security\AccessManager;
use Thelia\Core\Security\Resource\AdminResources;
use Thelia\Log\Tlog;
use Thelia\Tools\URL;

/**
 * @author Franck Allimant <franck@cqfdev.fr>
 */
class PriceController extends BaseAdminController
{
    public function saveAction(int $areaId, int $moduleId): Response
    {
        if (null !== $response = $this->checkAuth(AdminResources::MODULE, 'MondialRelay', AccessManager::UPDATE)) {
            return $response;
        }

        $form = $this->createForm(PricesUpdateForm::getName());

        $errorMessage = null;

        try {
            $data = $this->validateForm($form)->getData();

            MondialRelayDeliveryPriceQuery::create()->filterByAreaId($areaId)->delete();

            foreach ($data['max_weight'] as $key => $value) {
                (new MondialRelayDeliveryPrice())
                    ->setAreaId($areaId)
                    ->setMaxWeight((string) $value)
                    ->setPriceWithTax((string) $data['price'][$key])
                    ->save();
            }
        } catch (\Exception $ex) {
            $errorMessage = $ex->getMessage();

            Tlog::getInstance()->error("Failed to validate price form: $errorMessage");
        }

        return $this->redirectToPrices($errorMessage);
    }

    public function createAction(int $areaId, int $moduleId): Response
    {
        if (null !== $response = $this->checkAuth(AdminResources::MODULE, 'MondialRelay', AccessManager::UPDATE)) {
            return $response;
        }

        $form = $this->createForm(PriceCreateForm::getName());

        $errorMessage = null;

        try {
            $data = $this->validateForm($form)->getData();

            MondialRelayDeliveryPriceQuery::create()
                ->filterByAreaId($areaId)
                ->filterByMaxWeight((string) $data['max_weight'])
                ->delete();

            (new MondialRelayDeliveryPrice())
                ->setAreaId($areaId)
                ->setPriceWithTax((string) $data['price'])
                ->setMaxWeight((string) $data['max_weight'])
                ->save();
        } catch (\Exception $ex) {
            $errorMessage = $ex->getMessage();

            Tlog::getInstance()->error("Failed to validate price form: $errorMessage");
        }

        return $this->redirectToPrices($errorMessage);
    }

    public function deleteAction(int $priceId, int $moduleId): Response
    {
        if (null !== $response = $this->checkAuth(AdminResources::MODULE, 'MondialRelay', AccessManager::DELETE)) {
            return $response;
        }

        $errorMessage = null;

        try {
            // Validates the CSRF token carried by the delete form.
            $this->validateForm($this->createForm(DeleteForm::getName()));

            MondialRelayDeliveryPriceQuery::create()->filterById($priceId)->delete();
        } catch (\Exception $ex) {
            $errorMessage = $ex->getMessage();

            Tlog::getInstance()->error("Failed to delete price: $errorMessage");
        }

        return $this->redirectToPrices($errorMessage);
    }

    private function redirectToPrices(?string $errorMessage): Response
    {
        if (null !== $errorMessage) {
            $session = $this->getSession();
            if ($session instanceof FlashBagAwareSessionInterface) {
                $session->getFlashBag()->add('danger', $errorMessage);
            }
        }

        return $this->generateRedirect(
            URL::getInstance()->absoluteUrl('/admin/module/MondialRelay', ['tab' => 'prices'])
        );
    }
}
