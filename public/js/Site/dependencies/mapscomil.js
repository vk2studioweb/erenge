function getLocations(urlPage, page) {

    let coordenadas = {
        newcoords : [],
        avgLocation : {
            lat : 0,
            lng : 0
        }
    };

    $.ajax({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url: urlPage,
        type: "POST",
        data: {},
        dataType: "JSON",
        async: false,
        success: function(json) {
            let count = 0;
            json.forEach(function(location, i) {
                let coords = location['location'].split(",");

                coordenadas.avgLocation.lat = coordenadas.avgLocation.lat + parseFloat(coords[0]);
                coordenadas.avgLocation.lng = coordenadas.avgLocation.lng + parseFloat(coords[1]);

                if( page === 'representante'){
                    coordenadas.newcoords.push({
                        lat: parseFloat(coords[0]),
                        lng: parseFloat(coords[1]),
                        value: "<span class='maps-selle-name'>"+location['name']+"</span><span class='maps-selle-companyname'>"+location['corporatename']+"</span><span class='maps-selle-companyname'>"+location['phone']+"</span><span class='maps-selle-companyname'>"+location['mail']+"</span>"
                    });
                } else {
                    coordenadas.newcoords.push({
                        lat: parseFloat(coords[0]),
                        lng: parseFloat(coords[1]),
                        value: "<span class='maps-selle-name'>"+location['name']+"</span><span class='maps-selle-companyname'>"+location['phone']+"</span><span class='maps-selle-companyname'>"+location['mail']+"</span><span class='maps-selle-companyname'>"+location['address']+"</span>"
                    });
                }
                count++;
            });

            coordenadas.avgLocation.lat = coordenadas.avgLocation.lat / count;
            coordenadas.avgLocation.lng = coordenadas.avgLocation.lng / count;
        }
    });

    return coordenadas;



}

function initMap(locations, avgLocation, page) {
    const map = new google.maps.Map(document.getElementById("conteiner-map"), {
        zoom: 3,
        center: avgLocation,
        disableDefaultUI: true,
        mapTypeId: "roadmap"

    });
    const infoWindow = new google.maps.InfoWindow({
        content: "",
        disableAutoPan: true,
    });

    const markers = locations.map((position, i) => {
        const label = '';
        const name = position.value;

        const marker = new google.maps.Marker({
          position,
          label,
        });

        marker.addListener("click", () => {
            infoWindow.setContent(name);
            infoWindow.open(map, marker);
          });
          return marker;
    });

    new markerClusterer.MarkerClusterer({ markers, map });
}


$(document).ready(function () {
    if ($('#conteiner-map').length){
        let urlPage = $('#conteiner-map').attr('data-url');
        let page = $('#conteiner-map').attr('data-page');
        let locations = getLocations(urlPage, page);

        initMap(locations.newcoords, locations.avgLocation, page);
    }
});


