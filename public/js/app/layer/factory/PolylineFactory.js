/* global LayerFactory, L */

/**
 * @return {PolygonFactory}
 */
var PolylineFactory = Object.create(LayerFactory);


/**
 * @abstract
 * @param {element.Element} element
 * @return {L}
 */
PolylineFactory.createLayer = function (element) {
    if (element.coordinates.length && element.hexaColor && element.weight) {
        return L.polyline(element.coordinates, {
            color: element.hexaColor,
            weight: element.weight
        });
    }
    return L.polyline([]);
};