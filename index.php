<!DOCTYPE html>
<html>
<head>

    <title>sshfail2kml Demo</title>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <style>
      html, body {
        margin: 10px;
        padding: 0px
      }
      #map-canvas {
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
print "<h2>SSH break in attempts map. Last updated: $ftime [<a href=\"https://github.com/BIAndrews/sshfail2kml\">Project Home and Source</a>]</h2>";
?>

<div id="map-canvas"></div>

<br>
<h2>PHP JSON Usage examples</h2>

<?php
highlight_string('<?php 

##########################################################
#
# First we load the JSON and decode it into an array
#

$array = json_decode(file_get_contents("sshfail2kml.json"), true); 

#######################################################################
#
# One way to get all the IP addresses with failed login attemps
#

print "Total unique IP addresses: <b>".number_format(count($array))."</b><Br>\n";

#################################################
#
# One way to get the top offending contry
#

foreach ($array as $ip => $a2) {
  if ($a2[\'count\'] > $top[\'count\']) {
    $top = $a2;
  }
}

print "Top country: <b>$top[country_name]</b> at <b>".number_format($top[count])."</b> <Br>\n";

# See below:
?>
');

print " <br>\n ";

$array = json_decode(file_get_contents("sshfail2kml.json"), true);

print "Total unique IP addresses: <b>".number_format(count($array))."</b><Br>\n";

    /*
    [183.136.216.4] => Array
        (
            [count] => 1088
            [geoip] => 1
            [latitude] => 26.9689
            [longitude] => 109.7725
            [country_name] => China
            [city] => Zhongxin
            [state] => Hunan
            [timezone] => Asia/Chongqing
            [county_code3] => 
        )
    */

foreach ($array as $ip => $a2) {
  if ($a2['count'] > $top['count']) {
    $top = $a2;
  }
}
print "Top country: <b>$top[country_name]</b> at <b>".number_format($top[count])."</b> <Br>\n";

//print_r($array);

print "<h2>SQLite3 PHP Demo</h2>\n\n";

highlight_string('<?php

$sqlitedb = "sshfail2kml.sqlite";
$db = new SQLite3($sqlitedb) or die("Unable to open SQLite3 database at $sqlitedb\n");
$resobj = $db->query("SELECT * FROM ipaddresses ORDER BY count DESC LIMIT 100");
print "<ol>\n";
while ($row = $resobj->fetchArray()) {
  $name = stripslashes("$row[country_name] $row[state] $row[city]");
  print "\t<li>$name ($row[ip]) - <b><a href=\"http://www.abuseipdb.com/check/$row[ip]\">".number_format($row[count])."</a></b> failed login attemps</li>\n";
}
print "</ol>\n";

# See below: 
?>');

$sqlitedb = "sshfail2kml.sqlite";
$db = new SQLite3($sqlitedb) or die("Unable to open SQLite3 database at $sqlitedb\n");
$resobj = $db->query("SELECT * FROM ipaddresses ORDER BY count DESC LIMIT 100");
print "<ol>\n";
while ($row = $resobj->fetchArray()) {
  $name = stripslashes("$row[country_name] $row[state] $row[city]");
  print "\t<li>$name ($row[ip]) - <b><a href=\"http://www.abuseipdb.com/check/$row[ip]\">".number_format($row[count])."</a></b> failed login attemps</li>\n";
}
print "</ol>\n";

?>

</body>

</html>

