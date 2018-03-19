<?php
/*************************************************************************************/
/*      Copyright (c) Franck Allimant, CQFDev                                        */
/*      email : thelia@cqfdev.fr                                                     */
/*      web : http://www.cqfdev.fr                                                   */
/*                                                                                   */
/*      For the full copyright and license information, please view the LICENSE      */
/*      file that was distributed with this source code.                             */
/*************************************************************************************/

namespace MondialRelay\Controller\BackOffice;

use MondialRelay\Model\MondialRelayDeliveryPrice;
use MondialRelay\Model\MondialRelayDeliveryPriceQuery;
use Thelia\Controller\Admin\BaseAdminController;
use Thelia\Core\Security\AccessManager;
use Thelia\Core\Security\Resource\AdminResources;
use Thelia\Log\Tlog;

/**
 * @author Franck Allimant <franck@cqfdev.fr>
 */
class PriceController extends BaseAdminController
{
    public function saveAction($areaId, $moduleId)
    {
        if (null !== $response = $this->checkAuth(AdminResources::MODULE, 'MondialRelay', AccessManager::UPDATE)) {
            return $response;
        }

        $form = $this->createForm('mondialrelay.prices_update_form');

        $errorMessage = false;

        try {
            $viewForm = $this->validateForm($form);

            $data = $viewForm->getData();

            MondialRelayDeliveryPriceQuery::create()->filterByAreaId($areaId)->delete();

            foreach ($data['max_weight'] as $key => $value) {
                (new MondialRelayDeliveryPrice())
                    ->setAreaId($areaId)
                    ->setMaxWeight($value)
                    ->setPriceWithTax($data['price'][$key])
                    ->save();
            }

        } catch (\Exception $ex) {
            $errorMessage = $ex->getMessage();

            Tlog::getInstance()->error("Failed to validate price form: $errorMessage");
        }

        return $this->render('mondialrelay/ajax/prices', [
            'module_id' => $moduleId,
            'error_message' => $errorMessage
        ]);
    }

    public function createAction($areaId, $moduleId)
    {
        if (null !== $response = $this->checkAuth(AdminResources::MODULE, 'MondialRelay', AccessManager::UPDATE)) {
            return $response;
        }

        $form = $this->createForm('mondialrelay.price_form');

        $errorMessage = false;

        try {
            $viewForm = $this->validateForm($form);

            $data = $viewForm->getData();

            MondialRelayDeliveryPriceQuery::create()->filterByMaxWeight($data['max_weight'])->delete();

            (new MondialRelayDeliveryPrice())
                ->setAreaId($areaId)
                ->setPriceWithTax($data['price'])
                ->setMaxWeight($data['max_weight'])
                ->save();
        } catch (\Exception $ex) {
            $errorMessage = $ex->getMessage();

            Tlog::getInstance()->error("Failed to validate price form: $errorMessage");
        }

        return $this->render('mondialrelay/ajax/prices', [
            'module_id' => $moduleId,
            'error_message' => $errorMessage
        ]);
    }

    /**
     * @param $insuranceId
     * @return mixed|\Thelia\Core\HttpFoundation\Response
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function deleteAction($priceId, $moduleId)
    {
        if (null !== $response = $this->checkAuth(AdminResources::MODULE, 'MondialRelay', AccessManager::DELETE)) {
            return $response;
        }

        MondialRelayDeliveryPriceQuery::create()->filterById($priceId)->delete();

        return $this->render('mondialrelay/ajax/prices', [ 'module_id' => $moduleId ]);
    }
}
