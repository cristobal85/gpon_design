/* global axios, AlertAdapter */

var GeoAdapter = {};

/**
 * 
 * @param {string} url
 * @param {JSON} options
 * @returns {Promise}
 */
GeoAdapter.getLocation = function (options) {
    return new Promise(function (resolve, reject) {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(resolve, reject, options);
        } else {
            AlertAdapter.error('Su navegador no soporta la geolocalización');
            reject('Su navegador no soporta la geolocalización');
        }
    });
};

module.exports = GeoAdapter;