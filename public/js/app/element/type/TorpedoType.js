/* global ElementType, Wire, AddressModel */

/**
 * @return {TorpedoType}
 */
var TorpedoType = Object.create(ElementType);


/**
 * @param {{id:Number, name:string, latitude:Number, longitude:Number, icon:string, address:string}} data
 * @param {mapView} mapView
 * @return {Torpedo}
 */
TorpedoType.buildElement = function (data, mapView) {
    return new Torpedo(
            mapView,
            data.id,
            data.name,
            data.latitude,
            data.longitude,
            data.icon,
//            new AddressModel(data.address),
//            data.images,
//            data.pdfs,
//            data.torpedoFusions
            );
};