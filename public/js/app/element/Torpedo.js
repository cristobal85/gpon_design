/* global L, Path, Element, element, MarkerFactory, LayerListener, ApiUrl, AjaxAdapter, AlertAdapter, PopupBuilder, ResourceUrl, TorpedoFusionListener, TorpedoPassantListener, TorpedoFormListener, TorpedoListener */

/**
 * @param {mapView} mapView
 * @param {Number} id
 * @param {string} name
 * @param {string} latitude
 * @param {float} longitude
 * @param {float} icon
 * @returns {Torpedo}
 */
var Torpedo = function (mapView, id, name, latitude, longitude, icon) {

    element.Element.call(this, mapView);

    /**
     * @type {Number}
     */
    this.id = id;
    
    /**
     * @type {string}
     */
    this.name = name;

    /**
     * @type {Number}
     */
    this.latitude = latitude;

    /**
     * @type {Number}
     */
    this.longitude = longitude;

    /**
     * @type {string}
     */
    this.icon = icon;

    /**
     * @type {L.marker}
     */
    this.marker = MarkerFactory.createLayer(this, [50, 75]);

};

Torpedo.prototype = Object.create(element.Element.prototype);

Torpedo.prototype = {

    /**
     * @returns {L.marker}
     */
    getLayer: function () {
        this.marker.bindPopup("", {
            maxWidth: 'none'
        });
        this.subscribeToEvents();
        return this.marker;
    },

    edit: function () {
        var self = this;
        this.marker.toggleEdit();
        var layer = self.marker;
        if (!this.marker.editEnabled()) {
            layer.editing.disable(); // for CSS Class
            self.latitude = layer.getLatLng().lat;
            self.longitude = layer.getLatLng().lng;
            AjaxAdapter.post(ApiUrl.PUT_TORPEDO, {
                'id': self.id,
                'latitude': self.latitude,
                'longitude': self.longitude
            }).then(function (response) {
                AlertAdapter.success(response.data.message);
            });
        } else {
            layer.editing.enable();
        }
    },

    /**
     * @returns {Promise}
     */
    generatePopUp: function () {
        var self = this;
        return new Promise(function (resolve, reject) {
            AjaxAdapter.get(ApiUrl.GET_TORPEDO_ID + self.id)
                    .then(function (response) {
                        var torpedo = response.data;
                        var html = PopupBuilder.getInstance()
                                .addContentDescription(
                                        {id: 'description', label: 'Descripción'},
                                        {'Torpedo': torpedo.name, 'Dirección': new AddressModel(torpedo.address)},
                                        true)
                                .addContentCarousel(
                                        {id: 'images', label: 'Imágenes'},
                                        torpedo.images,
                                        false)
                                .addContentPdf(
                                        {id: 'pdfs', label: 'Archivos'},
                                        torpedo.pdfs,
                                        false)
                                .addContentFusion(
                                        {id: 'fusions', label: 'Fusiones'},
                                        torpedo.torpedoFusions,
                                        false)
                                .addContentPassant(
                                        {id: 'passant', label: 'Pasantes'},
                                        torpedo.passants,
                                        false)
                                .addTorpedoPhotoBtn(self.id)
                                .build(550, 240);

                        resolve(html);
                    })
                    .catch(function (error) {
                        console.error(error);
                        AlertAdapter.error(error.response.data.message);
                    });
        });

    },

    subscribeToEvents: function () {
        var self = this;

        this.marker.bindContextMenu({
            contextmenuItems: [
                {
                    text: '<strong>Torpedo ' + self.name + '</strong>',
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
                        TorpedoFormListener.showEditModal(self.id);
                    }
                },
                {
                    text: '<i class="fas fa-link"></i> Añadir fusiones',
                    callback: function () {
                        TorpedoFusionListener.showFusionModal(self.id);
                    }
                },
                {
                    text: '<i class="fas fa-network-wired"></i> Añadir pasantes',
                    callback: function () {
                        TorpedoPassantListener.showPassantModal(self.id);
                    }
                },
                '-',
                {
                    text: '<i class="fas fa-cut"></i> Eliminar pasantes',
                    callback: function () {
                        TorpedoPassantListener.deletePasants(self.id);
                    }
                },
                {
                    text: '<i class="far fa-trash-alt"></i> Eliminar',
                    callback: function () {
                        TorpedoListener.delete(self.id).then(function() {
                            self.mapView.deleteLayer(self.marker);
                        });
                    }
                }
            ]
        });


        this.marker.on('click', function (e) {
            self.generatePopUp().then(function (html) {
                self.marker.bindPopup(html);
            });
        });
    }
};