const AjaxAdapter = require('../../adapter/AjaxAdapter');
const ModalAdapter = require('../../adapter/ModalAdapter');
const ApiUrl = require('../../enum/ApiUrl');
const TorpedoFusionFormBuilder = require('../builder/TorpedoFusionFormBuilder');
const HtmlID = require('../../enum/HtmlID');
const AlertAdapter = require('../../adapter/AlertAdapter');

/**
 * @type TorpedoFusionListener
 */
var TorpedoFusionListener = {

    /**
     * @param {Number} torpedoId ID from database
     * @returns {undefined}
     */
    showFusionModal: function (torpedoId) {
        AjaxAdapter.get(ApiUrl.GET_FORM_WIRE).then(function (response) {
            var wires = response.data;

            ModalAdapter.showModal(
                    'Nueva fusión',
                    new TorpedoFusionFormBuilder()
                    .addSelectWires(wires)
                    .build(),
                    {
                        ok: {
                            label: "Siguiente",
                            className: 'btn-info',
                            callback: function () {
                                var wire1Id = document.getElementById(HtmlID.FUSION_WIRE_1).value;
                                var wire2Id = document.getElementById(HtmlID.FUSION_WIRE_2).value;
                                AjaxAdapter.get(ApiUrl.GET_WIRE_ID + wire1Id).then(function (response) {
                                    var wire1 = response.data;
                                    AjaxAdapter.get(ApiUrl.GET_WIRE_ID + wire2Id).then(function (response) {
                                        var wire2 = response.data;
                                        ModalAdapter.showModal(
                                                'Fusiones',
                                                new TorpedoFusionFormBuilder()
                                                .addSelectedWires(wire1, wire2, torpedoId)
                                                .build()
                                                );
                                    });
                                });
                            }
                        }
                    }
            );

            $('select').select2({width: '100%'});


        });

    },

    /**
     * @param {Number} id ID from database
     * @param {HTMLElement} el
     * @returns {undefined}
     */
//    deleteFusion(id, el) {
//        ModalAdapter.showConfirm(
//                'Fusiones',
//                '¿Seguro que quiere eliminar la fusión?',
//                function (result) {
//                    if (result) {
//                        AjaxAdapter
//                                .delete(ApiUrl.DELETE_TORPEDO_FUSION + "/" + id)
//                                .then(function (response) {
//                                    el.parentNode.parentNode.remove();
//                                    AlertAdapter.success(response.data.message);
//                                })
//                                .catch(function (error) {
//                                    AlertAdapter.error(error.response.data.message);
//                                });
//                    }
//                }
//        );
//    }

};

module.exports = TorpedoFusionListener;