<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmailSend extends Model
{
    public $fillable = [
        'name',
        'receiver',
        'title',
        'body',
        'view',
        'error',
        'status',
    ];
    protected $filterable = [
        'name'=>0,
        'receiver'=>1,
        'title'=>1,
        'error'=>1,
        'body'=>1,
        'status'=>1,
    ];
    public function scopeFilter($query, $request){
        if ($request->fl){
            switch($request->tfl){
                case 'null':
                    $query->whereNull($request->fl);
                    break;
                case 'fill':
                    $query->whereNotNull($request->fl);
                    break;
                default:
                    $query->where($request->fl, $request->tfl);
                    break;
            }
        }
        if ($request->asort){
            $query->orderBy($request->asort);
        }else
        if ($request->dsort){
            $query->orderBy($request->dsort, 'DESC');
        }else
            $query->latest();

        if ($request->sc){
            $val = '%'.$request->sc.'%';
            foreach($this->filterable as $key => $fkey){
                if (is_numeric($fkey)){
                    if($fkey)
                        $query->orWhere($key, 'like', $val);
                    else
                        $query->where($key, 'like', $val);
                }else{
                    $query->orWhereHas($key, function($q)use($fkey,$val){
                        return $q->where($fkey,'like',$val);
                    });
                }
            }
        }
        return $query;
    }
}
