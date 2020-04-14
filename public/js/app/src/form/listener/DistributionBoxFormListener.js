const ModalAdapter = require('../../adapter/ModalAdapter');
const UploadPhotoDistributionBoxFormBuilder = require('../builder/UploadPhotoDistributionBoxFormBuilder');
const DistributionBoxFormBuilder = require('../builder/DistributionBoxFormBuilder');

/**
 * @type DistributionBoxFormListener
 */
var DistributionBoxFormListener = {

//    /**
//     * @param {Number} distributionBoxId ID from database
//     * @returns {undefined}
//     */
//    showPhotoModal: function (distributionBoxId) {
//            ModalAdapter.showModal(
//                    'Fotos',
//                    new UploadPhotoDistributionBoxFormBuilder().addPhotoUpload(distributionBoxId).build()
//                    );
//    },
    
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

module.exports = DistributionBoxFormListener;