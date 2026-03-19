<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Setting;
use Livewire\WithFileUploads;
class Settings extends Component
{
    use WithFileUploads;
    public $logo,$name,$email,$phone,$facebook,$twitter,$instagram,$telegram,$policy,$sales_terms,$keyword,$address,$whatsapp;

    public function update()
    {
        $setting = Setting::where('id', 1)->first();
        if(!empty($this->logo))
        {
            $name = md5($this->logo . microtime()).'.'.$this->logo->extension();
            $this->logo->storeAs('setting', $name);
            $setting->logo = $name;
        }
        $setting->name = $this->name;
        $setting->phone = $this->phone;
        $setting->email = $this->email;
        $setting->facebook = $this->facebook;
        $setting->twitter = $this->twitter;
        $setting->instagram = $this->instagram;
        $setting->telegram = $this->telegram;
        $setting->policy = $this->policy;
        $setting->sales_terms = $this->sales_terms;
        $setting->keyword = $this->keyword;
        $setting->address = $this->address;
        $setting->whatsapp = $this->whatsapp;
        $setting->save();
        session()->flash('message', 'تم التعديل بنجاح');
    }

    public function mount()
    {
        $setting = Setting::where('id', 1)->first();

        $this->name = $setting->name;
        $this->phone = $setting->phone;
        $this->email = $setting->email;
        $this->facebook = $setting->facebook;
        $this->twitter = $setting->twitter;
        $this->instagram = $setting->instagram ;
        $this->telegram = $setting->telegram;
        // $this->policy = $setting->policy;
        // $this->sales_terms = $setting->sales_terms;
        $this->keyword = $setting->keyword;
        $this->address = $setting->address;
        $this->whatsapp = $setting->whatsapp;
    }
    public function render()
    {
        $setting = Setting::where('id', 1)->first();
        return view('livewire.settings', compact('setting'));
    }
}
