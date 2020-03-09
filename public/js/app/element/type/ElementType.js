var ElementType = {
    
    /**
     * @param {Object} data
     * @param {mapView} mapView
     * @return {element.Element}
     */
    buildElement: function(data, mapView) {
        throw new Error("Abstract method!");
    }
};