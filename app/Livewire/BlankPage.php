<?php

namespace App\Livewire;

use Livewire\Component;

class BlankPage extends Component
{
    public function render()
    {
        return view('livewire.blank-page')->layout('layouts.company');
    }
}
