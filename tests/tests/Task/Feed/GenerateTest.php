<?php

/**
 * @group   task.feed.generate
 */
class Task_Feed_GenerateTest extends Testcase_Extended {

	public function test_feed_content()
	{
		$task = new Task_Feed_Generate();

		$content = $task->feed_content('product', NULL, 'test/feedtest');

		$expected <<<CONTENT
		asd
CONTENT;

		$this->assertEquals($expected, $content);
	}
}
