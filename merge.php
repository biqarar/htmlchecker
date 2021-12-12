<?php

ini_set('display_startup_errors', 'On');
ini_set('error_reporting'       , 'E_ALL | E_STRICT');
ini_set('track_errors'          , 'On');
ini_set('display_errors'        , 1);
error_reporting(E_ALL);


$check_duplicate = [];

set_time_limit(0);

$dir = __DIR__. '/site/';

ob_start();

$mypath = $dir;

$directory   = new \RecursiveDirectoryIterator($mypath);
$flattened   = new \RecursiveIteratorIterator($directory);

$files       = new \RegexIterator($flattened, "/.*/i");

$translation = [];

$i = 0;
foreach($files as $file)
{
    $i++;
    $file_name = basename($file);

    if($file_name === '.' || $file_name === '..')
    {
        continue;
    }

    $addr = $file->getpathName();

    // $addr = str_replace('$', '\\$', $addr);


    file_put_contents(__DIR__. '/fullhtml.html', file_get_contents($addr). "\n --- $i --- \n", FILE_APPEND);


}
?>