# Jam Generated Feed Module

[![Build Status](https://travis-ci.org/OpenBuildings/jam-generated-feed.png?branch=master)](https://travis-ci.org/OpenBuildings/jam-generated-feed)
[![Coverage Status](https://coveralls.io/repos/OpenBuildings/jam-generated-feed/badge.png?branch=master)](https://coveralls.io/r/OpenBuildings/jam-generated-feed?branch=master)
[![Latest Stable Version](https://poser.pugx.org/openbuildings/jam-generated-feed/v/stable.png)](https://packagist.org/packages/openbuildings/jam-generated-feed)

A module to generate xml files based on a jam collection with a minion task

## Usage

You need to add configuration to config/jam-generated-feed.php file:

```php
return array(
	// Each key is a "name" of the feed, will be used when generating a new one
	'products-uk'	=> array(

		// Jam model for the collection
		'model' => 'product'

		// Optional filter that will be applied to the collection (in the form of $collection->{$filter_name}())
		'filter' => 'feed_products_uk',

		// What view to use to generate the feed. It would be passed a $collection variable with the Jam Collection
		'view' => 'feeds/products-uk',

		// Where to output the file, prepends DOCROOT, overwrites
		'file' => 'feeds/products-uk.xml',
	),
);
```

## Using The Task

```
minion feed:generate --name=products-uk

Generating {"model":"product","filter":"feed_products_uk","view":"feeds\/products-uk","file":"feeds/products-uk.xml","name":"products-uk"}
Done.
Saving feed content to DOCROOT/test_file.xml
Done.
```

## License

Copyright (c) 2012-2013, OpenBuildings Ltd. Developed by Ivan Kerin as part of [clippings.com](http://clippings.com)

Under BSD-3-Clause license, read LICENSE file.

