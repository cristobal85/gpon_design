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

    if (element.latitude && element.longitude && element.icon) {
        return L.marker([element.latitude, element.longitude], {
                icon: L.icon({
                    iconUrl: Path.IMAGE_UPLOADS + element.icon,
                    iconSize: iconSize
                })
            });
    }
    
    return L.marker([0,0]);
};