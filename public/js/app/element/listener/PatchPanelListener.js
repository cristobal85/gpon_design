/* global Path, bootbox, ApiUrl, AjaxAdapter, self */

/**
 * @type PatchPanelListener
 */
var PatchPanelListener = {

    /**
     * @param {Number} patchPanelConectorId ID from database
     * @returns {undefined}
     */
    showModal: function (patchPanelConectorId) {
        var self = this;

        AjaxAdapter.get(ApiUrl.GET_CONECTOR_ID + patchPanelConectorId).then(function (response) {
            var patchPanelConector = response.data;

            var conectorFiber = patchPanelConector.fiber;

            var html = "";
            if (conectorFiber) {
                html += "<div id='tree'>";
                html += self.generateNexo(conectorFiber);
                html += "</div>";
            }


            // TODO: Aplicar refactoring a todo este código. Composite?
//            var html = "<div id='tree'>";
//            html += "<ul>";
//            html += "<li data-jstree='{\"icon\":\"" + Path.IMAGE_UPLOADS + conectorFiber.tube.wire.image + "\"}'>";
//            html += "Fibra: " + conectorFiber.tube.wire.name + " <strong>(" + conectorFiber.tube.wire.longitude.toFixed(2) + "m)</strong>";
//            html += "<div class='wire tube-left' style='background-color:" + conectorFiber.tube.hexaColor + "'></div>";
//            html += "<div class='wire fiber-left' style='background-color:" + conectorFiber.hexaColor + "'></div>";
//            conectorFiber.torpedoFusions.forEach(function (iFusion) {
//                html += "<ul>";
//                html += "<li data-jstree='{\"icon\":\"" + Path.IMAGE_UPLOADS + iFusion.torpedo.icon + "\"}'>";
//                html += "Torpedo: " + iFusion.torpedo.name + " <strong>(" + iFusion.torpedo.address.location + ")</strong>";
//                iFusion.fibers.forEach(function (iFiber) {
//                    if (iFiber) {
//                        html += "<ul>";
//                        html += "<li data-jstree='{\"icon\":\"" + Path.IMAGE_UPLOADS + iFiber.tube.wire.image + "\"}'>";
//                        html += "Fibra: " + iFiber.tube.wire.name + " <strong>(" + iFiber.tube.wire.longitude.toFixed(2) + "m)</strong>";
//                        html += "<div class='wire tube-left' style='background-color:" + iFiber.tube.hexaColor + "'></div>";
//                        html += "<div class='wire fiber-left' style='background-color:" + iFiber.hexaColor + "'></div>";
//                        iFiber.torpedoFusions.forEach(function (iFusion) {
//                            if (iFusion) {
//                                html += "<ul>";
//                                html += "<li data-jstree='{\"icon\":\"" + Path.IMAGE_UPLOADS + iFusion.torpedo.icon + "\"}'>";
//                                html += "Torpedo: " + iFusion.torpedo.name + " <strong>(" + iFusion.torpedo.address.location + ")</strong>";
//                                iFusion.fibers.forEach(function (jFiber) {
//                                    if (jFiber) {
//                                        html += "<ul>";
//                                        html += "<li data-jstree='{\"icon\":\"" + Path.IMAGE_UPLOADS + jFiber.tube.wire.image + "\"}'>";
//                                        html += "Fibra: " + jFiber.tube.wire.name + " <strong>(" + jFiber.tube.wire.longitude.toFixed(2) + "m)</strong>";
//                                        html += "<div class='wire tube-left' style='background-color:" + jFiber.tube.hexaColor + "'></div>";
//                                        html += "<div class='wire fiber-left' style='background-color:" + jFiber.hexaColor + "'></div>";
//                                        if (jFiber.distributionBoxPort) {
//                                            html += "<ul>";
//                                            html += "<li data-jstree='{\"icon\":\"" + Path.IMAGE_UPLOADS + jFiber.distributionBoxPort.distributionBox.icon + "\"}'>";
//                                            html += "Caja distribución: " + jFiber.distributionBoxPort.distributionBox.name + " <strong>(" + jFiber.distributionBoxPort.distributionBox.address.location + ")</strong>";
//                                            html += "</li>";
//                                            html += "</ul>";
//                                        }
//                                        html += "</li>";
//                                        html += "</ul>";
//                                    }
//                                });
//                                html += "</li>";
//                                html += "</ul>";
//                            }
//                        });
//                        html += "</li>";
//                        html += "</ul>";
//                    }
//                });
//                html += "</li>";
//                html += "</ul>";
//            });
//            html += "</li>";
//            html += "</ul>";
//            html += "</div>";

            bootbox.dialog({
                title: 'Trayectoria',
                message: html
            });

            $('#tree').jstree();
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

        if (fiber.distributionBoxPort) {
            html += "<ul>";
            html += "<li data-jstree='{\"icon\":\"" + Path.IMAGE_UPLOADS + fiber.distributionBoxPort.distributionBox.icon + "\"}'>";
            html += "Caja distribución: " + fiber.distributionBoxPort.distributionBox.name + " <strong>(" + fiber.distributionBoxPort.distributionBox.address.location + ")</strong>";
            html += "</li>";
            html += "</ul>";
        }

        html += "</li>";
        html += "</ul>";

        return html;
    }
};