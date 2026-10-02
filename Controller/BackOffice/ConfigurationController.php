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

use MondialRelay\Form\SettingsForm;
use MondialRelay\MondialRelay;
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
class ConfigurationController extends BaseAdminController
{
    public function saveAction(): Response
    {
        if (null !== $response = $this->checkAuth(AdminResources::MODULE, 'MondialRelay', AccessManager::UPDATE)) {
            return $response;
        }

        $form = $this->createForm(SettingsForm::getName());

        $errorMessage = null;

        try {
            $data = $this->validateForm($form)->getData();

            foreach ($data as $name => $value) {
                MondialRelay::setConfigValue($name, (string) $value);
            }
        } catch (\Exception $ex) {
            $errorMessage = $ex->getMessage();

            Tlog::getInstance()->error("Failed to validate configuration form: $errorMessage");
        }

        return $this->redirectToConfiguration('general', $errorMessage);
    }

    private function redirectToConfiguration(string $tab, ?string $errorMessage): Response
    {
        if (null !== $errorMessage) {
            $session = $this->getSession();
            if ($session instanceof FlashBagAwareSessionInterface) {
                $session->getFlashBag()->add('danger', $errorMessage);
            }
        }

        return $this->generateRedirect(
            URL::getInstance()->absoluteUrl('/admin/module/MondialRelay', ['tab' => $tab])
        );
    }
}
