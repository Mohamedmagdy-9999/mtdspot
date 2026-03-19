<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\BookCategory;
class BookCategories extends Component
{

    public $category_id,$name,$category_edit_id, $category_delete_id;

    public function updated($fields)
    {
        $this->validateOnly($fields, [
           
            'name' => 'required',
        ]);
    }


    public function storeCategoryData()
    {
        //on form submit validation
        $this->validate([
            
            'name' => 'required',

        ]);

        //Add Category Data
        $category = new BookCategory();
        $category->name = $this->name;
        $category->save();

        session()->flash('message', 'تم الاضافة بنجاح');

        
 
        $this->name = '';
      
        

        //For hide modal after add category success
        $this->dispatchBrowserEvent('close-modal');
    }

    public function resetInputs()
    {
       
        $this->name = '';
    }

    public function close()
    {
        $this->resetInputs();
    }

    public function editCategory($id)
    {
        $category = BookCategory::where('id', $id)->first();

        $this->category_edit_id = $id;
        $this->name = $category->name;

        $this->dispatchBrowserEvent('show-edit-user-modal');
    }
    
    public function editCategoryData()
    {
        //on form submit validation
        $this->validate([
            'name' => 'required',
        ]);

        $caategory = BookCategory::where('id', $this->category_edit_id)->first();
        $caategory->name = $this->name;
        $caategory->save();

        session()->flash('message', 'تم التعديل بنجاح');

        //For hide modal after add category success
        $this->dispatchBrowserEvent('close-modal');
    }

    //Delete Confirmation
    public function deleteConfirmation($id)
    {
        $this->category_delete_id = $id; 

        $this->dispatchBrowserEvent('show-delete-confirmation-modal');
    }

    public function deleteCategoryData()
    {
        $category = BookCategory::where('id', $this->category_delete_id)->first();
        $category->delete();

        session()->flash('message', 'تم الحذف بنجاح');

        $this->dispatchBrowserEvent('close-modal');

        $this->category_delete_id = '';
    }

    public function cancel()
    {
        $this->category_delete_id = '';
    }

    public function render()
    {
        $categories = BookCategory::latest()->get();
        return view('livewire.book-categories', compact('categories'));
    }
}
