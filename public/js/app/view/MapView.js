/* global L, LControlAdapter, GeoAdapter, MapUrl, LoaderAdapter, ModalAdapter */

var mapId = "#map";
var mapHeight = $(window).height() - ($(window).height() / 14);
$(mapId).height(mapHeight);

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
                    contextmenu: true // Enable context menu on the map (enable / disable all contextmenus)
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
//            var openStreetMapLayer = L.tileLayer(MapUrl.OPEEN_STREET_MAP.url, {
//                minZoom: MapUrl.OPEEN_STREET_MAP.minZoom,
//                maxZoom: MapUrl.OPEEN_STREET_MAP.maxZoom
//            });
//            var arcgisStreetSateliteLayer = L.tileLayer(MapUrl.ARCGIS_STREET_SATELITE.url, {
//                minZoom: MapUrl.ARCGIS_STREET_SATELITE.minZoom,
//                maxZoom: MapUrl.ARCGIS_STREET_SATELITE.maxZoom
//            });
//
//            var catastroStreetLayer = L.tileLayer.wms(MapUrl.CATASTRO.url, {
//                layers: MapUrl.CATASTRO.name, //nombre de la capa (ver get capabilities)
//                format: 'image/png',
//                transparent: true,
//                version: '1.1.1', //wms version (ver get capabilities)
//                attribution: MapUrl.CATASTRO.displayName,
//                minZoom: MapUrl.CATASTRO.minZoom,
//                maxZoom: MapUrl.CATASTRO.maxZoom
//            });
//
//            var catastroParcelaStreetLayer = L.tileLayer.wms(MapUrl.CATASTRO_PARCELA.url, {
//                layers: MapUrl.CATASTRO_PARCELA.name, //nombre de la capa (ver get capabilities)
//                format: 'image/png',
//                transparent: true,
//                version: '1.1.1', //wms version (ver get capabilities)
//                attribution: MapUrl.CATASTRO_PARCELA.displayName,
//                minZoom: MapUrl.CATASTRO_PARCELA.minZoom,
//                maxZoom: MapUrl.CATASTRO_PARCELA.maxZoom
//            });
//
//
//
//            var zoom = MapUrl.OPEEN_STREET_MAP.maxZoom - Math.round((MapUrl.OPEEN_STREET_MAP.maxZoom - MapUrl.OPEEN_STREET_MAP.minZoom) / 2);
//            this.map = L.map('map', {
//                attributionControl: false,
//                editable: true,
//                renderer: L.canvas(),
//                contextmenu: true, // Enable context menu on the map (enable / disable all contextmenus)
//            }).setView([cpd.latitude, cpd.longitude], zoom).addLayer(arcgisStreetSateliteLayer); // Default MAP

//            this.lControl.addBaseLayer(openStreetMapLayer, MapUrl.OPEEN_STREET_MAP.displayName);
//            this.lControl.addBaseLayer(arcgisStreetSateliteLayer, MapUrl.ARCGIS_STREET_SATELITE.displayName);
//            this.lControl.addBaseLayer(catastroStreetLayer, MapUrl.CATASTRO.displayName);
//            this.lControl.addBaseLayer(catastroParcelaStreetLayer, MapUrl.CATASTRO_PARCELA.displayName);
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
         * @param {Layer[]} layers
         * @returns {undefined}
         */
        renderSearchControl: function (layers) {
            var leaftLayers = [];
            layers.forEach(function (layer) {
                layer.getLayers().forEach(function (l) {
                    if (l instanceof L.Marker) {
                        leaftLayers.push(l);
                    }
                });
            });
            new L.Control.Search({
                layer: L.layerGroup(leaftLayers),
                textPlaceholder: "Buscar elemento",
                textErr: "Elemento no encontrado.",
                textCancel: "Cancelar",
                zoom: 999,
                marker: {
                    circle: {
                        weight: 5
                    }
                }
            }).addTo(this.map);

        },

        /**
         * 
         * @param {L} layer
         * @return {undefined}
         */
        renderFixedLayer: function (layer) {
            this.map.addLayer(layer);
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
         * @param {L} layer
         * @return {undefined}
         */
        renderLayer: function (layer) {
            this.map.addLayer(layer);
        },

        /**
         * @param {L} layer
         * @return {undefined}
         */
        deleteLayer: function (layer) {
            this.map.removeLayer(layer);
        }

    }
});