/* global ApiUrl, AjaxAdapter, HtmlID, jsPlumb, AlertAdapter, ModalAdapter, UploadPhotoSubscriberBoxFormBuilder */

/**
 * @type SubscriberBoxFormListener
 */
var SubscriberBoxFormListener = {

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
     * @param {Number} subscriberBoxId ID from database
     * @returns {undefined}
     */
    showEditModal: function (subscriberBoxId) {
        AjaxAdapter.get(ApiUrl.GET_SUBSCRIBER_ID + subscriberBoxId).then(function (response) {
            var subscriberBox = response.data;
            ModalAdapter.showModal(
                    'Editar Caja',
                    new SubscriberBoxFormBuilder().addEditForm(subscriberBox).build()
                    );


        });

    }
    

};