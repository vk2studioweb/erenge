$(document).ready(function () {
    if ($('#bannerSlider').length) {
        $('#bannerSlider').slick({
            autoplay: true,
            autoplaySpeed: 5000,
            speed: 800,
            fade: true,
            dots: true,
            arrows: false,
            pauseOnHover: false,
            cssEase: 'ease-in-out'
        });

        // Inicializa AOS depois do Slick renderizar
        setTimeout(function () {
            AOS.init({
                offset: 0,
                once: true,
                duration: 500,
                easing: 'ease'
            });
            AOS.refresh();
        }, 300);

    } else {
        // Páginas sem banner inicializam normalmente
        AOS.init({
            offset: 0,
            once: true,
            duration: 500,
            easing: 'ease'
        });
    }

    $('.oQueFazemosServico').hover(function () {
        var img = $(this).data('img');
        var nome = $(this).data('nome');
        if (img) {
            $('#oQueFazemosImg').fadeTo(200, 0, function () {
                $(this).attr('src', img).attr('alt', nome).fadeTo(200, 1);
            });
        }
    });

    function initMap() {
        let locationCoords = $("#empresaMapaLeaflet").data("coords");
        let coords = locationCoords.split(",");
      
        var map = L.map("empresaMapaLeaflet", {
          zoomControl: true,
          center: coords,
          zoom: 8,
          scrollWheelZoom: false
        });
        
        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', { maxZoom: 19, attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'}).addTo(map);
        
        //Personaliza o icone
        var Icon = L.icon({
            iconUrl: '../../images/mapmarker.png',
            iconSize: [43, 70]
        });

        //Pega coordenadas da lista do mapa e monta os markers
        var listcordnate = $('#coordslist')
        $.each(listcordnate[0].children, function(index, value) {
            let pointercoord = $(this).data('coord');
            let coords = pointercoord.split(",");
            L.marker([coords[0], coords[1]], {icon: Icon}).addTo(map);
        });

    }
    function initMap2() {
        let locationCoords = $("#obraInfoMapaLeaflet").data("coords");
        let coords = locationCoords.split(",");
      
        var map = L.map("obraInfoMapaLeaflet", {
          zoomControl: true,
          center: coords,
          zoom: 8,
          scrollWheelZoom: false
        });
        
        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', { maxZoom: 19, attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'}).addTo(map);
        
        //Personaliza o icone
        var Icon = L.icon({
            iconUrl: '../../images/mapmarker.png',
            iconSize: [43, 70]
        });

        //Pega coordenadas da lista do mapa e monta os markers
        var listcordnate = $('#coordslist')
        L.marker([coords[0], coords[1]], {icon: Icon}).addTo(map);
        // $.each(listcordnate[0].children, function(index, value) {
        //     let pointercoord = $(this).data('coord');
        //     let coords = pointercoord.split(",");
            
        // });
    }
      
    window.initMap = initMap;
    
    if ($("#empresaMapaLeaflet").length > 0) {
        initMap();
    }
    if ($("#obraInfoMapaLeaflet").length > 0) {
        initMap2();
    }

    $('#headerMenuBtn').click(function(){
        $('#headerNav').toggleClass('showMenu');
        $(this).toggleClass('animBar');
    });


});

$(window).resize(function () {

    $('.positionImg').JQPositioningVK2();

});
