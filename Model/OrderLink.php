<?php

namespace Wss\ExternalOrderId\Model;

use Wss\ExternalOrderId\Api\Data\OrderLinkInterface;
use Wss\ExternalOrderId\Model\ResourceModel\OrderLink as OrderLinkResourceModel;
use Magento\Framework\Model\AbstractModel;

class OrderLink extends AbstractModel implements OrderLinkInterface
{
    protected function _construct()
    {
        $this->_init(OrderLinkResourceModel::class);
    }

    /**
     * {@inheritDoc}
     */
    public function setValue($value)
    {
        return $this->setData('value', $value);
    }

    /**
     * {@inheritDoc}
     */
    public function getValue()
    {
        return $this->getData('value');
    }

    /**
     * {@inheritDoc}
     */
    public function setQuoteId($quoteId)
    {
        return $this->setData('quote_id', $quoteId);
    }

    /**
     * {@inheritDoc}
     */
    public function getQuoteId()
    {
        return $this->getData('quote_id');
    }

    /**
     * {@inheritDoc}
     */
    public function setOrderId($orderId)
    {
        return $this->setData('order_id', $orderId);
    }

    /**
     * {@inheritDoc}
     */
    public function getOrderId()
    {
        return $this->getData('order_id');
    }
}
