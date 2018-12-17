$(document).ready(function(){


    /*******************************************************************************************************************
     * Appel Ajax pour récupérer la latitude et la longitude
     */



    /*******************************************************************************************************************
     * Création d'une map centré sur Paris
     */
    let map = L.map('addMapId', {
        center: [48.859, 2.344],
        zoom: 11
    });


    /*******************************************************************************************************************
     * Config de mapbox pour avoir leur carte
     *
     * token : pk.eyJ1IjoiYWxleHNhdmluaWVuIiwiYSI6ImNqcGR3OHh5czA4b24zcHF0NnhvYnQzdjUifQ.yH3ow0zJP1v-Kvjueuke-Q
     */
    L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token={accessToken}', {
        attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
        maxZoom: 18,
        id: 'mapbox.streets',
        accessToken: 'pk.eyJ1IjoiYWxleHNhdmluaWVuIiwiYSI6ImNqcGR3OHh5czA4b24zcHF0NnhvYnQzdjUifQ.yH3ow0zJP1v-Kvjueuke-Q'
    }).addTo(map);


    /*******************************************************************************************************************
     * ZOOM min pour ne pas trop dézoomer
     *
     * @type {number}
     * @private
     */
    map._layersMinZoom=5;
    L.control.zoom(false);
    // map.zoomControl=false

    var layer1 = L.layerGroup([]);
    let marker = L.marker([$('#addMapId').data('lat'), $('#addMapId').data('lon')]);

    layer1.addLayer(marker);
    map.addLayer(layer1);



});