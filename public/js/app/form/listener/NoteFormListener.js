/* global ApiUrl, AjaxAdapter, HtmlID, jsPlumb, AlertAdapter, ModalAdapter, UploadPhotoSubscriberBoxFormBuilder */

/**
 * @type NoteFormListener
 */
var NoteFormListener = {

    /**
     * @param {Number} lat
     * @param {Number} lng
     * @returns {undefined}
     */
    showForm: function (lat, lng) {
        window.location.href = ApiUrl.GET_NOTE_ID + 'new?lat=' + lat + '&lng=' + lng;
    },
    
    

};