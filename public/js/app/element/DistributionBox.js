/* global L, Path, Element, element, MarkerFactory, ApiUrl, AjaxAdapter, AlertAdapter; SubsSubscriberBox, AlertAdapter, PopupBuilder, PopupEnum, ResourceUrl */

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
                                .addEditButton(ResourceUrl.DISTRIBUTION_BOX, self.id)
                                .addEditConectorBtn(self.id)
                                .addDistributionPassantBtn(self.id)
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
        if (!this.marker.editEnabled()) {
            e.target.editing.disable(); // for CSS Class
            var layer = e.target;
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
            e.target.editing.enable();
        }
    },

    subscribeToEvents: function () {
        var self = this;
        this.marker.on('contextmenu', function (e) {
            self.edit(e);
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