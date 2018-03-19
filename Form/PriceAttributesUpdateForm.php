<?php
/*************************************************************************************/
/*      Copyright (c) Franck Allimant, CQFDev                                        */
/*      email : thelia@cqfdev.fr                                                     */
/*      web : http://www.cqfdev.fr                                                   */
/*                                                                                   */
/*      For the full copyright and license information, please view the LICENSE      */
/*      file that was distributed with this source code.                             */
/*************************************************************************************/

namespace MondialRelay\Form;

use MondialRelay\Model\MondialRelayZoneConfiguration;
use MondialRelay\MondialRelay;
use Symfony\Component\Validator\Constraints\GreaterThan;
use Thelia\Form\BaseForm;

/**
 * @author Franck Allimant <franck@cqfdev.fr>
 */
class PriceAttributesUpdateForm extends BaseForm
{
    protected function buildForm()
    {
        $this->formBuilder
            ->add(
                'delivery_time',
                'integer',
                [
                    "constraints" => [new GreaterThan([ 'value' => 0 ])],
                    'label' => $this->translator->trans('Delivery delay', [], MondialRelay::DOMAIN_NAME),
                ]
            )->add(
                'delivery_type',
                'choice',
                [
                    "choices" => [
                        MondialRelayZoneConfiguration::RELAY_DELIVERY_TYPE => $this->translator->trans('Relay delivery', [], MondialRelay::DOMAIN_NAME),
                        MondialRelayZoneConfiguration::HOME_DELIVERY_TYPE => $this->translator->trans('Home delivery', [], MondialRelay::DOMAIN_NAME),
                        MondialRelayZoneConfiguration::ALL_DELIVERY_TYPE => $this->translator->trans('Home and relay delivery', [], MondialRelay::DOMAIN_NAME)
                    ],
                    'label' => $this->translator->trans('Delivery type', [], MondialRelay::DOMAIN_NAME),
                ]
            )
        ;
    }
}
