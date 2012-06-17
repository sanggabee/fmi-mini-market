<?php
$this->breadcrumbs=array(
	'Order Items'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List OrderItem', 'url'=>array('index')),
	array('label'=>'Manage OrderItem', 'url'=>array('admin')),
);
?>

<h1>Create OrderItem</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>