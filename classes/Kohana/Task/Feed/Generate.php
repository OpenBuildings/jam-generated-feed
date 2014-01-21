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
		return parent::build_validation($validation)
			->rule('name', 'not_empty')
			->rule('name', array($this, 'config_exists'));
	}

	public function config_exists($name)
	{
		return (bool) Kohana::$config->load('jam-generated-feed.'.$name);
	}

	protected function _execute(array $options)
	{
		$config = $this->config($options['name']);

		$config = array_merge($config, $options);

		$file = DOCROOT.$config['file'];

		$file = strtr($file, array(
			":timestamp" => strtotime('now')
		));

		Minion_CLI::write('Generating '.json_encode($config));

		$filters = is_array($config['filter']) ? $config['filter'] : explode(',', $config['filter']);

		$content = $this->feed_content($config['model'], (array) $filters, $config['view']);

		Minion_CLI::write('Done.');

		Minion_CLI::write('Saving feed content to '.Debug::path($file));		

		file_put_contents($file, $content);

		Minion_CLI::write('Done.');
	}

	public function config($name)
	{
		$config = Kohana::$config->load('jam-generated-feed.'.$name);

		if ( ! $config)
			throw new Kohana_Exception('No Feed configuration named :name, put one in config/jam-generated-feed.php file', array(':name' => $name));

		if (($missing_keys = array_diff(array('model', 'view', 'file'), array_keys($config))))
			throw new Kohana_Exception('Missing keys in config :name: :missing_keys', array(':name' => $name, ':missing_keys' => join(', ', $missing_keys)));

		return $config;
	}

	public function feed_content($model, array $filters, $view)
	{
		$collection = Jam::all($model);

		if ($filters) 
		{
			foreach ($filters as $filter) 
			{
				$collection->{$filter}();
			}
		}

		return View::factory($view, array('collection' => $collection))->render();
	}
}