<!-- <script src="https://maps.googleapis.com/maps/api/js?key=GOOGLE_MAPS_API_KEY&callback=initMap&v=weekly" defer></script> -->

<?= $this->extend('layouts/game'); ?>

<?= $this->section('game'); ?>

    <div class="dialog">
        <div class="row">
            <div class="col-xs-6"><a href="#"><?=$user->login?></a></div>
            <div class="col-xs-6">
<!--                <label class="close-dialog" href="#">X</label>-->
            </div>
        </div>
        <div class="row map-container">
            <div class="col-xs-12 map-col">
                <canvas class="map" id="map">

                </canvas>
<!--                <div class="" id="map"></div>-->
            </div>
        </div>
    </div>

<style>
    .map-container{
        border: 1px solid blue;
        max-width: 400px;
        margin-left: auto;
        margin-right: auto;
    }
    .map-col{
        width: 100%;
        height: 100%;
        margin: 0;
        padding: 0;
    }
    canvas{
        background-color: #223168;
    }
</style>

<script>
    $(document).ready(function(){
        function showPosition(position) {
            $('#map').text(position.coords.latitude + ', ' + position.coords.longitude);
        }

        let tH = setInterval(function(){
            if (navigator.geolocation) {
                //navigator.geolocation.getCurrentPosition(showPosition);
            }
        }, 2000);

        function initMap(){
            let canvas = document.querySelector('canvas')
            let ctx = canvas.getContext('2d')
            let step = 50;

            //set canvas rect
            let cW = $('#map').parent('.map-col').width();
            
            console.log(cW);
            
            $('#map').parent('.map-col').height(cW);
            $('#map').parent('.map-container').height(cW);

            ctx.canvas.height = ctx.canvas.width  = cW;

            drawGrid(ctx, cW, step);
        }

        function drawGrid(ctx, cW, step){
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
        
        $('body').on('click', 'canvas', function (){
            console.log($(this));
        })
        
        initMap();
    })
</script>

<?= $this->endSection(); ?>