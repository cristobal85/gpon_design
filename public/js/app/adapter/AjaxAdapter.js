/* global axios, HttpCode, AlertAdapter, LoaderAdapter, LocalStorageAdapter */
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
var AjaxAdapter = {};

/**
 * 
 * @param {string} url
 * @param {JSON} data
 * @returns {Promise}
 */
AjaxAdapter.post = function (url, data) {

    return new Promise(function (resolve, reject) {
        LoaderAdapter.showLoader('Actualizando datos');
        axios.post(url, {
            data: data
        }, {
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'
            }
        }).then(function (response) {
            LoaderAdapter.hideLoader();
            resolve(response);
        }).catch(function (error) {
            LoaderAdapter.hideLoader();
            AjaxAdapter.printError(error.response.status);
            reject(error.response);
        });
    });

};

/**
 * 
 * @param {string} url
 * @param {string} query HTTP get query with the forma param=value&param2=value2
 * @returns {Promise}
 */
AjaxAdapter.get = function (url, query) {
    return new Promise(function (resolve, reject) {
        if (query) {
            url += '?' + query;
        }
        LoaderAdapter.showLoader('Obteniendo datos');
        axios.get(url).then(function (response) {
            LoaderAdapter.hideLoader(); // NO PONER EN FINNALY POR FLUJO DE EJECUCIÓN
            resolve(response);
        }).catch(function (error) {
            LoaderAdapter.hideLoader();
            AjaxAdapter.printError(error.response.status);
            reject(error);
        });
    });

};


/**
 * 
 * @param {string} url
 * @param {JSON} data
 * @returns {Promise}
 */
AjaxAdapter.put = function (url, data) {

    return new Promise(function (resolve, reject) {
        LoaderAdapter.showLoader('Actualizando datos');
        axios.put(url, {
            data: data
        }).then(function (response) {
            LoaderAdapter.hideLoader();
            resolve(response);
        }).catch(function (error) {
            LoaderAdapter.hideLoader();
            AjaxAdapter.printError(error.response.status);
            reject(error);
        });
    });

};


/**
 * @param {string} url
 * @param {JSON} data
 * @returns {Promise}
 */
AjaxAdapter.delete = function (url, data) {

    return new Promise(function (resolve, reject) {
        LoaderAdapter.showLoader('Eliminando de la base de datos');
        axios.delete(url, {
            data: data
        }).then(function (response) {
            LoaderAdapter.hideLoader();
            resolve(response);
        }).catch(function (error) {
            LoaderAdapter.hideLoader();
            AjaxAdapter.printError(error.response.status);
            reject(error);
        });
    });

};

/**
 * @param {string} status
 * @return {undefined}
 */
AjaxAdapter.printError = function (status) {
    switch (status) {
        case HttpCode.FORBIDDEN:
            AlertAdapter.error('403: No tiene permisos para realizar esta operación.');
            break;
        case HttpCode.NOT_FOUND:
            AlertAdapter.error('404: La URL indicada no existe.');
            break;
        case HttpCode.SERVER_ERROR:
            AlertAdapter.error('500: Error del servidor.');
            break;
        case HttpCode.BAD_REQUEST:
            AlertAdapter.error('400: Los argumentos enviados son erróneos.');
            break;
    }
};