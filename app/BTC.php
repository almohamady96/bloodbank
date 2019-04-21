<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BTC extends Model 
{

    protected $table = 'blood_type_client';
    public $timestamps = true;
    protected $fillable = array('client_id', 'blood_type_id');

}