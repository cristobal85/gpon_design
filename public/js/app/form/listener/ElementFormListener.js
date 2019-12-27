/* global AlertAdapter, mapView, EntityTypeEnum, reponse, WireType, DistributionBoxType, SubscriberBoxType, SubscriberBoxExtType, LayerType, TorpedoType, ElementFactory */

var ElementFormListener = {

    /**
     * 
     * @param {HTMLElementNodeo} el
     * @returns {undefined}
     */
    saveForm: function (el) {
        var form = el.parentNode;
        var url = $(form).prop('action');
        var data = $(form).serialize();

        $.ajax({
            method: "POST",
            url: url,
            data: data
        }).done(function (response) {
            mapView.renderLayer(
                    ElementFactory
                        .factory(response)
                        .getLayer()
                    );
            AlertAdapter.success(response.message);
            ModalAdapter.hideAll();
        });
    }
};