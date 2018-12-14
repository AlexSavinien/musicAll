$(document).ready(function(){

    /*******************************************************************************************************************
     * Création d'une map centré sur Paris
     */
    let map = L.map('mapid', {
        center: [48.859, 2.344],
        zoom: 13
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


    let research = $(this).val();
    // Création de layer de base
    var eventsBase = L.layerGroup([]);
    var eventsResearch = L.layerGroup([]);

    /*******************************************************************************************************************
     * APPEL AJAX
     */
    $.get(
        '/home/map-ajax',
        function(retour){

            console.log(retour);


            /**
             * Boucle d'affichage des événements grâce à des markers
             */
            for (var i=0; i<retour.length; i++)
            {
                var marker = L.marker([retour[i].lat, retour[i].lon]);
                marker.bindPopup(
                    "<p>"+ retour[i].place +"</p>"+
                    "<p>"+ retour[i].name +"</p>"+
                    "<p>"+ retour[i].artist +"</p>"+
                    "<p>"+ retour[i].style +"</p>"
                );
                // ajout du marker au layer de base
                eventsBase.addLayer(marker)
            }
            // affichage du layer de base
            map.addLayer(eventsBase)

        },
        'json'                                      // format de la réponse ajax
    );
    // ======================== FIN APPEL AJAX ========================


    /*******************************************************************************************************************
     * APPEL AJAX sur l'événement 'input' de l'input de recherche
     */
    $('#recherche').on('input', function(){
        console.log("j'écris bien dans la recherche");
        // je récupère la valeur du champ de recherche


        // Reset de la map
        map.removeLayer(eventsBase);
        map.addLayer(eventsResearch);

        $.get(
            '/home/map-ajax?research='+research,
            function(retour){

                console.log(retour);

                /**
                 * Config de mapbox pour avoir leur carte
                 * token : pk.eyJ1IjoiYWxleHNhdmluaWVuIiwiYSI6ImNqcGR3OHh5czA4b24zcHF0NnhvYnQzdjUifQ.yH3ow0zJP1v-Kvjueuke-Q
                 */
                L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token={accessToken}', {
                    attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
                    maxZoom: 18,
                    id: 'mapbox.streets',
                    accessToken: 'pk.eyJ1IjoiYWxleHNhdmluaWVuIiwiYSI6ImNqcGR3OHh5czA4b24zcHF0NnhvYnQzdjUifQ.yH3ow0zJP1v-Kvjueuke-Q'
                }).addTo(map);


                /**
                 * Boucle d'affichage des événements grâce à des markers
                 */
                for (var i=0; i<retour.length; i++)
                {
                    var marker = L.marker([retour[i].lat, retour[i].lon]);
                    marker.bindPopup(
                        "<p>"+ retour[i].place +"</p>"+
                        "<p>"+ retour[i].name +"</p>"+
                        "<p>"+ retour[i].artist +"</p>"+
                        "<p>"+ retour[i].style +"</p>"
                    );
                    eventsResearch.addLayer(marker)
                }

            },
            'json'                                      // format de la réponse ajax
        );
        // ======================== FIN APPEL AJAX ========================
    });

    /*******************************************************************************************************************
     * Au clique sur la carte, affiche les coordonées
     * @param e
     */
    // function onMapClick(e) {
    //     popup
    //         .setLatLng(e.latlng)
    //         .setContent("You clicked the map at " + e.latlng.toString())
    //         .openOn(map);
    // }
    //
    // map.on('click', onMapClick);


});