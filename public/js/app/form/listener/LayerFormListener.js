const ModalAdapter = require('../../adapter/ModalAdapter');
const LayerFormBuilder = require('../builder/LayerFormBuilder');

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

module.exports = LayerFormListener;