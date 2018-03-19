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

use MondialRelay\Model\MondialRelayDeliveryInsurance;
use MondialRelay\Model\MondialRelayDeliveryInsuranceQuery;
use Thelia\Controller\Admin\BaseAdminController;
use Thelia\Core\Security\AccessManager;
use Thelia\Core\Security\Resource\AdminResources;
use Thelia\Log\Tlog;

/**
 * @author Franck Allimant <franck@cqfdev.fr>
 */
class InsuranceController extends BaseAdminController
{
    public function saveAction()
    {
        if (null !== $response = $this->checkAuth(AdminResources::MODULE, 'MondialRelay', AccessManager::UPDATE)) {
            return $response;
        }

        $form = $this->createForm('mondialrelay.insurances_update_form');

        $errorMessage = false;

        try {
            $viewForm = $this->validateForm($form);

            $data = $viewForm->getData();

            foreach ($data['max_value'] as $key => $value) {
                if (null !== $insurance = MondialRelayDeliveryInsuranceQuery::create()->findPk($key)) {
                    $insurance
                        ->setMaxValue($value)
                        ->setPriceWithTax($data['price_with_tax'][$key])
                        ->save();
                }
            }
        } catch (\Exception $ex) {
            $errorMessage = $ex->getMessage();

            Tlog::getInstance()->error("Failed to validate insurances form: $errorMessage");
        }

        return $this->render('mondialrelay/ajax/insurances', [ 'error_message' => $errorMessage ]);
    }

    public function createAction()
    {
        if (null !== $response = $this->checkAuth(AdminResources::MODULE, 'MondialRelay', AccessManager::UPDATE)) {
            return $response;
        }

        $form = $this->createForm('mondialrelay.insurance_create_form');

        $errorMessage = false;

        try {
            $viewForm = $this->validateForm($form);

            $data = $viewForm->getData();

            MondialRelayDeliveryInsuranceQuery::create()->filterByMaxValue($data['max_value'])->delete();

            (new MondialRelayDeliveryInsurance())
                ->setPriceWithTax($data['price_with_tax'])
                ->setMaxValue($data['max_value'])
                ->save();
        } catch (\Exception $ex) {
            $errorMessage = $ex->getMessage();

            Tlog::getInstance()->error("Failed to validate insurances form: $errorMessage");
        }

        return $this->render('mondialrelay/ajax/insurances', [ 'error_message' => $errorMessage ]);
    }

    /**
     * @param $insuranceId
     * @return mixed|\Thelia\Core\HttpFoundation\Response
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function deleteAction($insuranceId)
    {
        if (null !== $response = $this->checkAuth(AdminResources::MODULE, 'MondialRelay', AccessManager::DELETE)) {
            return $response;
        }

        MondialRelayDeliveryInsuranceQuery::create()->filterById($insuranceId)->delete();

        return $this->render('mondialrelay/ajax/insurances');
    }
}
