<?php

namespace Wss\ExternalOrderId\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class OrderLink extends AbstractDb
{
    const TABLE_NAME = 'sales_order_external_order_id';

    protected function _construct()
    {
        $this->_init(static::TABLE_NAME, 'entity_id');
    }
}
