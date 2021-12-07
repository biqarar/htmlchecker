<?php

ini_set('display_startup_errors', 'On');
ini_set('error_reporting'       , 'E_ALL | E_STRICT');
ini_set('track_errors'          , 'On');
ini_set('display_errors'        , 1);
error_reporting(E_ALL);


set_time_limit(0);

$dir = __DIR__. '/site/';

ob_start();

$mypath = $dir;

$directory   = new \RecursiveDirectoryIterator($mypath);
$flattened   = new \RecursiveIteratorIterator($directory);

$files       = new \RegexIterator($flattened, "/.*/i");

$translation = [];

foreach($files as $file)
{
    $file_name = basename($file);

    if($file_name === '.' || $file_name === '..')
    {
        continue;
    }

    $addr = $file->getpathName();

    $cmd = 'java -jar vnu.jar '. $addr. '  2>&1';

    $result = exec($cmd, $c);

    if(!is_array($c))
    {
        $c = [];
    }


    file_put_contents(__DIR__. '/result.log', implode("\n", $c), FILE_APPEND);

}
?>