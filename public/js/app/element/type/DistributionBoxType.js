/* global ElementType, DistributionBox, AddressModel */

/**
 * @return {CpdType}
 */
var DistributionBoxType = Object.create(ElementType);


/**
 * @param {{name:string, latitude:Number, longitude:Number, icon:string, images:{filePath: String}[], pdfs:{filePath: String}[] }} data
 * @return {DistributionBox}
 */
DistributionBoxType.buildElement = function (data) {
    return new DistributionBox(
            data.id,
            data.latitude,
            data.longitude,
            data.icon,
            );
};