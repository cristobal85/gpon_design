
var TreeAdapter = {};

/**
 * @param {string} elementId
 * @returns {undefined}
 */
TreeAdapter.showTree = function(elementId) {
    $('#' + elementId).jstree();
};