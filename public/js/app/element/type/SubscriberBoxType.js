/* global ElementType, SubscriberBox */

/**
 * @return {SubscriberBoxType}
 */
var SubscriberBoxType = Object.create(ElementType);


/**
 * @param {{id:Number, latitude:Number, longitude:Number, icon:string}} data
 * @param {mapView} mapView
 * @return {SubscriberBox}
 */
SubscriberBoxType.buildElement = function (data, mapView) {
    return new SubscriberBox(
            mapView,
            data.id,
            data.name,
            data.latitude,
            data.longitude,
            data.icon,
            );
};