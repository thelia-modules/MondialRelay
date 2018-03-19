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

use MondialRelay\MondialRelay;
use Thelia\Controller\Admin\BaseAdminController;
use Thelia\Core\Security\AccessManager;
use Thelia\Core\Security\Resource\AdminResources;
use Thelia\Log\Tlog;

/**
 * @author Franck Allimant <franck@cqfdev.fr>
 */
class ConfigurationController extends BaseAdminController
{
    public function saveAction()
    {
        if (null !== $response = $this->checkAuth(AdminResources::MODULE, 'MondialRelay', AccessManager::UPDATE)) {
            return $response;
        }

        $form = $this->createForm('mondialrelay.settings_form');

        $errorMessage = false;

        try {
            $viewForm = $this->validateForm($form);

            $data = $viewForm->getData();

            foreach ($data as $name => $value) {
                MondialRelay::setConfigValue($name, $value);
            }
        } catch (\Exception $ex) {
            $errorMessage = $ex->getMessage();

            Tlog::getInstance()->error("Failed to validate configuration form: $errorMessage");
        }

        return $this->render('mondialrelay/ajax/general', [ 'error_message' => $errorMessage ]);
    }
}
