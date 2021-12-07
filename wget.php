<?php

/**
 *
 */
class wget
{

  private static function prepare()
  {
	ini_set('display_startup_errors', 'On');
	ini_set('error_reporting'       , 'E_ALL | E_STRICT');
	ini_set('track_errors'          , 'On');
	ini_set('display_errors'        , 1);
	error_reporting(E_ALL);
	set_time_limit(0);
  }


  private static function config()
  {
	$config = [];

	$config_dir = __DIR__. '/config.json';

	if(is_file($config_dir))
	{
	  $config = json_decode(file_get_contents($config_dir), true);
	  if(!is_array($config))
	  {
		$config = [];
	  }
	}
	else
	{
	  return self::error('Please set config.json');
	}

	return $config;
  }

  public static function run()
  {

  	$config = self::config();

	if(isset($config['site']) && $config['site'])
	{
	  $site = $config['site'];
	}
	else
	{
		return self::error('Config.site not set!');
	}

	$cookie = null;
	if(isset($config['cookie']) && $config['cookie'])
	{
		$cookie = $config['cookie'];
	}


	$cmd = 'wget ';

	$cmd .= ' '. $site;
	$cmd .= ' -r';
	$cmd .= ' -c';
	$cmd .= ' --mirror';
	$cmd .= ' --no-check-certificate';

	$cmd .= ' --reject-regex "(.*)\?(id\=.*)"';

	$cmd .= " --header 'authority: jibres.local'";
	$cmd .= " --header 'user-agent: Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/96.0.4664.45 Safari/537.36' ";
	$cmd .= " --header 'accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9' ";

	if($cookie)
	{
		$cmd .= sprintf(" --header 'cookie: %s' ", $cookie);
	}

	exec($cmd);
  }

  private static function error($_text)
  {
  	exit($_text);
  }
}

wget::run();
?>