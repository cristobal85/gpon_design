/* global ElementFormBuilder, ApiUrl, HtmlID, AjaxAdapter, AlertAdapter */

/**
 * @returns {PatchFormBuilder}
 */
var PatchFormBuilder = function () {
    ElementFormBuilder.call(this);
};

PatchFormBuilder.prototype = Object.create(ElementFormBuilder.prototype);

/**
 * 
 * @param {{id:Number, name:string}[]} wires
 * @returns {PatchFormBuilder.prototype}
 */
PatchFormBuilder.prototype.addSelectWires = function (wires) {

    var self = this;
    this.form += '<div class="form-group row">\
            <label for="' + HtmlID.DSBOX_CONECTOR_WIRE + '" class="col-sm-2 col-form-label">Cable</label>\
            <div class="col-sm-10">\
                <select class="custom-select" id="' + HtmlID.DSBOX_CONECTOR_WIRE + '" name="' + HtmlID.DSBOX_CONECTOR_WIRE + '">';
    wires.forEach(function (wire) {
        self.form += "<option value='" + wire.id + "'>" + wire.name + "</option>";
    });
    this.form += '</select>\
            </div>\
        </div>';

    return this;
};

/**
 * 
 * @param {{id:Number, name:string, tubes:Tube[]}} wire
 * @param {DistributionBox} slot
 * @returns {PatchFormBuilder.prototype}
 */
PatchFormBuilder.prototype.addSelectedWires = function (wire, slot) {
    var self = this;
    var data = {
        operators: {
            operator1: {
                top: 20,
                left: 20,
                properties: {
                    title: wire.name,
                    inputs: {},
                    outputs: {}
                }
            },
            operator2: {
                top: 20,
                left: 300,
                properties: {
                    title: slot.name,
                    inputs: {},
                    outputs: {}
                }
            }
        }
    };
    var wireNumberOfFibers = (wire.tubes.length * wire.tubes[0].fibers.length);
    var numberOfPorts = slot.patchPanelSlotConectors.length;
    var maxNumberOfFibers = (wireNumberOfFibers > numberOfPorts) ? wireNumberOfFibers : numberOfPorts;
    self.form += "<div id='fusion-table' class='fusions text-center' style='height:" + maxNumberOfFibers * 40 + "px;'>";
    wire.tubes.forEach(function (tube) {
        tube.fibers.forEach(function (fiber) {
            data.operators.operator1.properties.outputs[fiber.id] = {};
            data.operators.operator1.properties.outputs[fiber.id]['label'] = "<div class='form-fusion tube-left' style='background-color:" + tube.hexaColor + ";height:inherit;'>";
            data.operators.operator1.properties.outputs[fiber.id]['label'] += "<div class='form-fusion fiber-left fiber' style='background-color:" + fiber.hexaColor + ";height:10px;' id='" + fiber.id + "' title='Layer " + tube.layer + "'></div>";
            data.operators.operator1.properties.outputs[fiber.id]['label'] += "</div>";
            if (fiber.slotPort) {
                data.operators.operator1.properties.outputs[fiber.id]['label'] += "<i class='far fa-check-circle text-success' title='Esta fibra está conectada a un puerto'></i> ";
            }
        });
    });

    slot.patchPanelSlotConectors.forEach(function (port) {
        var className = "";
        if (port.fiber) {
            className += "bg-success";
        }
        data.operators.operator2.properties.inputs[port.id] = {};
        data.operators.operator2.properties.inputs[port.id]['label'] = "<div class='form-fusion tube-right " + className + "'>";
        data.operators.operator2.properties.inputs[port.id]['label'] += port.number;
        data.operators.operator2.properties.inputs[port.id]['label'] += "</div>";
    });
    self.form += "</div>";


    setTimeout(function () {
        var fusionTable = $('#fusion-table');
        fusionTable.flowchart({
            data: data,

            onLinkCreate: function (linkId, linkData) {
                var fiberId = linkData.fromConnector;
                var conectorId = linkData.toConnector;
                AjaxAdapter
                        .post(ApiUrl.POST_PATCH_CONECTOR + conectorId, {
                            fiberId: fiberId,
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