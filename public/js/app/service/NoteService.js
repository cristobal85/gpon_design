/* global AjaxAdapter, ApiUrl, CpdType, NoteType */

/**
 * @return {NoteService.NoteServiceAnonym$4}
 */
var NoteService = (function () {

    /**
     * @type {NoteService}
     */
    var instance;

    /**
     * @type {NoteService}
     */
    var self = this;


    function init() {
        return {
            /**
             * @return {Promise<Cpd>}
             */
            getNotes: function () {
                return new Promise(function (resolve, reject) {
                    AjaxAdapter.get(ApiUrl.GET_NOTES).then(function (response) {
                        var dbNotes = response.data;
                        var notes = [];
                        dbNotes.forEach(function (note) {
                            notes.push(NoteType.buildElement(note));
                        });
                        return resolve(notes);
                    }).catch(function (error) {
                        console.error(error);
                        return reject(error);
                    });
                });
            }
        };

    }
    ;

    return {
        getInstance: function () {
            if (!instance) {
                instance = init();
            }
            return instance;
        },

    };

})();