/* global L */
const LayerFactory = require('./LayerFactory');
const Path = require('../../enum/Path');

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
            weight: element.weight,
            contextmenu: true,
            contextmenuInheritItems: false,
            title: element.name || "No definido"
        });
    }
    return L.polyline([[0,0],[0,0]], {
        title: " "
    }); // REMARK: Title can not be empty beacuse L.Control.Search fail with empty values.
};

module.exports = PolylineFactory;