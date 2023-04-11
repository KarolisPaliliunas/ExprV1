<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class ProjectFilterLoayout extends Component
{
    public $filterType;
    public $filterValue;
    public function __construct($filterType, $filterValue)
    {
        //
        $this->$filterType=$filterType;
        $this->$filterValue=$filterValue;
    }

    /**
     * Get the view / contents that represents the component.
     */
    public function render(): View
    {
        return view('components.project-list-filters');
    }
}
