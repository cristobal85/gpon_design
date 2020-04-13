const ModalAdapter = require('../../adapter/ModalAdapter');
const TorpedoFormBuilder = require('../builder/TorpedoFormBuilder');

/**
 * @type TorpedoFormListener
 */
var TorpedoFormListener = {
    
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

module.exports = TorpedoFormListener;