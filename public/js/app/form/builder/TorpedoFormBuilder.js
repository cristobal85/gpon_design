/* global ElementFormBuilder, ApiUrl */

/**
 * @returns {TorpedoFormBuilder}
 */
var TorpedoFormBuilder = function () {
    ElementFormBuilder.call(this);
    this.form = "<form id='torpedo-form' action='" + ApiUrl.POST_TORPEDO + "' method='POST'>";
};

TorpedoFormBuilder.prototype = Object.create(ElementFormBuilder.prototype);