<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class File extends Model{
    public $table = 't_budget_attachment_tab';
    public $timestamps = false;
    public $fillable = [
        't_budget_id',
        'file_desc',
        'file_url',
        'file_origin',
        'uploaded_by',
        'verifikasi_status_id'
    ];
}
