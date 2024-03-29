<?php /* @var $this Controller */ ?>
<?php /* @var $model Category */ ?>

<div class="form">

<?php $this->widget('FlashMessage',array('key'=>'success')); ?>

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'category-form',
	'enableAjaxValidation'=>true,
//    'focus'=>array($model, 'name'),
    'htmlOptions' => array(
        'enctype' => 'multipart/form-data'
    ),
)); /* @var $form CActiveForm */ ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('maxlength'=>45)); ?>
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
<br />
<br />
<br />
<br />
<br />