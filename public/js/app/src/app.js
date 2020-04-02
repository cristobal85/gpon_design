/************** REGISTER DOCUMENT LISTENER // TODO: Pensar en un registrador de listener */
const ElementFormListener = require('./form/listener/ElementFormListener')();

/************** GLOBAL DISPATCHERS ********/
const MapDispatcher = require('./dispatcher/MapDispatcher')();

/************** MAIN *************/
//console.log(new Date().toUTCString()); // FOR check load time
const MapController = require('./controller/MapController.js');
var mapController = new MapController();

mapController.load();
