/* global Path, ApiUrl, AjaxAdapter, self, ModalAdapter, TreeAdapter, AlertAdapter, ROMPathBuilder */

/**
 * @type PatchPanelListener
 */
var PatchPanelListener = {

    /**
     * @param {Number} patchPanelConectorId ID from database
     * @returns {undefined}
     */
    showModal: function (patchPanelConectorId) {
        AjaxAdapter.get(ApiUrl.GET_CONECTOR_ID + patchPanelConectorId).then(async function (response) {
            var patchPanelConector = response.data;
            var conectorFiber = patchPanelConector.fiber;
            
            var romPathBuilder = ROMPathBuilder.getInstance();
            await romPathBuilder.addRomToOltPath(patchPanelConector);
            await romPathBuilder.addDistributionBoxPath(conectorFiber);
//            console.log(patchPanelConector);
            

            ModalAdapter.showModal('Trayectoria', romPathBuilder.build());
            TreeAdapter.showTree('tree');
        });

        return false;
    },

    /**
     * @param {Number} patchPanelConectorId ID from database
     * @returns {undefined}
     */
    showPromptDescription: function (patchPanelConectorId) {
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
    },

    disconnectPort: function (patchPanelConectorId) {
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
    }
};
