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
            </div>
        </div>

        <br/>

        <!-- STATISTICS -->
        <div class="row">
            <div class="col-xs-6">Current latitude:</div>
            <div class="col-xs-4" id="user_lat"></div>
        </div>

        <div class="row">
            <div class="col-xs-6">Current longitude:</div>
            <div class="col-xs-4" id="user_lon"></div>
        </div>

        <!--
        <div class="row">
            <div class="col-xs-6">Current direction:</div>
            <div class="col-xs-4" id="user_head"></div>
        </div>
        -->

        <div class="row">
            <div class="col-xs-6">Anomalies count:</div>
            <div class="col-xs-4" id="anoma_count">0</div>
        </div>

        <div class="row">
            <div class="col-xs-6">Nearest:</div>
            <div class="col-xs-4" id="anoma_near">0m</div>
        </div>
    </div>

<?= $this->endSection(); ?>