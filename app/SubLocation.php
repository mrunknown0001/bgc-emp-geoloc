<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubLocation extends Model
{
    protected $connection = 'mysql2';

    public function location()
    {
    	return $this->belongsTo('App\Location');
    }

    public function farm()
    {
        return $this->belongsTo('App\Farm');
    }
}
