const ElementFormBuilder = require('./ElementFormBuilder');
const ApiUrl = require('../../enum/ApiUrl');
const HtmlID = require('../../enum/HtmlID');
const AjaxAdapter = require('../../adapter/AjaxAdapter');
const AlertAdapter = require('../../adapter/AlertAdapter');

/**
 * @returns {DistributionBoxFusionFormBuilder}
 */
var DistributionBoxFusionFormBuilder = function () {
    ElementFormBuilder.call(this);
};

DistributionBoxFusionFormBuilder.prototype = Object.create(ElementFormBuilder.prototype);

/**
 * @param {{id:Number, name:string}[]} wires
 * @return {DistributionBoxFusionFormBuilder}
 */
DistributionBoxFusionFormBuilder.prototype.addSelectWires = function (wires) {

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
 * @param {Number} dsBoxId
 * @return {DistributionBoxFusionFormBuilder}
 */
DistributionBoxFusionFormBuilder.prototype.addSelectedWires = function (wire1, wire2, dsBoxId) {
    var self = this;
    var data = {
        operators: {
            operator1: {
                top: 20,
                left: 20,
                properties: {
                    title: wire1.name,
                    inputs: {},
                    outputs: {}
                }
            },
            operator2: {
                top: 20,
                left: 300,
                properties: {
                    title: wire2.name,
                    inputs: {},
                    outputs: {}
                }
            }
        }
    };
    var wire1NumberOfFibers = (wire1.tubes.length * wire1.tubes[0].fibers.length);
    var wire2NumberOfFibers = (wire2.tubes.length * wire2.tubes[0].fibers.length);
    var maxNumberOfFibers = (wire1NumberOfFibers > wire2NumberOfFibers) ? wire1NumberOfFibers : wire2NumberOfFibers;
    self.form += "<div id='fusion-table' class='fusions text-center' style='height:" + maxNumberOfFibers * 40 + "px;'>";
    wire1.tubes.forEach(function (tube) {
        tube.fibers.forEach(function (fiber) {
            data.operators.operator1.properties.outputs[fiber.id] = {};
            data.operators.operator1.properties.outputs[fiber.id]['label'] = "<div class='form-fusion tube-left' style='background-color:" + tube.hexaColor + ";height:inherit;'>";
            data.operators.operator1.properties.outputs[fiber.id]['label'] += "<div class='form-fusion fiber-left fiber' style='background-color:" + fiber.hexaColor + ";height:10px;' id='" + fiber.id + "' title='Layer " + tube.layer + "'></div>";
            data.operators.operator1.properties.outputs[fiber.id]['label'] += "</div>";
            data.operators.operator1.properties.outputs[fiber.id]['label'] += "</div>";
        });
    });

    wire2.tubes.forEach(function (tube) {
        tube.fibers.forEach(function (fiber) {
            data.operators.operator2.properties.inputs[fiber.id] = {};
            data.operators.operator2.properties.inputs[fiber.id]['label'] = "<div class='form-fusion tube-right' style='background-color:" + tube.hexaColor + ";height:inherit;'>";
            data.operators.operator2.properties.inputs[fiber.id]['label'] += "<div class='form-fusion fiber-right fiber' style='background-color:" + fiber.hexaColor + ";height:10px;' id='" + fiber.id + "' title='Layer " + tube.layer + "'></div>";
            data.operators.operator2.properties.inputs[fiber.id]['label'] += "</div>";
            data.operators.operator2.properties.inputs[fiber.id]['label'] += "</div>";
        });
    });
    self.form += "</div>";


    setTimeout(function () {
        var fusionTable = $('#fusion-table');
        fusionTable.flowchart({
            data: data,
            
            onLinkCreate: function (linkId, linkData) {
                var fiber1Id = linkData.fromConnector;
                var fiber2Id = linkData.toConnector;
                AjaxAdapter
                        .post(ApiUrl.GET_DISTRIBUTION_BOX_FUSION_ID + dsBoxId, {
                            fiber1Id: fiber1Id,
                            fiber2Id: fiber2Id
                        })
                        .then(function (response) {
                            AlertAdapter.success(response.data.message);
                        })
                        .catch(function (response) {
                            fusionTable.flowchart('deleteLink', linkId);
                            AlertAdapter.error(response.data.message);
                            
                        });
                return true;
            }
        });
    }, 500);

    return this;
};

module.exports = DistributionBoxFusionFormBuilder;