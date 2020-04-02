const ElementFormBuilder = require('./ElementFormBuilder');
const ApiUrl = require('../../enum/ApiUrl');

/**
 * @returns {TorpedoFormBuilder}
 */
var TorpedoFormBuilder = function () {
    ElementFormBuilder.call(this);
    this.form = "<form id='torpedo-form' action='" + ApiUrl.POST_TORPEDO + "' method='POST'>";
};

TorpedoFormBuilder.prototype = Object.create(ElementFormBuilder.prototype);

/**
 * @param {Number} torpedoId
 * @returns {DistributionBoxFormBuilder.prototype}
 */
TorpedoFormBuilder.prototype.addEditForm = function (torpedoId) {

    this.form = "<iframe src='" + ApiUrl.GET_TORPEDO_ID + torpedoId + "/form' style='width:100%;height:500px;'></iframe>";

    return this;
};

module.exports = TorpedoFormBuilder;