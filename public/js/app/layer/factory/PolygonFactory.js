/* global LayerFactory, L */

/**
 * @return {PolygonFactory}
 */
var PolygonFactory = Object.create(LayerFactory);


/**
 * @abstract
 * @param {element.Element} element
 * @return {L}
 */
PolygonFactory.createLayer = function (element) {

    if (element.coordinates && element.hexaColor && element.weight) {
        return L.polygon(element.coordinates, {
            color: element.hexaColor,
            weight: element.weight
        });
    }
    return L.polygon([]);
};