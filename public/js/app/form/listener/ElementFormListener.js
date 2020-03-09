/* global AlertAdapter, mapView, EntityTypeEnum, reponse, WireType, DistributionBoxType, SubscriberBoxType, SubscriberBoxExtType, LayerType, TorpedoType, ElementFactory, ModalAdapter, AjaxAdapter */

var ElementFormListener = {

    /**
     * 
     * @param {HTMLElementNodeo} el
     * @returns {undefined}
     */
    saveForm: function (el) {
        var form = el.parentNode;
        var url = $(form).prop('action');
        var formData = $(form).serializeArray();
        
        var data = {};
        $(formData).each(function (index, obj) {
            data[obj.name] = obj.value;
        });
        
        AjaxAdapter.post(url, data)
                .then(function (response) {
                    mapView.renderLayer(
                            ElementFactory
                            .factory(response.data, mapView)
                            .getLayer()
                            );
                    AlertAdapter.success(response.data.message);
                    ModalAdapter.hideAll();
                })
                .catch(function (error) {
                    AlertAdapter.error(error.data.message);
                });
    }
};