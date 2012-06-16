<?php
$this->breadcrumbs=array(
	'Manifacturers'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'Manage Manifacturer', 'url'=>array('admin')),
);
?>

<h1>Create Manifacturer</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>