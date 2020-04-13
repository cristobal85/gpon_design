const AjaxAdapter = require('../../adapter/AjaxAdapter');
const ModalAdapter = require('../../adapter/ModalAdapter');
const AlertAdapter = require('../../adapter/AlertAdapter');
const mapView = require('../../view/MapView');
const ElementFactory = require('../../element/factory/ElementFactory');
const Listener = require('../../enum/Listener');
const UploadPhotoTorpedoFormBuilder = require('../builder/UploadPhotoTorpedoFormBuilder');
const ApiUrl = require('../../enum/ApiUrl');
const ROMPathBuilder = require('../../element/builder/ROMPathBuilder');
const TreeAdapter = require('../../adapter/TreeAdapter');
const HtmlID = require('../../enum/HtmlID');
const PatchFormBuilder = require('../builder/PatchFormBuilder');

module.exports = function () {


    /**
     * @param {CustomEvent} e
     */
    document.addEventListener(Listener.ELEMENT_SAVE_FORM, function (e) {
        var el = e.detail;
        var form = el.parentNode;
        var url = $(form).prop('action');
        var formData = $(form).serializeArray();

        var data = {};
        $(formData).each(function (index, obj) {
            data[obj.name] = obj.value;
        });

        AjaxAdapter.post(url, data)
                .then(function (response) {
                    mapView.renderLayer(
                            ElementFactory
                            .factory(response.data, mapView)
                            .getLayer()
                            );
                    AlertAdapter.success(response.data.message);
                    ModalAdapter.hideAll();
                })
                .catch(function (error) {
                    AlertAdapter.error(error.data.message);
                });
    });

    /**
     * @param {CustomEvent} e
     */
    document.addEventListener(Listener.TORPEDO_SHOW_PHOTO_MODAL, function (e) {
        var torpedoId = e.detail;
        ModalAdapter.showModal(
                'Fotos',
                new UploadPhotoTorpedoFormBuilder().addPhotoUpload(torpedoId).build()
                );
    });

    /**
     * @param {CustomEvent} e
     */
    document.addEventListener(Listener.TORPEDO_DELETE_FUSION, function (e) {
        console.log(e);
        var fusionId = e.detail.fusionId;
        var el = e.detail.el;
        ModalAdapter.showConfirm(
                'Fusiones',
                '¿Seguro que quiere eliminar la fusión?',
                function (result) {
                    if (result) {
                        AjaxAdapter
                                .delete(ApiUrl.DELETE_TORPEDO_FUSION + "/" + fusionId)
                                .then(function (response) {
                                    el.parentNode.parentNode.remove();
                                    AlertAdapter.success(response.data.message);
                                })
                                .catch(function (error) {
                                    AlertAdapter.error(error.response.data.message);
                                });
                    }
                }
        );
    });

    /**
     * @param {CustomEvent} e
     */
    document.addEventListener(Listener.DS_BOX_SHOW_PATH, function (e) {
        var dsBoxPortId = e.detail;
        AjaxAdapter.get(ApiUrl.GET_DSBOX_PORT_ID + dsBoxPortId).then(async function (response) {
            var dsBoxConector = response.data;

            var conectorFiber = dsBoxConector.fiber;

            var romPathBuilder = ROMPathBuilder.getInstance();
            romPathBuilder.addDsToRomPath(conectorFiber);
            await romPathBuilder.addOltPath();

            ModalAdapter.showModal('Trayectoria', romPathBuilder.build());
            TreeAdapter.showTree('tree');
        });
    });

    /**
     * @param {CustomEvent} e
     */
    document.addEventListener(Listener.PATCH_SHOW_PATH, function (e) {
        var patchPanelConectorId = e.detail;
        AjaxAdapter.get(ApiUrl.GET_CONECTOR_ID + patchPanelConectorId).then(async function (response) {
            var patchPanelConector = response.data;
            var conectorFiber = patchPanelConector.fiber;

            var romPathBuilder = ROMPathBuilder.getInstance();
            await romPathBuilder.addRomToOltPath(patchPanelConector);
            await romPathBuilder.addDistributionBoxPath(conectorFiber);


            ModalAdapter.showModal('Trayectoria', romPathBuilder.build());
            TreeAdapter.showTree('tree');
        });

        return false;
    });

    /**
     * @param {CustomEvent} e
     */
    document.addEventListener(Listener.PATCH_SHOW_PROMPT, function (e) {
        var patchPanelConectorId = e.detail;
        AjaxAdapter.get(ApiUrl.GET_CONECTOR_ID + patchPanelConectorId).then(function (response) {
            var patchPanelConector = response.data;
            ModalAdapter.showPromptDescription(
                    'Puerto de patch panel ' + patchPanelConector.number,
                    function (result) {
                        if (result) {
                            AjaxAdapter.put(ApiUrl.PUT_PATCHPORT_DESCRIPTION + patchPanelConector.id,
                                    {
                                        'description': result
                                    })
                                    .then(function (response) {
                                        AlertAdapter.success(response.data.message);
                                    })
                                    .catch(function (error) {
                                        console.error(error);
                                    });
                        }
                    }, patchPanelConector.description);
        });

        return false;
    });


    /**
     * @param {CustomEvent} e
     */
    document.addEventListener(Listener.PATCH_DISCONNECT_PORT, function (e) {
        var patchPanelConectorId = e.detail;

        AjaxAdapter.get(ApiUrl.GET_CONECTOR_ID + patchPanelConectorId).then(function (response) {
            var patchPanelConector = response.data;
            ModalAdapter.showConfirm(
                    'Puerto patch panel (slot ' + patchPanelConector.patchPanelSlot.number + ')',
                    '¿Desconectar puerto ' + patchPanelConector.number + '?',
                    function (result) {
                        if (result) {
                            AjaxAdapter.put(ApiUrl.PUT_PATCH_PANEL_PORT + '/' + patchPanelConectorId + '/disconnect')
                                    .then(function (response) {
                                        AlertAdapter.success(response.data.message);
                                    })
                                    .catch(function (error) {
                                        console.error(error);
                                    });
                        }
                    });
        });
    });

    /**
     * @param {CustomEvent} e
     */
    document.addEventListener(Listener.PATCH_CONNECT_PORTS, function (e) {
        var slotId = e.detail;
        AjaxAdapter.get(ApiUrl.GET_FORM_WIRE).then(function (response) {
            var wires = response.data;

            ModalAdapter.showModal(
                    'Nueva conexión',
                    new PatchFormBuilder()
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
                                    AjaxAdapter.get(ApiUrl.GET_SLOT_ID + slotId).then(function (response) {
                                        var slot = response.data;
                                        ModalAdapter.showModal(
                                                'Conexiones',
                                                new PatchFormBuilder()
                                                .addSelectedWires(wire, slot)
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
    });

};