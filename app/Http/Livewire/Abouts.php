<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\About;
use Livewire\WithFileUploads;
class Abouts extends Component
{

    use WithFileUploads;
    public $about_id,$image,$content,$about_edit_id, $about_delete_id;

    public function updated($fields)
    {
        $this->validateOnly($fields, [
           
            'image' => 'required',
            'content' => 'required',
        ]);
    }


    public function storeAboutData()
    {
        //on form submit validation
        $this->validate([
            
            'image' => 'required',
            'content' => 'required',

        ]);

        //Add Category Data
        $about = new About();
        if(!empty($this->image))
        {
            $name = md5($this->image . microtime()).'.'.$this->image->extension();
            $this->image->storeAs('about', $name);
            $about->image = $name;
        }
        $about->content = $this->content;
        $about->save();

        session()->flash('message', 'تم الاضافة بنجاح');

        
        $this->image = '';
        $this->content = '';
      
        

        //For hide modal after add category success
        $this->dispatchBrowserEvent('close-modal');
    }

    public function resetInputs()
    {
       
        $this->image = '';
        $this->content = '';
    }

    public function close()
    {
        $this->resetInputs();
    }

    public function editAbout($id)
    {
        $about = About::where('id', $id)->first();

        $this->about_edit_id = $id;
        // $this->content = $about->content;

        $this->dispatchBrowserEvent('show-edit-user-modal');
    }
    public function amount(){
        $about = About::first();
        $this->content = $about->content;
    }
    public function editAboutData()
    {
        //on form submit validation
        $this->validate([
            'image' => 'required',
            'content' => 'required',
        ]);

        $about = About::where('id', $this->about_edit_id)->first();
        
        if(!empty($this->image))
        {
            $name = md5($this->image . microtime()).'.'.$this->image->extension();
            $this->image->storeAs('about', $name);
            $about->image = $name;
        }
  
        $about->content = $this->content;
        $about->save();

        session()->flash('message', 'تم التعديل بنجاح');

        //For hide modal after add category success
        $this->dispatchBrowserEvent('close-modal');
    }

    //Delete Confirmation
    public function deleteConfirmation($id)
    {
        $this->about_delete_id = $id; 

        $this->dispatchBrowserEvent('show-delete-confirmation-modal');
    }

    public function deleteAboutData()
    {
        $about = About::where('id', $this->about_delete_id)->first();
        $about->delete();

        session()->flash('message', 'تم الحذف بنجاح');

        $this->dispatchBrowserEvent('close-modal');

        $this->about_delete_id = '';
    }

    public function cancel()
    {
        $this->about_delete_id = '';
    }

    public function render()
    {
        $abouts = About::all();
        return view('livewire.abouts', compact('abouts'));
    }
}
