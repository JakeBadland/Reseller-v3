<?= $this->extend('layouts/game'); ?>

<?= $this->section('game'); ?>

    <div class="dialog">
        <div class="row">
            <div class="col-xs-6">.col-xs</div>
            <div class="col-xs-6">
                <label class="close-dialog" href="#">X</label>
            </div>
        </div>

        .dialog{
            max-width: 400px;
            /*background-color: black;*/
            /*border-color: darkblue #000095 #000095 darkblue;*/
            background-clip: padding-box;
            margin: 10px auto 30px auto;
            border: solid 5px transparent;
            background: linear-gradient(to bottom, #000095, darkblue);
            height: 100%;
        }

    </div>

    <div class="container" id="map">

    </div>

    <!-- <script src="https://maps.googleapis.com/maps/api/js?key=GOOGLE_MAPS_API_KEY&callback=initMap&v=weekly" defer></script> -->



<style>


</style>

<script>
    $(document).ready(function(){
        function showPosition(position) {
            $('#map').text(position.coords.latitude + ', ' + position.coords.longitude);
        }

        let tH = setInterval(function(){
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(showPosition);
            }
        }, 2000);
    })
</script>

<?= $this->endSection(); ?>