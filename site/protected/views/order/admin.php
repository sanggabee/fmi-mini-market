<?php
/* @var $this Controller */
$this->breadcrumbs=array(
	'Orders'=>array('index'),
	'Manage',
);

$this->menu=array(
	array(
        'label'=>'Create Order', 
        'url'=>array('create'), 
        'linkOptions'=>array(
            'class'=>'order-click',
            'alt'=>'Create order',
        ),
    ),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('order-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Orders</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $dialogForm = $this->widget('application.widgets.dialogform.DialogFormWidget', array(
    'linkSelector' => '.order-click',
    'gridId' => 'order-grid',
    'formId' => 'order-form',
)); ?>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'order-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
    'afterAjaxUpdate' => $dialogForm->afterAjaxReloadFunction,
	'columns'=>array(
		'id',
        array(
            'name'=>'type',
            'value'=>'$data->typeName',
            'filter'=>$model->types,
        ),
        array(
            'name'=>'state',
            'value'=>'$data->stateName',
            'filter'=>$model->states,
        ),
        array(
            'name'=>'user_email',
            'value'=>'$data->user->email',
        ),
		'total',
		'create_time',
	
		array(
			'class'=>'CButtonColumn',
            'template'=>'{view}{delete}',
            'buttons'=>array(
                'delete'=>array(
                    'visible'=>'$data->canBeDeleted',
                ),
                'update'=>array(
                    'options'=>array(
                        'class' => 'order-click',
                        'alt'=>'Update order',
                    ),
                ),    
            ),
		),
	),
)); ?>
