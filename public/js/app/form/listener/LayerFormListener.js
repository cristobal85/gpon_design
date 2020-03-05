/* global ApiUrl, AjaxAdapter, HtmlID, jsPlumb, AlertAdapter, ModalAdapter, UploadPhotoSubscriberBoxFormBuilder */

/**
 * @type LayerFormListener
 */
var LayerFormListener = {

    /**
     * @param {Number} layerId ID from database
     * @returns {undefined}
     */
    showEditModal: function (layerId) {
        ModalAdapter.showModal(
                'Editar Delimitador',
                new LayerFormBuilder().addEditForm(layerId).build()
                );
    }

};