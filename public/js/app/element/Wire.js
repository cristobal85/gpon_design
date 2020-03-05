/* global L, Path, Element, element, PolylineFactory, ApiUrl, AjaxAdapter, AlertAdapter, PopupBuilder, PopupEnum, ResourceUrl, mapView, WireListener */

/**
 * @param {Number} id
 * @param {Array} coordinates
 * @param {string} hexaColor
 * @param {Number} weight
 * @returns {SubscriberBox}
 */
var Wire = function (id, coordinates, hexaColor, weight) {

    element.Element.call(this);

    /**
     * @type {Number}
     */
    this.id = id;

    /**
     * @type {Array}
     */
    this.coordinates = coordinates;

    /**
     * @type {string}
     */
    this.hexaColor = hexaColor;

    /**
     * @type {Number}
     */
    this.weight = weight;

    /**
     * @type {L.polyline}
     */
    this.polyline = PolylineFactory.createLayer(this);

};

Wire.prototype = Object.create(element.Element.prototype);

Wire.prototype = {

    /**
     * @returns {L.polyline}
     */
    getLayer: function () {
        this.polyline.bindPopup("", {
            maxWidth: PopupEnum.MAX_WIDTH
        });
        this.subscribeToEvents();

        return this.polyline;

    },

    generatePopUp: function () {
        var self = this;
        return new Promise(function (resolve, reject) {
            AjaxAdapter.get(ApiUrl.GET_WIRE_ID + self.id)
                    .then(function (response) {
                        var wire = response.data;
                        var html = PopupBuilder.getInstance()
                                .addContentDescription(
                                        {id: 'description', label: 'Descripción'},
                                        {
                                            'Cable': wire.name,
                                            'Longitud': wire.longitude.toFixed(2).toString() + 'm',
                                        },
                                        true)
                                .addContentCarousel(
                                        {id: 'images', label: 'Imágenes'},
                                        [{filePath: wire.image}],
                                        false)
//                                .addEditButton(ResourceUrl.WIRE, self.id)
//                                .addDeleteBtn(ApiUrl.DELETE_WIRE_ID, self.id)
                                .build(250, 240);
                        resolve(html);
                    })
                    .catch(function (error) {
                        console.error(error);
                        AlertAdapter.error(error.response.data.message);
                    });
        });
    },

    edit: function () {
        var self = this;
        this.polyline.toggleEdit();
        var layer = self.polyline;
        if (!this.polyline.editEnabled()) {
            self.coordinates = layer.getLatLngs();
            AjaxAdapter.post(ApiUrl.PUT_WIRE, {
                'id': self.id,
                'coordinates': self.coordinates
            }).then(function (response) {
                AlertAdapter.success(response.data.message);
            });
        }
    },

    subscribeToEvents: function () {
        var self = this;
        this.polyline.bindContextMenu({
            contextmenuItems: [
                {
                    text: '<strong>Cable ' + self.name + '</strong>',
                    disabled: true
                },
                '-',
                {
                    text: '<i class="fas fa-arrows-alt"></i> Mover | Fijar',
                    callback: function () {
                        self.edit();
                    }
                },
                '-',
                {
                    text: '<i class="far fa-edit"></i> Editar',
                    callback: function () {
                        LayerFormListener.showEditModal(self.id);
                    }
                },
                '-',
                {
                    text: '<i class="far fa-trash-alt"></i> Eliminar',
                    callback: function () {
                        WireListener.delete(self.id);
                    }
                },
            ]
        });
        
        this.polyline.on('click', function (e) {
            self.generatePopUp().then(function (html) {
                self.polyline.bindPopup(html);
            });
        });
    }
    
};