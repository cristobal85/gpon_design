/* global L */

var LControlAdapter = {};

/**
 * This callback is displayed as part of the Requester class.
 * @callback controlCallback
 * @param {map} L.map
 */

/**
 * @param {string} btnFa
 * @param {type} map
 * @param {call} callback
 * @return {undefined}
 */
LControlAdapter.addControl = function (btnFa, map, callback) {
    L.easyButton(btnFa, callback).addTo(map);
};

/**
 * @param {type} map
 * @param {type} callback
 * @returns {undefined}
 */
LControlAdapter.addCenterPositionControl = function(map, callback) {
    L.easyButton('fa-crosshairs', callback).addTo(map);
};

/**
 * @param {type} map
 * @param {type} callback
 * @returns {undefined}
 */
LControlAdapter.addNewNoteControl = function(map, callback) {
    L.easyButton('fas fa-tasks', callback).addTo(map);
};

module.exports = LControlAdapter;