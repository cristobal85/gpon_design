/* global ElementType, Wire, AddressModel */

/**
 * @return {NoteType}
 */
var NoteType = Object.create(ElementType);


/**
 * @param {{id:Number, latitude:Number, longitude:Number, icon:string}} data
 * @param {mapView} mapView
 * @return {Note}
 */
NoteType.buildElement = function (data, mapView) {
    return new Note(
            mapView,
            data.id,
            data.latitude,
            data.longitude,
            data.icon,
            );
};