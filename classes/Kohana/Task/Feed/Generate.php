<?php defined('SYSPATH') OR die('No direct script access.');

/**
 * @package    Openbuildings\JamGeneratedFeed
 * @author     Ivan Kerin <ikerin@gmail.com>
 * @copyright  (c) 2013 OpenBuildings Ltd.
 * @license    http://spdx.org/licenses/BSD-3-Clause
 */
class Kohana_Task_Feed_Generate extends Minion_Task {

	protected $_options = array(
		'name' => NULL,
	);

	public function build_validation(Validation $validation)
	{
		$feeds = array_keys(Kohana::$config->load('jam-generated-feed'));

		return parent::build_validation($validation)
			->rule('name', 'required')
			->rule('name', 'in_array', array(':value', $feeds));
	}

	protected function _execute(array $options)
	{
		$config = $this->config($options['name']);

		$config = array_merge($config, $options);

		$file = DOCROOT.$config['file'];

		CLI::write('Generating (options: '.json_encode($config).')');

		$content = $this->feed_content($config['model'], $config['filter'], $config['view']);

		CLI::write('Done.');

		CLI::write('Saving feed content to '.Debug::file($file));		

		file_put_contents($file, $content);

		CLI::write('Done.');
	}

	public function config($name)
	{
		$config = Kohana::$config->load('jam-generated-feed.'.$name);

		if ( ! $config)
			throw new Kohana_Exception('No Feed configuration named :name, put one in config/jam-generated-feed.php file', array(':name' => $name));

		if (($missing_keys = array_diff(array('model', 'view', 'file'), array_keys($config)))
			throw new Kohana_Exception('Missing keys in config file: :missing_keys', array(':missing_keys' => $missing_keys));

		return $config;
	}

	public function feed_content($model, $filter, $view)
	{
		$collection = Jam::all($model);

		if ($filter) 
		{
			$collection->{$filter}();
		}

		return View::factory($view, array('colleciton' => $colleciton));
	}
}