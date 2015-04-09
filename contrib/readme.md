Packaging
=========

Debian / Ubuntu
---------------

### sshfail2kml-VER ###
~~~
root@host:/usr/src/sshfail2kml/contrib/sshfail2kml-1.3.3# ./build.sh 
--2015-04-09 15:36:54--  https://raw.githubusercontent.com/BIAndrews/sshfail2kml/master/sshfail2kml
Resolving raw.githubusercontent.com (raw.githubusercontent.com)... 199.27.74.133
Connecting to raw.githubusercontent.com (raw.githubusercontent.com)|199.27.74.133|:443... connected.
HTTP request sent, awaiting response... 200 OK
Length: 18189 (18K) [text/plain]
Saving to: `sshfail2kml/usr/bin/sshfail2kml'

100%[===========================================================================================================================>] 18,189      --.-K/s   in 0.02s   

2015-04-09 15:36:55 (888 KB/s) - `sshfail2kml/usr/bin/sshfail2kml' saved [18189/18189]

--2015-04-09 15:36:55--  https://raw.githubusercontent.com/BIAndrews/sshfail2kml/master/sshfail2kml.conf
Resolving raw.githubusercontent.com (raw.githubusercontent.com)... 199.27.74.133
Connecting to raw.githubusercontent.com (raw.githubusercontent.com)|199.27.74.133|:443... connected.
HTTP request sent, awaiting response... 200 OK
Length: 228 [text/plain]
Saving to: `sshfail2kml/etc/sshfail2kml.conf'

100%[===========================================================================================================================>] 228         --.-K/s   in 0s      

2015-04-09 15:36:55 (4.38 MB/s) - `sshfail2kml/etc/sshfail2kml.conf' saved [228/228]

dpkg-buildpackage: export CFLAGS from dpkg-buildflags (origin: vendor): -g -O2 -fstack-protector --param=ssp-buffer-size=4 -Wformat -Wformat-security
dpkg-buildpackage: export CPPFLAGS from dpkg-buildflags (origin: vendor): -D_FORTIFY_SOURCE=2
dpkg-buildpackage: export CXXFLAGS from dpkg-buildflags (origin: vendor): -g -O2 -fstack-protector --param=ssp-buffer-size=4 -Wformat -Wformat-security
dpkg-buildpackage: export FFLAGS from dpkg-buildflags (origin: vendor): -g -O2
dpkg-buildpackage: export LDFLAGS from dpkg-buildflags (origin: vendor): -Wl,-Bsymbolic-functions -Wl,-z,relro
dpkg-buildpackage: source package sshfail2kml
dpkg-buildpackage: source version 1.3.3
dpkg-buildpackage: source changed by Bryan Andrews <bryanandrews@gmail.com>
dpkg-buildpackage: host architecture amd64
 dpkg-source --before-build sshfail2kml-1.3.3
 debian/rules clean
dh clean 
   dh_testdir
   dh_auto_clean
   dh_clean
 dpkg-source -b sshfail2kml-1.3.3
dpkg-source: info: using source format `3.0 (native)'
dpkg-source: info: building sshfail2kml in sshfail2kml_1.3.3.tar.gz
dpkg-source: info: building sshfail2kml in sshfail2kml_1.3.3.dsc
 debian/rules build
dh build 
   dh_testdir
   dh_auto_configure
   dh_auto_build
   dh_auto_test
 debian/rules binary
dh binary 
   dh_testroot
   dh_prep
   dh_installdirs
   dh_auto_install
   dh_install
   dh_installdocs
   dh_installchangelogs
   dh_installexamples
   dh_installman
   dh_installcatalogs
   dh_installcron
   dh_installdebconf
   dh_installemacsen
   dh_installifupdown
   dh_installinfo
   dh_installinit
   dh_installmenu
   dh_installmime
   dh_installmodules
   dh_installlogcheck
   dh_installlogrotate
   dh_installpam
   dh_installppp
   dh_installudev
   dh_installwm
   dh_installxfonts
   dh_installgsettings
   dh_bugfiles
   dh_ucf
   dh_lintian
   dh_gconf
   dh_icons
   dh_perl
   dh_usrlocal
   dh_link
   dh_compress
   dh_fixperms
   dh_installdeb
   dh_gencontrol
   dh_md5sums
   dh_builddeb
dpkg-deb: building package `sshfail2kml' in `../sshfail2kml_1.3.3_all.deb'.
 dpkg-genchanges  >../sshfail2kml_1.3.3_amd64.changes
dpkg-genchanges: including full source code in upload
 dpkg-source --after-build sshfail2kml-1.3.3
dpkg-buildpackage: full upload; Debian-native package (full source is included)
root@host:/usr/src/sshfail2kml/contrib/sshfail2kml-1.3.3# ls -lah *.deb
total 68K
-rw-r--r-- 1 root root 9.0K Apr  9 15:36 sshfail2kml_1.3.3_all.deb
~~~



RPM / Redhat / CentOS
---------------------

### sshfail2kml.spec ###
~~~
[root@colo3 tmp]# curl https://raw.githubusercontent.com/BIAndrews/sshfail2kml/master/contrib/sshfail2kml.spec > sshfail2kml.spec
  % Total    % Received % Xferd  Average Speed   Time    Time     Time  Current
                                 Dload  Upload   Total   Spent    Left  Speed
