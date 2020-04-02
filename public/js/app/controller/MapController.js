const mapView = require('../view/MapView');
const CpdService = require('../service/CpdService');
const LayerService = require('../service/LayerService');
const NoteService = require('../service/NoteService');
const CreateElementListener = require('../listener/CreateElementListener');

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
        self.mapView.renderLayer(cpd.getLayer());

        var layers = await LayerService.getInstance().getLayers(self.mapView);
        layers.forEach(function(layer) {
            self.mapView.renderLayerControl(layer);
        });
        //        
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
       
       // SUBSCRIBE TO CREATE, EDIT, REMOVE ELEMENTS
        self.mapView.subscribe(new CreateElementListener(self));
        

        self.mapView.addLayersToSearch(layers);
        
        
        var notes = await NoteService.getInstance().getNotes();
        notes.forEach(function (note) {
            self.mapView.renderLayer(note.getLayer());
        });
        var alerts = await NoteService.getInstance().getAlerts();
        alerts.forEach(function (alert) {
            self.mapView.renderLayer(alert.getLayer());
        });
        
        

    },

    /**
     * @param {Layer} layer
     */
    addLayer: function (layer) {
        this.mapView.renderLayer(layer);
    }

};

module.exports = MapController;