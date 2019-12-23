/* global Cpd, AjaxAdapter, ApiUrl, CpdType */

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
                    if (self.cpd) {
                        return resolve(self.cpd);
                    }
                    AjaxAdapter.get(ApiUrl.GET_CPD).then(function (response) {
                        self.cpd = CpdType.buildElement(response.data);
                        return resolve(self.cpd);
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
                instance = init();
            }
            return instance;
        },

    };

})();