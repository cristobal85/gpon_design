const ElementType = require('./ElementType');
const Layer = require('../Layer');

/**
 * @return {LayerType}
 */
var LayerType = Object.create(ElementType);


/**
 * @param {{id:number, name:string, coordinates:Number[], hexaColor:string, weight:Number}} data
 * @param {mapView} mapView
 * @return {Wire}
 */
LayerType.buildElement = function (data, mapView) {
    return new Layer(
            mapView,
            data.id,
            data.name,
            data.coordinates,
            data.hexaColor,
            data.weight
            );
};

module.exports = LayerType;