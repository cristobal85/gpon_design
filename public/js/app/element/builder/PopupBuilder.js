/* global Path, AttributeEnum */

/**
 * @return {PopupBuilder.PopupBuilderAnonym$4}
 * TODO: Generate Child class and hineritance
 */
var PopupBuilder = (function () {

    /**
     * @type {PopupBuilder}
     */
    var instance;

    /**
     * @type {PopupBuilder}
     */
    var self = this;

    /**
     * @type {Object}
     */
    var content = {};

    /**
     * @type {Object}
     */
    var buttons = {};


    function init() {



        return {

            /**
             * @param {{ id:string, label:string}} tab
             * @param {{id:Number, code:string, name:string, subscriberBoxOut:Number}[]} customers
             * @param {boolean} active
             * @returns {PopupBuilder}
             */
            addContentClientList: function (tab, customers, active) {
                var active = active || false;
                if (customers.length) {
                    var html = "<div class='tab-pane " + (active ? "show active" : "fade") + " p-2' id='" + tab.id + "' role='tabpanel' aria-labelledby='" + tab.id + "-tab'>";
                    customers.forEach(function (customer) {
                        html += "<ul class='list-inline p-0 m-0'>";
                        html += "<li class='list-inline-item'><span class='customer-active-led rounded-circle' style='background-color:" + (customer.active ? "green" : "red") + ";'></span></li>";
                        html += "<li class='list-inline-item'><b>Código: </b>" + customer.code + "</li>";
                        html += "<li class='list-inline-item'><b>Nombre: </b>" + customer.name + "</li>";
                        html += "</ul>";
                    });

                    html += "</div>";

                    content[tab.id] = {
                        tab: tab,
                        html: html,
                        active: active
                    };
                }

                return this;
            },

            /**
             * @param {{ id:string, label:string}} tab
             * @param {Object} items
             * @param {boolean} active
             * @returns {PopupBuilder}
             */
            addContentDescription: function (tab, items, active) {
                var active = active || false;
                if (items) {
                    var html = "<div class='tab-pane " + (active ? "show active" : "fade") + " p-2' id='" + tab.id + "' role='tabpanel' aria-labelledby='" + tab.id + "-tab'>";
                    html += "<ul>";
                    for (var key in items) {
                        if (items.hasOwnProperty(key)) {
                            html += "<li><b>" + key + ": </b>" + items[key] + "</li>";
                        }
                    }
                    html += "</ul>";
                    html += "</div>";

                    content[tab.id] = {
                        tab: tab,
                        html: html,
                        active: active
                    };
                }

                return this;
            },

            /**
             * @param {{ id:string, label:string}} tab
             * @param {{filePath:string}[]} images
             * @param {boolean} active
             * @returns {PopupBuilder}
             */
            addContentCarousel: function (tab, images, active) {
                var active = active || false;
                if (images.length) {
                    var html = "<div class='tab-pane " + (active ? "show active" : "fade") + " p-2' id='" + tab.id + "' role='tabpanel' aria-labelledby='" + tab.id + "-tab'>\
                    <div id='carouselExampleIndicators' class='carousel slide' data-ride='carousel'>\
                        <ol class='carousel-indicators'>";
                    images.forEach(function (image, index) {
                        var activeClass = "";
                        if (index === 0) {
                            activeClass = "class='active'";
                        }
                        html += "<li data-target='#carouselExampleIndicators' data-slide-to='" + index + "' " + activeClass + "></li>";
                    });
                    html += "</ol>\
                    <div class='carousel-inner bg-dark'>";
                    images.forEach(function (image, index) {
                        var activeClass = "";
                        if (index === 0) {
                            activeClass = "active";
                        }
                        html += "<div class='carousel-item text-center " + activeClass + "'>\
                        <a href='" + Path.IMAGE_UPLOADS + image.filePath + "' data-lightbox='" + image.filePath + "'>\
                            <img src='" + Path.IMAGE_UPLOADS + image.filePath + "' style='max-height:150px;'>\
                        </a>\
                    </div>";
                    });

                    html += "</div>\
                            <a class='carousel-control-prev' href='#carouselExampleIndicators' role='button' data-slide='prev'>\
                                <span class='carousel-control-prev-icon' aria-hidden='true'></span>\
                                <span class='sr-only'>Previous</span>\
                            </a>\
                            <a class='carousel-control-next' href='#carouselExampleIndicators' role='button' data-slide='next'>\
                                <span class='carousel-control-next-icon' aria-hidden='true'></span>\
                                <span class='sr-only'>Next</span>\
                            </a>\
                        </div>\
                    </div>";

                    content[tab.id] = {
                        tab: tab,
                        html: html,
                        active: active
                    };
                }

                return this;
            },

            /**
             * @param {{ id:string, label:string}} tab
             * @param {{filePath:string}} image
             * @param {boolean} active
             * @returns {PopupBuilder}
             */
            addContentImage: function (tab, image, active) {
                var active = active || false;
                if (image) {
                    var html = "<div class='tab-pane " + (active ? "show active" : "fade") + " p-2' id='" + tab.id + "' role='tabpanel' aria-labelledby='" + tab.id + "-tab'>";
                    html += "<a href='" + Path.IMAGE_UPLOADS + image + "' data-lightbox='" + image + "'>\
                            <img src='" + Path.IMAGE_UPLOADS + image + "' style='max-height:150px;'>\
                        </a>";
                    html += "</div>";

                    content[tab.id] = {
                        tab: tab,
                        html: html,
                        active: active
                    };
                }

                return this;
            },

            /**
             * @param {{ id:string, label:string}} tab
             * @param {{filePath:string}[]} pdfs
             * @param {boolean} active
             * @returns {PopupBuilder}
             */
            addContentPdf: function (tab, pdfs, active) {
                var active = active || false;
                if (pdfs.length) {
                    var html = "<div class='tab-pane " + (active ? "show active" : "fade") + " p-2' id='" + tab.id + "' role='tabpanel' aria-labelledby='" + tab.id + "-tab'>";
                    html += "<ul>";
                    pdfs.forEach(function (pdf) {
                        html += "<li><a href='" + Path.FILE_UPLOADS + pdf.filePath + "' target='_blank'>" + pdf.filePath + "</a></li>";
                    });
                    html += "</ul></div>";

                    content[tab.id] = {
                        tab: tab,
                        html: html,
                        active: active
                    };
                }

                return this;
            },

            /**
             * @param {{ id:string, label:string}} tab
             * @param {{id:Number, signalLoss:Number, fiber:{id:Number, color:string, hexaColor:string, tube:Tube}[]}} fusions
             * @param {boolean} active
             * @returns {PopupBuilder}
             */
            addContentFusion: function (tab, fusions, active) {
                var active = active || false;
                if (fusions.length) {
                    var html = "<div class='tab-pane " + (active ? "show active" : "fade") + " p-2' id='" + tab.id + "' role='tabpanel' aria-labelledby='" + tab.id + "-tab'>";
                    html += "<ul class='fusions'>";
                    fusions.forEach(function (fusion) {
                        if (fusion.fibers[0] && fusion.fibers[1]) {
                            html += "<li>";
                            html += "<span style='position:relative;top:-10px;'>" + fusion.fibers[0].tube.wire.name + " </span>";
                            html += "<div class='fusion tube-left' style='background-color:" + fusion.fibers[0].tube.hexaColor + "' title='Layer " + fusion.fibers[0].tube.layer + "'></div>";
                            html += "<div class='fusion fiber-left' style='background-color:" + fusion.fibers[0].hexaColor + "' title='Layer " + fusion.fibers[0].tube.layer + "'></div>";
                            html += "<div class='fusion signal-loss'>";
                            html += "<span>------------- </span>";
                            html += fusion.signalLoss + " dBm";
                            html += "<span> -------------</span>";
                            html += "</div>";
                            html += "<div class='fusion fiber-right' style='background-color:" + fusion.fibers[1].hexaColor + "' title='Layer " + fusion.fibers[1].tube.layer + "'></div>";
                            html += "<div class='fusion tube-right' style='background-color:" + fusion.fibers[1].tube.hexaColor + "' title='Layer " + fusion.fibers[1].tube.layer + "'></div>";
                            html += "<span style='position:relative;top:-10px;'> " + fusion.fibers[1].tube.wire.name + "</span>";
                            html += "<span class='fusion-options'><i class='far fa-trash-alt text-danger' title='Eliminar fusión' onclick='TorpedoFusionListener.deleteFusion(" + fusion.id + ", this)'></i></span>";
                            html += "</li>";
                        }
                    });
                    html += "</ul></div>";

                    content[tab.id] = {
                        tab: tab,
                        html: html,
                        active: active
                    };
                }

                return this;
            },

            /**
             * @param {{ id:string, label:string}} tab
             * @param {{id:Number, signalLoss:Number, fiber:{id:Number, color:string, hexaColor:string, tube:Tube}[]}} passants
             * @param {boolean} active
             * @returns {PopupBuilder}
             */
            addContentPassant: function (tab, passants, active) {
                var active = active || false;
                if (passants.length) {
                    var html = "<div class='tab-pane " + (active ? "show active" : "fade") + " p-2' id='" + tab.id + "' role='tabpanel' aria-labelledby='" + tab.id + "-tab'>";
                    html += "<ul class='fusions'>";
                    passants.forEach(function (passant) {
                        if (passant.fibers) {
                            if (passant.fibers[0] && passant.fibers[1]) {
                                html += "<li>";
                                html += "<span style='position:relative;top:-10px;'>" + passant.fibers[0].tube.wire.name + " </span>";
                                html += "<div class='fusion tube-left' style='background-color:" + passant.fibers[0].tube.hexaColor + "' title='Layer " + passant.fibers[0].tube.layer + "'></div>";
                                html += "<div class='fusion fiber-left' style='background-color:" + passant.fibers[0].hexaColor + "' title='Layer " + passant.fibers[0].tube.layer + "'></div>";
                                html += "<div class='fusion signal-loss'>";
                                html += "<span>------------- </span>";
                                html += "</div>";
                                html += "<div class='fusion fiber-right' style='background-color:" + passant.fibers[1].hexaColor + "' title='Layer " + passant.fibers[1].tube.layer + "'></div>";
                                html += "<div class='fusion tube-right' style='background-color:" + passant.fibers[1].tube.hexaColor + "' title='Layer " + passant.fibers[1].tube.layer + "'></div>";
                                html += "<span style='position:relative;top:-10px;'> " + passant.fibers[1].tube.wire.name + "</span>";
                                html += "</li>";
                            }
                        }
                    });
                    html += "</ul></div>";

                    content[tab.id] = {
                        tab: tab,
                        html: html,
                        active: active
                    };
                }

                return this;
            },

            /**
             * @param {{ id:string, label:string}} tab
             * @param {Object} rack
             * @param {boolean} active
             * @returns {PopupBuilderPopupBuilder.init.PopupBuilderAnonym$0}
             */
            addContentRom: function (tab, rack, active) {
                var active = active || false;
                var html = "<div class='tab-pane " + (active ? "show active" : "fade") + " p-2' id='" + tab.id + "' role='tabpanel' aria-labelledby='" + tab.id + "-tab'>";
                rack.patchPanels.forEach(function (patchPanel) {
                    html += "<div class='card mt-3'>";
                    html += "<div class='card-header'>" + patchPanel.name + "</div>";
                    html += "<div class='card-body'>";
                    html += "<div class='row'>";
                    html += "<div class='col-12 mt-4'>";
                    html += "<div class='row'>";
                    patchPanel.patchPanelSlots.forEach(function (slot) {
                        html += "<div class='col text-center'>";
                        slot.patchPanelSlotConectors.forEach(function (conector) {
                            var classes = "";
                            if (conector.fiber) {
                                classes += "bg-success";
                            }
                            html += "<a href='#' title='" + (conector.description || 'No definido') + "' class='" + classes + "' style='display:block;' onclick='PatchPanelListener.showModal(" + conector.id + ")' oncontextmenu='javascript:PatchPanelListener.showPromptDescription(" + conector.id + ");return false;'>" + conector.number + "</a>";
                        });
                        html += "<a href='#' class='mt-2' onclick='PatchConectorFormListener.showModal(" + slot.id + ")'><i class='fas fa-link'></i></a>";
                        html += "</div>";
                    });
                    html += "</div>";
                    html += "</div>";
                    html += "</div>";
                    html += "</div>";
                    html += "</div>";
                });
                html += "</div>";

                content[tab.id] = {
                    tab: tab,
                    html: html,
                    active: active
                };

                return this;
            },
            
            /**
             * @param {{ id:string, label:string}} tab
             * @param {Object} rack
             * @param {boolean} active
             * @returns {PopupBuilderPopupBuilder.init.PopupBuilderAnonym$0}
             */
            addDisconnectContentRom: function (tab, rack, active) {
                var active = active || false;
                var html = "<div class='tab-pane " + (active ? "show active" : "fade") + " p-2' id='" + tab.id + "' role='tabpanel' aria-labelledby='" + tab.id + "-tab'>";
                rack.patchPanels.forEach(function (patchPanel) {
                    html += "<div class='card mt-3'>";
                    html += "<div class='card-header'>" + patchPanel.name + "</div>";
                    html += "<div class='card-body'>";
                    html += "<div class='row'>";
                    html += "<div class='col-12 mt-4'>";
                    html += "<div class='row'>";
                    patchPanel.patchPanelSlots.forEach(function (slot) {
                        html += "<div class='col text-center'>";
                        slot.patchPanelSlotConectors.forEach(function (conector) {
                            var classes = "";
                            if (conector.fiber) {
                                classes += "bg-success";
                            }
                            html += "<a href='#' title='" + (conector.description || 'No definido') + "' class='" + classes + "' style='display:block;' onclick='PatchPanelListener.disconnectPort(" + conector.id + ")'>" + conector.number + "</a>";
                        });
                        html += "</div>";
                    });
                    html += "</div>";
                    html += "</div>";
                    html += "</div>";
                    html += "</div>";
                    html += "</div>";
                });
                html += "</div>";

                content[tab.id] = {
                    tab: tab,
                    html: html,
                    active: active
                };

                return this;
            },
            
            

            /**
             * @param {{id:Number, name:string}[]} racks
             * @returns {PopupBuilderPopupBuilder.init.PopupBuilderAnonym$0}
             */
            addDissconectPortRom: function (racks) {
                var self = this;
                racks.forEach(function (rack) {
                    if (rack.patchPanels.length) {
                        self.addDisconnectContentRom(
                                {id: 'rack-' + rack.id, label: rack.name},
                                rack,
                                false)
                                ;
                    }
                });

                return this;
            },

            /**
             * @param {{ id:string, label:string}} tab
             * @param {{id:Number, number:Number}[]} ports
             * @param {boolean} active
             * @returns {PopupBuilderPopupBuilder.init.PopupBuilderAnonym$0}
             */
            addContentDsPorts: function (tab, ports, active) {
                var active = active || false;
                if (ports.length) {
                    var html = "<div class='tab-pane " + (active ? "show active" : "fade") + " p-2' id='" + tab.id + "' role='tabpanel' aria-labelledby='" + tab.id + "-tab'>";

                    html += "<div class='card mt-3'>";
                    html += "<div class='card-header'>Segundo 50%</div>";
                    html += "<div class='card-body'>";
                    html += "<div class='row'>";
                    // TODO: Refactoring two for loop.
                    for (var i = (ports.length / 2); i < ports.length; i++) {
                        var classes = "";
                        if (ports[i].fiber) {
                            classes += "bg-success";
                        }
                        html += "<div class='col text-center " + classes + "'>";
                        html += "<a href='#' " + AttributeEnum.DATA_DS_BOX_ID + "='" + ports[i].id + "' style='display:block;' onclick='javascript:DistributionBoxListener.showModal(" + ports[i].id + ");return false;' oncontextmenu=\"javascript:DistributionBoxListener.dissconectPort(this);return false;\">" + ports[i].number + "</a>";
                        html += "</div>";
                    }
                    html += "</div>";
                    html += "</div>";
                    html += "</div>";

                    html += "<div class='card mt-3'>";
                    html += "<div class='card-header'>Primer 50%</div>";
                    html += "<div class='card-body'>";
                    html += "<div class='row'>";
                    for (var i = 0; i < (ports.length / 2); i++) {
                        var classes = "";
                        if (ports[i].fiber) {
                            classes += "bg-success";
                        }
                        html += "<div class='col text-center " + classes + "'>";
                        html += "<a href='#' " + AttributeEnum.DATA_DS_BOX_ID + "='" + ports[i].id + "' style='display:block;' onclick='javascript:DistributionBoxListener.showModal(" + ports[i].id + ");return false;' oncontextmenu=\"javascript:DistributionBoxListener.dissconectPort(this);return false;\">" + ports[i].number + "</a>";
                        html += "</div>";
                    }
                    html += "</div>";
                    html += "</div>";
                    html += "</div>";



                    html += "</div>";


                    content[tab.id] = {
                        tab: tab,
                        html: html,
                        active: active
                    };
                }

                return this;
            },
            
            /**
             * @param {{ id:string, label:string}} tab
             * @param {{id:Number, number:Number}[]} ports
             * @param {boolean} active
             * @returns {PopupBuilderPopupBuilder.init.PopupBuilderAnonym$0}
             */
            addDiscontentDsPorts: function (tab, ports, active) {
                var active = active || false;
                if (ports.length) {
                    var html = "<div class='tab-pane " + (active ? "show active" : "fade") + " p-2' id='" + tab.id + "' role='tabpanel' aria-labelledby='" + tab.id + "-tab'>";

                    html += "<div class='card mt-3'>";
                    html += "<div class='card-header'>Segundo 50%</div>";
                    html += "<div class='card-body'>";
                    html += "<div class='row'>";
                    // TODO: Refactoring two for loop.
                    for (var i = (ports.length / 2); i < ports.length; i++) {
                        var classes = "";
                        if (ports[i].fiber) {
                            classes += "bg-success";
                        }
                        html += "<div class='col text-center " + classes + "'>";
                        html += "<a href='#' " + AttributeEnum.DATA_DS_BOX_ID + "='" + ports[i].id + "' style='display:block;' onclick=\"javascript:DistributionBoxListener.dissconectPort(this);return false;\">" + ports[i].number + "</a>";
                        html += "</div>";
                    }
                    html += "</div>";
                    html += "</div>";
                    html += "</div>";

                    html += "<div class='card mt-3'>";
                    html += "<div class='card-header'>Primer 50%</div>";
                    html += "<div class='card-body'>";
                    html += "<div class='row'>";
                    for (var i = 0; i < (ports.length / 2); i++) {
                        var classes = "";
                        if (ports[i].fiber) {
                            classes += "bg-success";
                        }
                        html += "<div class='col text-center " + classes + "'>";
                        html += "<a href='#' " + AttributeEnum.DATA_DS_BOX_ID + "='" + ports[i].id + "' style='display:block;' onclick=\"javascript:DistributionBoxListener.dissconectPort(this);return false;\">" + ports[i].number + "</a>";
                        html += "</div>";
                    }
                    html += "</div>";
                    html += "</div>";
                    html += "</div>";



                    html += "</div>";


                    content[tab.id] = {
                        tab: tab,
                        html: html,
                        active: active
                    };
                }

                return this;
            },

            /**
             * 
             * @param {string} href Resource URL
             * @param {Number} id ID from database
             * @returns {PopupBuilderPopupBuilder.init.PopupBuilderAnonym$0}
             */
            addEditButton: function (href, id) {
                buttons[id] = "<a href='/" + href + "/" + id + "/edit' class='btn btn-outline-primary btn-sm' role='button'><i class='fas fa-edit'></i> Editar</a>";

                return this;
            },

            /**
             * @param {string} href Resource URL
             * @param {Number} elementId ID from database
             * @returns {PopupBuilderPopupBuilder.init.PopupBuilderAnonym$0}
             */
            addDeleteBtn: function (href, elementId) {
                buttons['delete-btn'] = "<button type='button' class='btn btn-outline-danger btn-sm ml-2' onclick='ElementActionListener.delete(" + href + ", " + elementId + ")'><i class='far fa-trash-alt'></i> Eliminar</a>";

                return this;
            },

            /**
             * @param {Number} elementId ID from database
             * @returns {PopupBuilderPopupBuilder.init.PopupBuilderAnonym$0}
             */
            addEditFusionBtn: function (elementId) {
                buttons['edit-fusion'] = "<a href='#' class='btn btn-outline-primary btn-sm ml-2' role='button' onclick='TorpedoFusionListener.showModal(" + elementId + ")'><i class='fas fa-plus'></i> Fusiones</a>";

                return this;
            },

            /**
             * @param {Number} elementId ID from database
             * @returns {PopupBuilderPopupBuilder.init.PopupBuilderAnonym$0}
             */
            addTorpedoPassantBtn: function (elementId) {
                buttons['edit-torpedo-passant'] = "<a href='#' class='btn btn-outline-primary btn-sm ml-2' role='button' onclick='TorpedoPassantListener.showModal(" + elementId + ")'><i class='fas fa-network-wired'></i> Pasante</a>";

                return this;
            },
            
            /**
             * @param {Number} elementId ID from database
             * @returns {PopupBuilderPopupBuilder.init.PopupBuilderAnonym$0}
             */
            addSubscriberBoxPhotoBtn: function (elementId) {
                buttons['add-subscriber-box-photo-btn'] = "<a href='#' class='btn btn-outline-primary btn-sm ml-2' role='button' onclick='SubscriberBoxListener.showPhotoModal(" + elementId + ")'><i class='fas fa-camera'></i> Fotos</a>";

                return this;
            },

//            /**
//             * @param {Number} elementId ID from database
//             * @returns {PopupBuilderPopupBuilder.init.PopupBuilderAnonym$0}
//             */
//            addDistributionPassantBtn: function (elementId) {
//                buttons['edit-distribution-passant'] = "<a href='#' class='btn btn-outline-primary btn-sm ml-2' role='button' onclick='DistributionBoxPassantListener.showModal(" + elementId + ")'><i class='fas fa-network-wired'></i> Pasante</a>";
//
//                return this;
//            },

//            /**
//             * @param {Number} elementId ID from database
//             * @returns {PopupBuilderPopupBuilder.init.PopupBuilderAnonym$0}
//             */
//            addEditConectorBtn: function (elementId) {
//                buttons['distribution-conector'] = "<a href='#' class='btn btn-outline-primary btn-sm ml-2' role='button' onclick='DsBoxConectorFormListener.showModal(" + elementId + ")'><i class='fas fa-network-wired'></i> Conectar</a>";
//
//                return this;
//            },

//            /**
//             * @param {Number} elementId ID from database
//             * @returns {PopupBuilderPopupBuilder.init.PopupBuilderAnonym$0}
//             */
//            addPatchConectorBtn: function (elementId) {
//                buttons['patch-conector'] = "<a href='#' class='btn btn-outline-primary btn-sm ml-2' role='button' onclick='PatchConectorFormListener.showModal(" + elementId + ")'><i class='fas fa-network-wired'></i> Conectar</a>";
//
//                return this;
//            },

            /**
             * @param {Number} width
             * @param {Number} height
             * @return {string}
             */
            build: function (width, height) {
                if (!width || !height) {
                    throw new Error("build need width and height arguments.");
                }
                var html = "<div style='width:" + width + "px;min-height:" + height + "px;'>\
                                <ul class='nav nav-tabs' id='myTab' role='tablist'>";
                for (var key in content) {
                    if (content.hasOwnProperty(key)) {
                        html += "<li class='nav-item'>\
                                    <a class='nav-link " + (content[key].active ? "active" : "") + "' id='" + key + "-tab' data-toggle='tab' href='#" + key + "' role='tab' aria-controls='home' aria-selected='true'>" + content[key].tab.label + "</a>\
                                </li>";
                    }
                }
                html += "</ul>";
                html += "<div class='tab-content' id='myTabContent'>";
                for (var key in content) {
                    if (content.hasOwnProperty(key)) {
                        html += content[key].html;
                    }
                }
                html += "</div>";
                html += "<div class='d-block text-right'>";
                for (var key in buttons) {
                    if (buttons.hasOwnProperty(key)) {
                        html += buttons[key];
                    }
                }
                html += "</div>";
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
            content = {};
            buttons = {};
            return instance;
        }
    };

})();