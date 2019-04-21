<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DonationRequest extends Model 
{

    protected $table = 'donation_requests';
    public $timestamps = true;
    protected $fillable = array('patient_name', 'patient_age', 'blood_type_id','hospital_address', 'bags_number', 'hospital_name', 'phone', 'notes', 'client_id', 'city_id', 'latitude', 'longitude');

    public function city()
    {
        return $this->belongsTo('App\City');
    }

    public function blood_type()
    {
        return $this->belongsTo('App\BloodType');
    }

    public function notifications()
    {
        return $this->hasMany('App\Notification');
    }
    public function client()
    {
        return $this->belongsTo('App\Client');
    }
}