const ElementEnum = require('../../enum/ElementEnum');

/**
 * @type {TitleFormFactory}
 */
var TitleFormFactory = {

    /**
     * @param {string} elementType
     * @return {string}
     */
    createTitle: function (elementType) {
        switch (elementType) {
            case ElementEnum.SUBSCRIBER_BOX:
                return 'Caja de abonado';
                break;
            case ElementEnum.DISTRIBUTION_BOX:
                return 'Caja de distribución';
                break;
            case ElementEnum.SUBSCRIBER_BOX_EXT:
                return 'Caja de extensión';
                break;
            case ElementEnum.TORPEDO:
                return 'Torpedo';
                break;
        }
    }
};

module.exports = TitleFormFactory;