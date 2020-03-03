/* global ApiUrl, AjaxAdapter, HtmlID, jsPlumb, AlertAdapter, ModalAdapter, UploadPhotoSubscriberBoxFormBuilder */

/**
 * @type TorpedoFormListener
 */
var TorpedoFormListener = {

    /**
     * @param {Number} distributionBoxId ID from database
     * @returns {undefined}
     */
    showPhotoModal: function (distributionBoxId) {
            ModalAdapter.showModal(
                    'Fotos',
                    new UploadPhotoDistributionBoxFormBuilder().addPhotoUpload(distributionBoxId).build()
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