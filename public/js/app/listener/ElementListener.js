/**
 * @param {MapController} mapController
 * @return {ElementListener}
 */
var ElementListener = function(mapController) {
    
    /**
     * @type {MapController}
     */
    this.mapController = mapController;
    
    /**
     * @type {L.Draw.Event|String}
     */
    this.eventType;
    
};

ElementListener.prototype = {

    /**
     * @returns {L.Draw.Event|String}
     */
    getEventType: function () {
        return this.eventType;
    },
    
    listen: function (e) {}

};

module.exports = ElementListener;