/* global L, Path, Element, element, MarkerFactory, LayerListener, ApiUrl, AjaxAdapter, AlertAdapter, PopupBuilder, PopupEnum, ResourceUrl, SubscriberBoxFormListener */

/**
 * @param {Number} id
 * @param {string} name
 * @param {string} latitude
 * @param {float} longitude
 * @param {float} icon
 * @returns {SubscriberBox}
 */
var SubscriberBox = function (id, name, latitude, longitude, icon) {

    element.Element.call(this);

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
     * @type {SubscriberBoxExt[]}
     */
    this.subscriberBoxExts = [];

    /**
     * @type {L.marker}
     */
    this.marker = MarkerFactory.createLayer(this, [15, 25]);
};

SubscriberBox.prototype = Object.create(element.Element.prototype);

SubscriberBox.prototype = {

    /**
     * @returns {L.marker}
     */
    getLayer: function () {
        this.marker.bindPopup("", {
            maxWidth: PopupEnum.MAX_WIDTH
        });
        this.subscribeToEvents();

        return this.marker;
    },

    /**
     * @returns {Promise}
     */
    generatePopUp: function () {
        var self = this;
        return new Promise(function (resolve, reject) {
            AjaxAdapter.get(ApiUrl.GET_SUBSCRIBER_ID + self.id)
                    .then(function (response) {
                        var subsBox = response.data;
                        var html = PopupBuilder.getInstance()
                                .addContentDescription(
                                        {id: 'description', label: 'Descripción'},
                                        {'Caja': subsBox.name, 'Tubo': subsBox.tubeColor, 'Dirección': new AddressModel(subsBox.address)},
                                        true)
                                .addContentCarousel(
                                        {id: 'images', label: 'Imágenes'},
                                        subsBox.images,
                                        false)
                                .addContentPdf(
                                        {id: 'pdfs', label: 'Archivos'},
                                        subsBox.pdfs,
                                        false)
                                .addContentClientList(
                                        {id: 'customers', label: 'Clientes'},
                                        subsBox.customers,
                                        false)
                                .addSubscriberBoxPhotoBtn(self.id) // TODO: Change this for child of PopupBuilder with Factory
                                .build(360, 200);
                        resolve(html);
                    })
                    .catch(function (error) {
                        console.error(error);
                        AlertAdapter.error(error.response.data.message);
                    });
        });
    },

    /**
     * @returns {L.marker|L}
     */
    getMarker: function () {
        return this.marker;
    },

    /**
     * @param {SubscriberBoxExt} subscriberBoxExt
     * @returns {SubscriberBox.prototype}
     */
    addSubscriberBoxExt: function (subscriberBoxExt) {
        this.subscriberBoxExts.push(subscriberBoxExt);

        return this;
    },

    edit: function (e) {
        var self = this;
        this.marker.toggleEdit();
        var layer = e.relatedTarget;
        if (!this.marker.editEnabled()) {
            layer.editing.disable(); // for CSS 
            self.latitude = layer.getLatLng().lat;
            self.longitude = layer.getLatLng().lng;
            AjaxAdapter.post(ApiUrl.PUT_SUBSCRIBER, {
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

    turnOnMarker: function () {
        this.marker._icon.className += ' selectedMarker'; // TODO: CHANGE FOR COMMAND PATT
    },

    turnOffMarker: function () {
        this.marker._icon.className = this.marker._icon.className.replace(' selectedMarker');
    },

    turnToogleMarker: function () {
        if (this.marker._icon.className.includes('selectedMarker')) {
            this.turnOffMarker();
        } else {
            this.turnOnMarker();
        }
    },

    turnOnAllSubsExt: function () {
        this.subscriberBoxExts.forEach(function (subExt) {
            subExt.turnOnMarker();
        });
    },

    turnOffAllSubsExt: function () {
        this.subscriberBoxExts.forEach(function (subExt) {
            subExt.turnOffMarker();
        });
    },

    turnToogleAllSubsExt: function () {
        this.subscriberBoxExts.forEach(function (subExt) {
            subExt.turnToogleMarker();
        });
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
                    callback: function (e) {
                        self.edit(e);
                    }
                },
                '-',
                {
                    text: '<i class="far fa-edit"></i> Editar',
                    callback: function () {
                        SubscriberBoxFormListener.showEditModal(self.id);
                    }
                }]
        });

        this.marker.on('dblclick', function (e) {
            self.subscriberBoxExts.forEach(function (subs) {
                subs.turnToogleMarker();
            });
        });

        this.marker.on('click', function (e) {
            self.generatePopUp().then(function (html) {
                self.marker.bindPopup(html);
            });
        });
    }
};