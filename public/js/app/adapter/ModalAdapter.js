/* global bootbox */

var ModalAdapter = {};

/**
 * @param {string} title
 * @param {string} html
 * @returns {undefined}
 */
ModalAdapter.showModal = function (title, html) {
    bootbox.dialog({
        title: title,
        message: html
    });
};


/**
 * 
 * @param {string} title
 * @param {string} message
 * @param {callback} callback
 * @returns {undefined}
 */
ModalAdapter.showConfirm = function(title, message, callback) {
    bootbox.confirm({
            title: title,
            message: message,
            buttons: {
                cancel: {
                    label: '<i class="fa fa-times"></i> No'
                },
                confirm: {
                    label: '<i class="fa fa-check"></i> Si'
                }
            },
            callback: function (result) {
                if (result) {
                    callback();
                }
            }
        });
};