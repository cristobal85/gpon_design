var MapUrl = {
    OPEEN_STREET_MAP: {
        name: 'MAPA',
        displayName: 'Mapa',
        url: 'https://a.tile.openstreetmap.fr/hot/{z}/{x}/{y}.png',
        minZoom: 16,
        maxZoom: 20
    },
    ARCGIS_STREET_SATELITE: {
        name: 'SATELITE',
        displayName: 'Satélite',
        url: 'https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}',
        minZoom: 16,
        maxZoom: 19
    },
    CATASTRO: {
        name: 'CATASTRO',
        displayName: 'Catastro',
        url: 'https://ovc.catastro.meh.es/Cartografia/WMS/ServidorWMS.aspx?',
        minZoom: 16,
        maxZoom: 22
    },
    CATASTRO_PARCELA: {
        name: 'CATASTRO_GROUP',
        displayName: 'Catastro Cabra',
        url: 'http://geoserver.intnova.com:8080/geoserver/CATASTRO/wms?',
        minZoom: 16,
        maxZoom: 22
    },
    CATASTRO_CONSTRU: {
        name: 'CONSTRU',
        displayName: 'Construcciones',
        url: 'https://ovc.catastro.meh.es/Cartografia/WMS/ServidorWMS.aspx?',
        minZoom: 16,
        maxZoom: 22
    },
};