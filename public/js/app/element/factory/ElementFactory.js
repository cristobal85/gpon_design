/* global EntityTypeEnum, WireType, DistributionBoxType, SubscriberBoxType, SubscriberBoxExtType, LayerType, TorpedoType, NoteType */

var ElementFactory = {

    /**
     * 
     * @param {{type:string, data:Object, message:string}} response
     * @returns {Wire|Layer|SubscriberBox|DistributionBox|Cpd|Torpedo|DistributionBoxExt|SubscriberBoxExt}
     * 
     */
    factory: function (response) {
        var layer = null;
        switch (response.type) {
            case EntityTypeEnum.WIRE:
                layer = WireType.buildElement(response.data);
                break;
            case EntityTypeEnum.DISTRIBUTION_BOX:
                layer = DistributionBoxType.buildElement(response.data);
                break;
            case EntityTypeEnum.SUBSCRIBER_BOX:
                layer = SubscriberBoxType.buildElement(response.data);
                break;
            case EntityTypeEnum.SUBSCRIBER_BOX_EXT:
                layer = SubscriberBoxExtType.buildElement(response.data);
                break;
            case EntityTypeEnum.LAYER:
                layer = LayerType.buildElement(response.data);
                break;
            case EntityTypeEnum.TORPEDO:
                layer = TorpedoType.buildElement(response.data);
                break;
            case EntityTypeEnum.NOTE:
                layer = NoteType.buildElement(response.data);
                break;
        }
        return layer;
    }
};