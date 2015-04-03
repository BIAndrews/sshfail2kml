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

***************************************************************************************************/


/***********************************
 * Vars you might want to change
*/
$file = 	"auto";				// this is the syslog file where failed sshd attempts are logged
$regex = 	"/.*Failed password.*/";	// regex used to find failed SSH login attmepts
$savefile = 	"sshfail2kml.json";		// JSON data file, relative path
$sqlitedb = 	"sshfail2kml.sqlite";		// SQLite3 DB file name, relative path
$kmlfile =	"sshfail2kml.kml";		// KML file name, relative path
$maxprevious =	"6";				// max number of previous attempts to show in the KML map
$geoipREST =	"http://www.telize.com/geoip/";	// You guys rock thank you

$DEBUG = 	0;


//***************************************************************************************************
//***************************************************************************************************

$time_start = microtime(true); 

if ($file == "auto") {

	if (is_file("/var/log/secure")) {

		$file = "/var/log/secure";
		if ($DEBUG) print "Detected /var/log/secure\n";

	} elseif (is_file("/var/log/auth.log")) {

		$file = "/var/log/auth.log";
		if ($DEBUG) print "Detected /var/log/auth.log\n";

	} else {

		print "ERROR: Failed to auto detect syslog auth.log or secure file.\n";
		exit(1);
	}

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
	$rval = TRUE;
	$hostname = gethostname();

    	$k .= "<?xml version='1.0' encoding='UTF-8'?>\n";
    	$k .= "<kml xmlns='http://www.opengis.net/kml/2.2'>\n";
    	$k .= "<Document>\n";
    	$k .= "<name>$hostname sshfail2kml.kml</name>\n";
    	$k .= "<open>1</open>\n";
    	$k .= "   <Style id='StyleDocument'>\n";
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
		if ($DEBUG) print "SELECTing last $maxprevious attempts from sqlite3 DB from $i ";
                $result = $db->query("SELECT line FROM previousFails WHERE line LIKE '%$i%' ORDER BY t DESC LIMIT $maxprevious");

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
				if ($DEBUG) print ".";
				$lastX .= $res['line']." <br />\n";
			}
			if ($DEBUG) print "\n";
		} else {
			if ($DEBUG) print "Failed sqlite3 query\n";
		}

        	$k .= "<Placemark>\n";
        	$k .= "  <name>$v[country_name]</name>\n";
        	$k .= "  <description>$v[count] SSH attempt(s) $from <span style=\"font-size:9px\">$lastX</span></description>\n";
        	$k .= "  <Point>\n";
        	$k .= "    <coordinates> $v[longitude], $v[latitude], 0</coordinates>\n";
        	$k .= "  </Point>\n";
        	$k .= " </Placemark>\n";

		unset($from);
    	}

    	$k .= "</Document>\n";
    	$k .= "</kml>\n";

  	// when debugging also dump XML to console
   	if ($DEBUG) print "$k\n";

	if (!file_put_contents($kmlfile, $k)) {
		print "ERROR: unable to save KML XML to $kmlfile\n";
		$rval = FALSE;
	}

	return $rval;
}


/*
 * 	LOOP THROUGH THE SECURE LOG FILE FOR FAILED SSH LOGIN ATTEMPTS AND RECORD/INDEX/LOOKUP
*/

if (is_readable($file)) {				# main loop

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


			if (!isset($badguys[$items[10]]["geoip"])) { // lets only ever do this once

				if ($DEBUG) print "GeoIP lookup for $items[10] ...";

				sleep(rand(1,3)); // lets be nice to the upstream geoip API
				$record = json_decode(file_get_contents("$geoipREST/$items[10]"));

				if (is_object($record)) {

					if ($DEBUG) print "city is $record->city\n";
	
					$badguys[$items[10]]["geoip"] = 	true;
					$badguys[$items[10]]["latitude"] = 	$record->latitude;
					$badguys[$items[10]]["longitude"] = 	$record->longitude;
					$badguys[$items[10]]["country_name"] = 	$record->country;
					$badguys[$items[10]]["city"] = 		$record->city;
					$badguys[$items[10]]["state"] = 	$record->region;
					$badguys[$items[10]]["timezone"] = 	$record->timezone;
					$badguys[$items[10]]["county_code3"] = 	$record->county_code3;

				} else {

					if ($DEBUG) print " not found.\n";

					$badguys[$items[10]]["geoip"] = 	false;
				}

			} else {

				if ($DEBUG) print "Not looking up $items[10] because of prevous geoip lookup.\n";

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
