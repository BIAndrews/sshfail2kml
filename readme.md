sshfail2kml
===========

v1.1

SSH failed login collector with Google Map KML and JSON output. Scales with SQLite3 and is log-rotator friendly.

<a href="http://www.bryanandrews.org/failedlogins/">DEMO</a>

* Tested with RedHat/CentOS/RHEL, should work on any Debian variant as well
* SQLite3 database for duplicate record prevention
* JSON export for 3rd party friendly support
* HTML complete with working Google Map KML example
* Mouse hover over action shows number of total recorded login attempts
* Intelligent GeoIP lookups to eliminate redundant queries via external API so no need for local GeoIP dat files
* PHP examples for working with JSON

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
# ./create_kml.php -h
./create_kml.php [-f] [-j] [-s] [-k] [-m] [-g] [-h]

        -f file         Syslog secure or auth.log log file to process.
        -j file         JSON file.
        -s file         SQLite3 DB file.
        -k file         KML file.
        -m int          Max number of previous hits to show in KML file.
        -g url          URL to the GeoIP REST API to use.
        -h              This help screen.
        -d              Enable debug mode.
~~~

Bryan Andrews<br>
bryanandrews@gmail.com<br>
www.bryanandrews.org<br>
