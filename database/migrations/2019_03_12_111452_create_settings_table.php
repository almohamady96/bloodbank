<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSettingsTable extends Migration {

	public function up()
	{
		Schema::create('settings', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->text('about_app');
			$table->string('phone');
			$table->string('email');
			$table->string('android_app_url');
			$table->string('facebook_url');
			$table->string('whatsapp_url');
			$table->string('google_url');
			$table->string('instagram_url');
			$table->string('youtube_url');
			$table->string('twitter_url');
		});
	}

	public function down()
	{
		Schema::drop('settings');
	}
}