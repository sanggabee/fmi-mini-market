<?php if(!$model->picture || $model->isNewRecord): ?>
    <?php echo CHtml::activeLabelEx($model,'picture'); ?>
    <?php echo CHtml::activeFileField($model,'picture'); ?>
    <?php echo CHtml::error($model,'picture'); ?>
<?php elseif($model->picture && !$model->isNewRecord): ?>
    <?php echo CHtml::image($model->pictureUrl, 'preview', array('width' => 50,)); ?>
    <?php echo CHtml::ajaxLink(
        'Delete picture',
        array('deletePicture', 'id'=>$model->id),
        array('update'=>'#picture-container',)
            , array('onclick'=>'if( ! confirm(\'Delete the category picture?\')) return false;')
    ); ?>
<?php endif; ?>