<?php
$this->breadcrumbs=array(
	'Manifacturers'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'Create Manifacturer', 'url'=>array('create')),
	array('label'=>'Manage Manifacturer', 'url'=>array('admin')),
);
?>

<h1>Update Manifacturer <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>