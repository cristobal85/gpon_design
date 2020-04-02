const ElementFormBuilder = require('./ElementFormBuilder');
const ApiUrl = require('../../enum/ApiUrl');

/**
 * 
 * @returns {DistributionBoxFormBuilder}
 */
var DelimiterFormBuilder = function () {
    ElementFormBuilder.call(this);
    this.form = "<form id='layer-form' action='" + ApiUrl.POST_LAYER + "' method='POST'>";
};

DelimiterFormBuilder.prototype = Object.create(ElementFormBuilder.prototype);

/**
 * @param {{id:number, name: string}} layers 
 * @return {WireFormBuilder.prototype}
 */
DelimiterFormBuilder.prototype.addLayerList = function (layers) {
    var self = this;
    this.form += "<div class='input-group mb-3'>\
            <select class='custom-select' id='layer' name='layer'>";
    layers.forEach(function (layer) {
        self.form += "<option value='" + layer.id + "'>" + layer.name + "</option>";
    });
    this.form += "</select>\
        </div>";

    return this;
};

/**
 * 
 * @param {Array} coordinates
 * @return {WireFormBuilder.prototype}
 */
DelimiterFormBuilder.prototype.addCoordinates = function (coordinates) {
    this.form += "<input type='hidden' name='coordinates' value='" + JSON.stringify( coordinates ) + "'>";

    return this;
};

module.exports = DelimiterFormBuilder;