<?php
/* @var $model Order */

$this->breadcrumbs=array(
	'Orders'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Order', 'url'=>array('index')),
	array('label'=>'Create Order', 'url'=>array('create')),
	array('label'=>'Update Order', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Order', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Order', 'url'=>array('admin')),
);
?>

<h1>View Order #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
        array(
            'label'=>$model->getAttributeLabel('state'),
            'name'=>'stateName',
        ),
        array(
            'label'=>$model->getAttributeLabel('type'),
            'name'=>'typeName',
        ),
		'user.fullName',
		'total',
		'create_time',
		'update_time',
	),
)); ?>

<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'order-items',
    'dataProvider' => $item->search(),
    'columns'=>array(
        array(
            'name' =>'N',
            'value' => '$row+1',
        ),
        array(
            'name' => 'product_id',
            'value' => '$data->product->name',
        ),
        array(
            'name' => 'singlePrize',
            'value' => '$data->singlePrize',
        ),
        'quantity',
        array(
            'name' => 'rowTotal',
            'value' => '$data->rowTotal',
        ),
        array(
            'class'=>'CButtonColumn',
            'template'=>'{update}{delete}',
            'buttons'=>array(
                'delete'=>array(
                    'url'=>'Yii::app()->createUrl("orderItem/delete", array("id"=>$data->id));',
                ),
            ),
        ),
    ),
)); ?>
