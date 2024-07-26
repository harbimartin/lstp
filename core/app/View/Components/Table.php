<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Table extends Component
{
    public $column;
    public $datas;
    public $lim;
    public $datef;
    public $import;
    public $export;
    public $search;
    public $idk;
    public $title;
    public $sign;
    public $sort;
    public $prop;
    public $filter;
    public $tool;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($column, $datas, $lim=true, $search=true, $datef = false, $import = false, $export = false, $idk = 'id', $title = null, $sign = null, $sort = true, $prop = null, $tool=true, $filter=false){
        $this->column = $column;
        $this->datas = $datas;
        $this->lim = $lim;
        $this->search = $search;
        $this->datef = $datef;
        $this->import = $import;
        $this->export = $export;
        $this->idk = $idk;
        $this->title = $title;
        $this->sign = $sign;
        $this->sort = $sort && $tool;
        $this->prop = $prop;
        $this->filter = $filter;
        $this->tool = $tool;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render(){
        return view('components.table');
    }
}
