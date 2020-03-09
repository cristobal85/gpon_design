/* global ModalAdapter, AjaxAdapter, AlertAdapter, ApiUrl */

/**
 * @type WireListener
 */
var WireListener = {

    /**
     * @param {Number} wireId ID from database
     * @returns {Promise<Boolean>}
     */
    delete: function (wireId) {
        return new Promise(function (resolve, reject) {
            ModalAdapter.showConfirm(
                    'Cable',
                    '¿Seguro que quiere eliminar este cable?',
                    function (confirm) {
                        if (confirm) {
                            AjaxAdapter.delete(ApiUrl.DELETE_WIRE_ID + wireId)
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