104  1563  104  1563    0     0   4358      0 --:--:-- --:--:-- --:--:-- 15028
[root@colo3 tmp]# rpmbuild -bb sshfail2kml.spec
Executing(%prep): /bin/sh -e /var/tmp/rpm-tmp.LRG7R0
+ umask 022
+ cd /root/rpmbuild/BUILD
+ LANG=C
+ export LANG
+ unset DISPLAY
+ cd /root/rpmbuild/BUILD
+ rm -rf sshfail2kml-1.3.2
+ /bin/mkdir -p sshfail2kml-1.3.2
+ cd sshfail2kml-1.3.2
+ /bin/chmod -Rf a+rX,u+w,g-w,o-w .
+ exit 0
Executing(%build): /bin/sh -e /var/tmp/rpm-tmp.gTNzLS
+ umask 022
+ cd /root/rpmbuild/BUILD
+ cd sshfail2kml-1.3.2
+ LANG=C
+ export LANG
+ unset DISPLAY
+ /usr/bin/install -d /root/rpmbuild/SOURCES
+ curl -s https://raw.githubusercontent.com/BIAndrews/sshfail2kml/master/sshfail2kml
+ curl -s https://raw.githubusercontent.com/BIAndrews/sshfail2kml/master/sshfail2kml-cron.sh
+ curl -s https://raw.githubusercontent.com/BIAndrews/sshfail2kml/master/sshfail2kml.conf
+ exit 0
Executing(%install): /bin/sh -e /var/tmp/rpm-tmp.XkeJVN
+ umask 022
+ cd /root/rpmbuild/BUILD
+ '[' /root/rpmbuild/BUILDROOT/sshfail2kml-1.3.2-1.x86_64 '!=' / ']'
+ rm -rf /root/rpmbuild/BUILDROOT/sshfail2kml-1.3.2-1.x86_64
++ dirname /root/rpmbuild/BUILDROOT/sshfail2kml-1.3.2-1.x86_64
+ mkdir -p /root/rpmbuild/BUILDROOT
+ mkdir /root/rpmbuild/BUILDROOT/sshfail2kml-1.3.2-1.x86_64
+ cd sshfail2kml-1.3.2
+ LANG=C
+ export LANG
+ unset DISPLAY
+ /bin/mkdir -p /root/rpmbuild/BUILDROOT/sshfail2kml-1.3.2-1.x86_64/etc/cron.d
+ /bin/mkdir -p /root/rpmbuild/BUILDROOT/sshfail2kml-1.3.2-1.x86_64/usr/bin
+ /bin/mkdir -p /root/rpmbuild/BUILDROOT/sshfail2kml-1.3.2-1.x86_64/var/lib/sshfail2kml
+ /usr/bin/install -m0644 /root/rpmbuild/SOURCES/sshfail2kml /root/rpmbuild/BUILDROOT/sshfail2kml-1.3.2-1.x86_64/usr/bin
+ /usr/bin/install -m0644 /root/rpmbuild/SOURCES/sshfail2kml-cron.sh /root/rpmbuild/BUILDROOT/sshfail2kml-1.3.2-1.x86_64/etc/cron.d
+ /usr/bin/install -m0640 /root/rpmbuild/SOURCES/sshfail2kml.conf /root/rpmbuild/BUILDROOT/sshfail2kml-1.3.2-1.x86_64/etc
+ /usr/lib/rpm/find-debuginfo.sh --strict-build-id /root/rpmbuild/BUILD/sshfail2kml-1.3.2
+ /usr/lib/rpm/check-buildroot
+ /usr/lib/rpm/redhat/brp-compress
+ /usr/lib/rpm/redhat/brp-strip-static-archive /usr/bin/strip
+ /usr/lib/rpm/redhat/brp-strip-comment-note /usr/bin/strip /usr/bin/objdump
+ /usr/lib/rpm/brp-python-bytecompile
+ /usr/lib/rpm/redhat/brp-python-hardlink
+ /usr/lib/rpm/redhat/brp-java-repack-jars
Processing files: sshfail2kml-1.3.2-1.noarch
Requires(rpmlib): rpmlib(CompressedFileNames) <= 3.0.4-1 rpmlib(FileDigests) <= 4.6.0-1 rpmlib(PayloadFilesHavePrefix) <= 4.0-1
Checking for unpackaged file(s): /usr/lib/rpm/check-files /root/rpmbuild/BUILDROOT/sshfail2kml-1.3.2-1.x86_64
Wrote: /root/rpmbuild/RPMS/noarch/sshfail2kml-1.3.2-1.noarch.rpm
Executing(%clean): /bin/sh -e /var/tmp/rpm-tmp.XbbvyF
+ umask 022
+ cd /root/rpmbuild/BUILD
+ cd sshfail2kml-1.3.2
+ /bin/rm -rf /root/rpmbuild/BUILDROOT/sshfail2kml-1.3.2-1.x86_64
+ exit 0
[root@colo3 tmp]# rpm -qpil /root/rpmbuild/RPMS/noarch/sshfail2kml-1.3.2-1.noarch.rpm
Name        : sshfail2kml                  Relocations: (not relocatable)
Version     : 1.3.2                             Vendor: (none)
Release     : 1                             Build Date: Tue 07 Apr 2015 05:48:08 PM MST
Install Date: (not installed)               Build Host: colo3.example.org
Group       : Applications/System           Source RPM: sshfail2kml-1.3.2-1.src.rpm
Size        : 15715                            License: GPLv2
Signature   : (none)
Packager    : Bryan Andrews http://www.bryanandrews.org
URL         : https://github.com/BIAndrews/sshfail2kml
Summary     : SSH failed login attempts recorded to Google Maps KML file, JSON, and SQLite3.
Description :
SSH failed login attempts logged and GeoIP info acquired for Google Map KML display in an HTML page. Complete with JSON results and SQLite indexed database for a log rotation friendly setup.
/etc/cron.d/sshfail2kml-cron.sh
/etc/sshfail2kml.conf
/usr/bin/sshfail2kml
/var/lib/sshfail2kml
~~~

