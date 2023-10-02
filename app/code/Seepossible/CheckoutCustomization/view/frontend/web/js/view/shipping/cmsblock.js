define(
    [
        'uiComponent',
        'jquery',
        'ko'
    ],
    function(
        Component,
        $,
        ko
    ) {
        'use strict';
        return Component.extend({
            defaults: {
                template: 'Seepossible_CheckoutCustomization/shipping/cmsblock'
            },

            initialize: function () {
                var self = this;
                this._super();
            }

        });
    }
);