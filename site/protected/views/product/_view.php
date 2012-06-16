<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('category_id')); ?>:</b>
	<?php echo CHtml::encode($data->category_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('manifacturer_id')); ?>:</b>
	<?php echo CHtml::encode($data->manifacturer_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('measure_id')); ?>:</b>
	<?php echo CHtml::encode($data->measure_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
	<?php echo CHtml::encode($data->name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('delivery_prize')); ?>:</b>
	<?php echo CHtml::encode($data->delivery_prize); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('sell_prize')); ?>:</b>
	<?php echo CHtml::encode($data->sell_prize); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('current_quantity')); ?>:</b>
	<?php echo CHtml::encode($data->current_quantity); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('minimum_quantity')); ?>:</b>
	<?php echo CHtml::encode($data->minimum_quantity); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('create_time')); ?>:</b>
	<?php echo CHtml::encode($data->create_time); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('update_time')); ?>:</b>
	<?php echo CHtml::encode($data->update_time); ?>
	<br />

	*/ ?>

</div>