sshfail2kml
===========

v1.3

SSH failed login collector with Google Map KML and JSON output. Scales with SQLite3 and is log-rotator friendly.

<a href="http://www.bryanandrews.org/failedlogins/">DEMO</a>

* Tested with RedHat/CentOS/RHEL, should work on any Debian variant as well
* SQLite3 database for duplicate record prevention and detailed indexed records
* JSON file created and updated each run
* HTML complete with working Google Map KML example
* Mouse hover over action shows number of total recorded login attempts
* Intelligent GeoIP lookups to eliminate redundant queries via external API so no need for local GeoIP dat files
* PHP examples for working with JSON
* Command line switches to overwrite defaults
* Auto detect abuse email addresses for suspect IP addresses and log to SQL and JSON and KML outputs

Requirements
------------

* PHP5 CLI  - php-cli 2.2megs
* PHP5 PDO for SQLite3 - php-pdo 78kb

ScreenShot
----------
![screensho image](sshfail2kml-map.png "An example Map from live data.")

Usage
-----
~~~
# ./create_kml -h
./create_kml [-f] [-j] [-s] [-k] [-m] [-g] [-h] [-q] [-d]

        -f file         Syslog secure or auth.log log file to process.   Default: Auto detect
        -j file         JSON file.                                       Default: sshfail2kml.json
        -s file         SQLite3 DB file.                                 Default: sshfail2kml.sqlite
        -k file         KML file.                                        Default: sshfail2kml.kml
        -m int          Max number of previous hits to show in KML file. Default: 6
        -g url          URL to the GeoIP REST API to use.                Default: http://www.telize.com/geoip/
        -h              This help screen.
        -q              Be quiet.
        -d              Enable debug mode.
~~~

SQLite3 Schemas
---------------
~~~
 -- Complete syslog line fail
 CREATE TABLE IF NOT EXISTS previousFails (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  line STRING UNIQUE NOT NULL,
  ip CHAR(15),
  t TIMESTAMP DEFAULT CURRENT_TIMESTAMP);
 CREATE INDEX IF NOT EXISTS line ON previousFails (line);
 CREATE INDEX IF NOT EXISTS ip ON previousFails (ip);
 CREATE INDEX IF NOT EXISTS t ON previousFails (t);

 -- Indexed table of IP addresses with GeoIP details and hit counts
 CREATE TABLE IF NOT EXISTS ipaddresses (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  ip CHAR(15) UNIQUE NOT NULL,
  count INT,
  geoip INT,
  latitude REAL,
  longitude REAL,
  country_name CHAR(64),
  city CHAR(64),
  state CHAR(64),
  t TIMESTAMP DEFAULT CURRENT_TIMESTAMP);
 CREATE INDEX IF NOT EXISTS ip ON ipaddresses (ip);
 CREATE INDEX IF NOT EXISTS count ON ipaddresses (count);
 CREATE INDEX IF NOT EXISTS country_name ON ipaddresses (country_name);
~~~

> Bryan Andrews<br>
> bryanandrews@gmail.com<br>
> http://www.bryanandrews.org<br>
