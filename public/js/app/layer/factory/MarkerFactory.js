/* global LayerFactory, L, Path */

/**
 * @return {MarkerFactory}
 */
var MarkerFactory = Object.create(LayerFactory);


/**
 * @abstract
 * @param {element.Element} element
 * @param {{Number}[]} iconSize Array with sizes [width, height]
 * @return {L}
 */
MarkerFactory.createLayer = function (element, iconSize) {
    var title = "No definido";
    if (element.hasOwnProperty('title')) {
        title = element.title;
    }
    if (element.hasOwnProperty('name')) {
        title = element.name;
    }
    if (element.latitude && element.longitude && element.icon) {
        return L.marker([element.latitude, element.longitude], {
                icon: L.icon({
                    iconUrl: Path.IMAGE_UPLOADS + element.icon,
                    iconSize: iconSize
                }),
                contextmenu: true,
                contextmenuInheritItems: false,
                title: title
            });
    }
    
    return L.marker([0,0], {
        title: " "
    }); // REMARK: Title can not be empty beacuse L.Control.Search fail with empty values.
};