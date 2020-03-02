/* global ElementFormBuilder, ApiUrl */

/**
 * @returns {UploadPhotoDistributionBoxFormBuilder}
 */
var UploadPhotoDistributionBoxFormBuilder = function () {
    ElementFormBuilder.call(this);
    
};

UploadPhotoDistributionBoxFormBuilder.prototype = Object.create(ElementFormBuilder.prototype);


UploadPhotoDistributionBoxFormBuilder.prototype.addPhotoUpload = function (distributionBoxId) {

    this.form = "<iframe src='" + ApiUrl.POST_DISTRIBUTION_IMAGE + distributionBoxId + "/upload' style='width:100%;height:500px;'></iframe>";

    return this;
};