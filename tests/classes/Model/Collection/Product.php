<?php

class Model_Collection_Product extends Jam_Query_Builder_Collection {

	public function feed_test()
	{
		return $this
			->where('currency', '=', 'GBP');
	}
}
