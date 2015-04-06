sshfail2kml
===========

v1.2

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
./create_kml [-f] [-j] [-s] [-k] [-m] [-g] [-h]

        -f file         Syslog secure or auth.log log file to process.
        -j file         JSON file.
        -s file         SQLite3 DB file.
        -k file         KML file.
        -m int          Max number of previous hits to show in KML file.
        -g url          URL to the GeoIP REST API to use.
        -h              This help screen.
        -d              Enable debug mode.
~~~

SQLite3 Schemas
---------------
~~~
 -- Complete syslog line fail
 CREATE TABLE IF NOT EXISTS previousFails (
  line STRING PRIMARY KEY,
  t TIMESTAMP DEFAULT CURRENT_TIMESTAMP);
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
