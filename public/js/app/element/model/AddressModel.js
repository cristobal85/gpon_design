/**
 * @param {{id: Number, location:string}} data
 * @returns {AdressModel}
 */
var AddressModel = function(data) {
    
    /**
     * @type {Number}
     */
    this.id = (data) ? data.id : 0;
    
    /**
     * @type {string}
     */
    this.location = (data) ? data.location : 'No definida';
    
};

AddressModel.prototype = {
    
    /**
     * @returns {String}
     */
    toString: function() {
        return this.location;
    }
    
};