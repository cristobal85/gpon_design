const ApiUrl = require('../../enum/ApiUrl');

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
    }
    
    

};

module.exports = NoteFormListener;