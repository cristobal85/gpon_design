const ElementType = require('./ElementType');
const DistributionBox = require('../DistributionBox');

/**
 * @return {CpdType}
 */
var DistributionBoxType = Object.create(ElementType);


/**
 * @param {{name:string, latitude:Number, longitude:Number, icon:string, images:{filePath: String}[], pdfs:{filePath: String}[] }} data
 * @param {mapView} mapView
 * @return {DistributionBox}
 */
DistributionBoxType.buildElement = function (data, mapView) {
    return new DistributionBox(
            mapView,
            data.id,
            data.name,
            data.latitude,
            data.longitude,
            data.icon
            );
};

module.exports = DistributionBoxType;