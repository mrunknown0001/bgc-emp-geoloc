<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $connection = 'mysql2';

    public function sub_locations()
    {
    	return $this->hasMany('App\SubLocation');
    }
}
