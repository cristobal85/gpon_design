/* global ModalAdapter, AjaxAdapter, AlertAdapter, ApiUrl */

/**
 * @type WireListener
 */
var WireListener = {

    /**
     * @param {Number} wireId ID from database
     * @returns {undefined}
     */
    delete: function (wireId) {
        ModalAdapter.showConfirm(
                'Cable',
                '¿Seguro que quiere eliminar este cable?',
                function (confirm) {
                    if (confirm) {
                        AjaxAdapter.delete(ApiUrl.DELETE_WIRE_ID + wireId)
                                .then(function (response) {
                                    AlertAdapter.success(response.data.message);
                                    AlertAdapter.success("Refresca el mapa para ver los cambios.");
                                })
                                .catch(function (error) {
                                    console.error(error);
                                });
                    }
                });



    }

};