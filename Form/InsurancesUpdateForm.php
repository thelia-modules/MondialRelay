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
use Symfony\Component\Validator\Constraints\GreaterThanOrEqual;
use Thelia\Form\BaseForm;

/**
 * @author Franck Allimant <franck@cqfdev.fr>
 */
class InsurancesUpdateForm extends BaseForm
{
    protected function buildForm()
    {
        $this->formBuilder
            ->add(
                'max_value',
                'collection',
                [
                    "type" => 'number',
                    "constraints" => [new GreaterThanOrEqual([ 'value' => 0 ])],
                    'label' => $this->translator->trans('Cart value', [], MondialRelay::DOMAIN_NAME),
                    'label_attr' => [ ],
                    'allow_add'    => true,
                    'allow_delete' => true,
                ]
            )->add(
                'price_with_tax',
                'collection',
                [
                    "type" => 'number',
                    "constraints" => [new GreaterThanOrEqual([ 'value' => 0 ])],
                    'label' => $this->translator->trans('Insurance price', [], MondialRelay::DOMAIN_NAME),
                    'label_attr' => [ ],
                    'allow_add'    => true,
                    'allow_delete' => true,
                ]
            )
        ;
    }
}
