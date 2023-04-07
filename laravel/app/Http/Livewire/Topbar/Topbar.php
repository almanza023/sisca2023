<?php

namespace App\Http\Livewire\Topbar;

use App\Models\AperturaPeriodo;
use Carbon\Carbon;
use Livewire\Component;

class Topbar extends Component
{
    public function render()
    {
        $date = Carbon::now()->format('Y-m-d');

        $aperturas=AperturaPeriodo::getFecha($date);
        return view('livewire.topbar.topbar', compact('aperturas'));
    }
}
