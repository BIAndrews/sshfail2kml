# install -d ~/rpmbuild/SOURCES
# curl -s https://raw.githubusercontent.com/BIAndrews/sshfail2kml/master/sshfail2kml > ~/rpmbuild/SOURCES/sshfail2kml
# curl -s https://raw.githubusercontent.com/BIAndrews/sshfail2kml/master/sshfail2kml-cron.sh > ~/rpmbuild/SOURCES/sshfail2kml-cron.sh

Summary: SSH failed login attempts recorded to Google Maps KML file, JSON, and SQLite3.
Name: sshfail2kml
Version: 1.3
Release: 1
License: GPLv2
Group: Applications/System
Source0: sshfail2kml
Source1: sshfail2kml-cron.sh
URL: https://github.com/BIAndrews/sshfail2kml
Packager: Bryan Andrews http://www.bryanandrews.org
BuildArch: noarch
Requires: php-cli, php-pdo

%description
SSH failed login attempts logged and GeoIP info acquired for Google Map KML display in an HTML page. Complete with JSON results and SQLite indexed database for a log rotation friendly setup.

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
