<?php

ini_set('display_startup_errors', 'On');
ini_set('error_reporting'       , 'E_ALL | E_STRICT');
ini_set('track_errors'          , 'On');
ini_set('display_errors'        , 1);
error_reporting(E_ALL);
set_time_limit(0);

$site = 'https://yoursite.tld/';


$cmd = 'wget ';

$cmd .= ' -r';
$cmd .= ' -c';
$cmd .= ' --mirror';
$cmd .= ' --no-check-certificate';
$cmd .= ' --reject-regex "(.*)\?(.*)"';

$cmd .= ' '. $site;



exec($cmd);

?>