/* global ElementFormBuilder, ApiUrl */

/**
 * @returns {DistributionBoxFormBuilder}
 */
var WireFormBuilder = function () {
    ElementFormBuilder.call(this);
    this.form = "<form id='wire-form' action='" + ApiUrl.POST_WIRE + "' method='POST'>";
};

WireFormBuilder.prototype = Object.create(ElementFormBuilder.prototype);

/**
 * @param {{id:Number, name:string}[]} wirePatterns
 * @return {undefined}
 */
WireFormBuilder.prototype.addWirePatterns = function (wirePatterns) {

    var self = this;
    this.form += '<div class="form-group row">\
            <label for="layer" class="col-sm-2 col-form-label">Patrón</label>\
            <div class="col-sm-10">\
                <select class="custom-select" id="wire-pattern" name="wire-pattern">';
    wirePatterns.forEach(function (wire) {
        self.form += "<option value='" + wire.id + "'>" + wire.name + "</option>";
    });
    this.form += '</select>\
            </div>\
        </div>';

    return this;
};

/**
 * 
 * @param {Array} coordinates
 * @return {WireFormBuilder.prototype}
 */
WireFormBuilder.prototype.addCoordinates = function (coordinates) {
    this.form += "<input type='hidden' name='coordinates' value='" + JSON.stringify(coordinates) + "'>";

    return this;
};

/**
 * @param {Number} distance
 * @return {WireFormBuilder.prototype}
 */
WireFormBuilder.prototype.addDistance = function (distance) {
    this.form += "<input type='hidden' name='distance' value='" + distance + "'>";

    return this;
};