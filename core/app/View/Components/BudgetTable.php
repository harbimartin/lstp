<?php

namespace App\View\Components;

use Illuminate\View\Component;

class BudgetTable extends Component
{
    public $isVerify;
    public $dataBudget;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($isVerify, $dataBudget){
        $this->isVerify = $isVerify;
        $this->dataBudget = $dataBudget;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.budget-table');
    }
}
