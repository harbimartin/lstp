<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lstp extends AList{
    public $table = 't_lstp_tab';
    protected $sort_default = 'id';
    protected $date_default = 'id';
    public $fillable = [
    ];
    public $sortable = [
    ];
}
