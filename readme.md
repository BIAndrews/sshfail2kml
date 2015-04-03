sshfail2kml
===========

v1.1

SSH failed login collector with Google Map KML output. Scales with SQLite3 and is log-rotator friendly.

<a href="http://www.bryanandrews.org/failedlogins/">DEMO</a>

* Tested with RedHat/CentOS/RHEL, should work on any Debian variant as well
* SQLite3 database for duplicate record prevention
* JSON export for 3rd party friendly support
* HTML complete with working Google Map KML example
* Mouse hover over action shows number of total recorded login attempts
* Intelligent GeoIP lookups to eliminate redundant queries via external API so no need for local GeoIP dat files

Requirements
------------

* PHP5 CLI  - php-cli 2.2megs
* PHP5 PDO for SQLite3 - php-pdo 78kb

ScreenShot
----------
![screensho image](sshfail2kml-map.png "An example Map from live data.")

Bryan Andrews<br>
bryanandrews@gmail.com<br>
www.bryanandrews.org<br>
