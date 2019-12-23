/* global L, bootbox, AjaxAdapter, ApiUrl, HtmlID, FormBuilderFactory, TitleFormFactory */

/**
 * TODO: CREAR UN LISTENER POR CADA ELEMENTO
 * @param {MapController} mapController
 * @returns {CreateElementListener}
 */
function CreateElementListener(mapController) {

    this.mapController = mapController;
    this.eventType = L.Draw.Event.CREATED;
}
CreateElementListener.prototype = new ElementListener();
CreateElementListener.prototype.constructor = CreateElementListener;

/**
 * @param {L.Draw.Event} e
 * @returns {undefined}
 */
CreateElementListener.prototype.listen = function (e) {

    var layer = e.layer;

    // TODO: CHANGE FOR CONTROLLER
    if (layer instanceof L.Polygon) {
        AjaxAdapter.get(ApiUrl.GET_FORM_LAYER).then(function (response) {
            var layers = response.data;

            var coordinates = [];
            var latLangs = layer.getLatLngs();

            for (var i = 0; i < latLangs[0].length; i++) {
                coordinates.push([latLangs[0][i].lat, latLangs[0][i].lng]);
            }

            bootbox.dialog({
                title: 'Nuevo delimitador',
                message: new DelimiterFormBuilder() // TODO: Change for Singleton
                        .addLayerList(layers)
                        .addCoordinates(coordinates)
                        .addSubmitBtn()
                        .build()
            });

            $('select').select2({width: '100%'});

        });
    }

    if (layer instanceof L.Polyline && !(layer instanceof L.Polygon)) {
        var mDistance = 0;
        var coordinates = [];
        var latLangs = layer.getLatLngs();
        for (var i = 0; i < latLangs.length; i++) {
            if (i > 0) {
                mDistance += latLangs[i].distanceTo(latLangs[i - 1]);
            }
            coordinates.push([latLangs[i].lat, latLangs[i].lng]);
        }

        AjaxAdapter.get(ApiUrl.GET_FORM_WIRE_PATTERN).then(function (response) {


            bootbox.dialog({
                title: 'Nuevo cable',
                message: new WireFormBuilder() // TODO: Change for Singleton
                        .addName()
                        .addLayers(response.data.layers)
                        .addWirePatterns(response.data.wirePatterns)
                        .addCoordinates(coordinates)
                        .addDistance(mDistance)
                        .addSubmitBtn()
                        .build()
            });

            $('select').select2({width: '100%'});
        });
    }

    if (layer instanceof L.Marker) {
        var latitude = layer.getLatLng().lat,
                longitude = layer.getLatLng().lng;

        bootbox.dialog({
            title: 'Nuevo elemento',
            message: new ElementFormBuilder() // TODO: Change for Singleton
                    .addTypes()
                    .build(),
            buttons: {
                ok: {
                    label: "Siguiente",
                    className: 'btn-info',
                    callback: function () {
                        var type = document.getElementById(HtmlID.ELEMENT_TYPE).value;
                        FormBuilderFactory.createBuilder(type, latitude, longitude)
                                .then(function (formBuilder) {
                                    bootbox.dialog({
                                        title: TitleFormFactory.createTitle(type),
                                        message: formBuilder.build()
                                    });
                                    $('select').select2({width: '100%'});
                                });

                    }
                }
            }
        });
        $('select').select2({width: '100%'});
    }
};