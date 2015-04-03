<!DOCTYPE html>
<html>
<head>

    <title>sshfail2kml Demo</title>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <style>
      html, body, #map-canvas {
	width: 880px;
	height: 400px;
        margin: 0px;
        padding: 0px
      }
    </style>

    <!-- you might want to get an API key and add it here -->
    <script type="text/javascript"
      src="https://maps.googleapis.com/maps/api/js">
    </script>

	<script type="text/javascript">
            var map;
	    var src = '<?php print "http://".$_SERVER["HTTP_HOST"]; print dirname($_SERVER["PHP_SELF"]); ?>/sshfail2kml.kml';
            function initialize() {
                var myLatlng = new google.maps.LatLng(45.417495,28.015405);
                var mapOptions = {
                    center: myLatlng,
                    zoom: 8,
                    mapTypeId: google.maps.MapTypeId.TERRAIN
                };
                var map = new google.maps.Map(document.getElementById("map-canvas"),
                    mapOptions);
                loadKmlLayer(src, map);
                function loadKmlLayer(src, map) {
                    var kmlLayer = new google.maps.KmlLayer(src, {
                        map: map
                    });
                }
            }
            google.maps.event.addDomListener(window, 'load', initialize);
        </script>

</head>

<body>

<?php
$ftime = date("m/d/y h:ia",filemtime("sshfail2kml.kml"));
print "<h2>SSH break in attempts map. Last updated: $ftime [<a href=\"https://github.com/BIAndrews/sshfail2kml\">Source</a>]</h2>";
?>

<div id="map-canvas"></div>
</body>

</html>

