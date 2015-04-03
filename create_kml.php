#!/usr/bin/php
<?php
/**************************************************************************************************
										      Bryan Andrews 
									     bryanandrews@gmail.com
									http://www.bryanandrews.org 


                  SAFE TO CRON THIS - DUPLICATE ENTRIES WILL BE IGNORED

 Requirements
 - php cli
 - php pdo (for sqlite3)
 - php geoip
 - geoip City dateabase
   - Download from: http://geolite.maxmind.com/download/geoip/database/GeoLiteCity.dat.gz
   - CentOS6 local file location needed: /usr/share/GeoIP/GeoIPCity.dat

***************************************************************************************************/


/***********************************
 * Vars you might want to change
*/
$file = 	"/var/log/secure"; // centos6 default
$regex = 	"/.*Failed password.*/";
$savefile = 	"sshfail2kml.json";
$sqlitedb = 	"sshfail2kml.sqlite";
$kmlfile =	"sshfail2kml.kml";
$maxprevious =	"6";
$DEBUG = 	0;


//***************************************************************************************************
//***************************************************************************************************

$time_start = microtime(true); 

/*
 * LETS CHECK AND SEE IF WE HAVE GEOIP INSTALL AND THE CITY DATABASE INSTALLED
*/

if ((function_exists('geoip_db_avail')) && (geoip_db_avail(GEOIP_CITY_EDITION_REV1))) {
	// correct geoip database exists, usually at /usr/share/GeoIP/GeoIPCity.dat
	define('getGeoIP',TRUE);
	if ($DEBUG) print "Found GeoIP city edition.\n";
} else {
	if ($DEBUG) print "WARN: did not find GeoIP city edition. GeoIP lookups disabled.\n";
}

/*
 * SQLITE3 DATABASE CONNECTION - REQUIRED
*/

$db = new SQLite3($sqlitedb) or die("Unable to open SQLite3 database at $sqlitedb\n");
$query = "CREATE TABLE IF NOT EXISTS previousFails (
line STRING PRIMARY KEY,
t TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);";
$db->exec($query) or die("Create SQLite3 database failed but DB file open worked.\n");

/*
 * bool sshfail2KMLWrite ( array $badguys )
*/
function sshfail2KMLWrite ($badguys) {

	global $DEBUG, $kmlfile, $db, $maxprevious;

    	$k .= "<?xml version='1.0' encoding='UTF-8'?>\n";
    	$k .= "<kml xmlns='http://www.opengis.net/kml/2.2'>\n";
    	$k .= "<Document>\n";
    	$k .= "<name>Document.kml</name>\n";
    	$k .= "<open>1</open>\n";
    	$k .= "   <Style id='exampleStyleDocument'>\n";
    	$k .= "    <LabelStyle>\n";
    	$k .= "      <color>ff0000cc</color>\n";
    	$k .= "    </LabelStyle>\n";
    	$k .= "  </Style>\n";

    	/*
    	[218.65.30.73] => Array
        (
            [count] => 45
            [geoip] => 1
            [latitude] => 28.549999237061
            [longitude] => 115.93329620361
            [country_name] => China
            [city] => Nanchang
            [state] => 03
        )
    	*/

    	foreach ($badguys as $i => $v) {

		// get the last $maxprevious attempts
		if ($DEBUG) print "SELECT line from previousFails WHERE line like '%$i%' ORDER BY t ASC LIMIT $maxprevious\n";
                $result = $db->query("SELECT line from previousFails WHERE line like '%$i%' ORDER BY t ASC LIMIT $maxprevious");

		if (!is_numeric($v[city]) && $v[city] != "") {
			$from = "$v[city]";
		}
		if (!is_numeric($v[state]) && $v[state] != "") {
			$from .= " $v[state]";
		}
		if ($from != "") {
			$from = "from $from";
		}

		// grab the last X attempts from the SQLite3 DB and record them
		if ($result) {
			$lastX = "<br />\n";
			while($res = $result->fetchArray(SQLITE3_ASSOC)){ 
				$lastX .= $res['line']."<br />";
			}
		}

        	$k .= "<Placemark>\n";
        	$k .= "  <name>$v[country_name]</name>\n";
        	$k .= "  <description>$v[count] SSH attempt(s) $from $lastX</description>\n";
        	$k .= "  <Point>\n";
        	$k .= "    <coordinates> $v[longitude], $v[latitude], 0</coordinates>\n";
        	$k .= "  </Point>\n";
        	$k .= " </Placemark>\n";

		unset($from);
    	}

    	$k .= "</Document>\n";
    	$k .= "</kml>\n";

  	// write file of it debug print to screen

   	if ($DEBUG) {

		// we don't write the KML if we are in debug mode
		print "$k\n";

   	} else {

		if (!file_put_contents($kmlfile, $k)) {
			print "ERROR: unable to save KML XML to $kmlfile\n";
			exit(1);
		}
   	}

}


