<?php

namespace App;

use Exception;
use Illuminate\Database\Eloquent\Model;

class AList extends Model{
    public $timestamps = false;
    protected $filterable = [];
    protected $sortable = [];
    protected $sort_default = 'created_at';
    protected $date_default = 'created';
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
        if ($request->asort || $request->dsort){
            $sort_type = $request->asort ? 'ASC':'DESC';
            $sort_value = $request->asort ? $request->asort : $request->dsort;
            if (array_key_exists($request->asort,$this->sortable)){
                $cols = $this->sortable[$sort_value];
                if ($cols){
                        $query->select($this->table.'.*', $cols[0].'.'.$cols[2])->leftJoin($cols[0], function($join)use($cols) {
                            $join->on($this->table.'.'.$cols[1], '=', $cols[0].'.id');
                        })->orderBy($cols[2], $sort_type);
                }else
                    $query->orderBy($sort_value, $sort_type);
            }
        }else
            $query->latest($this->sort_default);

        if ($request->dt){
            $query->where($this->date_default,'<=',$request->dt);
        }
        if ($request->df){
            $query->where($this->date_default,'>=',$request->df);
        }
        if ($request->sc){
            $val = '%'.$request->sc.'%';
            foreach($this->filterable as $key => $fkey){
                if (is_numeric($fkey)){
                    switch($fkey){
                        case 0: // first
                            $query->where($key, 'like', $val);
                            break;
                        case 1: // second
                            $query->orWhere($key, 'like', $val);
                            break;
                        case 2: // unique
                            break;
                    }
                }else{
                    $query->orWhereHas($key, function($q)use($fkey,$val){
                        return $q->where($fkey,'like',$val);
                    });
                }
            }
        }
        return $query;
    }
    public static function boot(){
        parent::boot();
        static::creating(function ($model) {
            // $model->budget_status = 'Draft';
        });
    }
}
