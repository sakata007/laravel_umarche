<?php

namespace App\View\Components;

use Illuminate\View\Component;

class TestClassBase extends Component
{
    public $classBaseMessage;
    public $dafaultMessage;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($classBaseMessage, $dafaultMessage = "初期値です")
    {
        $this->classBaseMessage = $classBaseMessage;
        $this->dafaultMessage = $dafaultMessage;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.tests.test-class-base-component');
    }
}
