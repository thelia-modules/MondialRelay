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

use MondialRelay\MondialRelay;
use Symfony\Component\Validator\Constraints\NotBlank;
use Thelia\Form\BaseForm;

/**
 * @author Franck Allimant <franck@cqfdev.fr>
 */
class SettingsForm extends BaseForm
{
    protected function buildForm()
    {
        $this->formBuilder
            ->add(
                MondialRelay::CODE_ENSEIGNE,
                'text',
                [
                    "constraints" => [new NotBlank()],
                    'label' => $this->translator->trans('Mondial Relay store code', [], MondialRelay::DOMAIN_NAME),
                    'label_attr' => [
                        'help' => $this->translator->trans('This is the store code, as provided by Mondial Relay.', [], MondialRelay::DOMAIN_NAME)
                    ]

                ]
            )->add(
                MondialRelay::PRIVATE_KEY,
                'text',
                [
                    "constraints" => [new NotBlank()],
                    'label' => $this->translator->trans('Private key', [], MondialRelay::DOMAIN_NAME),
                    'label_attr' => [
                        'help' => $this->translator->trans('Your private key, as provided by Mondial Relay.', [], MondialRelay::DOMAIN_NAME)
                    ]

                ]
            )->add(
                MondialRelay::ALLOW_HOME_DELIVERY,
                'checkbox',
                [
                    'required' => false,
                    'label' => $this->translator->trans('Allow home delivery', [], MondialRelay::DOMAIN_NAME),
                    'label_attr' => [
                        'help' => $this->translator->trans('Check this box to allow delivery at customer address in supported countries.', [], MondialRelay::DOMAIN_NAME)
                    ]

                ]
            )->add(
                MondialRelay::ALLOW_RELAY_DELIVERY,
                'checkbox',
                [
                    'required' => false,
                    'label' => $this->translator->trans('Allow relay delivery', [], MondialRelay::DOMAIN_NAME),
                    'label_attr' => [
                        'help' => $this->translator->trans('Check this box to allow delivery in relays in supported countries.', [], MondialRelay::DOMAIN_NAME)
                    ]

                ]
            )->add(
                MondialRelay::ALLOW_INSURANCE,
                'checkbox',
                [
                    'required' => false,
                    'label' => $this->translator->trans('Allow optional insurance', [], MondialRelay::DOMAIN_NAME),
                    'label_attr' => [
                        'help' => $this->translator->trans('Check this box to allow an optionnal insurance selection depending on cart value.', [], MondialRelay::DOMAIN_NAME)
                    ]

                ]
            )->add(
                MondialRelay::WEBSERVICE_URL,
                'text',
                [
                    'label' => $this->translator->trans('Mondial Relay Web service WSDL URL', [], MondialRelay::DOMAIN_NAME),
                    'label_attr' => [
                        'help' => $this->translator->trans('This is the URL of the Mondial Relay web service WSDL.', [], MondialRelay::DOMAIN_NAME)
                    ]
                ]
            )->add(
                MondialRelay::GOOGLE_MAPS_API_KEY,
                'text',
                [
                    'label' => $this->translator->trans('Google Map API Key', [], MondialRelay::DOMAIN_NAME),
                    'label_attr' => [
                        'help' => $this->translator->trans(
                            'This key is required to display relays map. <a href="%get_key_url">Click here</a> to get one.',
                            [ "%get_key_url" => "https://developers.google.com/maps/documentation/javascript/get-api-key" ],
                            MondialRelay::DOMAIN_NAME
                        )
                    ]
                ]
            );
        ;
    }
}
