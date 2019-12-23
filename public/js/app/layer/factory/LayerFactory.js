/* global L, element.Element */

/**
 * @type {LayerFactory}
 */
var LayerFactory = {
    
    /**
     * @abstract
     * @param {element.Element} element
     * @return {L}
     */
    createLayer: function(element) {
        throw new Error("Abstract method!");
    }
};