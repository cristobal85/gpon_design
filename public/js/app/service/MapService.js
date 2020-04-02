const AjaxAdapter = require('../adapter/AjaxAdapter');
const ApiUrl = require('../enum/ApiUrl');

/**
 * @return {MapService.MapServiceAnonym$4}
 */
var MapService = (function () {

    /**
     * @type {CpdService}
     */
    var instance;

    /**
     * @type {Map}
     */
    var mapModel;
    
    /**
     * @type {LayerService}
     */
    var self = this;


    function init() {
        return {
            /**
             * @return {Promise<Map>}
             */
            getModel: function () {
                return new Promise(function (resolve, reject) {
                    if (self.mapModel) {
                        return resolve(self.model);
                    }
                    AjaxAdapter.get(ApiUrl.GET_LAYERS).then(function (response) {
                        self.mapModel = new Map();
                        var layers = response.data;
                        layers.forEach(function (layer) { // Recorer todas las capas de la BD
                            var layerModel = new Layer(layer.id, layer.name, layer.coordinates, layer.hexaColor, layer.weight);
                            layer.distributionBoxes.forEach(function (ds) { // Recorer todas las Distribution Box
                                if (ds.latitude && ds.longitude) {
                                    layerModel.addDistributionBox(new DistributionBox(
                                            ds.name, ds.latitude, ds.longitude, ds.icon, ds.images, ds.pdfs));
                                }
                                ds.subscriberBoxes.forEach(function (subscriber) { // Recorer todas las Subscriber Box
                                    if (subscriber.latitude && subscriber.longitude) {
                                        layerModel.addSubscriberBox(new SubscriberBox(
                                                subscriber.name, subscriber.latitude, subscriber.longitude
                                                , subscriber.icon, subscriber.images, subscriber.pdfs));
                                    }
                                });
                            });
                            layer.wires.forEach(function (wire) { // Recorer todos los Wires
                                if (wire.longitude) {
                                    layerModel.addWire(new Wire(wire.name, wire.coordinates, wire.hexaColor, wire.weight));
                                }
                            });
                            self.mapModel.addLayer(layerModel);
                        });
                        return resolve(self.mapModel);
                    }).catch(function (error) {
                        console.error(error);
                        return reject(error);
                    });
                });
            }
        };

    }
    ;

    return {
        getInstance: function () {
            if (!instance) {
                instance = init();
            }
            return instance;
        },

    };

})();

module.exports = MapService;