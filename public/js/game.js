let game = {
    anomalies : [],
    location : {
        lat: 0.0,
        lon: 0.0
    },

    init : function (){
        this.addEvents();
        this.drawMap();
        this.getPosition();

        let tH = setInterval(function(){
            game.getPosition();
        }, 2000);
    },
    addEvents : function (){
        $('body').on('click', 'canvas', function (){
            console.log($(this));
        })
    },
    getAnomalies : function (){

    },
    drawAnomalies : function (){

    },
    getPosition : function (){
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(this.showPosition);
        }
    },
    showPosition : function (position){
        this.location.lat = position.coords.latitude;
        this.location.lon = position.coords.longitude;

        $('#user_lat').text(this.location.lat);
        $('#user_lon').text(this.location.lon);
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
    }


};

$(document).ready(function(){
    game.init();
})