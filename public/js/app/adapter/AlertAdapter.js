/* global alertify, HttpCode */

var AlertAdapter = {};

/**
 * @param {string} message
 */
AlertAdapter.success = function(message) {
    alertify.success(message);
};

/**
 * @param {string} message
 */
AlertAdapter.error = function(message) {
    alertify.error(message);
};