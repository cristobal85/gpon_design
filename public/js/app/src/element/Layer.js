/* global L */
const Element = require('./Element');
const AjaxAdapter = require('../adapter/AjaxAdapter');
const Path = require('../enum/Path');
const ApiUrl = require('../enum/ApiUrl');
const PopupBuilder = require('./builder/PopupBuilder');
const PopupEnum = require('./enum/PopupEnum');
const AlertAdapter = require('../adapter/AlertAdapter');
const ResourceUrl = require('../enum/ResourceUrl');
const PolygonFactory = require('../layer/factory/PolygonFactory');
const LayerFormListener = require('../form/listener/LayerFormListener');
const LayerListener = require('./listener/LayerListener');


/**
 * @param {mapView} mapView
 * @param {Number} id
 * @param {string} name
 * @param {Number[]} coordinates
 * @param {string} hexaColor
 * @param {Number} weight
 * @returns {Layer}
 */
var Layer = function (mapView, id, name, coordinates, hexaColor, weight) {

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
     * @type {Number[]}
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
     * @type {DistributionBox[]}
     */
    this.distributionBoxes = [];

    /**
     * @type {SubscriberBox[]}
     */
    this.subscriberBoxes = [];

    /**
     * @type {SubscriberBoxExt[]}
     */
    this.subscriberBoxesExt = [];

    /**
     * @type {Wire[]}
     */
    this.wires = [];

    /**
     * @type {torpedos[]}
     */
    this.torpedos = [];

    /**
     * @type {L.polygon}
     */
    this.polygon = PolygonFactory.createLayer(this);


};

Layer.prototype = Object.create(Element.prototype);


Layer.prototype = {

    /**
     * @param {DistributionBox} ds
     */
    addDistributionBox: function (ds) {
        this.distributionBoxes.push(ds);
    },

    /**
     * @param {SubscriberBox} sub
     */
    addSubscriberBox: function (sub) {
        this.subscriberBoxes.push(sub);
    },

    /**
     * @param {SubscriberBoxExt} sub
     */
    addSubscriberBoxExt: function (sub) {
        this.subscriberBoxesExt.push(sub);
    },

    /**
     * @param {Wire} wire
     */
    addWire: function (wire) {
        this.wires.push(wire);
    },

    /**
     * @param {Torpedo} torpedo
     */
    addTorpedo: function (torpedo) {
        this.torpedos.push(torpedo);
    },

    /**
     * @return {L.polygon}
     */
    getLayer: function () {
//        var html = PopupBuilder.getInstance()
//                .addContentDescription(
//                        {id: 'description', label: 'Descripción'},
//                        {'Delimitador': this.name},
//                        true)
//                .addEditButton(ResourceUrl.LAYER, this.id)
//                .build(350, 240);

//        this.polygon.bindPopup(html, {
//            maxWidth: PopupEnum.MAX_WIDTH
//        });

        this.subscribeToEvents();

        return this.polygon;
    },

    /**
     * @returns {L[]}
     */
    getLayers: function () {
        // TODO: the loop block browser UI several seconds
        var markers = [];

        if (this.polygon) {
            markers.push(this.getLayer());
        }

        this.distributionBoxes.forEach(function (ds) {
            markers.push(ds.getLayer());
        });

        this.subscriberBoxes.forEach(function (subscriber) {
            markers.push(subscriber.getLayer());
        });

//      TODO: Relación DS_BOX -> SUB_BOX para seguimiento en mapa.
//        this.distributionBoxes.forEach(function(ds) {
//            console.log('>>>>>>>>>>>>>>>>>>>> DISTRIBUTION BOX: ' + ds.name);
//            markers.concat(ds.getLayers());
//        });

        this.subscriberBoxesExt.forEach(function (ext) {
            markers.push(ext.getLayer());
        });

        this.wires.forEach(function (wire) {
            markers.push(wire.getLayer());
        });

        this.torpedos.forEach(function (torpedo) {
            markers.push(torpedo.getLayer());
        });

//        console.log('>>>>>>>>>>>>>>>>>>>>>>>>>>>> Todos los layers:');
//        console.log(markers);

        return markers;
    },

    /**
     * @returns {L[]}
     */
    getDistributionBoxLayer: function () {
        var dsBoxLayers = [];

        this.distributionBoxes.forEach(function (ds) {
            dsBoxLayers.push(ds.getLayer());
            ds.getSubscriberBoxes().forEach(function (sub) {
                dsBoxLayers.push(sub.getLayer());
            });
        });

        return dsBoxLayers;
    },

    edit: function () {
        var self = this;
        this.polygon.toggleEdit();
        var layer = self.polygon;
        if (!this.polygon.editEnabled()) {
            self.coordinates = layer.getLatLngs();
            AjaxAdapter.post(ApiUrl.PUT_LAYER, {
                'id': self.id,
                'coordinates': self.coordinates
            }).then(function (response) {
                AlertAdapter.success(response.data.message);
            });
        }
    },

    subscribeToEvents: function () {
        var self = this;
        this.polygon.bindContextMenu({
            contextmenuItems: [
                {
                    text: '<strong>' + self.name + '</strong>',
                    disabled: true
                },
                {
                    text: '<i class="fas fa-arrows-alt"></i> Mover | Fijar',
                    callback: function () {
                        self.edit();
                    }
                },
                {
                    text: '<i class="far fa-edit"></i> Editar',
                    callback: function () {
                        LayerFormListener.showEditModal(self.id);
                    }
                },
                {
                    text: '<i class="far fa-trash-alt"></i> Eliminar',
                    callback: function () {
                        LayerListener.delete(self.id).then(function() {
                            self.mapView.deleteLayer(self.polygon);
                        });
                        
                    }
                }
            ]
        });
    },

    toString: function () {
        return this.name;
    }
};

module.exports = Layer;
