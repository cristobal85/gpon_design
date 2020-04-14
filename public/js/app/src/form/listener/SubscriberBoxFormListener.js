const AjaxAdapter = require('../../adapter/AjaxAdapter');
const ModalAdapter = require('../../adapter/ModalAdapter');
const ApiUrl = require('../../enum/ApiUrl');
const SubscriberBoxFormBuilder = require('../builder/SubscriberBoxFormBuilder');

/**
 * @type SubscriberBoxFormListener
 */
var SubscriberBoxFormListener = {

//    /**
//     * @param {Number} subscriberBoxId ID from database
//     * @returns {undefined}
//     */
//    showPhotoModal: function (subscriberBoxId) {
//        AjaxAdapter.get(ApiUrl.GET_SUBSCRIBER_ID + subscriberBoxId).then(function (response) {
//            var subscriberBox = response.data;
//            ModalAdapter.showModal(
//                    'Fotos',
//                    new UploadPhotoSubscriberBoxFormBuilder().addPhotoUpload(subscriberBox).build()
//                    );
//
//
//        });
//
//    },

    /**
     * @param {Number} subscriberBoxId ID from database
     * @returns {undefined}
     */
    showEditModal: function (subscriberBoxId) {
        ModalAdapter.showModal(
                'Editar Caja',
                new SubscriberBoxFormBuilder().addEditForm(subscriberBoxId).build()
                );
    }


};

module.exports = SubscriberBoxFormListener;