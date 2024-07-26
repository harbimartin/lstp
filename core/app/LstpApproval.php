<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LstpApproval extends AList{
    public $table = 't_lstp_status_tab';
    protected $sort_default = 'id';
    protected $date_default = 'id';
    public $fillable = [
    ];
    public $sortable = [
    ];
}
