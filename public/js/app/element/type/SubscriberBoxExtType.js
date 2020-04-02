const ElementType = require('./ElementType');
const SubscriberBoxExt = require('../SubscriberBoxExt');

/**
 * @return {SubscriberBoxType}
 */
var SubscriberBoxExtType = Object.create(ElementType);


/**
 * @param {{name:string, latitude:Number, longitude:Number, icon:string, address:string }} data
 * @param {mapView} mapView
 * @return {DistributionBoxExt}
 */
SubscriberBoxExtType.buildElement = function (data, mapView) {
    return new SubscriberBoxExt(
            mapView,
            data.id,
            data.name,
            data.latitude,
            data.longitude,
            data.icon,
            );
};

module.exports = SubscriberBoxExtType;