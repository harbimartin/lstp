<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Add extends Component
{
    public $unique;
    public $title;
    public $column;
    public $url;
    public $select;
    public $error;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($unique, $title, $column, $url = '', $select = [], $error = '')
    {
        $this->unique = $unique;
        $this->title = $title;
        $this->column = $column;
        $this->select = $select;
        $this->url = $url;
        $this->error = $error;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.add');
    }
}
