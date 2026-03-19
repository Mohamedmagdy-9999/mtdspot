<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Book;
use App\Models\BookDetail;
use Livewire\WithFileUploads;
class Books extends Component
{

    use WithFileUploads;
    public $book_id,$image,$name,$desc,$price,$price_after_discount,$text,$val,$book_category_id,$rate,$sample,$book,$unit_name,$unit_image,$book_edit_id,$book_delete_id;
    public $inputs = [];
    public $items = [];
    public $details = [];
    public $i = 1;
    public $v = 1;
    public function updated($fields)
    {
        $this->validateOnly($fields, [
           
            'image' => 'required',
            'name' => 'required',
            'desc' => 'required',
        ]);
    }

    public function add($i)
    {
        $i = $i + 1;
        $this->i = $i;
        array_push($this->inputs ,$i);
    }

    public function adds($v)
    {
        $v = $v + 1;
        $this->i = $v;
        array_push($this->items ,$v);
    }

    public function remove($i)
    {
        unset($this->inputs[$i]);
    }

    public function removes($v)
    {
        unset($this->items[$v]);
    }

    public function storeBookData()
    {
        //on form submit validation
        $this->validate([
            
            'image' => 'required',
            'name' => 'required',
            'desc' => 'required',

        ]);

        //Add Category Data
        $book = new Book();
        if(!empty($this->image))
        {
            $name = md5($this->image . microtime()).'.'.$this->image->extension();
            $this->image->storeAs('books', $name);
            $book->image = $name;
        }

        if(!empty($this->sample))
        {
            $name = md5($this->sample . microtime()).'.'.$this->sample->extension();
            $this->sample->storeAs('books', $name);
            $book->sample = $name;
        }

        if(!empty($this->book))
        {
            $name = md5($this->book . microtime()).'.'.$this->book->extension();
            $this->book->storeAs('books', $name);
            $book->book = $name;
        }
       
        $book->name = $this->name;
        $book->rate = $this->rate;
        $book->desc = $this->desc;
        $book->price = $this->price;
        $book->book_category_id = $this->book_category_id;

        $book->price_after_discount = $this->price_after_discount;
        $book->save();

        foreach ($this->text as $key => $value) {
            BookDetail::create(['text' => $this->text[$key], 'val' => $this->val[$key],'book_id' => $book->id]);
        }

        foreach ($this->unit_name as $keya => $units) 
        {
                    $name = md5($this->unit_image . microtime()).'.'.$this->unit_image->extension();
                    $this->unit_image->storeAs('books', $name);
                    BookUnit::create([
                    'unit_name' => $this->unit_name[$key],
                    'unit_image' => $name[$key],
                    'book_id' => $book->id]
                );
        }

        session()->flash('message', 'تم الاضافة بنجاح');

        
        $this->image = '';
        $this->name = '';
        $this->desc = '';
        $this->text = '';
        $this->val = '';
      
        

        //For hide modal after add category success
        $this->dispatchBrowserEvent('close-modal');
    }

    public function resetInputs()
    {
       
        $this->image = '';
        $this->name = '';
        $this->desc = '';
        $this->text = '';
        $this->val = '';
    }

    public function close()
    {
        $this->resetInputs();
    }

    public function editBook($id)
    {
        $book = Book::where('id', $id)->first();
        $this->book_edit_id = $id;
        $this->name = $book->name;
        $this->desc = $book->desc;
        $this->price = $book->price;
        $this->book_category_id = $book->book_category_id;
        $this->price_after_discount = $book->price_after_discount;
        $this->rate = $book->rate;
       
        foreach ($book->details as $key => $co) {
                $this->text[$key] = $co->text;
                $this->val[$key] = $co->val;
        }

        foreach ($book->units as $key => $uni) {
            $this->unit_name[$key] = $uni->unit_name;
            $this->unit_image[$key] = $uni->unit_image;
        }

        $this->dispatchBrowserEvent('show-edit-user-modal');
    }
    
    public function editBookData()
    {
        //on form submit validation
        $this->validate([
            'name' => 'required',
            'desc' => 'required',
        ]);

        $book = Book::where('id', $this->book_edit_id)->first();
        
        if(!empty($this->image))
        {
            $name = md5($this->image . microtime()).'.'.$this->image->extension();
            $this->image->storeAs('books', $name);
            $book->image = $name;
        }

        if(!empty($this->sample))
        {
            $name = md5($this->sample . microtime()).'.'.$this->sample->extension();
            $this->sample->storeAs('books', $name);
            $book->sample = $name;
        }

        if(!empty($this->book))
        {
            $name = md5($this->book . microtime()).'.'.$this->book->extension();
            $this->book->storeAs('books', $name);
            $book->book = $name;
        }
        
        $book->rate = $this->rate;
        $book->name = $this->name;
        $book->desc = $this->desc;
        $book->price = $this->price;
        $book->price_after_discount = $this->price_after_discount;
        $book->book_category_id = $this->book_category_id;
        $book->save();

        \DB::table('book_details')->where('book_id',$this->book_edit_id)->delete();
        foreach ($this->text as $key => $value) {
            BookDetail::create(['text' => $this->text[$key], 'val' => $this->val[$key],'book_id' => $book->id]);
        }
        \DB::table('book_units')->where('book_id',$this->book_edit_id)->delete();
        foreach ($this->unit_name as $keya => $units) 
        {
                    $name = md5($this->unit_image . microtime()).'.'.$this->unit_image->extension();
                    $this->unit_image->storeAs('book', $name);
                    BookUnit::create([
                    'unit_name' => $this->unit_name[$key],
                    'unit_image' => $name[$key],
                    'book_id' => $book->id]
                );
        }

        session()->flash('message', 'تم التعديل بنجاح');

        //For hide modal after add category success
        $this->dispatchBrowserEvent('close-modal');
    }

    //Delete Confirmation
    public function deleteConfirmation($id)
    {
        $this->book_delete_id = $id; 

        $this->dispatchBrowserEvent('show-delete-confirmation-modal');
    }

    public function deleteBookData()
    {
        $book = Book::where('id', $this->book_delete_id)->first();
        $book->delete();

        session()->flash('message', 'تم الحذف بنجاح');

        $this->dispatchBrowserEvent('close-modal');

        $this->book_delete_id = '';
    }

   

    public function cancel()
    {
        $this->book_delete_id = '';
    }

    public function render()
    {
        $books = Book::latest()->get();
        return view('livewire.books', compact('books'));
    }
}
