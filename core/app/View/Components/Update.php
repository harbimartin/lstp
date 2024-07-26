<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Update extends Component
{
    public $unique;
    public $column;
    public $url;
    public $title;
    public $datas;
    public $error;
    public $select;
    public $idk;
    public $detail;
    public $burl;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($unique, $column, $title, $data, $url = null,$select = '',$idk = 'id',  $error = '', $detail = false, $burl = null){
        $this->unique = $unique;
        $this->idk = $idk;
        $this->column = $column;
        $this->title = $title;
        $this->url = $url;
        $this->datas = $data;
        $this->error = $error;
        $this->select = $select;
        $this->detail = $detail;
        $this->burl = $burl;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render(){
        return view('components.update');
    }
}
