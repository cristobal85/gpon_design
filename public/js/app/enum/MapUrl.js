var MapUrl = {
    OPEEN_STREET_MAP: {
        name: 'Mapa',
        url: 'https://a.tile.openstreetmap.fr/hot/{z}/{x}/{y}.png',
        minZoom: 16,
        maxZoom: 20
    },
    ARCGIS_STREET_SATELITE: {
        name: 'Satélite',
        url: 'https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}',
        minZoom: 16,
        maxZoom: 19
    }
};