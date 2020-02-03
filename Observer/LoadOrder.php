<?php

namespace Wss\ExternalOrderId\Observer;

use Magento\Catalog\Model\Product\Link\Proxy;
use Magento\Framework\Exception\LocalizedException;
use Wss\ExternalOrderId\Api\Data\OrderLinkInterfaceFactory;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Sales\Api\Data\OrderExtensionFactory;
use Magento\Sales\Api\Data\OrderInterface;

class LoadOrder implements ObserverInterface
{
    /**
     * @var OrderExtensionFactory
     */
    private $orderExtensionFactory;

    /**
     * @var OrderLinkInterfaceFactory
     */
    private $orderLinkFactory;

    /**
     * @param OrderExtensionFactory $orderExtensionFactory
     * @param OrderLinkInterfaceFactory $orderLinkFactory
     */
    public function __construct(
        OrderExtensionFactory $orderExtensionFactory,
        OrderLinkInterfaceFactory $orderLinkFactory
    ) {
        $this->orderExtensionFactory = $orderExtensionFactory;
        $this->orderLinkFactory      = $orderLinkFactory;
    }

    /**
     * @param Observer $observer
     * @throws \Exception
     */
    public function execute(Observer $observer) : void
    {
        $order = $observer->getOrder();
        $this->setExternalOrderIdExtensionAttribute($order);
    }

    /**
     * @param OrderInterface $order
     * @throws \Exception
     */
    protected function setExternalOrderIdExtensionAttribute(OrderInterface $order) : void
    {
        $orderExtension = ($order->getExtensionAttributes()) ?: $this->orderExtensionFactory->create();
        if ($order->getId()) {
            $externalOrderId = $this->orderLinkFactory->create();
            $externalOrderId->load($order->getId(), 'order_id');
            if ($externalOrderId->getId() && $orderExtension->getExternalOrderId() === null) {
                $orderExtension->setExternalOrderId($externalOrderId);
            } elseif ($order->getQuoteId()) {
                $externalOrderId->load($order->getQuoteId(), 'quote_id');
                if ($externalOrderId->getId()) {
                    $externalOrderId->setOrderId($order->getId())->save();
                    $orderExtension->setExternalOrderId($externalOrderId);
                }
            }
        }

        $order->setExtensionAttributes($orderExtension);
    }
}
