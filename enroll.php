#!/bin/bash 

# Gather computer information
IDENTIFIER=$( defaults read /Library/Preferences/ManagedInstalls ClientIdentifier ); 
HOSTNAME=$( scutil --get ComputerName );

BUILDING=${HOSTNAME:0:3};
ROOM=${HOSTNAME:3:1};

if [ "$BUILDING" == "PHS" -a "$ROOM" == "M" -o "$ROOM" == "T" ]; then
	ROOM=${HOSTNAME:3:2};
elif [ "$BUILDING" == "PMS"  -a "$ROOM" == "a" -o "$ROOM" == "b" -o "$ROOM" == "c"  ]; then
	ROOM=${HOSTNAME:3:4};
else
	ROOM=${HOSTNAME:3:3};
fi
	

IDENTIFIER="$BUILDING/$ROOM/"

# Change this URL to the location for your Munki Enroll install
SUBMITURL="http://munki.portsmouth.k12.nh.us/repo/munki-enroll/enroll.php"

# Application paths
CURL="/usr/bin/curl"

#echo $IDENTIFIER

$CURL --max-time 5 --silent --get \
    -d hostname="$HOSTNAME" \
    -d identifier="$IDENTIFIER" \
    -d building="$BUILDING" \
    -d room="$ROOM" \
     "$SUBMITURL"

#echo $BUILDING
#echo $ROOM
defaults write /Library/Preferences/ManagedInstalls ClientIdentifier "$IDENTIFIER$HOSTNAME"
defaults write /Library/Preferences/ManagedInstalls InstallAppleSoftwareUpdates -bool True
exit 0
