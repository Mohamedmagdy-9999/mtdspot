<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Slider;
use Livewire\WithFileUploads;
class Sliders extends Component
{
    use WithFileUploads;
    public $slider_id,$image,$text,$slider_edit_id, $slider_delete_id;

    public function updated($fields)
    {
        $this->validateOnly($fields, [
           
            'image' => 'required',
        ]);
    }


    public function storeSliderData()
    {
        //on form submit validation
        $this->validate([
            
            'image' => 'required',

        ]);

        //Add Category Data
        $slider = new Slider();
        if(!empty($this->image))
        {
            $name = md5($this->image . microtime()).'.'.$this->image->extension();
            $this->image->storeAs('sliders', $name);
            $slider->image = $name;
        }
        $slider->text = $this->text;
        $slider->save();

        session()->flash('message', 'تم الاضافة بنجاح');

        
        $this->image = '';
        $this->text = '';
      
        

        //For hide modal after add category success
        $this->dispatchBrowserEvent('close-modal');
    }

    public function resetInputs()
    {
       
        $this->image = '';
        $this->text = '';
    }

    public function close()
    {
        $this->resetInputs();
    }

    public function editSlider($id)
    {
        $slider = Slider::where('id', $id)->first();

        $this->slider_edit_id = $id;
        $this->text = $slider->text;

        $this->dispatchBrowserEvent('show-edit-user-modal');
    }
    
    public function editSliderData()
    {
        //on form submit validation
        $this->validate([
            'image' => 'nullable',
        ]);

        $slider = Slider::where('id', $this->slider_edit_id)->first();
        
        if(!empty($this->image))
        {
            $name = md5($this->image . microtime()).'.'.$this->image->extension();
            $this->image->storeAs('sliders', $name);
            $slider->image = $name;
        }
  
        $slider->text = $this->text;
        $slider->save();

        session()->flash('message', 'تم التعديل بنجاح');

        //For hide modal after add category success
        $this->dispatchBrowserEvent('close-modal');
    }

    //Delete Confirmation
    public function deleteConfirmation($id)
    {
        $this->slider_delete_id = $id; 

        $this->dispatchBrowserEvent('show-delete-confirmation-modal');
    }

    public function deleteSliderData()
    {
        $slider = Slider::where('id', $this->slider_delete_id)->first();
        $slider->delete();

        session()->flash('message', 'تم الحذف بنجاح');

        $this->dispatchBrowserEvent('close-modal');

        $this->slider_delete_id = '';
    }

    public function cancel()
    {
        $this->slider_delete_id = '';
    }

    public function render()
    {
        $sliders = Slider::latest()->get();
        return view('livewire.sliders', compact('sliders'));
    }
}
