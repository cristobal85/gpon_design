/* global ElementFormBuilder, ApiUrl */

/**
 * @returns {UploadPhotoTorpedoFormBuilder}
 */
var UploadPhotoTorpedoFormBuilder = function () {
    ElementFormBuilder.call(this);
    
};

UploadPhotoTorpedoFormBuilder.prototype = Object.create(ElementFormBuilder.prototype);


UploadPhotoTorpedoFormBuilder.prototype.addPhotoUpload = function (torpedoId) {

    this.form = "<iframe src='" + ApiUrl.POST_TORPEDO_IMAGE + torpedoId + "/upload' style='width:100%;height:500px;'></iframe>";

    return this;
};