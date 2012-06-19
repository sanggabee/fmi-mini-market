<?php
$this->breadcrumbs=array(
	'Manifacturers'=>array('index'),
	'Manage',
);

$this->menu=array(
	array(
        'label'=>'Create Manifacturer', 
        'url'=>array('create'), 
        'linkOptions'=>array(
            'class'=>'manifacturer-click',
            'alt'=>'Create manifacturer',
        ),
    ),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('manifacturer-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Manifacturers</h1>

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
    'linkSelector' => '.manifacturer-click',
    'gridId' => 'manifacturer-grid',
    'formId' => 'manifacturer-form',
)); ?>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'manifacturer-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
    'afterAjaxUpdate' => $dialogForm->afterAjaxReloadFunction,
	'columns'=>array(
		'id',
		'name',
		array(
			'class'=>'CButtonColumn',
            'template'=>'{update}{delete}',
            'buttons'=>array(
                'delete'=>array(
                    'visible'=>'$data->canBeDeleted',
                ),
                'update'=>array(
                    'options'=>array(
                        'class' => 'manifacturer-click',
                        'alt'=>'Update manifacturer',
                    ),
                ),
            ),
		),
	),
)); ?>
