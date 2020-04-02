var LoaderAdapter = {
    
    /**
     * @param {string} message
     * @returns {undefined}
     */
    showLoader: function(message) {
        var loader = document.getElementById('loader');
        var loaderMessage = document.getElementById('loader-message');
        loader.style.display = 'block';
        
        if (message) {
            loaderMessage.innerHTML = message;
        }
    },
    
    /**
     * @returns {undefined}
     */
    hideLoader: function() {
        var loader = document.getElementById('loader');
        var loaderMessage = document.getElementById('loader-message');
        loader.style.display = 'none';
        
        loaderMessage.innerHTML = '';
    },
    
    /**
     * @param {string} message
     * @returns {undefined}
     */
    showRender: function(message) {
        var loader = document.getElementById('render');
        var loaderMessage = document.getElementById('render-message');
        loader.style.display = 'block';
        
        if (message) {
            loaderMessage.innerHTML = message;
        }
    },
    
    /**
     * @returns {undefined}
     */
    hideRender: function() {
        var loader = document.getElementById('render');
        var loaderMessage = document.getElementById('render-message');
        loader.style.display = 'none';
        
        loaderMessage.innerHTML = '';
    }
};

module.exports = LoaderAdapter;