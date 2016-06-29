#!/bin/bash 

# Gather computer information
IDENTIFIER=$( defaults read /Library/Preferences/ManagedInstalls ClientIdentifier ); 
HOSTNAME=$( scutil --get ComputerName );
TYPE=$( defaults read /Library/Preferences/com.apple.RemoteDesktop Text4 );



# Grab the building code from the front of the computer name
BUILDING=${HOSTNAME:0:3};
# set the room number to the character immediately following the building code
ROOM=${HOSTNAME:3:1};

# If it's a high school machine in the tech or music area, limit the room to 2 chars
if [ "$BUILDING" == "PHS" -a "$ROOM" == "M" -o "$ROOM" == "T" ]; then
	ROOM=${HOSTNAME:3:2};
# If it's a middle school machine grab the zone id as well as the room number
elif [ "$BUILDING" == "PMS"  -a "$ROOM" == "a" -o "$ROOM" == "b" -o "$ROOM" == "c"  ]; then
	ROOM=${HOSTNAME:3:4};
# otherwise the room is set to the 3 chars following the building code
else
	ROOM=${HOSTNAME:3:3};
fi
	
# build the identifier from the ComputerName & Type
IDENTIFIER="$BUILDING/$TYPE/$ROOM/"

# Change this URL to the location for your Munki Enroll install
SUBMITURL="http://munki.portsmouth.k12.nh.us/repo/munki-enroll/enroll.php"

# Application paths
CURL="/usr/bin/curl"

# Submit the info to enroll.php
$CURL --max-time 5 --silent --get \
    -d hostname="$HOSTNAME" \
    -d identifier="$IDENTIFIER" \
    -d building="$BUILDING" \
    -d room="$ROOM" \
    -d type="$TYPE" \
     "$SUBMITURL"

# set the ClientIdentifier to building/type/room/client
defaults write /Library/Preferences/ManagedInstalls ClientIdentifier "$IDENTIFIER$HOSTNAME"

# set munki to install Apple Updates
# defaults write /Library/Preferences/ManagedInstalls InstallAppleSoftwareUpdates -bool True


exit 0
