
var TreeAdapter = {};

/**
 * @param {string} elementId
 * @returns {undefined}
 */
TreeAdapter.showTree = function (elementId) {
    var $treeview = $("#" + elementId);
    $treeview.bind("ready.jstree", function () {
        $treeview.jstree('open_all');
    }).jstree();
//    $treeview.jstree().on('loaded.jstree', function () {
//        $treeview.jstree('open_all');
//    });
};
