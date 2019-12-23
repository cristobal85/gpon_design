/* global bootbox, ApiUrl, AjaxAdapter, HtmlID, jsPlumb, AlertAdapter */

/**
 * @type PatchConectorFormListener
 */
var PatchConectorFormListener = {

    /**
     * @param {Number} slotId ID from database
     * @returns {undefined}
     */
    showModal: function (slotId) {
        AjaxAdapter.get(ApiUrl.GET_FORM_WIRE).then(function (response) {
            var wires = response.data;

            bootbox.dialog({
                title: 'Nueva conexión',
                message: new PatchFormBuilder()
                        .addSelectWires(wires)
                        .build(),
                buttons: {
                    ok: {
                        label: "Siguiente",
                        className: 'btn-info',
                        callback: function () {
                            var wireId = document.getElementById(HtmlID.DSBOX_CONECTOR_WIRE).value;
                            AjaxAdapter.get(ApiUrl.GET_WIRE_ID + wireId).then(function (response) {
                                var wire = response.data;
                                AjaxAdapter.get(ApiUrl.GET_SLOT_ID + slotId).then(function (response) {
                                    var slot = response.data;
                                    bootbox.dialog({
                                        title: 'Conexiones',
                                        scrollable: true,
                                        message: new PatchFormBuilder()
                                                .addSelectedWires(wire, slot)
                                                .build()
                                    });

                                });
                            });
                        }
                    }
                }
            });

            $('select').select2({width: '100%'});


        });

    },

    /**
     * @param {Number} id ID from database
     * @param {HTMLElement} el
     * @returns {undefined}
     */
    deleteFusion(id, el) {
        AjaxAdapter
                .delete(ApiUrl.DELETE_TORPEDO_FUSION + "/" + id)
                .then(function (response) {
                    el.parentNode.parentNode.remove();
                    AlertAdapter.success(response.data.message);
                })
                .catch(function (response) {
                    AlertAdapter.error(response.data.message);
                });
    }

};