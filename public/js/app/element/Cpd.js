/* global L, AjaxAdapter , Path, element.Element, element, ApiUrl, AlertAdapter, CpdMarkerFactory, PopupBuilder, PopupEnum */

/**
 * @param {mapView} mapView
 * @param {Number} id
 * @param {string} logo
 * @param {float} latitude
 * @param {float} longitude
 * @param {{id:Number,name:string,displayName:string,url:string,wms:boolean,defaultMap:boolean,version:string}[]} maps
 * @return {Cpd}
 */
var Cpd = function (mapView, id, logo, latitude, longitude, maps) {

    element.Element.call(this, mapView);

    /**
     * @type {Number}
     */
    this.id = id;

    /**
     * @type {string}
     */
    this.icon = logo;

    /**
     * @type {Number}
     */
    this.latitude = latitude;

    /**
     * @type {Number}
     */
    this.longitude = longitude;
    
    /**
     * @type {{id:Number,name:string,displayName:string,url:string,wms:boolean,defaultMap:boolean,version:string}[]}
     */
    this.maps = maps;

    /**
     * @type {L}
     */
    this.marker = CpdMarkerFactory.createLayer(this, [100, 100]);

};

Cpd.prototype = Object.create(element.Element.prototype);

Cpd.prototype = {

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
     * @returns {Promise}
     */
    generatePopUp: function () {
        var self = this;
        return new Promise(function (resolve, reject) {
            AjaxAdapter.get(ApiUrl.GET_CPD_ID + self.id)
                    .then(function (response) {
                        var cpd = response.data;
                        var popupBuilder = PopupBuilder.getInstance()
                                .addContentDescription(
                                        {id: 'description', label: 'Descripción'},
                                        {'Empresa': cpd.company.name, 'Dirección': cpd.location, 'Ciudad': cpd.company.city},
                                        true)
                                .addContentCarousel(
                                        {id: 'images', label: 'Imágenes'},
                                        cpd.images,
                                        false)

                        cpd.racks.forEach(function (rack) {
                            if (rack.patchPanels.length) {
                                popupBuilder.addContentRom(
                                        {id: 'rack-' + rack.id, label: rack.name},
                                        rack,
                                        false)
                                        ;
                            }
                        });
                        var html = popupBuilder.build(500, 240);
                        resolve(html);
                    })
                    .catch(function (error) {
                        console.error(error);
                    });
        });
    },

    edit: function () {
        var self = this;
        self.marker.toggleEdit();
        var layer = self.marker;
        if (!this.marker.editEnabled()) {
            layer.editing.disable(); // for CSS 
            self.latitude = layer.getLatLng().lat;
            self.longitude = layer.getLatLng().lng;
            AjaxAdapter.post(ApiUrl.PUT_CPD, {
                'id': self.id,
                'latitude': self.latitude,
                'longitude': self.longitude
            }).then(function (response) {
                AlertAdapter.success(response.data.message);
            });
        } else {
            layer.editing.enable(); // For CSS
        }
    },

    subscribeToEvents: function () {
        var self = this;

        this.marker.bindContextMenu({
            contextmenuItems: [
                {
                    text: '<i class="fas fa-arrows-alt"></i> Mover | Fijar',
                    callback: function() {
                        self.edit();
                    }
                }, '-', {
                    text: '<i class="fas fa-unlink"></i> Desconectar puertos',
                    callback: function () {
                        AjaxAdapter.get(ApiUrl.GET_CPD_ID + self.id)
                                .then(function (response) {
                                    var cpd = response.data;
                                    var popupBuilder = PopupBuilder.getInstance();
                                    popupBuilder.addDissconectPortRom(cpd.racks);
                                    var html = popupBuilder.build(500, 240);

                                    self.marker.bindPopup(html).openPopup();
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