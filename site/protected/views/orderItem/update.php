<?php
$this->breadcrumbs=array(
	'Order Items'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List OrderItem', 'url'=>array('index')),
	array('label'=>'Create OrderItem', 'url'=>array('create')),
	array('label'=>'View OrderItem', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage OrderItem', 'url'=>array('admin')),
);
?>

<h1>Update OrderItem <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>