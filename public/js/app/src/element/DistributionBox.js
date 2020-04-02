/* global L */

const Element = require('./Element');
const AjaxAdapter = require('../adapter/AjaxAdapter');
const Path = require('../enum/Path');
const ApiUrl = require('../enum/ApiUrl');
const MarkerFactory = require('../layer/factory/MarkerFactory');
const PopupBuilder = require('./builder/PopupBuilder');
const PopupEnum = require('./enum/PopupEnum');
const AlertAdapter = require('../adapter/AlertAdapter');
const SubscriberBox = require('./SubscriberBox');
const ResourceUrl = require('../enum/ResourceUrl');
const DistributionBoxtListener = require('./listener/DistributionBoxListener');
const DsBoxConectorFormListener = require('../form/listener/DsBoxConectorFormListener');
const DistributionBoxFormListener = require('../form/listener/DistributionBoxFormListener');
const AddressModel = require('./model/AddressModel');

/**
 * @param {mapView} mapView
 * @param {Number} id
 * @param {string} name
 * @param {string} latitude
 * @param {float} longitude
 * @param {float} icon
 * @returns {DistributionBox}
 */
var DistributionBox = function (mapView, id, name, latitude, longitude, icon) {

    Element.call(this, mapView);

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
     * @type {SubscriberBox[]}
     */
    this.subscriberBoxes = [];

    /**
     * @type {L.marker}
     */
    this.marker = MarkerFactory.createLayer(this, [30, 30]);
};

DistributionBox.prototype = Object.create(Element.prototype);

DistributionBox.prototype = {

    /**
     * @returns {L.marker}
     */
    getLayer: function () {
        this.marker.bindPopup("", {
            maxWidth: 500
        });
        this.subscribeToEvents();

        return this.marker;
    },

    /**
     * @returns {L.marker[]}
     */
    getLayers: function () {
        var markers = [];
        markers.push(this.getLayer());
        this.subscriberBoxes.forEach(function (subscriber) {
            markers.push(subscriber.getLayer());
        });

        return markers;
    },

    /**
     * @returns {Promise}
     */
    generatePopUp: function () {
        var self = this;
        return new Promise(function (resolve, reject) {
            AjaxAdapter.get(ApiUrl.GET_DISTRIBUTION_BOX_ID + self.id)
                    .then(function (response) {
                        var dsBox = response.data;
                        var html = PopupBuilder.getInstance()
                                .addContentDescription(
                                        {id: 'description', label: 'Descripción'},
                                        {'Caja': dsBox.name, 'Dirección': new AddressModel(dsBox.address)},
                                        true)
                                .addContentCarousel(
                                        {id: 'images', label: 'Imágenes'},
                                        dsBox.images,
                                        false)
                                .addContentPdf(
                                        {id: 'pdfs', label: 'Archivos'},
                                        dsBox.pdfs,
                                        false)
                                .addContentDsPorts(
                                        {id: 'ports', label: 'Puertos'},
                                        dsBox.ports,
                                        false)
                                .addContentPassant(
                                        {id: 'passant', label: 'Pasantes'},
                                        dsBox.passants,
                                        false)
                                .addDistributionBoxPhotoBtn(self.id)
                                .build(500, 240);

                        resolve(html);
                    })
                    .catch(function (error) {
                        console.error(error);
                        AlertAdapter.error(error.response.data.message);
                    });
        });
    },

    /**
     * @param {SubscriberBox} subscriberBox
     * @return {undefined}
     */
    addSubscriberbox: function (subscriberBox) {
        this.subscriberBoxes.push(subscriberBox);
    },

    /**
     * @returns {SubscriberBox[]}
     */
    getSubscriberBoxes: function () {
        return this.subscriberBoxes;
    },

    edit: function () {
        var self = this;
        this.marker.toggleEdit();
        var layer = self.marker;
        if (!this.marker.editEnabled()) {
            layer.editing.disable(); // for CSS Class
            self.latitude = layer.getLatLng().lat;
            self.longitude = layer.getLatLng().lng;
            AjaxAdapter.post(ApiUrl.PUT_DISTRIBUTION, {
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

    subscribeToEvents: function () {
        var self = this;

        this.marker.bindContextMenu({
            contextmenuItems: [
                {
                    text: '<strong>Caja ' + self.name + '</strong>',
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
                        DistributionBoxFormListener.showEditModal(self.id);
                    }
                },
                {
                    text: '<i class="fas fa-plug"></i> Conectar puertos',
                    callback: function () {
                        DsBoxConectorFormListener.showModal(self.id);
                    }
                },
                {
                    text: '<i class="fas fa-network-wired"></i> Añadir pasantes',
                    callback: function () {
                        DistributionBoxPassantListener.showModal(self.id);
                    }
                },
                '-',
                {
                    text: '<i class="fas fa-unlink"></i> Desconectar puertos',
                    callback: function () {
                        AjaxAdapter.get(ApiUrl.GET_DISTRIBUTION_BOX_ID + self.id)
                                .then(function (response) {
                                    var dsBox = response.data;
                                    var html = PopupBuilder.getInstance()
                                            .addDiscontentDsPorts(
                                                    {id: 'ports', label: 'Desconectar puertos'},
                                                    dsBox.ports,
                                                    true)
                                            .build(500, 240);

                                    self.marker.bindPopup(html).openPopup();
                                });
                    }
                },
                {
                    text: '<i class="fas fa-cut"></i> Eliminar pasantes',
                    callback: function () {
                        DistributionBoxPassantListener.deletePasants(self.id);
                    }
                }]
        });

        this.marker.on('dblclick', function (e) {
            self.subscriberBoxes.forEach(function (subs) {
                subs.turnToogleMarker();
                subs.turnToogleAllSubsExt();
            });
        });

        this.marker.on('click', function (e) {
            self.generatePopUp().then(function (html) {
                self.marker.bindPopup(html);
            });
        });
    }
};

module.exports = DistributionBox;