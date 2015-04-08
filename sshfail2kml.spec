# rpmbuild -bb sshfail2kml.spec

Summary: SSH failed login attempts recorded to Google Maps KML file, JSON, and SQLite3.
Name: sshfail2kml
Version: 1.3.2
Release: 3
License: GPLv2
Group: Applications/System
Source0: sshfail2kml
Source1: sshfail2kml-cron.sh
Source2: sshfail2kml.conf
URL: https://github.com/BIAndrews/sshfail2kml
Packager: Bryan Andrews http://www.bryanandrews.org
BuildArch: noarch
Requires: php-cli, php-pdo
Buildrequires: curl
BuildRoot: %{_tmppath}/%{name}-%{version}-%{release}-root-%(%{__id_u} -n)

%description
SSH failed login attempts logged and GeoIP info acquired for Google Map KML display in an HTML page. Complete with JSON results and SQLite indexed database for a log rotation friendly setup.

%prep
%setup -T -c

%build
%{__install} -d ~/rpmbuild/SOURCES
curl -s https://raw.githubusercontent.com/BIAndrews/sshfail2kml/master/sshfail2kml > %{_sourcedir}/sshfail2kml
curl -s https://raw.githubusercontent.com/BIAndrews/sshfail2kml/master/sshfail2kml-cron.sh > %{_sourcedir}/sshfail2kml-cron.sh
curl -s https://raw.githubusercontent.com/BIAndrews/sshfail2kml/master/sshfail2kml.conf > %{_sourcedir}/sshfail2kml.conf

%install
%{__mkdir_p} ${RPM_BUILD_ROOT}/etc/cron.d
%{__mkdir_p} ${RPM_BUILD_ROOT}/usr/bin
%{__mkdir_p} ${RPM_BUILD_ROOT}/var/lib/sshfail2kml
%{__install} -m0744 %{SOURCE0} ${RPM_BUILD_ROOT}/usr/bin
%{__install} -m0644 %{SOURCE1} ${RPM_BUILD_ROOT}/etc/cron.d
%{__install} -m0640 %{SOURCE2} ${RPM_BUILD_ROOT}/etc

%files
/etc/sshfail2kml.conf
/etc/cron.d/sshfail2kml-cron.sh
/usr/bin/sshfail2kml
/var/lib/sshfail2kml
