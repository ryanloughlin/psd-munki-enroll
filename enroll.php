<?php
namespace CFPropertyList;

require_once( 'cfpropertylist-2.0.1/CFPropertyList.php' );

// Get the varibles passed by the enroll script
$identifier = $_GET["identifier"];
$hostname   = $_GET["hostname"];
$building   = $_GET["building"];
$room       = $_GET["room"];



// Split the manifest path up to determine directory structure
$directories		= explode( "/", $identifier, -1 ); 
$total				= count( $directories );
$n					= 0;
$identifier_path	= "";





while ( $n < $total )
    {
        $identifier_path .= $directories[$n] . '/';
        $n++;
    }

/*
$myfile = fopen("/Volumes/Images/repo/manifests/newfile.txt", "w") or die("Unable to open file!");
fwrite($myfile, $identifier_path);
fclose($myfile);
*/


// Check if manifest already exists for this machine
if ( file_exists( '../manifests/' . $identifier . "/" . $hostname ) )
    {
        echo "Computer manifest already exists.";
    }
else
    {
        echo "Computer manifest does not exist. Will create.";
        
        if ( !is_dir( '../manifests/' . $identifier ) )
            {
                mkdir( '../manifests/' . $identifier, 0755, true );
            }
        
        // Create the new manifest plist
        $plist = new CFPropertyList();
        $plist->add( $dict = new CFDictionary() );
        
        // Add manifest to production catalog by default
        $dict->add( 'catalogs', $array = new CFArray() );
        $array->add( new CFString( 'production' ) );
        
        // Add parent manifest to included_manifests to achieve waterfall effect
        $dict->add( 'included_manifests', $array = new CFArray() );
        $array->add( new CFString( $building . '/' . $room . '/' . $room . '_default' ) );

        
        // Save the newly created plist
        $plist->saveXML( '../manifests/' . $identifier . "/" . $hostname );
        
    } 

if ( file_exists( '../manifests/' . $building . '/' . $building . '_default' ) )
    {
        echo "Building manifest already exists.";
    }
else
    {
        echo "Building manifest does not exist. Will create.";
        
        // Create the new manifest plist
        $plist = new CFPropertyList();
        $plist->add( $dict = new CFDictionary() );
        
        // Add manifest to production catalog by default
        $dict->add( 'catalogs', $array = new CFArray() );
        $array->add( new CFString( 'production' ) );
        
        // Add parent manifest to included_manifests to achieve waterfall effect
        $dict->add( 'included_manifests', $array = new CFArray() );
        $array->add( new CFString( 'approved' ) );
        
        // Save the newly created plist
        $plist->saveXML( '../manifests/' . $building . '/' . $building . '_default' );
        
    }


if ( file_exists( '../manifests/' . $building . '/' . $room . '/' . $room . '_default' ) )
    {
        echo "Room manifest already exists.";
    }
else
    {
        echo "Room manifest does not exist. Will create.";
        
        // Create the new manifest plist
        $plist = new CFPropertyList();
        $plist->add( $dict = new CFDictionary() );
        
        // Add manifest to production catalog by default
        $dict->add( 'catalogs', $array = new CFArray() );
        $array->add( new CFString( 'production' ) );
        
        // Add parent manifest to included_manifests to achieve waterfall effect
        $dict->add( 'included_manifests', $array = new CFArray() );
        $array->add( new CFString( $building . '/' . $building. '_default' ) );
        
        // Save the newly created plist
        $plist->saveXML( '../manifests/' . $building . '/' . $room . '/' . $room . '_default' );
        
    }












?>
