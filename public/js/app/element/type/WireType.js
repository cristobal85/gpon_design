/* global ElementType, Wire */

/**
 * @return {WireType}
 */
var WireType = Object.create(ElementType);


/**
 * @param {{id:Number, name:string, coordinates:Number[], hecaColor:string, weight:Number, longitude:Number, image:string}} data
 * @return {Wire}
 */
WireType.buildElement = function (data) {
    return new Wire(
            data.id,
            data.coordinates,
            data.hexaColor,
            data.weight,
            );
};