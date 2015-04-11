# my build server is centos, could be easy to update this to support debian
if [ ! -x /bin/gcc ];then
yum install gcc
#aptitude install gcc
fi

if [ ! -f /usr/include/ruby.h ];then
yum install ruby-devel
#aptitude install ...
fi

if [ ! -x $(which fpm) ];then
gem install fpm
fi

DIR="fakeroot/"
NAME="sshfail2kml"
DESC="SSH failed login attempts logged and GeoIP info acquired for Google Map KML display in an HTML page. Complete with JSON results and SQLite indexed database for a log rotation friendly setup."
URI="https://github.com/BIAndrews/sshfail2kml"
LIC="GPLv3"
PROV="sshfail2kml"
EMAIL="bryanandrews@gmail.com"
VER="1.3.3"
RELEASE="1"

install -d $DIR/var/lib/sshfail2kml $DIR/etc/cron.d $DIR/usr/bin
cp -f ../sshfail2kml $DIR/usr/bin
cp -f ../sshfail2kml.conf $DIR/etc
cp -f sshfail2kml.cron.d $DIR/etc/cron.d/sshfail2kml.cron.sh
chmod a+x $DIR/etc/cron.d/sshfail2kml.cron.sh $DIR/usr/bin/sshfail2kml
chmod o-rwx $DIR/etc/sshfail2kml.conf

echo "DIR: $DIR"
cd $DIR

# CREATE THE REDHAT PACKAGE
fpm \
--url $URI --license $LIC --provides $PROV -p "../$NAME-$VER-$RELEASE.noarch.rpm" \
-m $EMAIL --no-rpm-sign -v $VER --iteration $RELEASE -a noarch \
-s dir -t rpm -n $NAME -d php-cli -d php-pdo --verbose --config-files /etc/sshfail2kml.conf --directories /var/lib/sshfail2kml --description "$DESC" \
*

# CREATE THE DEBIAN PACKAGE
fpm \
--url $URI --license $LIC --provides $PROV -p "../$NAME-$VER-${RELEASE}_all.deb" \
-m $EMAIL -v $VER --iteration $RELEASE -a all \
-s dir -t deb -n $NAME -d php5-cli -d php5-sqlite --verbose --config-files /etc/sshfail2kml.conf --directories /var/lib/sshfail2kml --description "$DESC" \
*

cd ..
if [ -f "$NAME-$VER-$RELEASE.noarch.rpm" ];then
rpm -qpil $NAME-$VER-$RELEASE.noarch.rpm
echo "Successfully created redhat package."
else
echo "FAILED TO CREATE RPM PACKAGE"
exit 1
fi

if [ -f "$NAME-$VER-${RELEASE}_all.deb" ];then
echo "Successfully created debian package."
else
echo "FAILED TO CREATE DEBIAN PACKAGE"
exit 1
fi

#clean up
rm -rf $DIR
