<?php
/* @var $this Controller */
$this->breadcrumbs=array(
	'Categories'=>array('index'),
	'Manage',
);

$this->menu=array(
	array(
        'label'=>'Create Category', 
        'url'=>array('create'), 
        'linkOptions'=>array(
            'class'=>'category-click',
            'rel'=>'Add category',
        ),
    ),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('category-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Categories</h1>

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

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'category-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
    'afterAjaxUpdate' => 'bindGridClickHandlers',
    'rowCssClassExpression' => 'CategoryStylesWidget::getClassNameOfCategory($data);',
	'columns'=>array(
		'id',
		'name',
        array(
            'class'=>'CLinkColumn',
            'labelExpression'=>'CHtml::image($data->pictureUrl, "", array("width"=>100))',
        ),
		array(
			'class'=>'CButtonColumn',
            'template'=> '{update}{delete}',
            'buttons'=>array(
                'delete'=>array(
                    'visible'=>'$data->canBeDeleted',
                ),
                'update' => array(
                    'options' => array(
                        'class'=>'category-click',
                        'rel' =>'Update category',
                    ),
                ),
            ),
		),
	),
)); ?>

<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id'=>'category-dialog',
    'options'=>array(
        'draggable'=>true,
        'title'=>'Category Dialog',
        'autoOpen'=>false,
        'modal' => true,
        'close'=>'js:refreshGrid',
        'width' => 330,
    ),
)); ?>
    

   
<?php $this->endWidget(); ?>

<script language="JavaScript">
    function autoResize(id){
        var newheight;
//        var newwidth;

        if(document.getElementById){
            newheight=document.getElementById(id).contentWindow.document .body.scrollHeight;
//            newwidth=document.getElementById(id).contentWindow.document .body.scrollWidth;
        }

        document.getElementById(id).height= (newheight) + "px";
//        document.getElementById(id).width= (newwidth) + "px";

        $('#category-dialog').dialog('close').dialog('open');;
    }
    
    function bindGridClickHandlers()
    {
        $('.category-click').click(function(){
            var link = $(this);
            var dialog = $('#category-dialog');
            
            dialog.html('<IFRAME SRC=\"'+ link.attr('href') +'\" width=\"280\" height=\"20\" id=\"category-iframe\" marginheight=\"0\" frameborder=\"0\" onLoad=\"autoResize(\'category-iframe\');\"></iframe>')
            dialog.dialog('open');
            return false;
        });
    }
    
</script>
    
<?php Yii::app()->clientScript
    ->registerScript('category-managment', "
        function refreshGrid(){
            $.fn.yiiGridView.update('category-grid');
        }
        bindGridClickHandlers();
    ", CClientScript::POS_READY); ?>