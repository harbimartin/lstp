<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserPositionRpt extends Model
{
    public $timestamps = false;
    protected $table = 'position_user_rpt';
    protected $guarded = [];
}
