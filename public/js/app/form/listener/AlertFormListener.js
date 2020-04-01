/* global ApiUrl, AjaxAdapter, HtmlID, jsPlumb, AlertAdapter, ModalAdapter, UploadPhotoSubscriberBoxFormBuilder */

/**
 * @type AlertFormListener
 */
var AlertFormListener = {

    /**
     * @param {Number} lat
     * @param {Number} lng
     * @returns {undefined}
     */
    showForm: function (lat, lng) {
        window.location.href = ApiUrl.GET_ALERT_ID + 'new?lat=' + lat + '&lng=' + lng;
    },
    
    

};