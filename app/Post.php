<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model 
{

    protected $table = 'posts';
    public $timestamps = true;
    protected $fillable = array('title_post', 'image', 'content_post', 'puplish_date', 'category_id');

    public function clients()
    {
        return $this->belongsToMany('App\Client');
    }

    public function category()
    {
        return $this->belongsTo('App\Category');
    }

}