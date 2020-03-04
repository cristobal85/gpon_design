/* global ApiUrl, AjaxAdapter, HtmlID, jsPlumb, AlertAdapter, ModalAdapter */

/**
 * @type DistributionBoxPassantListener
 */
var DistributionBoxPassantListener = {

    /**
     * @param {Number} distributionBoxId ID from database
     * @returns {undefined}
     */
    showModal: function (distributionBoxId) {
        AjaxAdapter.get(ApiUrl.GET_FORM_WIRE).then(function (response) {
            var wires = response.data;

            ModalAdapter.showModal(
                    'Nuevo pasante',
                    new DistributionBoxPassantFormBuilder().addSelectWires(wires).build(),
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
                                        AjaxAdapter.post(ApiUrl.POST_DISTRIBUTION_BOX_PASSANT + '/' + distributionBoxId, {
                                            'wire1Id': wire1.id,
                                            'wire2Id': wire2.id,
                                            'distributionBoxId': distributionBoxId
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
     * @param {Number} dsBoxId ID from database
     * @returns {undefined}
     */
    deletePasants(dsBoxId) {
        ModalAdapter.showConfirm('Pasantes', '¿Seguro que quiere eliminar todos los pasantes?', function (result) {
            if (result) {
                console.log(dsBoxId);
                AjaxAdapter
                        .delete(ApiUrl.DELETE_DISTRIBUTION_BOX_PASSANT + dsBoxId)
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