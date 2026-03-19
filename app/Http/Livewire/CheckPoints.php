<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\CheckPoint;
class CheckPoints extends Component
{

    public $ckeck_id,$content,$ckeck_edit_id, $ckeck_delete_id;

    public function updated($fields)
    {
        $this->validateOnly($fields, [
           
            'content' => 'required',
        ]);
    }


    public function storeCheckData()
    {
        //on form submit validation
        $this->validate([
            
            'content' => 'required',

        ]);

        //Add Category Data
        $check = new CheckPoint();
        $check->content = $this->content;
        $check->save();

        session()->flash('message', 'تم الاضافة بنجاح');

        
        $this->Content = '';
      
        

        //For hide modal after add category success
        $this->dispatchBrowserEvent('close-modal');
    }

    public function resetInputs()
    {
       
        $this->Content = '';
    }

    public function close()
    {
        $this->resetInputs();
    }

    public function editCheck($id)
    {
        $check = CheckPoint::where('id', $id)->first();

        $this->check_edit_id = $id;
        $this->content = $check->content;

        $this->dispatchBrowserEvent('show-edit-user-modal');
    }
    
    public function editCheckData()
    {
        //on form submit validation
        $this->validate([
            'content' => 'required',
        ]);

        $check = CheckPoint::where('id', $this->check_edit_id)->first();
        $check->content = $this->content;
        $check->save();

        session()->flash('message', 'تم التعديل بنجاح');

        //For hide modal after add category success
        $this->dispatchBrowserEvent('close-modal');
    }

    //Delete Confirmation
    public function deleteConfirmation($id)
    {
        $this->check_delete_id = $id; 

        $this->dispatchBrowserEvent('show-delete-confirmation-modal');
    }

    public function deleteCheckData()
    {
        $check = CheckPoint::where('id', $this->check_delete_id)->first();
        $check->delete();

        session()->flash('message', 'تم الحذف بنجاح');

        $this->dispatchBrowserEvent('close-modal');

        $this->check_delete_id = '';
    }

    public function cancel()
    {
        $this->check_delete_id = '';
    }


    public function render()
    {
        $checks = CheckPoint::all();
        return view('livewire.check-points', compact('checks'));
    }
}
