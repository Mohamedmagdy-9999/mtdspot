<?php

namespace App\Http\Livewire;

use Livewire\Component;

use App\Models\Package;
class PackageReport extends Component
{
    public $from,$to;
    public function render()
    {
        
        $packages = Package::whereHas('orders', function($query)
        {
            $query->whereBetween('created_at', [$this->from, $this->to]);

        })->get();
        return view('livewire.package-report', compact('packages'));
    }
}
