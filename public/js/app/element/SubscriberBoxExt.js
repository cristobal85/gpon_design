/* global L, Path, Element, element, MarkerFactory, LayerListener, ApiUrl, AjaxAdapter, AlertAdapter, PopupEnum, PopupBuilder, ResourceUrl */

/**
 * @param {Number} id
 * @param {string} latitude
 * @param {float} longitude
 * @param {float} icon
 * @returns {SubscriberBoxExt}
 */
var SubscriberBoxExt = function (id, latitude, longitude, icon) {

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
     * @type {L.marker}
     */
    this.marker = MarkerFactory.createLayer(this, [15, 25]);
};

SubscriberBoxExt.prototype = Object.create(element.Element.prototype);

SubscriberBoxExt.prototype = {

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
            AjaxAdapter.get(ApiUrl.GET_SUBSCRIBER_EXT_ID + self.id)
                    .then(function (response) {
                        var subsExt = response.data;
                        var html = PopupBuilder.getInstance()
                                .addContentDescription(
                                        {id: 'description', label: 'Descripción'},
                                        {'Caja de extensión': subsExt.name, 'Dirección': new AddressModel(subsExt.address)},
                                        true)
                                .addContentCarousel(
                                        {id: 'images', label: 'Imágenes'},
                                        subsExt.images,
                                        false)
                                .addContentClientList(
                                        {id: 'customers', label: 'Clientes'},
                                        subsExt.customers,
                                        false)
                                .addEditButton(ResourceUrl.SUBSCRIBER_BOX_EXT, self.id)
                                .build(350, 240);
                        
                        resolve(html);
                    })
                    .catch(function (error) {
                        console.error(error);
                        AlertAdapter.error(error.response.data.message);
                    });
        });
    },

    edit: function (e) {
        var self = this;
        this.marker.toggleEdit();
        if (!this.marker.editEnabled()) {
            e.target.editing.disable(); // for CSS 
            var layer = e.target;
            self.latitude = layer.getLatLng().lat;
            self.longitude = layer.getLatLng().lng;
            AjaxAdapter.post(ApiUrl.PUT_SUBSCRIBER_EXT, {
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

    turnOnMarker: function () {
        this.marker._icon.className += ' selectedMarker';
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

    subscribeToEvents: function () {
        var self = this;
        this.marker.on('contextmenu', function (e) {
            self.edit(e);
        });
        
        this.marker.on('click', function (e) {
            self.generatePopUp().then(function (html) {
                self.marker.bindPopup(html);
            });
        });
    }
};