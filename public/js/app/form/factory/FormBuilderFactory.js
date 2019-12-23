/* global L, element.Element, ElementFormBuilder, ElementEnum, ApiUrl, AjaxAdapter */

/**
 * @type {FormBuilderFactory}
 */
var FormBuilderFactory = {

    /**
     * @param {string} elementType
     * @param {Number} latitude
     * @param {Number} longitude
     * @return {Promise<ElementFormBuilder>}
     */
    createBuilder: function (elementType, latitude, longitude) {
        switch (elementType) {
            case ElementEnum.SUBSCRIBER_BOX:
                return new Promise(function (resolve, reject) {
                    AjaxAdapter.get(ApiUrl.GET_SUBSCRIBER).then(function (response) {
                        resolve(
                                new SubscriberBoxFormBuilder()
                                .addSubscriberBoxList(response.data)
                                .addLatitude(latitude)
                                .addLongitude(longitude)
                                .addSubmitBtn()
                                );
                    });
                });
                break;
            case ElementEnum.DISTRIBUTION_BOX:
                return new Promise(function (resolve, reject) {
                    AjaxAdapter.get(ApiUrl.GET_DISTRIBUTION).then(function (response) {
                        resolve(
                                new DistributionBoxFormBuilder()
                                .addDistributionBoxList(response.data)
                                .addLatitude(latitude)
                                .addLongitude(longitude)
                                .addSubmitBtn()
                                );
                    });
                });
                break;
            case ElementEnum.SUBSCRIBER_BOX_EXT:
                return new Promise(function (resolve, reject) {
                    AjaxAdapter.get(ApiUrl.GET_SUBSCRIBER_EXT).then(function (response) {
                        resolve(
                                new SubscriberBoxExtFormBuilder()
                                .addSubscriberBoxExtList(response.data)
                                .addLatitude(latitude)
                                .addLongitude(longitude)
                                .addSubmitBtn()
                                );
                    });
                });
                break;
            case ElementEnum.TORPEDO:
                return new Promise(function (resolve, reject) {
                    AjaxAdapter.get(ApiUrl.GET_FORM_LAYER).then(function (response) {
                        resolve(
                                new TorpedoFormBuilder()
                                .addName()
                                .addLayers(response.data)
                                .addLatitude(latitude)
                                .addLongitude(longitude)
                                .addSubmitBtn()
                                );
                    });
                });
                break;

        }
    }
};