/* global ElementType, Cpd */

/**
 * @return {CpdType}
 */
var CpdType = Object.create(ElementType);


/**
 * @param {{company.name:string,company.logo:string,location:string,latitude:Number,longitude:Number}} data
 * @return {Cpd}
 */
CpdType.buildElement = function (data) {
    return new Cpd(
            data.id,
            data.company.logo,
            data.latitude,
            data.longitude,
            );
};