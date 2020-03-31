/* global L, LControlAdapter, GeoAdapter, MapUrl, LoaderAdapter, ModalAdapter */

var mapId = "#map";
//var mapHeight = $(window).height() - ($(window).height() / 17);
//var mapHeight = $(document).height() - 70;
//$(mapId).height(mapHeight);

var mapView = new Vue({

    el: mapId,

    data: {

        /**
         * @type {L.map}
         */
        map: null,

        /**
         * @type {{title:string, tileLayer:L.tileLayer}}
         */
//        baseLayer: {},

        /**
         * @type {L.Control}
         */
        lControl: L.control.layers(),

        /**
         * @type {L.layerGroup}
         */
        lGroup: L.layerGroup([]),

        /**
         * @type {L.Control.Search}
         */
        lSearch: new L.Control.Search({
            layer: L.layerGroup([]),
            textPlaceholder: "Buscar elemento",
            textErr: "Elemento no encontrado.",
            textCancel: "Cancelar",
            zoom: 999,
            marker: {
                circle: {
                    weight: 5
                }
            }
        }),
    },

    methods: {

        /**
         * @param {Layer} layer
         * @returns {undefined}
         */
        renderLayerControl: function (layer) {
            var self = this;
            var layerGroup = L.layerGroup(layer.getLayers()).addTo(this.map);

//            var markerClusterGroup = L.markerClusterGroup().addLayers(layerGroup); // TODO: CREATE CHILD NODES and show im MAX ZOOM
            var layerDiv = "<div style='color:" + layer.hexaColor + ";display:inline'>" + layer.name + "</div>";
            this.lControl.addOverlay(layerGroup, layerDiv).addTo(this.map);
        },

//        /**
//         * Print all Layer on the map (DistributionBoxes, Subscriber, ...) and show Control Layer.
//         * @param {Layer[]} layers
//         * @returns {undefined}
//         */
//        renderLayersControl: function (layers) {
//            var self = this;
//            var groupLayers = {};
//            var divLayer = {};
//
//
//            layers.forEach(function (layer) {
//                Array.prototype.push.apply(self.layers, layer.getLayers());
////                if (self.lCount <= 7) {
////                    self.lCount++;
////                    Array.prototype.push.apply(self.layers, layer.getLayers());
////                    console.log(self.layers);
////                } else if (self.lCount == 8) {
////                    self.lCount++;
////                    console.log("=====================> Nodo09");
//                layer.getLayers().forEach(function (l) {
//                    console.log(l);
//                    if (!l.options.title) {
//                        console.log(l.options.title);
//                        console.log(l);
//                    }
//                });
////                }
//////                var nodoCluster = L.markerClusterGroup().addLayers(layer.getLayer());
//////                nodoCluster.getVisibleParent(layer.getLayer());
//////                var distributionLayerCluster = L.markerClusterGroup().addLayers(layer.getDistributionBoxLayer());
//////                nodoCluster.addLayers(distributionLayerCluster);
//////                groupLayers[layer.name] = L.layerGroup(layer.getDistributionBoxLayer()); // THIS WORKING WITH RELATIONS
////                groupLayers[layer.name] = L.layerGroup(layer.getLayers()); // MAIN
//////                groupLayers[layer.name] = nodoCluster;
////                groupLayers[layer.name].addTo(self.map);
//            });
////            layers.forEach(function (layer) {
////                divLayer["<div style='color:" + layer.hexaColor + ";display:inline'>" + layer.name + "</div>"] = groupLayers[layer.name];
////            });
////
////            L.control.layers(this.baseLayer, divLayer).addTo(self.map);
//        },

        /**
         * 
         * @param {Cpd} cpd
         * @return {undefined}
         */
        renderMap: function (cpd) {

            var self = this;

            if (cpd.maps) {
                var zoom = cpd.maps[0].maxZoom - Math.round((cpd.maps[0].maxZoom - cpd.maps[0].minZoom) / 2);
                this.map = L.map('map', {
                    attributionControl: false,
                    editable: true,
                    renderer: L.canvas(),
                    contextmenu: true, // Enable context menu on the map (enable / disable all contextmenus)
                    contextmenuItems: [{
                            text: '<strong>Mapa</strong>',
                            disabled: true
                        },
                        {
                            text: 'Mostrar coordenadas',
                            callback: function (e) {
                                ModalAdapter.showModal('Información', "\
                                    <p>Latitud: " + e.latlng.lat + "</p>\
                                    <p>Longitud: " + e.latlng.lng + "</p>\
                                ");
                            }
                        },
                        {
                            text: 'Nueva nota',
                            callback: function (e) {
                                ModalAdapter.showModal('Información', "\
                                    <p>Latitud: " + e.latlng.lat + "</p>\
                                    <p>Longitud: " + e.latlng.lng + "</p>\
                                ");
                            }
                        },
                        {
                            text: 'Nueva alerta',
                            callback: function (e) {
                                ModalAdapter.showModal('Información', "\
                                    <p>Latitud: " + e.latlng.lat + "</p>\
                                    <p>Longitud: " + e.latlng.lng + "</p>\
                                ");
                            }
                        },
                        '-'
                    ]
                }).setView([cpd.latitude, cpd.longitude], zoom);

                cpd.maps.forEach(function (map) {
                    var geoMap = null;
                    if (map.wms) {
                        geoMap = L.tileLayer.wms(map.url, {
                            layers: map.name, //nombre de la capa (ver get capabilities)
                            format: 'image/png',
                            transparent: true,
                            version: map.version, //wms version (ver get capabilities)
                            attribution: map.displayName,
                            minZoom: map.minZoom,
                            maxZoom: map.maxZoom
                        });
                    } else {
                        geoMap = L.tileLayer(map.url, {
                            minZoom: map.minZoom,
                            maxZoom: map.maxZoom
                        });
                    }
                    self.lControl.addBaseLayer(geoMap, map.displayName).addTo(self.map);
                    if (map.defaultMap) {
                        self.map.addLayer(geoMap);
                    }
                });
            }
            this.renderEditControls();
            this.renderSearchControl();
        },

        /**
         * @returns {undefined}
         */
        renderEditControls: function () {

            var drawControl = new L.Control.Draw({
                draw: {
                    polyline: true,
                    polygon: true,
                    circle: false,
                    rectangle: false,
                    marker: true,
                    circlemarker: false
                }
            });

            L.drawLocal.draw.toolbar.buttons.polyline = 'Añadir Cable';
            L.drawLocal.draw.toolbar.buttons.marker = 'Añadir Caja';
            L.drawLocal.draw.toolbar.buttons.polygon = 'Añadir delimitador';
            L.drawLocal.draw.handlers.polygon.tooltip.start = 'Click para comenzar el delimitador';
            L.drawLocal.draw.handlers.polygon.tooltip.cont = 'Click para crear vértice (mínimo 5)';
            L.drawLocal.draw.handlers.polygon.tooltip.end = 'Click en el último vértice para finalizar';
            L.drawLocal.draw.handlers.polyline.tooltip.start = 'Click para comenzar el cableado';
            L.drawLocal.draw.handlers.polyline.tooltip.cont = 'Click para crear vértice';
            L.drawLocal.draw.handlers.polyline.tooltip.end = 'Click en el último vértice para finalizar';
            L.drawLocal.draw.handlers.marker.tooltip.start = 'Click para ubicar';

            this.map.addControl(drawControl);

//            this.map.addControl(new L.Control.Search({
//                container: 'findbox',
////                layer: markersLayer,
//                initial: false,
//                collapsed: false
//            }));

            var self = this;
            LControlAdapter.addCenterPositionControl(this.map, function () {
                GeoAdapter.getLocation().then(function (location) {
                    var coordinates = location.coords;
                    self.map.flyTo([coordinates.latitude, coordinates.longitude], MapUrl.ARCGIS_STREET_SATELITE.maxZoom);
                });
            });
        },

        /**
         * @returns {undefined}
         */
        renderSearchControl: function () {
            this.lSearch.addTo(this.map);
            this.lSearch.setLayer(this.lGroup);
        },

        /**
         * 
         * @param {L} layer
         * @return {undefined}
         */
        renderFixedLayer: function (layer) {
            this.map.addLayer(layer);
            if (layer instanceof L.Marker) {
                this.lGroup.addLayer(layer);
                this.lSearch.setLayer(this.lGroup);
            }
        },

        /**
         * @param {Elementlistener} listener
         * @returns {undefined}
         */
        subscribe: function (listener) {
            this.map.on(listener.getEventType(), function (e) {
                listener.listen(e);
            });
        },

        /**
         * @param {L[]} layers
         * @return {undefined}
         */
        addLayersToSearch: function (layers) {
            var self = this;
            layers.forEach(function (layer) {
                layer.getLayers().forEach(function (l) {
                    if (l instanceof L.Marker) {
                        self.lGroup.addLayer(l);
                    }
                });
            });
            this.lSearch.setLayer(this.lGroup);
        },

        /**
         * @param {L} layer
         * @return {undefined}
         */
        renderLayer: function (layer) {
            this.map.addLayer(layer);
            if (layer instanceof L.Marker) {
                this.lGroup.addLayer(layer);
                this.lSearch.setLayer(this.lGroup);
            }
        },

        /**
         * @param {L} layer
         * @return {undefined}
         */
        deleteLayer: function (layer) {
            this.map.removeLayer(layer);
            if (layer instanceof L.Marker) {
                this.lGroup.removeLayer(layer);
                this.lSearch.setLayer(this.lGroup);
            }
        }

    }
});