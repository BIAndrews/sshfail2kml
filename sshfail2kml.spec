# install -d ~/rpmbuild/SOURCES
# wget https://raw.githubusercontent.com/BIAndrews/sshfail2kml/master/create_kml -O ~/rpmbuild/SOURCES/create_kml
# wget https://raw.githubusercontent.com/BIAndrews/sshfail2kml/master/sshfail2kml-cron.sh -O ~/rpmbuild/SOURCES/sshfail2kml-cron.sh
# mv ~/rpmbuild/SOURCES/create_kml ~/rpmbuild/SOURCES/sshfail2kml

Summary: SSH failed login attempts logged and GeoIP info acquired for Google Map KML display in an HTML page. Complete with JSON results and SQLite indexed database for a log rotation friendly setup.
Name: sshfail2kml
Version: 1.3
Release: 1
License: GPLv2
Group: Applications/System
Source0: https://raw.githubusercontent.com/BIAndrews/sshfail2kml/master/sshfail2kml
Source1: https://raw.githubusercontent.com/BIAndrews/sshfail2kml/master/sshfail2kml-cron.sh
URL: https://github.com/BIAndrews/sshfail2kml
Packager: Bryan Andrews <http://www.bryanandrews.org>
Requires: php-cli, php-pdo

%description
Tested with RedHat/CentOS/RHEL, should work on any Debian variant as well
SQLite3 database for duplicate record prevention and detailed indexed records
JSON file created and updated each run
HTML complete with working Google Map KML example
Mouse hover over action shows number of total recorded login attempts
Intelligent GeoIP lookups to eliminate redundant queries via external API so no need for local GeoIP dat files
PHP examples for working with JSON
Command line switches to overwrite defaults
Auto detect abuse email addresses for suspect IP addresses and log to SQL and JSON and KML outputs

%install
%{__mkdir_p} ${RPM_BUILD_ROOT}/etc/cron.d
%{__mkdir_p} ${RPM_BUILD_ROOT}/usr/bin
%{__mkdir_p} ${RPM_BUILD_ROOT}/var/lib/sshfail2kml
%{__install} -m0644 %{SOURCE0} ${RPM_BUILD_ROOT}/usr/bin
%{__install} -m0644 %{SOURCE1} ${RPM_BUILD_ROOT}/etc/cron.d

%files
/etc/cron.d/*
/usr/bin/*
/var/lib/sshfail2kml
