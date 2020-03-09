/* global ApiUrl, AjaxAdapter, HtmlID, jsPlumb, AlertAdapter, ModalAdapter, UploadPhotoSubscriberBoxFormBuilder */

/**
 * @type WireFormListener
 */
var WireFormListener = {

    /**
     * @param {Number} wireId ID from database
     * @returns {undefined}
     */
    showEditModal: function (wireId) {
        ModalAdapter.showModal(
                'Editar Cable',
                new WireFormBuilder().addEditForm(wireId).build()
                );
    }

};