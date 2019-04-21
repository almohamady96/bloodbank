<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model 
{

    protected $table = 'settings';
    public $timestamps = true;
    protected $fillable = array('about_app', 'android_app_url', 'facebook_url', 'whatsapp_url', 'google_url', 'instagram_url', 'youtube_url', 'twitter_url');

}