<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); /* @var $form CActiveForm */ ?>

	<div class="row">
		<?php echo $form->label($model,'id'); ?>
		<?php echo $form->textField($model,'id',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'type'); ?>
		<?php echo $form->dropDownList($model, 'type', $model->types); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'user_id'); ?>
		<?php echo $form->dropDownList($model,'user_id',User::model()->listData); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'create_time'); ?>
		<?php echo $form->textField($model,'create_time'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'state'); ?>
		<?php echo $form->dropDownList($model,'state', $model->states); ?>
	</div>
    
    <div class="row">
        <?php echo $form->label($model, 'from'); ?>
        <?php $this->widget('DatePicker', array(
            'model'=>$model,
            'attribute' => 'from',
        )); ?>
    </div>
    
    <div class="row">
        <?php echo $form->label($model, 'to'); ?>
        <?php $this->widget('DatePicker', array(
            'model'=>$model,
            'attribute' => 'to',
        )); ?>
    </div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->