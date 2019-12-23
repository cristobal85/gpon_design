/* global ModalAdapter, AjaxAdapter, AlertAdapter */

/**
 * @type ElementActionListener
 */
var ElementActionListener = {

    /**
     * @param {string} href Resource URL
     * @param {Number} elementId ID from database
     * @returns {undefined}
     */
    delete: function (href, elementId) {
        ModalAdapter.showConfirm(
                'Cable',
                '¿Seguro que quiere eliminar este cable?',
                function () {
                    AjaxAdapter.delete(href + elementId)
                            .then(function (response) {
                                AlertAdapter.success(response.data.message);
                                AlertAdapter.success("Refresca el mapa para ver los cambios.");
                            })
                            .catch(function (error) {
                                console.error(error);
                            });
                });



    }

};