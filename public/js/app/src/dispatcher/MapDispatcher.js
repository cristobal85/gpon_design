module.exports = function () {

    /**
     * @param {string} listener 
     * @param {Object} options
     */
    window.dispatch = function (listener, options) {
        document.dispatchEvent(new CustomEvent(listener, {"detail": options}));
    };


};