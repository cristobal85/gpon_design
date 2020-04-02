const ElementFormBuilder = require('./ElementFormBuilder');
const ApiUrl = require('../../enum/ApiUrl');
const HtmlID = require('../../enum/HtmlID');
const AjaxAdapter = require('../../adapter/AjaxAdapter');
const AlertAdapter = require('../../adapter/AlertAdapter');


/**
 * @returns {DistributionBoxPassantFormBuilder}
 */
var DistributionBoxPassantFormBuilder = function () {
    ElementFormBuilder.call(this);
};

DistributionBoxPassantFormBuilder.prototype = Object.create(ElementFormBuilder.prototype);

/**
 * @param {{id:Number, name:string}[]} wires
 * @return {DistributionBoxPassantFormBuilder}
 */
DistributionBoxPassantFormBuilder.prototype.addSelectWires = function (wires) {

    var self = this;
    this.form += '<div class="form-group row">\
            <label for="' + HtmlID.FUSION_WIRE_1 + '" class="col-sm-2 col-form-label">Cable 1</label>\
            <div class="col-sm-10">\
                <select class="custom-select" id="' + HtmlID.FUSION_WIRE_1 + '" name="' + HtmlID.FUSION_WIRE_1 + '">';
    wires.forEach(function (wire) {
        self.form += "<option value='" + wire.id + "'>" + wire.name + "</option>";
    });
    this.form += '</select>\
            </div>\
        </div>';


    this.form += '<div class="form-group row">\
            <label for="' + HtmlID.FUSION_WIRE_2 + '" class="col-sm-2 col-form-label">Cable 2</label>\
            <div class="col-sm-10">\
                <select class="custom-select" id="' + HtmlID.FUSION_WIRE_2 + '" name="' + HtmlID.FUSION_WIRE_2 + '">';
    wires.forEach(function (wire) {
        self.form += "<option value='" + wire.id + "'>" + wire.name + "</option>";
    });
    this.form += '</select>\
            </div>\
        </div>';

    return this;
};

/**
 * @param {{id:Number, name:string, tubes:Tube[]}} wire1
 * @param {{id:Number, name:string, tubes:Tube[]}} wire2
 * @param {Number} distributionBoxId
 * @return {TorpedoFusionFormBuilder}
 */
DistributionBoxPassantFormBuilder.prototype.addSelectedWires = function (wire1, wire2, distributionBoxId) {

    AjaxAdapter.post(ApiUrl.POST_DISTRIBUTION_BOX_PASSANT + '/' + distributionBoxId, {
        'wire1Id': wire1.id,
        'wire2Id': wire2.id,
        'distributionBoxId': distributionBoxId
    })
            .then(function (response) {
                AlertAdapter.success(response.data.message);
            });

    return this;
};

module.exports = DistributionBoxPassantFormBuilder;