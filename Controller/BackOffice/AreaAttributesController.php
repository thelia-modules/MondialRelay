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

use MondialRelay\Model\MondialRelayZoneConfiguration;
use MondialRelay\Model\MondialRelayZoneConfigurationQuery;
use Thelia\Controller\Admin\BaseAdminController;
use Thelia\Core\Security\AccessManager;
use Thelia\Core\Security\Resource\AdminResources;
use Thelia\Log\Tlog;

/**
 * @author Franck Allimant <franck@cqfdev.fr>
 */
class AreaAttributesController extends BaseAdminController
{
    public function saveAction($areaId, $moduleId)
    {
        if (null !== $response = $this->checkAuth(AdminResources::MODULE, 'MondialRelay', AccessManager::UPDATE)) {
            return $response;
        }

        $form = $this->createForm('mondialrelay.area_attributes_update_form');

        $errorMessage = false;

        try {
            $viewForm = $this->validateForm($form);

            $data = $viewForm->getData();

            if (null === $zoneConfig = MondialRelayZoneConfigurationQuery::create()->findOneByAreaId($areaId)) {
                $zoneConfig = new MondialRelayZoneConfiguration();
            }

            $zoneConfig
                ->setAreaId($areaId)
                ->setDeliveryTime($data['delivery_time'])
                ->setDeliveryType($data['delivery_type'])
                ->save();

        } catch (\Exception $ex) {
            $errorMessage = $ex->getMessage();

            Tlog::getInstance()->error("Failed to validate area attributes form: $errorMessage");
        }

        return $this->render('mondialrelay/ajax/prices', [
            'module_id' => $moduleId,
            'error_message' => $errorMessage
        ]);
    }
}
