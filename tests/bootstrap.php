<?php 

require_once __DIR__.'/../vendor/autoload.php';

spl_autoload_register(function($class)
{
	$file = __DIR__.DIRECTORY_SEPARATOR.'classes'.DIRECTORY_SEPARATOR.str_replace('_', '/', $class).'.php';

	if (is_file($file))
	{
		require_once $file;
	}
});

Kohana::modules(array(
	'database'           => MODPATH.'database',
	'minion'             => MODPATH.'minion',
	'jam'                => __DIR__.'/../modules/jam',
	'jam-generated-feed' => __DIR__.'/..',
));

Kohana::$config
	->load('database')
		->set('default', array(
			'type'       => 'MySQL',
			'connection' => array(
				'hostname'   => 'localhost',
				'database'   => 'test-jam-generated-feed',
				'username'   => 'root',
				'password'   => '',
				'persistent' => TRUE,
			),
			'table_prefix' => '',
			'charset'      => 'utf8',
			'caching'      => FALSE,
		));

Kohana::$environment = Kohana::TESTING;