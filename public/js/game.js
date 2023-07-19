let game = {
    anomalies : [],
    location : {
        lat: 0.0,
        lon: 0.0
    },
    gridStep : 35.8,
    canvasHeight : null,
    canvasWidth : null,
    visibleRadius : 500,

    init : function (){

        if ($('canvas').length == 0){
            return;
        }

        game.leafTest();

        //this.addEvents();
        //this.getAnomalies();

        /*
        let options = {
            enableHighAccuracy: true,
            timeout: 5000,
            maximumAge: 0,
        };
        let id = navigator.geolocation.watchPosition(game.showPosition, null, options);
        */
    },
    leafTest : function (){



        // находим кнопку и добавляем к ней обработчик
        document.getElementById('my_position').onclick = () => {
            navigator.geolocation.getCurrentPosition(success, error, {
                enableHighAccuracy: true
            })
        }

        function success({ coords }) {
            const { latitude, longitude } = coords
            const currentPosition = [latitude, longitude]
            // вызываем функцию, передавая ей текущую позицию и сообщение
            getMap(currentPosition, 'You are here')
        }

        function error({ message }) {
            console.log(message)
        }

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
    findAnomalies : function (){
        let distance = 0;
        let near = 999999999;
        let anomalies = [];
        
        for (let i = 0; i < game.anomalies.length; i++){
            distance = game.calculateDistance(
                game.location.lat,
                game.location.lon,
                game.anomalies[i].lat,
                game.anomalies[i].lon,
            );
            if (distance < near){
                near = distance;
                name = game.anomalies[i].name;
            }
            if (distance < 500){
                anomalies.push(game.anomalies[i]);
            }
        }
        
        $('#anoma_near').text(near + 'm (' + name + ')');

        game.drawAnomalies(anomalies);
    },
    latLonToXY: function (lat, lon) {
        let x = (lon + 180) * (358 / 360);
        let y = (1 - Math.log(Math.tan(lat * Math.PI / 180) + 1 / Math.cos(lat * Math.PI / 180)) / Math.PI) * (358 / 2);

        return { x: x, y: y };
    },
    drawAnomalies : function (anomalies){
        let canvas = document.querySelector('canvas');
        let ctx = canvas.getContext('2d');

        ctx.strokeStyle = "blue";
        ctx.lineWidth = 0.5;

        let cW = canvas.width;
        for (let i = 0; i < anomalies.length; i++) {
            let radiusInMeters = anomalies[i].radius;
            let radiusInPixels = radiusInMeters;

            let coords = game.latLonToXY(anomalies[i].lat, anomalies[i].lon); // Исправлено: использовано anomalies[i].lon вместо anomalies[i].lat для долготы

            let centerX = coords.x;
            let centerY = coords.y;

            ctx.beginPath();
            ctx.arc(centerX, centerY, radiusInPixels, 0, Math.PI * 2, true);
            ctx.closePath();
            ctx.stroke(); // Исправлено: stroke() должен быть внутри цикла, чтобы нарисовать каждую окружность
        }
    },
    showPosition : function (position){
        game.location.lat = position.coords.latitude;
        game.location.lon = position.coords.longitude;
        game.location.head = position.coords.heading;

        $('#user_lat').text(game.location.lat);
        $('#user_lon').text(game.location.lon);
        $('#user_head').text(this.location.head);

        $.post( "/game/save-user-loc", {data : game.location});

        //game.drawMap();
        //game.findAnomalies();
    },
    drawMap : function(){
        let canvas = document.querySelector('canvas');
        let ctx = canvas.getContext('2d');

        ctx.clearRect(0, 0, canvas.width, canvas.height);

        let cW = $('#map').parent('.map-col').width();

        $('#map').parent('.map-col').height(cW);
        $('#map').parent('.map-container').height(cW);

        ctx.canvas.height = ctx.canvas.width = cW;
        game.canvasWidth = cW;
        game.canvasHeight = cW;

        this.drawGrid(ctx, cW, game.gridStep);
    },
    drawGrid :  function(ctx, cW, step){
        let offset = game.calculateOffset();
        game.calculateOffset();
        ctx.strokeStyle = "white";
        ctx.lineWidth = 0.3;

        $('#grid_offset').text(offset.X + ' : ' + offset.Y);

        //ctx.beginPath();
        for (let i = (step * -1); (i * step) < (cW + step); i++){
            ctx.moveTo(i * step + offset.X, 0);
            ctx.lineTo(i * step + offset.X, cW);

            ctx.moveTo(0, i * step + offset.Y);
            ctx.lineTo(cW, i * step + offset.Y);
        }

        ctx.arc(cW / 2, cW / 2, cW / 2, 0, Math.PI*2, true);
        ctx.stroke();
        ctx.closePath();
    },
    calculateOffset : function (){
        let diffLat = game.calculateDistance(0, 0, game.location.lat, 0, true);
        let diffLon = game.calculateDistance(0, 0, 0, game.location.lon, true);

        return {
            X : Math.round(diffLon % 100),
            Y : Math.round(diffLat % 100)
        };
    },
    calculateDistance : function (lat1, lon1, lat2, lon2, highAccuracy = false) {
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

        if (highAccuracy){
            return earthRadius * c * 1000;
        }

        return Math.round(earthRadius * c * 1000);
    },
    toRadians : function(degrees) {
        return degrees * (Math.PI / 180);
    }
    
};

$(document).ready(function(){
    game.init();
})