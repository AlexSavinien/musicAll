$(document).ready(function(){

    $('.adresse').on('blur', function () {
        console.log("J'ai bien écris ");
        let streetNumber = $('#place_streetNumber').val();
        let streetName = $('#place_streetName').val();
        let zipCode = $('#place_zipCode').val();
        let town = $('#place_town').val();

       $.getJSON(
           "http://open.mapquestapi.com/nominatim/v1/search.php?key=VlEXC4XHHkuveMElxFCkFl7wSv6IYNQw&q="+ streetNumber + ' ' + streetName+" " +zipCode+" " +town+"&format=json",
           [],
           function(retour){
               console.log(retour);
               console.log(retour[0].lat);
               console.log(retour[0].lon);
               let lat = retour[0].lat;
               let lon = retour[0].lon;
               $('#place_lat').val(lat);
               $('#place_lon').val(lon);

           }
       );
    });




});