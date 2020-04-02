const AjaxAdapter = require('../../adapter/AjaxAdapter');
const ModalAdapter = require('../../adapter/ModalAdapter');
const AlertAdapter = require('../../adapter/AlertAdapter');
const mapView = require('../../view/MapView');
const ElementFactory = require('../../element/factory/ElementFactory');
const Listener = require('../../enum/Listener');


module.exports = function () {


    /**
     * @param {CustomEvent} e
     */
    document.addEventListener(Listener.ELEMENT_SAVE_FORM, function (e) {
        console.log(e);
        var el = e.detail;
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
    });

};