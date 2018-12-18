$(document).ready(function(){


    /*******************************************************************************************************************
     * Appel Ajax pour récupérer la latitude et la longitude
     */
    $('.adresse').on('blur', function () {
        // console.log("J'ai bien écris ");
        let streetNumber = $('#place_streetNumber').val();
        let streetName = $('#place_streetName').val();
        let zipCode = $('#place_zipCode').val();
        let town = $('#place_town').val();

       $.getJSON(
           "http://open.mapquestapi.com/nominatim/v1/search.php?key=VlEXC4XHHkuveMElxFCkFl7wSv6IYNQw&q="+ streetNumber + ' ' + streetName+" " +zipCode+" " +town+"&format=json",
           [],
           function(retour){
               if(retour.length!=0)
               {
                   // console.log(retour);
                   // console.log(retour[0].lat);
                   // console.log(retour[0].lon);
                   let lat = retour[0].lat;
                   let lon = retour[0].lon;
                   $('#place_lat').val(lat);
                   $('#place_lon').val(lon);
               }

           }
       );
    });


    /*******************************************************************************************************************
     * Création d'une map centré sur Paris
     */
    let map = L.map('addMapId', {
        center: [48.859, 2.344],
        zoom: 10
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
    $('#mapButton').click(function () {
        layer1.clearLayers();
        let marker = L.marker([$('#place_lat').val(), $('#place_lon').val()]);
        // console.log($('#place_lat').val());

        layer1.addLayer(marker);
        map.addLayer(layer1);
    })


    map.scrollWheelZoom.disable();
    let enable = 'no';
    $('#addMapId').click(function () {
        if (enable === "no")
        {
            map.scrollWheelZoom.enable();
            enable = 'yes';
        }
        else if (enable === "yes")
        {
            map.scrollWheelZoom.disable();
            enable = 'no';
        }
    });


});