/* global ElementType, SubscriberBoxExt */

/**
 * @return {SubscriberBoxType}
 */
var SubscriberBoxExtType = Object.create(ElementType);


/**
 * @param {{name:string, latitude:Number, longitude:Number, icon:string, address:string }} data
 * @return {DistributionBoxExt}
 */
SubscriberBoxExtType.buildElement = function (data) {
    return new SubscriberBoxExt(
            data.id,
            data.latitude,
            data.longitude,
            data.icon,
            );
};