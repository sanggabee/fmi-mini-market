<?php

class m120617_084456_add_order_state extends CDbMigration
{
	public function up()
	{
        $this->addColumn('order', 'state', 'integer not null default 1');
	}

	public function down()
	{
		$this->dropColumn('order', 'state');
	}
}