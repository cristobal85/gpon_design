const ElementType = require('./ElementType');
const Wire = require('../Wire');

/**
 * @return {WireType}
 */
var WireType = Object.create(ElementType);


/**
 * @param {{id:Number, name:string, coordinates:Number[], hecaColor:string, weight:Number, longitude:Number, image:string}} data
 * @param {mapView} mapView
 * @return {Wire}
 */
WireType.buildElement = function (data, mapView) {
    return new Wire(
            mapView,
            data.id,
            data.name,
            data.coordinates,
            data.hexaColor,
            data.weight,
            );
};

module.exports = WireType;