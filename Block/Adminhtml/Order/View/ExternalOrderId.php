<?php

namespace Wss\ExternalOrderId\Block\Adminhtml\Order\View;

use Magento\Sales\Api\OrderRepositoryInterface;

class ExternalOrderId extends \Magento\Backend\Block\Widget
{

    /**
     * @var OrderRepositoryInterface
     */
    protected $orderRepository;

    /**
     * @param \Magento\Backend\Block\Template\Context $context
     * @param OrderRepositoryInterface $orderRepository
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        OrderRepositoryInterface $orderRepository,
        array $data = []
    ) {
        $this->orderRepository = $orderRepository;
        parent::__construct($context, $data);
    }

    /**
     * @return bool|string
     */
    public function getOrderExternalId()
    {
        $orderId = (int) $this->getRequest()->getParam('order_id');
        if ($orderId) {
            $order = $this->orderRepository->get($orderId);
            $externalOrderId = $order->getExtensionAttributes()->getExternalOrderId();
            if ($externalOrderId && $value = $externalOrderId->getValue()) {
                return $value;
            }
        }
        return false;
    }
}
