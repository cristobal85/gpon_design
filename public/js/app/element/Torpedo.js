/* global L, Path, Element, element, MarkerFactory, LayerListener, ApiUrl, AjaxAdapter, AlertAdapter, PopupBuilder, ResourceUrl */

/**
 * @param {Number} id
 * @param {string} latitude
 * @param {float} longitude
 * @param {float} icon
 * @returns {Torpedo}
 */
var Torpedo = function (id, latitude, longitude, icon) {

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

    /**
     * @param {L.MouseEvent} e
     * @returns {undefined}
     */
    edit: function (e) {
        var self = this;
        this.marker.toggleEdit();
        if (!this.marker.editEnabled()) {
            e.target.editing.disable(); // for CSS 
            var layer = e.target;
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
            e.target.editing.enable();
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
                                .addEditButton(ResourceUrl.TORPEDO, self.id)
                                .addEditFusionBtn(self.id)
                                .addTorpedoPassantBtn(self.id)
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