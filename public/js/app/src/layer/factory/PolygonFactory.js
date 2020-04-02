/* global L */
const LayerFactory = require('./LayerFactory');
const Path = require('../../enum/Path');

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
            weight: element.weight,
            contextmenu: true,
            contextmenuInheritItems: true,
            title: element.name || "No definido"
        });
    }
    return L.polygon([[0,0],[0,0]], {
        title: " "
    }); // REMARK: Title can not be empty beacuse L.Control.Search fail with empty values.
};

module.exports = PolygonFactory;