/*
 * 	LOOP THROUGH THE SECURE LOG FILE FOR FAILD SSH LOGIN ATTEMPS AND RECORD/INDEX/LOOKUP
*/

if (is_readable($file)) {

	$readfile = file_get_contents ($file);
	preg_match_all ($regex, $readfile, $matches);

	if (is_array($matches)) {

		// get the last runs cache file so we can increment
		if (is_file($savefile)) {
			$badguys = json_decode(file_get_contents($savefile), true);
		}

		foreach ($matches[0] as $v) {

			/*
			Mar 30 11:09:44 colo3 sshd[19366]: Failed password for invalid user (created) from 80.56.95.211 port 50632 ssh2
			Mar 30 11:09:47 colo3 sshd[19368]: Failed password for invalid user NETWORK from 80.56.95.211 port 51824 ssh2
			Mar 29 05:57:49 colo3 sshd[22990]: Failed password for root from 115.230.127.55 port 39075 ssh2
			*/

			$v = preg_replace('/\s+/', ' ', $v); 							// remove all double spaces to clean it up for the explode
			$v = str_replace("Failed password for invalid user", "Failed password for", $v);	// remove a string to make it all neat for explode

			// check to see if we've already processed this hit before, if so skip it
			$result = $db->query("SELECT * from previousFails WHERE line = '$v'");
			$row = $result->fetchArray();
			if (is_array($row)) {
				// previously recorded hit, ignore
				if ($DEBUG) print ".";
				continue;
			}
			if ($DEBUG) print "\n";

			$items = explode(" ", $v);

			/* $v = (
			    [0] => Mar
			    [1] => 29
			    [2] => 03:18:57
			    [3] => colo3
			    [4] => sshd[19712]:
			    [5] => Failed
			    [6] => password
			    [7] => for
			    [8] => root
			    [9] => from
			    [10] => 115.230.126.151
			    [11] => port
			    [12] => 48091
			    [13] => ssh2
			) */

			if ($DEBUG) print "Logging failed attempt by ".$items[10]."\n";

			$badguys[$items[10]]["count"]++;

			// insert into the SQLite3 DB so we don't count this again
			$result = $db->query("INSERT INTO previousFails VALUES ('$v', '')");
			if (!$result) {
				print "ERROR: unable to insert record into SQLite3 DB\n"; // not strictly fatal but maybe this should be
			}

			// get the geoip loc if we haven't yet
			if (defined('getGeoIP')) {

				if ($badguys[$items[10]]["geoip"] != "false") { // lets only ever do this once

					// get the geoip loc or false to fail it
					// yum install php-pecl-geoip

					if ($DEBUG) print "GeoIP lookup for $items[10]\n";
					$record = geoip_record_by_name($items[10]);

					if ($record['latitude']) {
	
						$badguys[$items[10]]["geoip"] = true;
						$badguys[$items[10]]["latitude"] = $record['latitude'];
						$badguys[$items[10]]["longitude"] = $record['longitude'];
						$badguys[$items[10]]["country_name"] = $record['country_name'];
						$badguys[$items[10]]["city"] = $record['city'];
						$badguys[$items[10]]["state"] = $record['region'];

					} else {

						$badguys[$items[10]]["geoip"] = false;
					}
				}
			} else {
				print "WARN: geoip_record_by_name() doesn't exist, is geoip for php installed?\n";
			}

		}

		if ($DEBUG) print_r($badguys);

		// convert the array to the KML file or print if in debug mode
		sshfail2KMLWrite ($badguys);

		// save game
		if (file_put_contents($savefile, json_encode($badguys,TRUE))) {
			if ($DEBUG) print "Saved data to $savefile\n";
		} else {
			print "WARN: unable to save data to $savefile\n";
		}


	} else {
		print "No matches found.\n";
	}

} else {
	print "ERROR: unable to read $file. Do you need to run this as sudo?\n";
	exit(1);
}

$time_end = microtime(true);
$execution_time = ($time_end - $time_start);
print "Total Execution Time: ".$execution_time." s\n";
?>
