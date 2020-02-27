/* global L, Path, Element, element, MarkerFactory, ApiUrl, AjaxAdapter, AlertAdapter; SubsSubscriberBox, AlertAdapter, PopupBuilder, PopupEnum, ResourceUrl, DistributionBoxPassantListener, DsBoxConectorFormListener */

/**
 * @param {Number} id
 * @param {string} latitude
 * @param {float} longitude
 * @param {float} icon
 * @returns {DistributionBox}
 */
var DistributionBox = function (id, latitude, longitude, icon) {

    element.Element.call(this);

    /**
     * @type {Number}
     */
    this.id = id;

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

DistributionBox.prototype = Object.create(element.Element.prototype);

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

    edit: function (e) {
        var self = this;
        this.marker.toggleEdit();
        var layer = e.relatedTarget;
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
//        this.marker.on('contextmenu', function (e) {
//            self.edit(e);
//        });

        this.marker.bindContextMenu({
            contextmenuItems: [{
                    text: '<i class="fas fa-arrows-alt"></i> Mover | Fijar',
                    callback: function (e) {
                        self.edit(e);
                    }
                },
                '-',
                {
                    text: '<i class="far fa-edit"></i> Editar',
                    callback: function () {
                        var url = "/" + ResourceUrl.DISTRIBUTION_BOX + "/" + self.id + "/edit";
                        newwindow = window.open(url, 'Editar caja', 'height=600,width=900');
                        if (window.focus) {
                            newwindow.focus()
                        }
                        return false;
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
                                })
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