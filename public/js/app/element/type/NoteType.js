/* global ElementType, Wire, AddressModel */

/**
 * @return {NoteType}
 */
var NoteType = Object.create(ElementType);


/**
 * @param {{id:Number, latitude:Number, longitude:Number, icon:string}} data
 * @return {Note}
 */
NoteType.buildElement = function (data) {
    return new Note(
            data.id,
            data.latitude,
            data.longitude,
            data.icon,
            );
};