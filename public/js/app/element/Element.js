/**
 * @return {Element}
 */
var element = {};
element.Element = function (mapView) {
    
    /**
     * @type {mapView}
     */
    this.mapView = mapView;
};

element.Element.prototype = {
    
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