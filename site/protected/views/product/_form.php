<?php /* @var $this Controller */ ?>
<div class="form">

<?php $this->widget('FlashMessage',array('key'=>'success')); ?>
    
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'product-form',
	'enableAjaxValidation'=>false,
)); /* @var $form CActiveForm */?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'category_id'); ?>
		<?php echo $form->dropDownList($model,'category_id', $categories); ?>
		<?php echo $form->error($model,'category_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'manifacturer_id'); ?>
		<?php echo $form->dropDownList($model,'manifacturer_id',$manifacturers); ?>
		<?php echo $form->error($model,'manifacturer_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'measure_id'); ?>
		<?php echo $form->dropDownList($model,'measure_id',$measures); ?>
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

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->