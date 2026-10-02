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
use Symfony\Component\Validator\Constraints\GreaterThanOrEqual;
use Thelia\Form\BaseForm;

/**
 * @author Franck Allimant <franck@cqfdev.fr>
 */
class InsuranceCreateForm extends BaseForm
{
    public static function getName(): string
    {
        return 'mondialrelay-insurance-create-form';
    }

    protected function buildForm(): void
    {
        $this->formBuilder
            ->add(
                'max_value',
                NumberType::class,
                [
                    'constraints' => [new GreaterThanOrEqual(['value' => 0])],
                    'label' => $this->translator->trans('Cart value', [], MondialRelay::DOMAIN_NAME),
                ]
            )
            ->add(
                'price_with_tax',
                NumberType::class,
                [
                    'constraints' => [new GreaterThanOrEqual(['value' => 0])],
                    'label' => $this->translator->trans('Insurance price', [], MondialRelay::DOMAIN_NAME),
                ]
            );
    }
}
