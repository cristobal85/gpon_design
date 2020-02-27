/* global Path, ApiUrl, AjaxAdapter, TreeAdapter, ModalAdapter, AttributeEnum, tippy, AlertAdapter */

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
        AjaxAdapter.get(ApiUrl.GET_DSBOX_PORT_ID + dsBoxPortId).then(function (response) {
            var dsBoxConector = response.data;

            var conectorFiber = dsBoxConector.fiber;
            var html = "";
            if (conectorFiber) {
                html += "<div id='tree'>";
                html += self.generateNexo(conectorFiber);
                html += "</div>";
            }

            ModalAdapter.showModal('Trayectoria', html);

            TreeAdapter.showTree('tree');
        });
    },

    /**
     * 
     * @param {{id:Number, color:string, distributionBoxPort:DistributionBoxPort, hexaColor:string, patchPanelSlotConector:PatchPanelSlotConector, torpedoFusions:array, torpedoPassants:array, tube:Tube}} fiber
     * @returns {undefined}
     */
    generateNexo: function (fiber) {
        var self = this;
        var html = "<ul>";
        html += "<li data-jstree='{\"icon\":\"" + Path.IMAGE_UPLOADS + fiber.tube.wire.image + "\"}'>";
        html += "Fibra: " + fiber.tube.wire.name + " <strong>(" + fiber.tube.wire.longitude.toFixed(2) + "m)</strong>";
        html += "<div class='wire tube-left' style='background-color:" + fiber.tube.hexaColor + "'></div>";
        html += "<div class='wire fiber-left' style='background-color:" + fiber.hexaColor + "'></div>";

        fiber.torpedoFusions.forEach(function (fusion) {
            if (fusion) {
                html += "<ul>";
                html += "<li data-jstree='{\"icon\":\"" + Path.IMAGE_UPLOADS + fusion.torpedo.icon + "\"}'>";
                html += "Fusión en torpedo: " + fusion.torpedo.name;
                if (fusion.torpedo.address) {
                    html += " <strong>(" + fusion.torpedo.address.location + ")</strong>";
                }
                fusion.fibers.forEach(function (iFiber) {
                    if (iFiber) {
                        html += self.generateNexo(iFiber);
                    }
                });
                html += "</li>";
                html += "</ul>";
            }
        });

        fiber.torpedoPassants.forEach(function (passant) {
            if (passant) {
                html += "<ul>";
                html += "<li data-jstree='{\"icon\":\"" + Path.IMAGE_UPLOADS + passant.torpedo.icon + "\"}'>";
                html += "Pasante en torpedo: " + passant.torpedo.name;
                if (passant.torpedo.address) {
                    html += " <strong>(" + passant.torpedo.address.location + ")</strong>";
                }
                passant.fibers.forEach(function (iFiber) {
                    if (iFiber) {
                        html += self.generateNexo(iFiber);
                    }
                });
                html += "</li>";
                html += "</ul>";
            }
        });

        fiber.distributionBoxPassants.forEach(function (passant) {
            if (passant) {
                html += "<ul>";
                html += "<li data-jstree='{\"icon\":\"" + Path.IMAGE_UPLOADS + passant.distributionBox.icon + "\"}'>";
                html += "Pasante en caja distribución: " + passant.distributionBox.name;
                if (passant.distributionBox.address) {
                    html += " <strong>(" + passant.distributionBox.address.location + ")</strong>";
                }
                passant.fibers.forEach(function (iFiber) {
                    if (iFiber) {
                        html += self.generateNexo(iFiber);
                    }
                });
                html += "</li>";
                html += "</ul>";
            }
        });

        if (fiber.distributionBoxPort) {
            html += "<ul>";
            html += "<li data-jstree='{\"icon\":\"" + Path.IMAGE_UPLOADS + fiber.distributionBoxPort.distributionBox.icon + "\"}'>";
            html += "Caja distribución: " + fiber.distributionBoxPort.distributionBox.name + " <strong>(" + fiber.distributionBoxPort.distributionBox.address.location + ")</strong>";
            html += "</li>";
            html += "</ul>";
        }

        if (fiber.patchPanelSlotConector) {
            html += "<ul>";
            html += "<li>";
            html += "Conector CPD: ";
            html += fiber.patchPanelSlotConector.patchPanelSlot.patchPanel.rack.name + "_";
            html += fiber.patchPanelSlotConector.patchPanelSlot.patchPanel.name + "_";
            html += fiber.patchPanelSlotConector.patchPanelSlot.number + "_";
            html += fiber.patchPanelSlotConector.number;
            html += " <strong>(" + fiber.patchPanelSlotConector.patchPanelSlot.patchPanel.rack.name + ")</strong>";
            html += "</li>";
            html += "</ul>";
        }

        html += "</li>";
        html += "</ul>";

        return html;
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