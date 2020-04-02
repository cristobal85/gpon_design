/* global L */
const LayerFactory = require('./LayerFactory');
const Path = require('../../enum/Path');

/**
 * @return {MarkerFactory}
 */
var CpdMarkerFactory = Object.create(LayerFactory);


/**
 * @abstract
 * @param {element.Element} element
 * @return {L}
 */
CpdMarkerFactory.createLayer = function (element) {

    if (element.latitude && element.longitude && element.icon) {
        return L.marker([element.latitude, element.longitude], {
            icon: L.icon({
                iconUrl: Path.IMAGE_UPLOADS + element.icon,
                iconSize: [50, 50]
            }),
            contextmenu: true,
            contextmenuInheritItems: false,
            title: "CPD"
        });
    }

    return L.marker([0, 0], {
        title: " "
    }); // REMARK: Title can not be empty beacuse L.Control.Search fail with empty values.
};

module.exports = CpdMarkerFactory;