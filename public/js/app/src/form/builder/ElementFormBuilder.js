const HtmlID = require('../../enum/HtmlID');
const ElementEnum = require('../../enum/ElementEnum');
const Listener = require('../../enum/Listener');

/**
 * @returns {ElementFormBuilder}
 */
var ElementFormBuilder = function () {

    /**
     * @type {String}
     */
    this.form = "";
};

ElementFormBuilder.prototype = {

    /**
     * @returns {String}
     */
    build: function () {
        this.form += "</form>";
        return this.form;
    },
    
    /**
     * @returns {ElementFormBuilder.prototype}
     */
    addSubmitBtn: function() {
        this.form += "<a href='#' class='btn btn-outline-primary' onclick='javascript:dispatch(\"" + Listener.ELEMENT_SAVE_FORM + "\", this);'>Guardar</a>";
        return this;
    },
    
    /**
     * @returns {ElementFormBuilder.prototype}
     */
    addName: function () {
        this.form += '<div class="form-group row">\
            <label for="name" class="col-sm-2 col-form-label">Nombre</label>\
            <div class="col-sm-10">\
                <input type="text" class="form-control" id="name" name="name">\
            </div>\
        </div>';
        return this;
    },
    
    /**
     * @returns {ElementFormBuilder.prototype}
     */
    addColor: function () {
        this.form += '<div class="form-group row">\
            <label for="color" class="col-sm-2 col-form-label">Color</label>\
            <div class="col-sm-10">\
                <input type="color" class="form-control" id="color" name="color" value="#000000">\
            </div>\
        </div>';
        return this;
    },
    
    /**
     * @param {{id:Number, name:string}[]} layers
     * @return {undefined}
     */
    addLayers: function (layers) {
        var self = this;
        this.form += '<div class="form-group row">\
            <label for="layer" class="col-sm-2 col-form-label">Capa</label>\
            <div class="col-sm-10">\
                <select class="custom-select" id="layer" name="layer">';
        layers.forEach(function (layer) {
            self.form += "<option value='" + layer.id + "'>" + layer.name + "</option>";
        });
        this.form += '</select>\
            </div>\
        </div>';

        return this;
    },
    
    /**
     * @returns {ElementFormBuilder.prototype}
     */
    addTypes: function () {
        this.form += '<div class="form-group row">\
            <label for="layer" class="col-sm-2 col-form-label">Tipo</label>\
            <div class="col-sm-10 col-form-label">\
            <select class="custom-select" id="' + HtmlID.ELEMENT_TYPE + '">\
                <option selected>Selecciona...</option>\
                <option value="' + ElementEnum.TORPEDO + '">Torpedo</option>\
                <option value="' + ElementEnum.DISTRIBUTION_BOX + '">Caja de distribución</option>\
                <option value="' + ElementEnum.SUBSCRIBER_BOX + '">Caja de abonado</option>\\n\
                <option value="' + ElementEnum.SUBSCRIBER_BOX_EXT + '">Caja de extensión</option>\
            </select>\
            </div>\
        </div>';
        return this;
    },
    /**
     * @param {Number} latitude
     * @return {ElementFormBuilder.prototype}
     */
    addLatitude: function (latitude) {
        this.form += "<input type='hidden' name='latitude' value='" + latitude + "'>";
        return this;
    },
    /**
     * @param {Number} longitude
     * @return {ElementFormBuilder.prototype}
     */
    addLongitude: function (longitude) {
        this.form += "<input type='hidden' name='longitude' value='" + longitude + "'>";
        return this;
    }

};

module.exports = ElementFormBuilder;