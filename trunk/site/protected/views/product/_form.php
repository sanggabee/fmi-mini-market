<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'product-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'category_id'); ?>
		<?php echo $form->textField($model,'category_id',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'category_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'manifacturer_id'); ?>
		<?php echo $form->textField($model,'manifacturer_id',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'manifacturer_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'measure_id'); ?>
		<?php echo $form->textField($model,'measure_id',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'measure_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'delivery_prize'); ?>
		<?php echo $form->textField($model,'delivery_prize',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'delivery_prize'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'sell_prize'); ?>
		<?php echo $form->textField($model,'sell_prize',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'sell_prize'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'current_quantity'); ?>
		<?php echo $form->textField($model,'current_quantity',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'current_quantity'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'minimum_quantity'); ?>
		<?php echo $form->textField($model,'minimum_quantity',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'minimum_quantity'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'create_time'); ?>
		<?php echo $form->textField($model,'create_time'); ?>
		<?php echo $form->error($model,'create_time'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'update_time'); ?>
		<?php echo $form->textField($model,'update_time'); ?>
		<?php echo $form->error($model,'update_time'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->