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
    map.scrollWheelZoom.disable();
    let enable = 'no';
    $('#mapid').click(function () {
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
            for (let i=0; i<retour.length; i++)
            {
                let marker = L.marker([retour[i].lat, retour[i].lon]);
                marker.bindPopup(
                    "<p>"+ retour[i].place +"</p>"+
                    "<p>"+ retour[i].name +"</p>"+
                    "<p>"+ retour[i].artist +"</p>"+
                    "<p>"+ retour[i].style +"</p>"+
                    "<a href='/event/"+ retour[i].id + "'>Plus d'info</a>"
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
     * APPEL AJAX sur le submit de l'input de recherche
     */
    $('#searchForm').on('submit', function(){
        event.preventDefault();
        console.log('recherche soumise');

        let research = $(this).val();

        $.get(
            '/home/map-ajax?research='+research,
            function(retour){

                console.log(retour);

                /**
                 * Boucle d'affichage des événements grâce à des markers
                 */
                for (let i=0; i<retour.length; i++)
                {
                    let marker = L.marker([retour[i].lat, retour[i].lon]);
                    marker.bindPopup(
                        "<p>"+ retour[i].place +"</p>"+
                        "<p>"+ retour[i].name +"</p>"+
                        "<p>"+ retour[i].artist +"</p>"+
                        "<p>"+ retour[i].style +"</p>"+
                        "<a href='/event/"+ retour[i].id + "'>Plus d'info</a>"
                    );
                    eventsResearch.addLayer(marker)
                }

                // Reset de la map
                map.removeLayer(eventsBase);
                map.addLayer(eventsResearch);

                $('#searchContent').html('<div id="searchContent-scrollbar"></div>');
                for (let i=0; i<5; i++)
                {
                        console.log(i)
                        $('#searchContent-scrollbar').append(
                            "<div>"+
                                "<p>"+ retour[i].place +"</p>"+
                                "<p>"+ retour[i].name +"</p>"+
                                "<p>"+ retour[i].artist +"</p>"+
                                "<p>"+ retour[i].style +"</p>"+
                                "<a href='/event/"+ retour[i].id + "'>Plus d'info</a>"+
                            "</div><hr>"
                        )
                }
                // $('.scrollbar-macosx').scrollbar();
            },
            'json'
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


    /*******************************************************************************************************************
     * Affichage des 5 premiers résultats de la recherche à la place de la présentation du site
     *
     */


});