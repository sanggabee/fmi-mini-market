<?php
$this->breadcrumbs=array(
	'Manifacturers'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List Manifacturer', 'url'=>array('index')),
	array('label'=>'Create Manifacturer', 'url'=>array('create')),
	array('label'=>'Update Manifacturer', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Manifacturer', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Manifacturer', 'url'=>array('admin')),
);
?>

<h1>View Manifacturer #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
	),
)); ?>
