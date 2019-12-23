/* global ElementType, Layer */

/**
 * @return {LayerType}
 */
var LayerType = Object.create(ElementType);


/**
 * @param {{id:number, name:string, coordinates:Number[], hexaColor:string, weight:Number}} data
 * @return {Wire}
 */
LayerType.buildElement = function (data) {
    return new Layer(
            data.id,
            data.name,
            data.coordinates,
            data.hexaColor,
            data.weight
            );
};