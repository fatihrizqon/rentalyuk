<?php

namespace App\View\Components;

use Carbon\Carbon;
use Illuminate\View\Component;

class SearchComponent extends Component
{   
    public $date;
    public function __construct($date = null) {
        $this->date = $date; 
    }
    public function render()
    {
        return view('components.search');
    }
}
