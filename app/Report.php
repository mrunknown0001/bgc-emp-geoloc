<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    public function report_images()
    {
    	return $this->hasMany('App\ReportImage');
    }


    public function farm()
    {
    	return $this->belongsTo('App\Farm');
    }


    public function loc()
    {
    	return $this->belongsTo('App\Location');
    }


    public function sub()
    {
    	return $this->belongsTo('App\SubLocaton');
    }
}
