<?php

namespace Wss\ExternalOrderId\Api\Data;

use Exception;

/**
 * @api
 */
interface OrderLinkInterface
{
    /**
     * Set value
     *
     * @param string $value
     *
     * @return $this
     */
    public function setValue($value);

    /**
     * Get value
     *
     * @return string
     */
    public function getValue();

    /**
     * Set quote id
     *
     * @param integer $quoteId
     *
     * @return $this
     */
    public function setQuoteId($quoteId);

    /**
     * Get quote id
     *
     * @return integer
     */
    public function getQuoteId();

    /**
     * Set order id
     *
     * @param integer $orderId
     *
     * @return $this
     */
    public function setOrderId($orderId);

    /**
     * Get order id
     *
     * @return integer
     */
    public function getOrderId();

    /**
     * Save order link
     *
     * @return $this
     * @throws Exception
     */
    public function save();

    /**
     * Load order link data
     *
     * @param integer $modelId
     * @param null|string $field
     * @return $this
     */
    public function load($modelId, $field = null);
}
