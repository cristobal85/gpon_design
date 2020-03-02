/* global ApiUrl, AjaxAdapter, HtmlID, jsPlumb, AlertAdapter, ModalAdapter, UploadPhotoSubscriberBoxFormBuilder */

/**
 * @type DistributionBoxFormListener
 */
var DistributionBoxFormListener = {

    /**
     * @param {Number} distributionBoxId ID from database
     * @returns {undefined}
     */
    showEditModal: function (distributionBoxId) {
        ModalAdapter.showModal(
                'Editar Caja',
                new DistributionBoxFormBuilder().addEditForm(distributionBoxId).build()
                );



    }

};