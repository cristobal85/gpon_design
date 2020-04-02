const ModalAdapter = require('../../adapter/ModalAdapter');
const WireFormBuilder = require('../builder/WireFormBuilder');

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

module.exports = WireFormListener
;