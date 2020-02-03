define([
    'jquery',
    'Magento_Ui/js/form/element/abstract',
    'Magento_Customer/js/customer-data',
    'Magento_Checkout/js/model/quote',
    'Magento_Checkout/js/checkout-data',
    'mage/validation'
], function ($, Component, customerData, quote, checkoutData) {
    'use strict';

    function getExternalOrderId() {
        if (window.checkoutConfig.hasOwnProperty('externalOrderId') &&
            typeof window.checkoutConfig.externalOrderId.value === 'string'
        ) {
            return window.checkoutConfig.externalOrderId.value;
        }
        return '';
    }

    return Component.extend({
        defaults: {
            value: getExternalOrderId()
        },

        initialize: function () {
            this._super();
            return this;
        }
    });
});
