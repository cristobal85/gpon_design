/* global Path, AttributeEnum, ApiUrl, AjaxAdapter */

/**
 * @return {ROMPathBuilder.PathBuilderAnonym$4}
 */
var ROMPathBuilder = (function () {

    /**
     * @type {ROMPathBuilder}
     */
    var instance;

    /**
     * @type {ROMPathBuilder}
     */
    var self = this;

    /**
     * @type {string}
     */
    var html = "";
    
    /**
     * 
     * @type {Number}
     */
    var longitude = 0;

    /**
     * 
     * @type {{ latiguilloPath, fiber}} patchPanelConector
     */
    var patchPanelConector = null;

    function init() {



        return {

            /**
             * @returns {ROMPathBuilder}
             */
            addOltPath: async function () {
                var self = instance;
                if (patchPanelConector) {
                    var latiguilloPatch = patchPanelConector.latiguilloPatch;
                    html += "<ul>";
                    html += "<li>";
                    html += "Conector CPD: ";
                    html += patchPanelConector.patchPanelSlot.patchPanel.rack.name + "_";
                    html += patchPanelConector.patchPanelSlot.patchPanel.name + "_";
                    html += patchPanelConector.patchPanelSlot.number + "_";
                    html += patchPanelConector.number;
                    html += " <strong>(" + patchPanelConector.patchPanelSlot.patchPanel.rack.name + ")</strong>";
                    html += "<ul>";
                    html += "<li>";
                    html += "Latiguillo a EDFA: " + latiguilloPatch.name;
                    if (latiguilloPatch.edfaPort) {
                        var edfaPort = latiguilloPatch.edfaPort;
                        html += "<ul>";
                        html += "<li>";
                        html += "Puerto EDFA: " + edfaPort.edfaSlot.edfa.name + " Puerto <strong>" + edfaPort.number + "</strong>";
                        await AjaxAdapter.get(ApiUrl.GET_EDFA_PORT_ID + edfaPort.id + "/" + ((edfaPort.edfaSlot.type.toLowerCase() === 'out') ? 'in' : 'out')).then(function (response) {
                            var edfaPort = response.data;
                            if (edfaPort.latiguilloEdfa) {
                                var latiguilloEdfa = edfaPort.latiguilloEdfa;
                                html += "<ul>";
                                html += "<li>";
                                html += "Latiguillo a OLT: " + latiguilloEdfa.name;
                                if (latiguilloEdfa.oltPort) {
                                    var oltPort = latiguilloEdfa.oltPort;
                                    html += "<ul>";
                                    html += "<li>";
                                    html += "Puerto OLT: <strong>" + oltPort.oltSlot.olt.name + " / Tarjeta " + oltPort.oltSlot.number + " / Puerto " + oltPort.number + "</strong>";
                                    html += "</li>";
                                    html += "</ul>";
                                }
                                html += "</li>";
                                html += "</ul>";
                            }
                        });

                        html += "</li>";
                        html += "</ul>";
                    }
                    html += "</li>";
                    html += "</ul>";
                    html += "</li>";
                    html += "</ul>";
                }

                return this;
            },

            /**
             * @param {{ latiguilloPath, fiber}} patchPanelSlotConector
             * @returns {ROMPathBuilder}
             */
            addRomToOltPath: async function (patchPanelSlotConector) {
                var self = instance;
                if (patchPanelSlotConector.latiguilloPatch) {
                    patchPanelConector = patchPanelSlotConector;
                    html += "<ul>";
                    html += "<li>";
                    html += "<strong>Trayectoria a OLT</strong>";
                    await self.addOltPath();
                    html += "</li>";
                    html += "</ul>";
                }

                return this;
            },

            /**
             * 
             * @param {{id:Number, tube, hexaColor:string, torpedoFusions:[], torpedoPassans:[], distributionBoxPassants}} fiber
             * @returns {ROMPathBuilderROMPathBuilder.init.ROMPathBuilderAnonym$0}
             */
            addDistributionBoxPath: function (fiber) {
                var self = instance;
                if (fiber) {
                    html += "<ul>";
                    html += "<li>";
                    html += "<strong>Trayectoria a Caja Distribución</strong>";
                    html += self.generateNexo(fiber);
                    html += "</li>";
                    html += "</ul>";
                }

                return this;
            },

            /**
             * 
             * @param {{id:Number, tube, hexaColor:string, torpedoFusions:[], torpedoPassans:[], distributionBoxPassants}} fiber
             * @returns {ROMPathBuilderROMPathBuilder.init.ROMPathBuilderAnonym$0}
             */
            addDsToRomPath: function (fiber) {
                var self = instance;
                if (fiber) {
                    html += "<ul>";
                    html += "<li>";
                    html += "<strong>Trayectoria a CPD</strong>";
                    html += self.generateNexo(fiber);
                    html += "</li>";
                    html += "</ul>";
                }

                return this;
            },

            /**
             * 
             * @param {{id:Number, color:string, distributionBoxPort:DistributionBoxPort, hexaColor:string, patchPanelSlotConector:PatchPanelSlotConector, torpedoFusions:array, torpedoPassants:array, tube:Tube}} fiber
             * @returns {undefined}
             */
            generateNexo: function (fiber) {
                var self = instance;
                longitude += parseFloat(fiber.tube.wire.longitude.toFixed(2));
                var html = "<ul>";
                html += "<li data-jstree='{\"icon\":\"" + Path.IMAGE_UPLOADS + fiber.tube.wire.image + "\"}'>";
                html += "Fibra: " + fiber.tube.wire.name + " (" + fiber.tube.wire.longitude.toFixed(2) + "m)" + " <strong>(" + longitude + "m)</strong>";
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

                    if (fiber.patchPanelSlotConector.latiguilloPatch) {
                        patchPanelConector = fiber.patchPanelSlotConector;
                    }
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
            },

            /**
             * @return {string}
             */
            build: function () {
                html += "</div>";
                return html;
            }
        };

    }
    ;

    return {
        getInstance: function () {
            if (!instance) {
                instance = init();
            }
            html = "<div id='tree'>";
            patchPanelConector = null;
            longitude = 0;
            return instance;
        }
    };

})();