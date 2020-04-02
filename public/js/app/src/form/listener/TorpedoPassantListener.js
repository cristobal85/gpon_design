const AjaxAdapter = require('../../adapter/AjaxAdapter');
const ModalAdapter = require('../../adapter/ModalAdapter');
const ApiUrl = require('../../enum/ApiUrl');
const TorpedoPassantFormBuilder = require('../builder/TorpedoPassantFormBuilder');
const HtmlID = require('../../enum/HtmlID');
const AlertAdapter = require('../../adapter/AlertAdapter');

/**
 * @type TorpedoPassantListener
 */
var TorpedoPassantListener = {

    /**
     * @param {Number} torpedoId ID from database
     * @returns {undefined}
     */
    showPassantModal: function (torpedoId) {
        AjaxAdapter.get(ApiUrl.GET_FORM_WIRE).then(function (response) {
            var wires = response.data;

            ModalAdapter.showModal(
                    'Nuevo pasante',
                    new TorpedoPassantFormBuilder()
                    .addSelectWires(wires)
                    .build(),
                    {
                        ok: {
                            label: "Enlazar",
                            className: 'btn-info',
                            callback: function () {
                                var wire1Id = document.getElementById(HtmlID.FUSION_WIRE_1).value;
                                var wire2Id = document.getElementById(HtmlID.FUSION_WIRE_2).value;
                                AjaxAdapter.get(ApiUrl.GET_WIRE_ID + wire1Id).then(function (response) {
                                    var wire1 = response.data;
                                    AjaxAdapter.get(ApiUrl.GET_WIRE_ID + wire2Id).then(function (response) {
                                        var wire2 = response.data;
                                        AjaxAdapter.post(ApiUrl.POST_TORPEDO_PASSANT + '/' + torpedoId, {
                                            'wire1Id': wire1.id,
                                            'wire2Id': wire2.id,
                                            'torpedoId': torpedoId
                                        }).then(function (response) {
                                            AlertAdapter.success(response.data.message);
                                        });

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
     * @param {Number} torpedoId ID from database
     * @returns {undefined}
     */
    deletePasants(torpedoId) {
        ModalAdapter.showConfirm('Pasantes', '¿Seguro que quiere eliminar todos los pasantes?', function (result) {
            if (result) {
                console.log(torpedoId);
                AjaxAdapter
                        .delete(ApiUrl.DELETE_TORPEDO_PASSANT_ID + torpedoId)
                        .then(function (response) {
                            AlertAdapter.success(response.data.message);
                        })
                        .catch(function (error) {
                            AlertAdapter.error(error.response.data.message);
                        });
            }
        });
    }
};

module.exports = TorpedoPassantListener;