/* global EntityTypeEnum, WireType, DistributionBoxType, SubscriberBoxType, SubscriberBoxExtType, LayerType, TorpedoType, NoteType */

var ElementFactory = {

    /**
     * 
     * @param {{type:string, data:Object, message:string}} response
     * @param {mapView} mapView
     * @returns {Wire|Layer|SubscriberBox|DistributionBox|Cpd|Torpedo|DistributionBoxExt|SubscriberBoxExt}
     * 
     */
    factory: function (response, mapView) {
        var layer = null;
        switch (response.type) {
            case EntityTypeEnum.WIRE:
                layer = WireType.buildElement(response.data, mapView);
                break;
            case EntityTypeEnum.DISTRIBUTION_BOX:
                layer = DistributionBoxType.buildElement(response.data, mapView);
                break;
            case EntityTypeEnum.SUBSCRIBER_BOX:
                layer = SubscriberBoxType.buildElement(response.data, mapView);
                break;
            case EntityTypeEnum.SUBSCRIBER_BOX_EXT:
                layer = SubscriberBoxExtType.buildElement(response.data, mapView);
                break;
            case EntityTypeEnum.LAYER:
                layer = LayerType.buildElement(response.data, mapView);
                break;
            case EntityTypeEnum.TORPEDO:
                layer = TorpedoType.buildElement(response.data, mapView);
                break;
            case EntityTypeEnum.NOTE:
                layer = NoteType.buildElement(response.data, mapView);
                break;
        }
        return layer;
    }
};