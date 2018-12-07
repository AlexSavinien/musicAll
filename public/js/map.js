$(document).ready(function(){

    // ================================================================
    // ========================== APPEL AJAX ==========================
    // ================================================================

    /**
     * Il faut spécifier quel l'id donné à l'input de recherche
     */
    $('#').on('input', function(){
        console.log("j'écris bien dans la recherche");
        // je récupère la valeur du champ de recherche
        let research = $(this).val();
        // je la met au format json
        let parameters = {'research' : research};

        // je fais mon appel ajax
        $.post(
            '/home/map-ajax',       // mon lien vers la fonction/route qui va traiter l'appel
            parameters,             // mes parametre en json
            function(retour){
                // TODO traitement d'affichage de la carte en fonction des données reçu de la route /home/map-ajax
            },
            'json'                  // format de la réponse ajax
        );
    });

    // ======================== FIN APPEL AJAX ========================


    /**
     * Création d'une map centré sur Paris
     */
    var map = L.map('mapid', {
        center: [48.859, 2.344],
        zoom: 13
    });

    /**
     * Création d'un marker
     * Ce qu'affiche le marker
     */
    var marker = L.marker([48.8483297, 2.3510462000000416]).addTo(map);
    marker.bindPopup("<p>Vous êtes au 18 rue saint victor </p>");


    /**
     * Au clique sur la carte, affiche les coordonées
     * @param e
     */
    function onMapClick(e) {
        popup
            .setLatLng(e.latlng)
            .setContent("You clicked the map at " + e.latlng.toString())
            .openOn(map);
    }

    map.on('click', onMapClick);


    /**
     * Config de mapbox
     * token : pk.eyJ1IjoiYWxleHNhdmluaWVuIiwiYSI6ImNqcGR3OHh5czA4b24zcHF0NnhvYnQzdjUifQ.yH3ow0zJP1v-Kvjueuke-Q
     */
    L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token={accessToken}', {
        attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
        maxZoom: 18,
        id: 'mapbox.streets',
        accessToken: 'pk.eyJ1IjoiYWxleHNhdmluaWVuIiwiYSI6ImNqcGR3OHh5czA4b24zcHF0NnhvYnQzdjUifQ.yH3ow0zJP1v-Kvjueuke-Q'
    }).addTo(map);


});