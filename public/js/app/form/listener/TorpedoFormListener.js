/* global ApiUrl, AjaxAdapter, HtmlID, jsPlumb, AlertAdapter, ModalAdapter, UploadPhotoSubscriberBoxFormBuilder */

/**
 * @type TorpedoFormListener
 */
var TorpedoFormListener = {

    /**
     * @param {Number} torpedoId ID from database
     * @returns {undefined}
     */
    showPhotoModal: function (torpedoId) {
            ModalAdapter.showModal(
                    'Fotos',
                    new UploadPhotoTorpedoFormBuilder().addPhotoUpload(torpedoId).build()
                    );
    },
    
    /**
     * @param {Number} distributionBoxId ID from database
     * @returns {undefined}
     */
    showEditModal: function (distributionBoxId) {
        ModalAdapter.showModal(
                'Editar Torpedo',
                new TorpedoFormBuilder().addEditForm(distributionBoxId).build()
                );
    }

};