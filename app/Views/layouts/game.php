<!DOCTYPE html>
<html dir="ltr" lang="">
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Anomalistic City</title>

    <script type="text/javascript" src="/js/jquery-3.2.1.min.js"></script>
    <script type="text/javascript" src="/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="/js/game.js"></script>
    <script type="text/javascript" src="/js/leaflet.js"></script>
    <script type="text/javascript" src="/js/script.js"></script>
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/game.css">
    <link rel="stylesheet" href="/css/leaflet.css">

    <!--
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?v=3.exp"></script>
    <link rel="alternate" hreflang="en" href="https://developers.google.com/maps/documentation/javascript/geolocation" />
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&callback=initialize"></script>
    <link rel="alternate" hreflang="en" href="https://developers.google.com/maps/documentation/javascript/geolocation" />
    -->

</head>
<body>
<div class="body game-body">
    <?= $this->renderSection('login') ?>
    <?= $this->renderSection('game') ?>
    <?= $this->renderSection('puzzle') ?>
</div>

</body>
</html>