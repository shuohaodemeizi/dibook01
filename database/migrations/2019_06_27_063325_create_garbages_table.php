<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGarbagesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::connection('mysql_garbage')->create('garbages', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('name');
			$table->enum('type', array('wait','recyclable','hazardous','householdfood','residual'))->comment('不确定，可回收，有害，湿垃圾，干垃圾');
			$table->integer('pid')->nullable()->default(0);
			$table->integer('is_show')->nullable()->default(1);
			$table->timestamps();
			$table->integer('hot')->nullable()->default(0);
			$table->integer('addhot')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::connection('mysql_garbage')->drop('garbages');
	}

}
