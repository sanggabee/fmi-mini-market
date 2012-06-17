<?php

class m120617_090652_add_order_update_time extends CDbMigration
{
	public function up()
	{
        $this->addColumn('order', 'update_time', 'datetime default null');
	}

	public function down()
	{
		$this->dropColumn('order', 'update_time');
	}
}