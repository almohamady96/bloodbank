<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateClientsTable extends Migration {

	public function up()
	{
		Schema::create('clients', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('name');
			$table->string('email');
			$table->date('birth_date');
			$table->date('donation_last_date');
			$table->string('phone');
			$table->string('password');
            $table->string('pin_code')->nullable();
            $table->integer('city_id')->unsigned();
			$table->integer('blood_type_id')->unsigned();
			$table->boolean('is_active')->default(1);
			$table->string('api_token', 60)->unique()->nullable();
		});
	}

	public function down()
	{
		Schema::drop('clients');
	}
}