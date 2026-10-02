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

use Thelia\Form\BaseForm;

/**
 * Fieldless form used to protect delete actions with a CSRF token.
 */
class DeleteForm extends BaseForm
{
    public static function getName(): string
    {
        return 'mondialrelay-delete-form';
    }

    protected function buildForm(): void
    {
        // No field: this form only carries the CSRF token validated on delete actions.
    }
}
