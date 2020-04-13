const AjaxAdapter = require('../../adapter/AjaxAdapter');
const ModalAdapter = require('../../adapter/ModalAdapter');
const AlertAdapter = require('../../adapter/AlertAdapter');
const ApiUrl = require('../../enum/ApiUrl');


/**
 * @type LayerListener
 */
var LayerListener = {

    /**
     * @param {Number} layerId
     * @returns {Promise<Boolean>}
     */
    delete: function (layerId) {
        return new Promise(function (resolve, reject) {
            ModalAdapter.showConfirm(
                    'Delimitador',
                    '¿Seguro que quiere eliminar este delimitador?',
                    function (confirm) {
                        if (confirm) {
                            AjaxAdapter.delete(ApiUrl.DELETE_LAYER_ID + layerId)
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

module.exports = LayerListener;