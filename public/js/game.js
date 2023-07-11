let game = {
    anomalies : [],
    location : {
        lat: 0.0,
        lon: 0.0
    },

    init : function (){
        this.addEvents();
        this.drawMap();
        this.getAnomalies();

        let options = {
            enableHighAccuracy: false,
            timeout: 1000,
            maximumAge: 0,
        };

        let id = navigator.geolocation.watchPosition(game.showPosition, null, options);
    },
    addEvents : function (){
        $('body').on('click', 'canvas', function (){
            console.log($(this));
        })
    },
    getAnomalies : function (){
        $.get( "/game/get-anomalies", function (data){
            data = JSON.parse(data);
            game.anomalies = data;
            $('#anoma_count').text(data.length);

            //game.drawAnomalies();
        });
    },
    drawAnomalies : function (){
        let distance = 0;
        let near = 999999999;
        for (let i=0; i<game.anomalies.length; i++){
            distance = game.calculateDistance(
                game.location.lat,
                game.location.lon,
                game.anomalies[i].lat,
                game.anomalies[i].lon,
            );
            if (distance < near){ near = distance; }
        }

        $('#anoma_near').text(near + 'm');
    },
    showPosition : function (position){
        game.location.lat = position.coords.latitude;
        game.location.lon = position.coords.longitude;
        game.location.head = position.coords.heading;

        $('#user_lat').text(game.location.lat);
        $('#user_lon').text(game.location.lon);
        $('#user_head').text(this.location.head);

        $.post( "/game/save-user-loc", {data : game.location});

        game.drawAnomalies();
    },
    drawMap : function(){
        let canvas = document.querySelector('canvas')
        let ctx = canvas.getContext('2d')
        let step = 50;

        let cW = $('#map').parent('.map-col').width();

        $('#map').parent('.map-col').height(cW);
        $('#map').parent('.map-container').height(cW);

        ctx.canvas.height = ctx.canvas.width = cW;

        this.drawGrid(ctx, cW, step);
    },
    drawGrid :  function(ctx, cW, step){
        ctx.strokeStyle = "white";
        ctx.lineWidth = 0.3;
        for (let i = 1; (i * step) < cW; i++){
            ctx.moveTo(i * step, 0);
            ctx.lineTo(i * step, cW);

            ctx.moveTo(0, i * step);
            ctx.lineTo(cW, i * step);
        }
        ctx.arc(cW / 2, cW / 2, cW / 2, 0, Math.PI*2, true);
        ctx.stroke();
    },
    calculateDistance : function (lat1, lon1, lat2, lon2) {
        const earthRadius = 6371; // Радиус Земли в километрах

        // Преобразуем градусы в радианы
        const lat1Rad = game.toRadians(lat1);
        const lon1Rad = game.toRadians(lon1);
        const lat2Rad = game.toRadians(lat2);
        const lon2Rad = game.toRadians(lon2);

        // Вычисляем разницу между координатами
        const dLat = lat2Rad - lat1Rad;
        const dLon = lon2Rad - lon1Rad;

        // Вычисляем расстояние по формуле Haversine
        const a =
            Math.sin(dLat / 2) ** 2 +
            Math.cos(lat1Rad) * Math.cos(lat2Rad) * Math.sin(dLon / 2) ** 2;
        const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
        return Math.round(earthRadius * c * 1000);
    },

    toRadians : function(degrees) {
        return degrees * (Math.PI / 180);
    }
    
};

$(document).ready(function(){
    game.init();
})