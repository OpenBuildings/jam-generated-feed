<?php

/**
 * @group   task.feed.generate
 */
class Task_Feed_GenerateTest extends Testcase_Extended {

	/**
	 * @covers Task_Feed_Generate::feed_content
	 */
	public function test_feed_content()
	{
		$task = Minion_Task::factory(array('feed:generate'));

		$content = $task->feed_content('product', NULL, 'test/feedtest');

		$expected = <<<CONTENT
<products>
	<item>
		<name>Chair</name>
		<price>290.4 GBP</price>
	</item>
	<item>
		<name>Rug</name>
		<price>30 GBP</price>
	</item>
	<item>
		<name>Matrass</name>
		<price>130.99 EUR</price>
	</item>
</products>
CONTENT;

		$this->assertEquals($expected, $content);
	}

	/**
	 * @covers Task_Feed_Generate::feed_content
	 */
	public function test_feed_content_with_filter()
	{
		$task = Minion_Task::factory(array('feed:generate'));

		$content = $task->feed_content('product', 'feed_test', 'test/feedtest');

		$expected = <<<CONTENT
<products>
	<item>
		<name>Chair</name>
		<price>290.4 GBP</price>
	</item>
	<item>
		<name>Rug</name>
		<price>30 GBP</price>
	</item>
</products>
CONTENT;

		$this->assertEquals($expected, $content, 'Should use feed_test to filter out collection items');
	}

	/**
	 * @covers Task_Feed_Generate::config
	 */
	public function test_config()
	{
		$task = Minion_Task::factory(array('feed:generate'));

		$config = array('model' => 'model1', 'file' => 'file1', 'view' => 'view1', 'filter' => 'filter1');

		$this->env->backup_and_set(array(
			'jam-generated-feed.name1' => $config,
		));

		$this->assertSame($config, $task->config('name1'));
	}

	/**
	 * @covers Task_Feed_Generate::config
	 * @expectedException Kohana_Exception
	 * @expectedExceptionMessage No Feed configuration named name1, put one in config/jam-generated-feed.php file
	 */
	public function test_missing_config()
	{
		$task = Minion_Task::factory(array('feed:generate'));

		$task->config('name1');
	}

	/**
	 * @covers Task_Feed_Generate::config
	 * @expectedException Kohana_Exception
	 * @expectedExceptionMessage Missing keys in config name1: view, file
	 */
	public function test_wrong_config()
	{
		$task = Minion_Task::factory(array('feed:generate'));

		$this->env->backup_and_set(array(
			'jam-generated-feed.name1' => array('model' => 'model1', 'test' => 'test'),
		));

		$task->config('name1');
	}

	/**
	 * @covers Task_Feed_Generate::config_exists
	 */
	public function test_config_exists()
	{
		$task = Minion_Task::factory(array('feed:generate'));

		$this->assertFalse($task->config_exists('name1'));

		$this->env->backup_and_set(array(
			'jam-generated-feed.name1' => array('model' => 'model1', 'test' => 'test'),
		));

		$this->assertTrue($task->config_exists('name1'));

	}
	
	/**
	 * @covers Task_Feed_Generate::_execute
	 * @covers Task_Feed_Generate::build_validation
	 */
	public function test_execute()
	{

		$this->env->backup_and_set(array(
			'jam-generated-feed.name1' => array(
				'model' => 'product', 
				'filter' => 'feed_test', 
				'view' => 'test/feedtest', 
				'file' => 'test_file.xml',
			),
		));

		$task = Minion_Task::factory(array('feed:generate', 'name' => 'name1'));

		$task->execute();

		$this->assertFileEquals(__DIR__.'/../../../test_data/expected_file.xml', DOCROOT.'test_file.xml');

		unlink(DOCROOT.'test_file.xml');
	}
}
