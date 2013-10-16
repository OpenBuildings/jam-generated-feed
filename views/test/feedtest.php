<products>
<?php foreach ($collection as $item): ?>
	<item>
		<name><?php echo $item->name ?></name>
		<price><?php echo $item->price ?> <?php echo $item->currency ?></price>
	</item>
<?php endforeach ?>
</products>