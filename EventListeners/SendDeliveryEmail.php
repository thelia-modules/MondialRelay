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

namespace MondialRelay\EventListeners;

use MondialRelay\MondialRelay;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Thelia\Core\Event\Order\OrderEvent;
use Thelia\Core\Event\TheliaEvents;
use Thelia\Mailer\MailerFactory;
use Thelia\Model\ConfigQuery;

class SendDeliveryEmail implements EventSubscriberInterface
{
    /**
     * @var MailerFactory
     */
    protected $mailer;

    public function __construct(MailerFactory $mailer)
    {
        $this->mailer = $mailer;
    }

    /**
     * @param OrderEvent $event
     * @throws \Exception
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function updateStatus(OrderEvent $event)
    {
        $order = $event->getOrder();

        $deliveryRef = $order->getDeliveryRef();

        if ($order->isSent()
            &&
            ! empty($deliveryRef)
            &&
            $order->getDeliveryModuleId() == MondialRelay::getModuleId()
        ) {
            if (null !== ConfigQuery::read('store_email')) {
                $this->mailer->sendEmailToCustomer(
                    MondialRelay::TRACKING_MESSAGE_NAME,
                    $order->getCustomer(),
                    [
                        'order_id' => $order->getId(),
                    ]
                );
            }
        }
    }

    public static function getSubscribedEvents(): array
    {
        return [
            TheliaEvents::ORDER_UPDATE_STATUS => ["updateStatus", 128],
        ];
    }
}
