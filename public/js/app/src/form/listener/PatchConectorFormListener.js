const AjaxAdapter = require('../../adapter/AjaxAdapter');
const ApiUrl = require('../../enum/ApiUrl');
const ModalAdapter = require('../../adapter/ModalAdapter');
const AlertAdapter = require('../../adapter/AlertAdapter');
const HtmlID = require('../../enum/HtmlID');

/**
 * @type PatchConectorFormListener
 */
var PatchConectorFormListener = {

//    /**
//     * @param {Number} slotId ID from database
//     * @returns {undefined}
//     */
//    showModal: function (slotId) {
//        AjaxAdapter.get(ApiUrl.GET_FORM_WIRE).then(function (response) {
//            var wires = response.data;
//
//            ModalAdapter.showModal(
//                    'Nueva conexión',
//                    new PatchFormBuilder()
//                    .addSelectWires(wires)
//                    .build(),
//                    {
//                        ok: {
//                            label: "Siguiente",
//                            className: 'btn-info',
//                            callback: function () {
//                                var wireId = document.getElementById(HtmlID.DSBOX_CONECTOR_WIRE).value;
//                                AjaxAdapter.get(ApiUrl.GET_WIRE_ID + wireId).then(function (response) {
//                                    var wire = response.data;
//                                    AjaxAdapter.get(ApiUrl.GET_SLOT_ID + slotId).then(function (response) {
//                                        var slot = response.data;
//                                        ModalAdapter.showModal(
//                                                'Conexiones',
//                                                new PatchFormBuilder()
//                                                .addSelectedWires(wire, slot)
//                                                .build()
//                                                );
//                                    });
//                                });
//                            }
//                        }
//                    }
//            );
//
//            $('select').select2({width: '100%'});
//
//
//        });
//
//    },

//    /**
//     * @param {Number} id ID from database
//     * @param {HTMLElement} el
//     * @returns {undefined}
//     */
//    deleteFusion(id, el) {
//        AjaxAdapter
//                .delete(ApiUrl.DELETE_TORPEDO_FUSION + "/" + id)
//                .then(function (response) {
//                    el.parentNode.parentNode.remove();
//                    AlertAdapter.success(response.data.message);
//                })
//                .catch(function (response) {
//                    AlertAdapter.error(response.data.message);
//                });
//    }

};

module.exports = PatchConectorFormListener;