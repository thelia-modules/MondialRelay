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

namespace MondialRelay\Form;

use MondialRelay\MondialRelay;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Validator\Constraints\GreaterThan;
use Thelia\Form\BaseForm;

/**
 * @author Franck Allimant <franck@cqfdev.fr>
 */
class PriceCreateForm extends BaseForm
{
    public static function getName(): string
    {
        return 'mondialrelay-price-create-form';
    }

    protected function buildForm(): void
    {
        $this->formBuilder
            ->add(
                'max_weight',
                NumberType::class,
                [
                    'constraints' => [new GreaterThan(['value' => 0])],
                    'label' => $this->translator->trans('Weight up to...', [], MondialRelay::DOMAIN_NAME),
                ]
            )
            ->add(
                'price',
                NumberType::class,
                [
                    'constraints' => [new GreaterThan(['value' => 0])],
                    'label' => $this->translator->trans('Price', [], MondialRelay::DOMAIN_NAME),
                ]
            );
    }
}
