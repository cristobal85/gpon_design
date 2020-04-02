const AjaxAdapter = require('../adapter/AjaxAdapter');
const ApiUrl = require('../enum/ApiUrl');
const CpdType = require('../element/type/CpdType');
const Cpd = require('../element/Cpd');
const AlertAdapter = require('../adapter/AlertAdapter');

/**
 * @return {CpdService.CpdServiceAnonym$4}
 */
var CpdService = (function () {

    /**
     * @type {CpdService}
     */
    var instance;
    
    /**
     * @type {Cpd}
     */
    var cpd;

    /**
     * @type {CpdService}
     */
    var self = this;


    function init() {
        return {
            /**
             * @return {Promise<Cpd>}
             */
            getCpd: function () {
                return new Promise(function (resolve, reject) {
                    if (cpd) {
                        return resolve(cpd);
                    }
                    AjaxAdapter.get(ApiUrl.GET_CPD).then(function (response) {
                        if (response.data) {
			   cpd = CpdType.buildElement(response.data);
                            return resolve(cpd);
			}
			AlertAdapter.error("No se encontró ningún CPD en la base de datos.");
                    }).catch(function (error) {
                        console.error(error);
                        return reject(error);
                    });
                });
            }
        };

    };

    return {
        getInstance: function () {
            if (!instance) {
                cpd = null;
                instance = init();
            }
            return instance;
        },

    };

})();

module.exports = CpdService;