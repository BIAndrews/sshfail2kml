# updates files to be placed in the package from git repo master before packaging

install -d sshfail2kml/usr/bin sshfail2kml/etc
wget -O sshfail2kml/usr/bin/sshfail2kml https://raw.githubusercontent.com/BIAndrews/sshfail2kml/master/sshfail2kml
chmod a+x sshfail2kml/usr/bin/sshfail2kml
wget -O sshfail2kml/etc/sshfail2kml.conf https://raw.githubusercontent.com/BIAndrews/sshfail2kml/master/sshfail2kml.conf

dpkg-buildpackage -us -uc
