<?php
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Mini-Market Console',
	// application components
	'components'=>array(
		'db'=> require (dirname(__FILE__) . DIRECTORY_SEPARATOR . 'config.db.php'),
	),
);