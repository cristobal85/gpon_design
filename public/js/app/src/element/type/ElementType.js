var ElementType = {
    
    /**
     * @param {Object} data
     * @param {mapView} mapView
     * @return {Element}
     */
    buildElement: function(data, mapView) {
        throw new Error("Abstract method!");
    }
};

module.exports = ElementType;