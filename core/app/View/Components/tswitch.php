<?php

namespace App\View\Components;

use Illuminate\View\Component;

class tswitch extends Component
{
    public $param;
    public $key;
    public $item;
    public $idk;
    public $iind;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($key, $param, $item, $idk = 0, $iind = 0){
        $this->key = $key;
        $this->param = $param;
        $this->item = $item;
        $this->idk = $idk;
        $this->iind = $iind;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.tswitch');
    }
}
