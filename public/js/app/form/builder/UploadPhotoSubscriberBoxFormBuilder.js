const ElementFormBuilder = require('./ElementFormBuilder');
const ApiUrl = require('../../enum/ApiUrl');

/**
 * @returns {SubscriberBoxFormBuilder}
 */
var UploadPhotoSubscriberBoxFormBuilder = function () {
    ElementFormBuilder.call(this);
    
};

UploadPhotoSubscriberBoxFormBuilder.prototype = Object.create(ElementFormBuilder.prototype);


UploadPhotoSubscriberBoxFormBuilder.prototype.addPhotoUpload = function (subscriberBox) {

    this.form = "<iframe src='" + ApiUrl.POST_SUBSCRIBER_IMAGE + subscriberBox.id + "/upload' style='width:100%;height:500px;'></iframe>";

    return this;
};

module.exports = UploadPhotoSubscriberBoxFormBuilder;