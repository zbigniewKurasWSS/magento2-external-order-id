<?php

namespace Wss\ExternalOrderId\Model;

use Wss\ExternalOrderId\Api\Data\OrderLinkInterfaceFactory;
use Magento\Checkout\Model\ConfigProviderInterface;
use Magento\Checkout\Model\Session as CheckoutSession;

class CheckoutConfigProvider implements ConfigProviderInterface
{
    /**
     * @var CheckoutSession
     */
    private $checkoutSession;

    /**
     * @var OrderLinkInterfaceFactory
     */
    private $orderLinkFactory;

    /**
     * @param CheckoutSession $checkoutSession
     * @param OrderLinkInterfaceFactory $orderLinkFactory
     */
    public function __construct(
        CheckoutSession $checkoutSession,
        OrderLinkInterfaceFactory $orderLinkFactory
    ) {
        $this->checkoutSession = $checkoutSession;
        $this->orderLinkFactory = $orderLinkFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function getConfig() : array
    {
        $config = ['value' => null];
        $quote = $this->checkoutSession->getQuote();
        $externalOrderId = $this->orderLinkFactory->create();
        $externalOrderId->load($quote->getId(), 'quote_id');
        if ($externalOrderId->getId()) {
            $config['value'] = $externalOrderId->getValue();
        }
        return ['externalOrderId' => $config];
    }
}
