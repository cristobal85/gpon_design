/* global ElementType, Cpd */

/**
 * @return {CpdType}
 */
var CpdType = Object.create(ElementType);


/**
 * @param {{company.name:string,company.logo:string,location:string,latitude:Number,longitude:Number}} data
 * @param {mapView} mapView
 * @return {Cpd}
 */
CpdType.buildElement = function (data, mapView) {
    return new Cpd(
            mapView,
            data.id,
            data.company.logo,
            data.latitude,
            data.longitude,
            data.maps
            );
};