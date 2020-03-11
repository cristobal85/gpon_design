/* global Path, ApiUrl, AjaxAdapter, TreeAdapter, ModalAdapter, AttributeEnum, tippy, AlertAdapter, ROMPathBuilder */

/**
 * @type DistributionBoxListener
 */
var DistributionBoxListener = {

    /**
     * Show Path to CPD
     * @param {Number} dsBoxPortId ID from database
     * @returns {undefined}
     */
    showModal: function (dsBoxPortId) {
        var self = this;
        AjaxAdapter.get(ApiUrl.GET_DSBOX_PORT_ID + dsBoxPortId).then(async function (response) {
            var dsBoxConector = response.data;

            var conectorFiber = dsBoxConector.fiber;
            
            var romPathBuilder = ROMPathBuilder.getInstance();
            romPathBuilder.addDsToRomPath(conectorFiber);
            await romPathBuilder.addOltPath();

            ModalAdapter.showModal('Trayectoria', romPathBuilder.build());
            TreeAdapter.showTree('tree');
        });
    },


    /**
     * @param {HTMLElement} element
     * @returns {void}
     */
    dissconectPort: function (element) {
        var dsBoxId = $(element).attr(AttributeEnum.DATA_DS_BOX_ID);
        ModalAdapter.showConfirm(
                'Desconectar puerto Caja Distribución',
                '¿Estás seguro que quieres desconectar el puerto <strong>' + element.innerHTML + '</strong>?',
                function (confirmed) {
                    if (confirmed) {
                        AjaxAdapter.put(ApiUrl.PUT_DISTRIBUTION_PORT + '/' + dsBoxId + '/disconnect')
                                .then(function (response) {
                                    AlertAdapter.success(response.data.message);
                                })
                                .catch(function (error) {
                                    console.error(error);
                                });
                    }
                }
        );
    }

};