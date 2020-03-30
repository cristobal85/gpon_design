/* global L, Path, Element, element, MarkerFactory, LayerListener, ApiUrl, AjaxAdapter, AlertAdapter, PopupBuilder, ResourceUrl */

/**
 * @param {mapView} mapView
 * @param {Number} id
 * @param {string} title
 * @param {Number} latitude
 * @param {Number} longitude
 * @param {string} icon
 * @returns {Note}
 */
var Alert = function (mapView, id, title, latitude, longitude, icon) {

    element.Element.call(this, mapView);

    /**
     * @type {Number}
     */
    this.id = id;
    
    /**
     * @type {string}
     */
    this.title = "Alerta: " + title;

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
    this.marker = MarkerFactory.createLayer(this, [21, 20]);
};

Alert.prototype = Object.create(element.Element.prototype);

Alert.prototype = {

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
            layer.editing.disable(); // for CSS 
            self.latitude = layer.getLatLng().lat;
            self.longitude = layer.getLatLng().lng;
            AjaxAdapter.post(ApiUrl.PUT_ALERT, {
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
            AjaxAdapter.get(ApiUrl.GET_ALERT_ID + self.id)
                    .then(function (response) {
                        var alert = response.data;
                        var popupBuilder = PopupBuilder.getInstance();
                        var html = popupBuilder
                                .addContentDescription(
                                        {id: 'description', label: 'Descripción'},
                                        {'Título': alert.title, 'Descripción': alert.description},
                                        true)
                                .addContentImage(
                                        {id: 'image', label: 'Imagen'},
                                        alert.image,
                                        false)
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

        this.marker.on('dblclick', function () {
            self.edit();
        });


        this.marker.on('click', function (e) {
            self.generatePopUp().then(function (html) {
                self.marker.bindPopup(html);
            });
        });
    }
};