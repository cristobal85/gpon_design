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
    load: function () {

        var self = this;
        CpdService.getInstance().getCpd().then(function (cpd) {
            self.mapView.renderMap(cpd);
            self.mapView.renderFixedLayer(cpd.getLayer());
            LayerService.getInstance().getLayers(self.mapView).then(function (layers) {
                self.mapView.renderEditControls();
//                self.mapView.renderLayersControl(layers);
                for (let i = 0, p = Promise.resolve(); i < layers.length; i++) {
                    p = p.then(_ => new Promise(resolve =>
                            setTimeout(function () {
                                LoaderAdapter.showRender(layers[i]);
                                self.mapView.renderLayerControl(layers[i]);
                                if (i === layers.length - 1) {
                                    LoaderAdapter.hideRender();
                                }
                                resolve();
                            }, 200)
                        ));
                }
                self.mapView.subscribe(new CreateElementListener(self));
            });

            NoteService.getInstance().getNotes().then(function (notes) {
                notes.forEach(function (note) {
                    self.mapView.renderLayer(note.getLayer());
                });
            });
        });


    },

    /**
     * @param {Layer} layer
     */
    addLayer: function (layer) {
        this.mapView.renderLayer(layer);
    }

};