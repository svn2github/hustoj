#!/bin/bash
IN_SCREEN=no
if echo "$TERM"|grep "screen" ; then
        IN_SCREEN=yes;
fi

if [ "$IN_SCREEN" == "no" ] ;then
        echo "not in screen";
        apt update
        apt install screen
        chmod +x $0
        screen bash $0 $*
else
        echo "in screen";
        OSID=`lsb_release -is|tr 'UDC' 'udc'`
        OSRS=`lsb_release -rs`
        INSTALL="install-$OSID$OSRS.sh"
        URL="http://dl.hustoj.com/$INSTALL"
        wget -O "$INSTALL" "$URL"
        chmod +x "$INSTALL"
        "./$INSTALL"
        sleep 60;
fi

