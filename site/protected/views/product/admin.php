<?php
$this->breadcrumbs=array(
	'Products'=>array('index'),
	'Manage',
);

$this->menu=array(
	array(
        'label'=>'Create Product', 
        'url'=>array('create'), 
        'linkOptions'=>array(
            'class'=>'product-click',
            'alt' =>'Create product'
        ),
    ),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('product-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Products</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
    'manifacturers' => $manifacturers,
    'categories' => $categories,
    'measures' => $measures,
)); ?>
</div><!-- search-form -->

<?php $dialogForm = $this->widget('application.widgets.dialogform.DialogFormWidget', array(
    'linkSelector' => '.product-click',
    'gridId' => 'product-grid',
    'formId' => 'product-form',
)); ?>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'product-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
    'afterAjaxUpdate' => $dialogForm->afterAjaxReloadFunction,
    'rowCssClassExpression' => 'CategoryStylesWidget::getClassNameOfCategory($data->category);',
	'columns'=>array(
		'id',
        array(
            'class'=>'CLinkColumn',
            'labelExpression'=>'CHtml::image($data->category->pictureUrl, "", array("width"=>50))',
        ),
        array(
            'name' => 'category_id',
            'value' => '$data->category->name',
            'filter' => $categories,
        ),
        array(
            'name'=>'manifacturer_id',
            'value'=>'$data->manifacturer->name',
            'filter'=>  $manifacturers,
        ),
        array(
            'name'=>'measure_id',
            'value'=>'$data->measure->name_short',
            'filter'=> $measures,
        ),
		
		'name',
		'delivery_prize',
		'sell_prize',
		'current_quantity',
		array(
			'class'=>'CButtonColumn',
            'template'=>'{update}{delete}',
            'buttons'=>array(
                'delete'=>array(
                    'visible'=>'$data->canBeDeleted',
                ),
                'update'=>array(
                    'options'=>array(
                        'class'=>'product-click',
                        'alt'=>'Update product',
                    ),
                ),
            ),
		),
	),
)); ?>

