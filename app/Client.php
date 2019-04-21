<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{

    protected $table = 'clients';
    public $timestamps = true;
    protected $fillable = array('name', 'email', 'birth_date', 'donation_last_date', 'phone', 'password', 'pin_code','city_id', 'blood_type_id', 'is_active', 'api_token');

    public function requests()
    {
        return $this->hasMany('App\DonationRequest');
    }

    public function posts()
    {
        return $this->belongsToMany('App\Post');
    }

    public function governorates()
    {
        return $this->belongsToMany('App\Governorate');
    }

    public function blood_types()
    {
        return $this->belongsToMany('App\BloodType');
    }

    public function contacts()
    {
        return $this->hasMany('App\Contact');
    }

    public function blood_type()
    {
        return $this->belongsTo('App\BloodType');
    }

    public function city()
    {
        return $this->belongsTo('App\City');
    }

    public function notifications()
    {
        return $this->belongsToMany('App\Notification');
    }
    public function tokens()
    {
        return $this->hasMany('App\Token');
    }
    public function reports()
    {
        return $this->hasMany('App\Report');
    }




    protected $hidden = [
        'password','api_token',
    ];
}