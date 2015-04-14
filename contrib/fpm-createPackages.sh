#!/bin/bash

# this is a fast way to create packages with the fpm tool: https://github.com/jordansissel/fpm/wiki

DIR="$$/" # lets make a random temp dir as a fakeroot
NAME="sshfail2kml"
DESC="SSH failed login attempts logged and GeoIP info acquired for Google Map KML display in an HTML page. Complete with JSON results and SQLite indexed database for a log rotation friendly setup."
URI="https://github.com/BIAndrews/sshfail2kml"
LIC="GPLv3"
PROV="sshfail2kml"
EMAIL="bryanandrews@gmail.com"

#################################################################################################
#
# PREFLIGHT CHECK FOR REQUIRED TOOLS
#

# my build server is centos, could be easy to update this to support debian
if [ ! command -v fpm >/dev/null 2>&1 ];then

  gem install fpm

  if [ ! command -v fpm >/dev/null 2>&1 ];then
    echo "Unable to install or find fpm."
    exit 1
  fi

fi

if [ ! command -v gcc >/dev/null 2>&1 ];then

  yum install gcc
  #aptitude install gcc

fi

rpm -ql ruby-devel > /dev/null
if [ $? -ne 0 ];then

  yum install ruby-devel
  #aptitude install ...

fi

# juuussttt in case
if [ "$DIR" == "/" ]; then
  echo "ERROR: the fakeroot temp dir can't be / or really really bad things will happen."
  exit 255;
fi

########################################################################################
#
# LETS GO
#

if [ ! -f "${PWD}/version.sh" ];then
  echo "Unable to find the version.sh file."
  pwd
  ls -lah .
  exit 1
fi

. "${PWD}/version.sh"

if [ $? -ne 0 ];then
  echo "ERROR: Failed to include ${PWD}/version.sh"
  exit 1
fi

#
# Lets automatically create the package release number for jenkin/ci automation, resets on a new version/tag
#

if [ -f "${PWD}/.release-${VER}" ];then
. "${PWD}/.release-${VER}"
RELEASE=$((RELEASE+1))
else
RELEASE="0"
fi
echo "RELEASE=$RELEASE" > "${PWD}/.release-${VER}"

###############################################################
#
# Create and populate the fakeroot directory to be packaged
#

echo "Building package fakeroot dir for ${VER}-${RELEASE}"

install -d $DIR/var/lib/sshfail2kml $DIR/etc/cron.d $DIR/usr/bin
cp -f ../sshfail2kml $DIR/usr/bin
cp -f ../sshfail2kml.conf $DIR/etc
cp -f sshfail2kml.cron.d $DIR/etc/cron.d/sshfail2kml.cron.sh
chmod a+x $DIR/etc/cron.d/sshfail2kml.cron.sh $DIR/usr/bin/sshfail2kml
chmod o-rwx $DIR/etc/sshfail2kml.conf

echo "DIR: $DIR"
cd $DIR

##################################
#
# CREATE THE REDHAT PACKAGE
#
# todo - when fpm can make srpms add that


fpm \
--url $URI --license $LIC --provides $PROV -p "../$NAME-$VER-$RELEASE.noarch.rpm" \
-m $EMAIL --no-rpm-sign -v $VER --iteration $RELEASE -a noarch \
-s dir -t rpm -n $NAME -d php-cli -d php-pdo --verbose --config-files /etc/sshfail2kml.conf --directories /var/lib/sshfail2kml --description "$DESC" \
*

##################################
#
# CREATE THE DEBIAN PACKAGE
#

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

#clean up, this is a good example of why we never run someone elses code as root
rm -rf $DIR
