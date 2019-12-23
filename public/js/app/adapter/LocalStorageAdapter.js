/* global alertify, HttpCode */

var LocalStorageAdapter = {};

/**
 * @param {string} name
 * @param {Array|Object} data
 * @returns {undefined}
 */
LocalStorageAdapter.setItem = function (name, data) {
    localStorage.setItem(name, JSON.stringify(data));
};


/**
 * @param {string} name
 * @returns {Array|Object}
 */
LocalStorageAdapter.getItem = function (name) {
    return JSON.parse(localStorage.getItem(name));
};

/**
 * @returns {undefined}
 */
LocalStorageAdapter.clear = function() {
    localStorage.clear();
};