/* global AjaxAdapter, ApiUrl, Map, Layer, DistributionBoxType, SubscriberBoxType, WireType, LayerType, SubscriberBoxExtType, TorpedoType, LoaderAdapter, LocalStorageAdapter */

/**
 * @return {LayerService.LayerServiceAnonym$4}
 */
var LayerService = (function () {

    /**
     * @type {CpdService}
     */
    var instance;

    /**
     * @type {Layer[]}
     */
    this.layers = [];

    /**
     * @type {LayerService}
     */
    var self = this;



    function init() {

        function generateLayers(layers) {
            layers.forEach(function (layer) { // Recorer todos los Layers de la BD
                var layerElement = LayerType.buildElement(layer);
                layer.distributionBoxes.forEach(function (ds) { // Recorer todas las Distribution Box
                    var distBox = DistributionBoxType.buildElement(ds);
                    layerElement.addDistributionBox(distBox);
                    ds.subscriberBoxes.forEach(function (subscriber) { // Recorer todas las Subscriber Box
                        subBox = SubscriberBoxType.buildElement(subscriber);
                        subscriber.subscriberBoxExts.forEach(function (ext) {
                            var subBoxExt = SubscriberBoxExtType.buildElement(ext);
                            layerElement.addSubscriberBoxExt(subBoxExt);
                            subBox.addSubscriberBoxExt(subBoxExt);

                        });
                        layerElement.addSubscriberBox(subBox);
                        distBox.addSubscriberbox(subBox);
                    });
                });
                layer.wires.forEach(function (wire) { // Recorer todos los Wires
                    layerElement.addWire(WireType.buildElement(wire));
                });
                layer.torpedos.forEach(function (torpedo) { // Recorrer todos los torpedos
                    layerElement.addTorpedo(TorpedoType.buildElement(torpedo));
                });
                self.layers.push(layerElement);
            });
        }
        ;

        return {

            /**
             * @return {Promise<Layer[]>}
             */
            getLayers: function () {

                return new Promise(function (resolve, reject) {
                    AjaxAdapter.get(ApiUrl.GET_LAYERS).then(function (response) {
                        var layers = response.data;
                        generateLayers(layers);

                        return resolve(self.layers);
                    }).catch(function (error) {
                        console.error(error);
                        return reject(error);
                    });
                });
            },

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