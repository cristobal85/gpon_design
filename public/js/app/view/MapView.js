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
        lControl: L.control.layers()

    },

    methods: {

        /**
         * @param {Layer} layer
         * @returns {undefined}
         */
        renderLayerControl: function (layer) {
            var layerGroup = L.layerGroup(layer.getLayers()).addTo(this.map);
//            var markerClusterGroup = L.markerClusterGroup().addLayers(layerGroup); // TODO: CREATE CHILD NODES and show im MAX ZOOM
            var layerDiv = "<div style='color:" + layer.hexaColor + ";display:inline'>" + layer.name + "</div>";
            this.lControl.addOverlay(layerGroup, layerDiv).addTo(this.map);
        },

        /**
         * Print all Layer on the map (DistributionBoxes, Subscriber, ...) and show Control Layer.
         * @param {Layer[]} layers
         * @returns {undefined}
         */
        renderLayersControl: function (layers) {
            var self = this;
            var groupLayers = {};
            var divLayer = {};


            layers.forEach(function (layer) {
//                var nodoCluster = L.markerClusterGroup().addLayers(layer.getLayer());
//                nodoCluster.getVisibleParent(layer.getLayer());
//                var distributionLayerCluster = L.markerClusterGroup().addLayers(layer.getDistributionBoxLayer());
//                nodoCluster.addLayers(distributionLayerCluster);
//                groupLayers[layer.name] = L.layerGroup(layer.getDistributionBoxLayer()); // THIS WORKING WITH RELATIONS
                groupLayers[layer.name] = L.layerGroup(layer.getLayers()); // MAIN
//                groupLayers[layer.name] = nodoCluster;
                groupLayers[layer.name].addTo(self.map);

            });
            layers.forEach(function (layer) {
                divLayer["<div style='color:" + layer.hexaColor + ";display:inline'>" + layer.name + "</div>"] = groupLayers[layer.name];
            });

            L.control.layers(this.baseLayer, divLayer).addTo(self.map);
        },

        /**
         * 
         * @param {Number} lat
         * @param {Number} long
         * @return {undefined}
         */
        renderMap: function (lat, long) {
            var openStreetMapLayer = L.tileLayer(MapUrl.OPEEN_STREET_MAP.url, {
                minZoom: MapUrl.OPEEN_STREET_MAP.minZoom,
                maxZoom: MapUrl.OPEEN_STREET_MAP.maxZoom
            });
            var arcgisStreetSateliteLayer = L.tileLayer(MapUrl.ARCGIS_STREET_SATELITE.url, {
                minZoom: MapUrl.ARCGIS_STREET_SATELITE.minZoom,
                maxZoom: MapUrl.ARCGIS_STREET_SATELITE.maxZoom
            });

            var zoom = MapUrl.OPEEN_STREET_MAP.maxZoom - Math.round((MapUrl.OPEEN_STREET_MAP.maxZoom - MapUrl.OPEEN_STREET_MAP.minZoom) / 2);
            this.map = L.map('map', {
                attributionControl: false,
                editable: true,
                renderer: L.canvas()
            }).setView([lat, long], zoom).addLayer(openStreetMapLayer); // Default MAP

            this.lControl.addBaseLayer(openStreetMapLayer, MapUrl.OPEEN_STREET_MAP.name);
            this.lControl.addBaseLayer(arcgisStreetSateliteLayer, MapUrl.ARCGIS_STREET_SATELITE.name);
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

            var self = this;
            LControlAdapter.addCenterPositionControl(this.map, function () {
                GeoAdapter.getLocation().then(function (location) {
                    var coordinates = location.coords;
                    self.map.flyTo([coordinates.latitude, coordinates.longitude], MapUrl.OPEEN_STREET_MAP.maxZoom);
                });
            });
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
            console.log('removeLayer from mapView');
            this.map.removeLayer(layer);
        }

    }
});