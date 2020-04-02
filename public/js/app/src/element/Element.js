const mapView = require('../view/MapView');

/**
 * @return {Element}
 */
var Element = function (mapView) {
    
    /**
     * @type {mapView}
     */
    this.mapView = mapView;
};

Element.prototype = {
    
    /**
     * @abstract
     * @return {L}
     */
    getLayer: function() {
        throw new Error("Abstract method!");
    },
    
    /**
     * @param {PopupBuilder} popupBuilder
     * @return {undefined}
     */
    addPopup: function(popupBuilder) {
        throw new Error("Abstract method!");
    },
    
    subscribeToEvents: function (listener) {
        throw new Error("Abstract method!");
    }
};

module.exports = Element;