const AjaxAdapter = require('../adapter/AjaxAdapter');
const ApiUrl = require('../enum/ApiUrl');
const NoteType = require('../element/type/NoteType');
const AlertType = require('../element/type/AlertType');

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
             * @return {Promise<Note[]>}
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
            },
            
            /**
             * @return {Promise<Alert[]>}
             */
            getAlerts: function () {
                return new Promise(function (resolve, reject) {
                    AjaxAdapter.get(ApiUrl.GET_ALERTS).then(function (response) {
                        var dbAlerts = response.data;
                        var alerts = [];
                        dbAlerts.forEach(function (alert) {
                            alerts.push(AlertType.buildElement(alert));
                        });
                        return resolve(alerts);
                    }).catch(function (error) {
                        console.error(error);
                        return reject(error);
                    });
                });
            },
            
            
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

module.exports = NoteService;