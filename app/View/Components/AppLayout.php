<?php

namespace App\View\Components;

use Carbon\Carbon;
use Illuminate\View\Component;

class AppLayout extends Component
{
    public $title; 
    public function __construct($title = null)
    {
        $this->title = $title; 
    }

    public function render()
    { 
        return view('layouts.app-layout');
    }
}
