/* global ApiUrl, AjaxAdapter, HtmlID, jsPlumb, AlertAdapter, ModalAdapter, UploadPhotoSubscriberBoxFormBuilder */

/**
 * @type SubscriberBoxExtFormListener
 */
var SubscriberBoxExtFormListener = {

    /**
     * @param {Number} subscriberBoxId ID from database
     * @returns {undefined}
     */
    showPhotoModal: function (subscriberBoxId) {
        AjaxAdapter.get(ApiUrl.GET_SUBSCRIBER_ID + subscriberBoxId).then(function (response) {
            var subscriberBox = response.data;
            ModalAdapter.showModal(
                    'Fotos',
                    new UploadPhotoSubscriberBoxFormBuilder().addPhotoUpload(subscriberBox).build()
                    );


        });

    },

    /**
     * @param {Number} subscriberBoxExtId ID from database
     * @returns {undefined}
     */
    showEditModal: function (subscriberBoxExtId) {
        ModalAdapter.showModal(
                'Editar Caja',
                new SubscriberBoxExtFormBuilder().addEditForm(subscriberBoxExtId).build()
                );
    }


};