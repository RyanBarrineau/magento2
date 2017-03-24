/**
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

define([
    'Magento_Ui/js/form/components/insert-form',
    'mage/translate',
    'jquery',
    'underscore',
    'Magento_Ui/js/modal/confirm',
    'uiRegistry',
    'Magento_Ui/js/lib/view/utils/async'
], function (Insert, $t, $, _, uiConfirm, registry) {
    'use strict';

    return Insert.extend({
        defaults: {
            updateModalProvider: '${ $.parentName }',
            subTitlePrefix: $t('Belongs to '),
            switcherSelector: '.store-switcher',
            toRemove: [],
            imports: {
                removeResponseData: '${ $.removeResponseProvider }',
                modalTitle: '${ $.modalTitleProvider }',
                modalSubTitle: '${ $.modalSubTitleProvider }'
            },
            listens: {
                responseData: 'afterUpdate',
                removeResponseData: 'afterRemove',
                modalTitle: 'changeModalTitle',
                modalSubTitle: 'changeModalSubTitle'
            },
            modules: {
                updateModal: '${ $.updateModalProvider }',
                removeModal: '${ $.removeModalProvider }',
                upcomingListing: 'index = ${ $.upcomingListingProvider }'
            }
        },

        /** @inheritdoc **/
        initialize: function () {
            _.bindAll(this, 'onSwitcherSelect');
            this._super()
                .initSwitcherHandler();

            return this;
        },

        /** @inheritdoc */
        destroyInserted: function () {
            if (this.isRendered) {
                _.each(this.toRemove, function (componentName) {
                    registry.get(componentName, function (component) {
                        if (component.hasOwnProperty('delegate')) {
                            component.delegate('destroy');
                        } else {
                            component.destroy();
                        }
                    });
                });
                this.set('modalTitle', '');
                this.set('modalSubTitle', '');
            }

            this._super();
        },

        /**
         * Form save callback.
         *
         * @param {Object} data
         */
        afterUpdate: function (data) {
            if (!data.error) {
                this.updateModal().closeModal();
                this.upcomingListing().reload();
            }
        },

        /**
         * Form remove callback.
         *
         * @param {Object} data
         */
        afterRemove:  function (data) {
            if (!data.error) {
                this.removeModal().closeModal();
                this.afterUpdate(data);
            }
        },

        /**
         * Change modal title.
         *
         * @param {String} title
         */
        changeModalTitle: function (title) {
            this.updateModal().setTitle(title);
        },

        /**
         * Change modal sub title.
         *
         * @param {String} subTitle
         */
        changeModalSubTitle: function (subTitle) {
            if (subTitle) {
                this.updateModal().setSubTitle(this.subTitlePrefix + this.modalTitle + ' ' + subTitle);
            } else {
                this.updateModal().setSubTitle('');
            }
        },

        /**
         * Switcher initialization.
         */
        initSwitcherHandler: function () {
            var switcherSelector = this.updateModal().rootSelector + ' ' + this.switcherSelector,
                self = this;

            $.async(switcherSelector, function (switcher) {
                $(switcher).on('click', 'li a', self.onSwitcherSelect);
            });
        },

        /**
         * Store switcher selection handler.
         * @param {Object} e - event object.
         */
        onSwitcherSelect: function (e) {
            var self = this,
                param = $(e.currentTarget).data('param'),
                params = {
                    store: 0
                };

            params[param] = $(e.currentTarget).data('value');

            uiConfirm({
                content:  $t('Please confirm scope switching. All data that hasn\'t been saved will be lost.'),
                actions: {

                    /** Confirm callback. */
                    confirm: function () {
                        self.destroyInserted();
                        params = _.extend(self.previousParams, params);
                        self.render(params);
                    }
                }
            });
        }
    });
});
