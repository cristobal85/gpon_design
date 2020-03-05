/* global ElementFormBuilder, ApiUrl, HtmlID, AjaxAdapter, AlertAdapter */

/**
 * @returns {LayerFormBuilder}
 */
var LayerFormBuilder = function () {
    ElementFormBuilder.call(this);
};

LayerFormBuilder.prototype = Object.create(ElementFormBuilder.prototype);

/**
 * @param {Number} layerId
 * @returns {LayerFormBuilder.prototype}
 */
LayerFormBuilder.prototype.addEditForm = function (layerId) {

    this.form = "<iframe src='" + ApiUrl.GET_LAYER_GROUP_ID + layerId + "/form' style='width:100%;height:500px;'></iframe>";

    return this;
};