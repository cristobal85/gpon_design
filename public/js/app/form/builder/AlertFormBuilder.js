/* global ElementFormBuilder, ApiUrl */

/**
 * @returns {AlertBuilder}
 */
var AlertBuilder = function () {
    ElementFormBuilder.call(this);
    this.form = "<form id='subscriber-box-form' action='" + ApiUrl.POST_SUBSCRIBER + "' method='POST' enctype='multipart/form-data'>";
};

AlertBuilder.prototype = Object.create(ElementFormBuilder.prototype);

AlertBuilder.prototype.addSubscriberBoxList = function (subscriberBoxes) {
    var self = this;
    this.form += "<div class='input-group mb-3'>\
            <select class='custom-select' id='ds' name='subscriber-box'>";
    subscriberBoxes.forEach(function (subscriber) {
        self.form += "<option value='" + subscriber.id + "'>" + subscriber.name + "</option>";
    });
    this.form += "</select>\
        </div>";

    return this;
};

/**
 * @param {Number} subscriberBoxId
 * @returns {AlertBuilder.prototype}
 */
AlertBuilder.prototype.addEditForm = function (subscriberBoxId) {

    this.form = "<iframe src='" + ApiUrl.GET_SUBSCRIBER_ID + subscriberBoxId + "/form' style='width:100%;height:500px;'></iframe>";

    return this;
};