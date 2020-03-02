/* global ApiUrl, AjaxAdapter, HtmlID, jsPlumb, AlertAdapter, ModalAdapter, UploadPhotoSubscriberBoxFormBuilder */

/**
 * @type SubscriberBoxListener
 */
var SubscriberBoxListener = {

    /**
     * @param {Number} subscriberBoxId ID from database
     * @returns {undefined}
     */
    showPhotoModal: function (subscriberBoxId) {
        AjaxAdapter.get(ApiUrl.GET_SUBSCRIBER_ID + subscriberBoxId).then(function (response) {
            var subscriberBox = response.data;

            console.log(subscriberBox);

            ModalAdapter.showModal(
                    'Fotos',
                    new UploadPhotoSubscriberBoxFormBuilder().addPhotoUpload(subscriberBox).build()
                    );


        });

    }

};