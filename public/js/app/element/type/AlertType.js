const ElementType = require('./ElementType');
const Alert = require('../Alert');

/**
 * @return {AlertType}
 */
var AlertType = Object.create(ElementType);


/**
 * @param {{id:Number, latitude:Number, longitude:Number, icon:string}} data
 * @param {mapView} mapView
 * @return {Alert}
 */
AlertType.buildElement = function (data, mapView) {
    return new Alert(
            mapView,
            data.id,
            data.title,
            data.latitude,
            data.longitude,
            data.icon,
            );
};

module.exports = AlertType;