const AjaxAdapter = require('../../adapter/AjaxAdapter');
const ApiUrl = require('../../enum/ApiUrl');
const ModalAdapter = require('../../adapter/ModalAdapter');
const AlertAdapter = require('../../adapter/AlertAdapter');
const HtmlID = require('../../enum/HtmlID');
const DistributionBoxFormBuilder = require('../builder/DistributionBoxFormBuilder');

/**
 * @type DsBoxConectorFormListener
 */
var DsBoxConectorFormListener = {

    /**
     * @param {Number} distributionBoxId ID from database
     * @returns {undefined}
     */
    showModal: function (distributionBoxId) {
        AjaxAdapter.get(ApiUrl.GET_FORM_WIRE).then(function (response) {
            var wires = response.data;

            ModalAdapter.showModal(
                    'Nueva conexión',
                    new DistributionBoxFormBuilder()
                    .addSelectWires(wires)
                    .build(),
                    {
                        ok: {
                            label: "Siguiente",
                            className: 'btn-info',
                            callback: function () {
                                var wireId = document.getElementById(HtmlID.DSBOX_CONECTOR_WIRE).value;
                                AjaxAdapter.get(ApiUrl.GET_WIRE_ID + wireId).then(function (response) {
                                    var wire = response.data;
                                    AjaxAdapter.get(ApiUrl.GET_DISTRIBUTION_BOX_ID + distributionBoxId).then(function (response) {
                                        var dsBox = response.data;
                                        ModalAdapter.showModal(
                                                'Conexiones',
                                                new DistributionBoxFormBuilder()
                                                    .addSelectedWires(wire, dsBox)
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

module.exports = DsBoxConectorFormListener;