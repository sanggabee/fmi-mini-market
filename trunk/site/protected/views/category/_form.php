<?php /* @var $this Controller */ ?>
<?php /* @var $model Category */ ?>

<?php if($this->user->hasFlash('success')): ?>
    <div class="success"><?php echo $this->user->getFlash('success'); ?></div>
<?php endif; ?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'category-form',
	'enableAjaxValidation'=>true,
    'htmlOptions' => array(
        'enctype' => 'multipart/form-data'
    ),
)); /* @var $form CActiveForm */ ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'colour'); ?>
		<?php $this->widget('ext.SMiniColors.SActiveColorPicker', array(
            'model' => $model,
            'attribute' => 'colour',
        )); ?>
		<?php echo $form->error($model,'colour'); ?>
	</div>

	<div id="picture-container" class="row">
        <?php $this->renderPartial('_picture', array('model'=>$model)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->