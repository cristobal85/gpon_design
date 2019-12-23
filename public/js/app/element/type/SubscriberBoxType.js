/* global ElementType, SubscriberBox */

/**
 * @return {SubscriberBoxType}
 */
var SubscriberBoxType = Object.create(ElementType);


/**
 * @param {{id:Number, latitude:Number, longitude:Number, icon:string}} data
 * @return {SubscriberBox}
 */
SubscriberBoxType.buildElement = function (data) {
    return new SubscriberBox(
            data.id,
            data.latitude,
            data.longitude,
            data.icon,
            );
};