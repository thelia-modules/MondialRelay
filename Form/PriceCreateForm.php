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
use Symfony\Component\Validator\Constraints\GreaterThan;
use Thelia\Form\BaseForm;

/**
 * @author Franck Allimant <franck@cqfdev.fr>
 */
class PriceCreateForm extends BaseForm
{
    protected function buildForm()
    {
        $this->formBuilder
            ->add(
                'max_weight',
                'number',
                [
                    "constraints" => [new GreaterThan([ 'value' => 0 ])],
                    'label' => $this->translator->trans('Weight up to...', [], MondialRelay::DOMAIN_NAME),
                ]
            )->add(
                'price',
                'number',
                [
                    "constraints" => [new GreaterThan([ 'value' => 0 ])],
                    'label' => $this->translator->trans('Price', [], MondialRelay::DOMAIN_NAME),
                ]
            )
        ;
    }
}
