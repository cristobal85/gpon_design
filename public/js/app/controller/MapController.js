/* global AjaxAdapter, GeoAdapter, mapView, Map, ApiUrl, CpdService, MapService, LayerService, LoaderAdapter, Promise, NoteService */

/**
 * @returns {MapController}
 */
var MapController = function () {

    /**
     * @type {mapView}
     */
    this.mapView = mapView;
};

MapController.prototype = {

    /**
     * Load elements and print.
     */
    load: async function () {

        var self = this;

        var cpd = await CpdService.getInstance().getCpd();
        self.mapView.renderMap(cpd);
        self.mapView.renderFixedLayer(cpd.getLayer());
        var layers = await LayerService.getInstance().getLayers(self.mapView);
        self.mapView.renderEditControls();
//        self.mapView.renderLayersControl(layers);
        layers.forEach(function(layer) {
            self.mapView.renderLayerControl(layer);
        });
//        for (let i = 0, p = Promise.resolve(); i < layers.length; i++) {
//            p = p.then(_ => new Promise(resolve =>
//                    setTimeout(function () {
//                        LoaderAdapter.showRender(layers[i]);
//                        self.mapView.renderLayerControl(layers[i]);
//                        if (i === layers.length - 1) {
//                            LoaderAdapter.hideRender();
//                        }
//                        resolve();
//                    }, 200)
//                ));
//        }
       
        self.mapView.subscribe(new CreateElementListener(self));

        var notes = await NoteService.getInstance().getNotes();
        notes.forEach(function (note) {
            self.mapView.renderLayer(note.getLayer());
        });
        var alerts = await NoteService.getInstance().getAlerts();
        alerts.forEach(function (alert) {
            self.mapView.renderLayer(alert.getLayer());
        });
        
        self.mapView.renderSearchControl(layers);

    },

    /**
     * @param {Layer} layer
     */
    addLayer: function (layer) {
        this.mapView.renderLayer(layer);
    }

};