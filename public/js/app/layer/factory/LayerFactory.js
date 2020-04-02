/* global L */
const Element = require('../../element/Element')

/**
 * @type {LayerFactory}
 */
var LayerFactory = {
    
    /**
     * @abstract
     * @param {Element} element
     * @return {L}
     */
    createLayer: function(element) {
        throw new Error("Abstract method!");
    }
};

module.exports = LayerFactory;