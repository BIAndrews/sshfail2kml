Packaging
=========

Easy package creation with FPM
------------------------------

~~~
[user@host sshfail2kml]# cd contrib
[user@host contrib]# ./fpm-createPackages.sh 
DIR: fakeroot/
Setting workdir {:workdir=>"/tmp", :level=>:info}
Setting from flags: architecture=noarch {:level=>:info}
Setting from flags: description=SSH failed login attempts logged and GeoIP info acquired for Google Map KML display in an HTML page. Complete with JSON results and SQLite indexed database for a log rotation friendly setup. {:level=>:info}
Setting from flags: epoch= {:level=>:info}
Setting from flags: iteration=1 {:level=>:info}
Setting from flags: license=GPLv3 {:level=>:info}
Setting from flags: maintainer=bryanandrews@gmail.com {:level=>:info}
Setting from flags: name=sshfail2kml {:level=>:info}
Setting from flags: url=https://github.com/BIAndrews/sshfail2kml {:level=>:info}
Setting from flags: version=1.3.3 {:level=>:info}
Setting from flags: architecture=noarch {:level=>:info}
Converting dir to rpm {:level=>:info}
no value for epoch is set, defaulting to nil {:level=>:warn}
Reading template {:path=>"/usr/local/share/gems/gems/fpm-1.3.3/templates/rpm.erb", :level=>:info}
no value for epoch is set, defaulting to nil {:level=>:warn}
Running rpmbuild {:args=>["rpmbuild", "-bb", "--target", "noarch", "--define", "buildroot /tmp/package-rpm-build20150411-31922-1ufhz9d/BUILD", "--define", "_topdir /tmp/package-rpm-build20150411-31922-1ufhz9d", "--define", "_sourcedir /tmp/package-rpm-build20150411-31922-1ufhz9d", "--define", "_rpmdir /tmp/package-rpm-build20150411-31922-1ufhz9d/RPMS", "--define", "_tmppath /tmp", "/tmp/package-rpm-build20150411-31922-1ufhz9d/SPECS/sshfail2kml.spec"], :level=>:info}
Building target platforms: noarch {:level=>:info}
Building for target noarch {:level=>:info}
Executing(%prep): /bin/sh -e /tmp/rpm-tmp.7m62HB {:level=>:info}
Executing(%build): /bin/sh -e /tmp/rpm-tmp.75X4Gb {:level=>:info}
Executing(%install): /bin/sh -e /tmp/rpm-tmp.DxFpGL {:level=>:info}
Processing files: sshfail2kml-1.3.3-1.noarch {:level=>:info}
Provides: sshfail2kml sshfail2kml = 1.3.3-1 {:level=>:info}
Requires(rpmlib): rpmlib(PayloadFilesHavePrefix) <= 4.0-1 rpmlib(CompressedFileNames) <= 3.0.4-1 {:level=>:info}
Wrote: /tmp/package-rpm-build20150411-31922-1ufhz9d/RPMS/noarch/sshfail2kml-1.3.3-1.noarch.rpm {:level=>:info}
Executing(%clean): /bin/sh -e /tmp/rpm-tmp.rySKJV {:level=>:info}
Created package {:path=>"../sshfail2kml-1.3.3-1.noarch.rpm"}
Setting workdir {:workdir=>"/tmp", :level=>:info}
Setting from flags: architecture=all {:level=>:info}
Setting from flags: description=SSH failed login attempts logged and GeoIP info acquired for Google Map KML display in an HTML page. Complete with JSON results and SQLite indexed database for a log rotation friendly setup. {:level=>:info}
Setting from flags: epoch= {:level=>:info}
Setting from flags: iteration=1 {:level=>:info}
Setting from flags: license=GPLv3 {:level=>:info}
Setting from flags: maintainer=bryanandrews@gmail.com {:level=>:info}
Setting from flags: name=sshfail2kml {:level=>:info}
Setting from flags: url=https://github.com/BIAndrews/sshfail2kml {:level=>:info}
Setting from flags: version=1.3.3 {:level=>:info}
Setting from flags: architecture=all {:level=>:info}
Converting dir to deb {:level=>:info}
No deb_installed_size set, calculating now. {:level=>:info}
Reading template {:path=>"/usr/local/share/gems/gems/fpm-1.3.3/templates/deb.erb", :level=>:info}
Creating {:path=>"/tmp/package-deb-build20150411-31933-swsinb/control.tar.gz", :from=>"/tmp/package-deb-build20150411-31933-swsinb/control", :level=>:info}
Creating boilerplate changelog file {:level=>:info}
Reading template {:path=>"/usr/local/share/gems/gems/fpm-1.3.3/templates/deb/changelog.erb", :level=>:info}
Created package {:path=>"../sshfail2kml-1.3.3-1_all.deb"}
Name        : sshfail2kml
Version     : 1.3.3
Release     : 1
Architecture: noarch
Install Date: (not installed)
Group       : default
Size        : 18563
License     : GPLv3
Signature   : (none)
Source RPM  : sshfail2kml-1.3.3-1.src.rpm
Build Date  : Sat 11 Apr 2015 12:32:08 PM MDT
Build Host  : bamboo.bryanandrews.org
Relocations : / 
Packager    : bryanandrews@gmail.com
Vendor      : jira@bamboo
URL         : https://github.com/BIAndrews/sshfail2kml
Summary     : SSH failed login attempts logged and GeoIP info acquired for Google Map KML display in an HTML page. Complete with JSON results and SQLite indexed database for a log rotation friendly setup.
Description :
SSH failed login attempts logged and GeoIP info acquired for Google Map KML display in an HTML page. Complete with JSON results and SQLite indexed database for a log rotation friendly setup.
/etc/cron.d/sshfail2kml.cron.sh
/etc/sshfail2kml.conf
/usr/bin/sshfail2kml
/var/lib/sshfail2kml
Successfully created redhat package.
Successfully created debian package.
~~~
