<?php

use yii\db\Schema;

class m130606_232323_init_blog extends \yii\db\Migration
{
	public function up()
	{
		// MySQL-specific table options. Adjust if you plan working with another DBMS
		$this->execute(file_get_contents(__DIR__.'/schema.mysql.sql'));
	}

	public function down()
	{
		$this->dropTable('tbl_user');
	}
}
