/* global ApiUrl, AjaxAdapter, HtmlID, jsPlumb, AlertAdapter, ModalAdapter */

/**
 * @type TorpedoPassantListener
 */
var TorpedoPassantListener = {

    /**
     * @param {Number} torpedoId ID from database
     * @returns {undefined}
     */
    showModal: function (torpedoId) {
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
     * @param {Number} id ID from database
     * @param {HTMLElement} el
     * @returns {undefined}
     */
    deletePassant(id, el) {
        ModalAdapter.showConfirm('Pasantes', '¿Seguro que quiere eliminar el pasante?', function (result) {
            if (result) {
//                AjaxAdapter
//                        .delete(ApiUrl.DELETE_TORPEDO_FUSION + "/" + id)
//                        .then(function (response) {
//                            el.parentNode.parentNode.remove();
//                            AlertAdapter.success(response.data.message);
//                        })
//                        .catch(function (error) {
//                            AlertAdapter.error(error.response.data.message);
//                        });
            }
        });
    }

};