/* global ElementFormBuilder, ApiUrl */

/**
 * @returns {DistributionBoxFormBuilder}
 */
var SubscriberBoxExtFormBuilder = function () {
    ElementFormBuilder.call(this);
    this.form = "<form id='subscriber-box-ext-form' action='" + ApiUrl.POST_SUBSCRIBER_EXT + "' method='POST'>";
};

SubscriberBoxExtFormBuilder.prototype = Object.create(ElementFormBuilder.prototype);

SubscriberBoxExtFormBuilder.prototype.addSubscriberBoxExtList = function (subscriberBoxExt) {
    var self = this;
    this.form += "<div class='input-group mb-3'>\
            <select class='custom-select' id='ds' name='subscriber-box-ext'>";
    subscriberBoxExt.forEach(function (subscriber) {
        self.form += "<option value='" + subscriber.id + "'>" + subscriber.name + "</option>";
    });
    this.form += "</select>\
        </div>";

    return this;
};