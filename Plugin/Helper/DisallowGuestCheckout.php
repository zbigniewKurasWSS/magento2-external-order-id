<?php
namespace Wss\ExternalOrderId\Plugin\Helper;

class DisallowGuestCheckout
{
    /***
     * @param \Magento\Checkout\Helper\Data $subject
     * @param bool $result
     * @return bool
     */
    public function afterIsAllowedGuestCheckout(\Magento\Checkout\Helper\Data $subject, bool $result) : bool
    {
        return false;
    }
}
