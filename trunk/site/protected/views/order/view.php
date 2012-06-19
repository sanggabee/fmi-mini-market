<?php
/* @var $model Order */
/* @var $item OrderItem */

$this->breadcrumbs=array(
	'Orders'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'Manage Orders', 'url'=>array('admin')),
	array(
        'label'=>'Finish Order', 
        'url'=>array('finish', 'id'=>$model->id), 
        'linkOptions'=>array(
            'class'=>'finish-link',
        ),
        'visible'=>$model->isNew,
    ),
    
    array(
        'label'=>'Add order item', 
        'url'=>array('orderItem/create', 'order_id'=>$model->id), 
        'linkOptions'=>array(
            'class'=>'order-item-click',
            'rel'=>'Add order item',
        ),
        'visible'=>$model->isNew,
    ),
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
		'create_time',
		'update_time',
	),
)); ?>

<?php $dialogForm = $this->widget('application.widgets.dialogform.DialogFormWidget', array(
    'linkSelector' => '.order-item-click',
    'gridId' => 'order-items-grid',
    'formId' => 'order-item-form',
)); ?>

<?php $provider=$item->search();
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'order-items-grid',
    'dataProvider' => $provider,
    'afterAjaxUpdate' => $dialogForm->afterAjaxReloadFunction,
    'rowCssClassExpression' => 'CategoryStylesWidget::getClassNameOfCategory($data->product->category);',
    'columns'=>array(
        array(
            'name' =>'N',
            'value' => '$row+1',
        ),
        array(
            'class'=>'CLinkColumn',
            'labelExpression'=>'CHtml::image($data->product->category->pictureUrl, "", array("width"=>50))',
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
            'footer' => $provider->itemCount === 0 ? '' : $model->getTotal(),
        ),
        array(
            'class'=>'CButtonColumn',
            'template'=>'{update}{delete}',
            'buttons'=>array(
                'update'=>array(
                    'url'=>'Yii::app()->createUrl("orderItem/update", array("id"=>$data->id));',
                    'options'=>array(
                        'class'=>'order-item-click',
                        'alt'=>'Update order item',
                    ),
                    'visible'=>'$data->order->isNew',
                ),
                'delete'=>array(
                    'url'=>'Yii::app()->createUrl("orderItem/delete", array("id"=>$data->id));',
                    'visible'=>'$data->order->isNew',
                ),
            ),
        ),
    ),
)); ?>

<?php Yii::app()->clientScript->registerScript('order-finish-handling', "        
    $('.finish-link').click(function(){
        var link = $(this);
        $.post(link.attr('href'), function(r){
            alert(r.error == 0 ? 'Success' : r.message);
            if(r.error == 0)
                window.location = window.location.href; // Refresh
        }, 'json');
        return false;
    });
", CClientScript::POS_READY); ?>