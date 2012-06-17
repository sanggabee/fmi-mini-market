<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); /* @var $form CActiveForm */?>

	<div class="row">
		<?php echo $form->label($model,'id'); ?>
		<?php echo $form->textField($model,'id',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'category_id'); ?>
		<?php echo $form->dropDownList($model, 'category_id', $categories, array('empty'=>'')); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'manifacturer_id'); ?>
		<?php echo $form->dropDownList($model, 'manifacturer_id', $manifacturers, array('empty'=>'')); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'measure_id'); ?>
		<?php echo $form->dropDownList($model, 'measure_id', $measures, array('empty'=>'')); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>100)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'delivery_prize'); ?>
		<?php echo $form->textField($model,'delivery_prize',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'sell_prize'); ?>
		<?php echo $form->textField($model,'sell_prize',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'current_quantity'); ?>
		<?php echo $form->textField($model,'current_quantity',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'minimum_quantity'); ?>
		<?php echo $form->textField($model,'minimum_quantity',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'create_time'); ?>
		<?php $this->widget('DatePicker', array(
            'model'=>$model,
            'attribute' => 'create_time',
        )); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'update_time'); ?>
        <?php $this->widget('DatePicker', array(
            'model'=>$model,
            'attribute' => 'update_time',
        )); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->