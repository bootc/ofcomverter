#!/bin/bash

VERSION=`./ofcomverter --help | head -n +1 | awk '{print $3}'`
sed s/^Version:.*$/Version:\ ${VERSION}/ < control > control2
cp control2 control
rm control2
rm -rf ./debian_package
mkdir -p debian_package
mkdir -p debian_package/DEBIAN
chown root: debian_package
mkdir -p debian_package/usr/bin
mkdir -p debian_package/usr/share/doc/ofcomverter
cp control debian_package/DEBIAN
chmod 755 debian_package/DEBIAN
cp ofcomverter debian_package/usr/bin
chmod -R 755 debian_package/usr
cp generate_dialplan debian_package/usr/bin
chmod -R 755 debian_package/usr
cp COPYING debian_package/usr/share/doc/ofcomverter
cp CREDITS debian_package/usr/share/doc/ofcomverter
cp README.* debian_package/usr/share/doc/ofcomverter
chmod 755 debian_package/usr/share/doc/ofcomverter
chmod 644 debian_package/usr/share/doc/ofcomverter/*
dpkg -b debian_package ofcomverter_${VERSION}_all.deb
rm -rf ./debian_package
