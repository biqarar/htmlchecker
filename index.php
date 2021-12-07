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

foreach($files as $file)
{
    $file_name = basename($file);

    if($file_name === '.' || $file_name === '..')
    {
        continue;
    }

    $addr = $file->getpathName();

    $addr = str_replace('$', '\\$', $addr);

    $cmd = 'java -jar vnu.jar '. $addr. '  2>&1';

    $result = exec($cmd, $c);

    if(!is_array($c))
    {
        $c = [];
    }

    foreach ($c as $key => $value)
    {
        if(!in_array(md5($value), $check_duplicate))
        {
            $check_duplicate[] = md5($value);
            file_put_contents(__DIR__. '/result.log', $value. "\n\n", FILE_APPEND);
        }
    }

}
?>