<?php

class m120617_095243_alter_order_total extends CDbMigration
{
	public function up()
	{
        $this->alterColumn('order', 'total', 'decimal(10,2) default null');
	}

	public function down()
	{
		$this->alterColumn('order', 'total', 'decimal(10,2) not null');
	}

	/*
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
	}

	public function safeDown()
	{
	}
	*/
}