<?php /* @var $this DialogFormWidget */ ?>
<?php $this->widget('zii.widgets.jui.CJuiDialog', array(
    'id'=>"dialog-$this->id",
    'options'=>array(
        'title'=>'Dialog',
        'autoOpen'=>false,
        'modal' => true,
    ),
)); ?>

<?php $this->cs
    ->registerScript("ready-script-$this->id", "
        $this->afterAjaxReloadFunction();
            
    ", CClientScript::POS_READY)
    ->registerScript("head-script-$this->id", "
        function $this->afterAjaxReloadFunction(){
            $('$this->linkSelector').dialogForm({
                dialogId: 'dialog-$this->id',
                formId: '$this->formId',
                gridId: '$this->gridId'
            });
        }
    ", CClientScript::POS_HEAD); 