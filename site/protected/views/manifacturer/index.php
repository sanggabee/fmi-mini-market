<?php
$this->breadcrumbs=array(
	'Manifacturers',
);

$this->menu=array(
	array('label'=>'Create Manifacturer', 'url'=>array('create')),
	array('label'=>'Manage Manifacturer', 'url'=>array('admin')),
);
?>

<h1>Manifacturers</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
