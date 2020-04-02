const AjaxAdapter = require('../../adapter/AjaxAdapter');
const ModalAdapter = require('../../adapter/ModalAdapter');
const AlertAdapter = require('../../adapter/AlertAdapter');
const ApiUrl = require('../../enum/ApiUrl');

/**
 * @type TorpedoListener
 */
var TorpedoListener = {

    /**
     * @param {Number} torpedoId ID from database
     * @returns {Promise<Boolean>}
     */
    delete: function (torpedoId) {
        return new Promise(function (resolve, reject) {
            ModalAdapter.showConfirm(
                    'Torpedo',
                    '¿Seguro que quiere eliminar este torpedo?',
                    function (confirm) {
                        if (confirm) {
                            AjaxAdapter.delete(ApiUrl.DELETE_TORPEDO_ID + torpedoId)
                                    .then(function (response) {
                                        AlertAdapter.success(response.data.message);
                                        return resolve();
                                    })
                                    .catch(function (error) {
                                        console.error(error);
                                        return reject();
                                    });
                        }
                    });
        });
    }

};