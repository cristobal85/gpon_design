const MapController = require('./controller/MapController.js');

/************** REGISTER LISTENER // TODO: Pensar en un registrador de listener */
/**
 * @type Module ElementFormListener|Module ElementFormListener
 */
const ElementFormListener = require('./form/listener/ElementFormListener');

//console.log(new Date().toUTCString()); // FOR check load time

var mapController = new MapController();

mapController.load();
