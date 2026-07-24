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
use MondialRelay\Form\InsuranceCreateForm;
use MondialRelay\Form\InsurancesUpdateForm;
use MondialRelay\Model\MondialRelayDeliveryInsurance;
use MondialRelay\Model\MondialRelayDeliveryInsuranceQuery;
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
class InsuranceController extends BaseAdminController
{
    public function saveAction(): Response
    {
        if (null !== $response = $this->checkAuth(AdminResources::MODULE, 'MondialRelay', AccessManager::UPDATE)) {
            return $response;
        }

        $form = $this->createForm(InsurancesUpdateForm::getName());

        $errorMessage = null;

        try {
            $data = $this->validateForm($form)->getData();

            foreach ($data['max_value'] as $key => $value) {
                if (null !== $insurance = MondialRelayDeliveryInsuranceQuery::create()->findPk($key)) {
                    $insurance
                        ->setMaxValue((string) $value)
                        ->setPriceWithTax((string) $data['price_with_tax'][$key])
                        ->save();
                }
            }
        } catch (\Exception $ex) {
            $errorMessage = $ex->getMessage();

            Tlog::getInstance()->error("Failed to validate insurances form: $errorMessage");
        }

        return $this->redirectToInsurances($errorMessage);
    }

    public function createAction(): Response
    {
        if (null !== $response = $this->checkAuth(AdminResources::MODULE, 'MondialRelay', AccessManager::UPDATE)) {
            return $response;
        }

        $form = $this->createForm(InsuranceCreateForm::getName());

        $errorMessage = null;

        try {
            $data = $this->validateForm($form)->getData();

            MondialRelayDeliveryInsuranceQuery::create()->filterByMaxValue((string) $data['max_value'])->delete();

            (new MondialRelayDeliveryInsurance())
                ->setPriceWithTax((string) $data['price_with_tax'])
                ->setMaxValue((string) $data['max_value'])
                ->save();
        } catch (\Exception $ex) {
            $errorMessage = $ex->getMessage();

            Tlog::getInstance()->error("Failed to validate insurances form: $errorMessage");
        }

        return $this->redirectToInsurances($errorMessage);
    }

    public function deleteAction(int $insuranceId): Response
    {
        if (null !== $response = $this->checkAuth(AdminResources::MODULE, 'MondialRelay', AccessManager::DELETE)) {
            return $response;
        }

        $errorMessage = null;

        try {
            // Validates the CSRF token carried by the delete form.
            $this->validateForm($this->createForm(DeleteForm::getName()));

            MondialRelayDeliveryInsuranceQuery::create()->filterById($insuranceId)->delete();
        } catch (\Exception $ex) {
            $errorMessage = $ex->getMessage();

            Tlog::getInstance()->error("Failed to delete insurance: $errorMessage");
        }

        return $this->redirectToInsurances($errorMessage);
    }

    private function redirectToInsurances(?string $errorMessage): Response
    {
        if (null !== $errorMessage) {
            $session = $this->getSession();
            if ($session instanceof FlashBagAwareSessionInterface) {
                $session->getFlashBag()->add('danger', $errorMessage);
            }
        }

        return $this->generateRedirect(
            URL::getInstance()->absoluteUrl('/admin/module/MondialRelay', ['tab' => 'insurances'])
        );
    }
}
