<?php
$this->breadcrumbs=array(
	'Products'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'Create Product', 'url'=>array('create')),
	array('label'=>'Manage Product', 'url'=>array('admin')),
);
?>

<h1>Update Product <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array(
    'model'=>$model,
    'manifacturers' => $manifacturers,
    'categories' => $categories,
    'measures' => $measures,
)); ?>