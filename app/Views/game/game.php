<?= $this->extend('layouts/game'); ?>

<?= $this->section('game'); ?>

    <div class="container" id="map">

    </div>

    <!-- <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAYMyPasucgCPtp5H5nzWLZlSpczrp8LBo&callback=initMap&v=weekly" defer></script> -->

    <script>
        let x = document.getElementById("map");
        function getLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(showPosition);
            } else {
                x.innerHTML = "Geolocation is not supported by this browser.";
            }
        }

        function showPosition(position) {
            x.innerHTML = "Latitude: " + position.coords.latitude +
                "<br>Longitude: " + position.coords.longitude;
        }

        getLocation();
    </script>

<?= $this->endSection(); ?>