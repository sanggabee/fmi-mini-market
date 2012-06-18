<?php
/* @var $model Order */
/* @var $item OrderItem */

$this->breadcrumbs=array(
	'Orders'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'Manage Orders', 'url'=>array('admin')),
	array('label'=>'Create Order', 'url'=>array('create')),
	array(
        'label'=>'Delete Order', 
        'url'=>'javascript:;', 
        'linkOptions'=>array(
            'submit'=>array('delete','id'=>$model->id),
            'confirm'=>'Are you sure you want to delete this item?',
        ),
        'visible'=>empty($model->orderItems),
    ),
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

<?php $provider=$item->search();
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'order-items-grid',
    'dataProvider' => $provider,
    'afterAjaxUpdate' => 'rebindOrderItemButtons',
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

<?php $this->widget('zii.widgets.jui.CJuiDialog', array(
    'id'=>'order-item-dialog',
    'options'=>array(
        'title'=>'Order Item Dialog',
        'autoOpen'=>false,
        'modal' => true,
    ),
)); ?>

<?php Yii::app()->clientScript
    ->registerScript('buttons-rebind-function',"
        function refreshGrid(){
            $.fn.yiiGridView.update('order-items-grid');
        }
        function rebindOrderItemButtons(){
            $('.order-item-click').click(function(){
                var dialog = $('#order-item-dialog');
                var link = $(this);
                $.get(link.attr('href'), function(html){
                    dialog.html(html);
                    dialog.dialog('option', 'title', link.attr('alt'));
                    function bindOrderItemFormButton(){
                        $('#order-item-form').submit(function(){
                            var form = $(this);
                            $.post(form.attr('action'), form.serialize(), function(html){
                                dialog.html(html);
                                bindOrderItemFormButton();
                                refreshGrid();
                            });
                            return false;
                        });
                    }
                    bindOrderItemFormButton();
                    dialog.dialog('open');
                });
                return false;
            });
        }
        
        ", CClientScript::POS_HEAD)
    ->registerScript('manageDialog', "
        rebindOrderItemButtons();
        
        $('.finish-link').click(function(){
            var link = $(this);
            $.post(link.attr('href'), function(r){
                alert(r.error == 0 ? 'Success' : r.message);
                if(r.error == 0)
                    window.location = window.location.href;
            }, 'json');
            return false;
        });
    ", CClientScript::POS_READY); ?>