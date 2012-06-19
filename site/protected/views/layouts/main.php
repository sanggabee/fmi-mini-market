<?php $this->beginContent('//layouts/empty'); ?>
<div class="container" id="page">

	<div id="header">
		<div id="logo"><?php echo CHtml::encode(Yii::app()->name); ?></div>
	</div><!-- header -->

	<div id="mainmenu">
		<?php $this->widget('zii.widgets.CMenu',array(
			'items'=>array(
				array('label'=>'Home', 'url'=>array('/site/index')),
				array('label'=>'Manifacturers', 'url'=>array('/manifacturer'), 'visible'=>!Yii::app()->user->isGuest),
				array('label'=>'Categories', 'url'=>array('/category'), 'visible'=>!Yii::app()->user->isGuest),
				array('label'=>'Products', 'url'=>array('/product'), 'visible'=>!Yii::app()->user->isGuest),
				array('label'=>'Orders', 'url'=>array('/order'), 'visible'=>!Yii::app()->user->isGuest),
				array('label'=>'Login', 'url'=>array('/site/login'), 'visible'=>Yii::app()->user->isGuest),
				array('label'=>'Logout ('.Yii::app()->user->name.')', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest)
			),
		)); ?>
	</div><!-- mainmenu -->
	<?php if(isset($this->breadcrumbs)):?>
		<?php $this->widget('zii.widgets.CBreadcrumbs', array(
			'links'=>$this->breadcrumbs,
		)); ?><!-- breadcrumbs -->
	<?php endif?>

	<?php echo $content; ?>

	<div class="clear"></div>

	<div id="footer">
		Copyright &copy; <?php echo date('Y'); ?> by <?php echo Yii::app()->params['author']; ?>.<br/>
		All Rights Reserved.
	</div><!-- footer -->

</div><!-- page -->
<?php $this->endContent(); ?>