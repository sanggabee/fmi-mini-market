<?php
$this->breadcrumbs=array(
	'Products'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'Manage Product', 'url'=>array('admin')),
);
?>

<h1>Create Product</h1>

<?php echo $this->renderPartial('_form', array(
    'model'=>$model,
    'manifacturers' => $manifacturers,
    'categories' => $categories,
    'measures' => $measures,
)); ?>