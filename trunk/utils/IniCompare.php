<?php
ini_set("display_errors", "1");

/*
 * Compare entries in 2 .ini files.
 * Usage:
 *     php IniCompare.php <master_file> <secondary_file>
 * Use case:
 * - This script can be used to compare 2 language files
 */

if ( count($argv) < 3 ) {
    echo "Usage:\n";
    echo "\tphp IniCompare.php <master_file> <secondary_file>";
    exit(-1);
}
 
$masterFile = $argv[1];
$secondaryFile = $argv[2];

$masterIni = parse_ini_file($masterFile);
$secondaryIni = parse_ini_file($secondaryFile);

echo "\n\nComparing [$masterFile]\nand [$secondaryFile]:\n\n";

echo "Entries in master that do not exist in secondary:\n\n";
foreach ( $masterIni as $key => $value ) {
    if ( !isset($secondaryIni[$key] ) ) {
        echo "\t$key=$value\n";
    }
}
echo "\nDone.";
