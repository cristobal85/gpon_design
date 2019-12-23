/* global ElementType, Wire, AddressModel */

/**
 * @return {TorpedoType}
 */
var TorpedoType = Object.create(ElementType);


/**
 * @param {{id:Number, name:string, latitude:Number, longitude:Number, icon:string, address:string}} data
 * @return {Torpedo}
 */
TorpedoType.buildElement = function (data) {
    return new Torpedo(
            data.id,
//            data.name,
            data.latitude,
            data.longitude,
            data.icon,
//            new AddressModel(data.address),
//            data.images,
//            data.pdfs,
//            data.torpedoFusions
            );
};