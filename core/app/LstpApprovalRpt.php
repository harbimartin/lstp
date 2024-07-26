<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LstpApprovalRpt extends AList{
    public $table = 't_lstp_status_rpt';
    protected $sort_default = 'id';
    protected $date_default = 'id';
    public $fillable = [
    ];
    public $sortable = [
    ];
}
