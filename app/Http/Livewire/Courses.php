<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Course;
use App\Models\CourseDetail;
use Livewire\WithFileUploads;
class Courses extends Component
{
    use WithFileUploads;
    public $course_id,$image,$title,$sub_title,$desc,$price,$price_after_discount,$video,$text,$val,$course_edit_id,$course_delete_id;
    public $inputs = [];
    public $details = [];
    public $i = 1;
    public function updated($fields)
    {
        $this->validateOnly($fields, [
           
            'image' => 'required',
            'title' => 'required',
            'sub_title' => 'required',
            'desc' => 'required',
        ]);
    }

    public function add($i)
    {
        $i = $i + 1;
        $this->i = $i;
        array_push($this->inputs ,$i);
    }

    public function remove($i)
    {
        unset($this->inputs[$i]);
    }

    public function storeCourseData()
    {
        //on form submit validation
        $this->validate([
            
            'image' => 'required',
            'title' => 'required',
            'sub_title' => 'required',
            'desc' => 'required',

        ]);

        //Add Category Data
        $course = new Course();
        if(!empty($this->image))
        {
            $name = md5($this->image . microtime()).'.'.$this->image->extension();
            $this->image->storeAs('courses', $name);
            $course->image = $name;
        }
       
        $course->title = $this->title;
        $course->sub_title = $this->sub_title;
        $course->desc = $this->desc;
        $course->video = $this->video;
        $course->price = $this->price;

        $course->price_after_discount = $this->price_after_discount;
        $course->save();

     

        session()->flash('message', 'تم الاضافة بنجاح');

        
        $this->image = '';
        $this->video = '';
        $this->title = '';
        $this->sub_title = '';
        $this->desc = '';
      
        

        //For hide modal after add category success
        $this->dispatchBrowserEvent('close-modal');
    }

    public function resetInputs()
    {
       
        $this->image = '';
        $this->video = '';
        $this->title = '';
        $this->sub_title = '';
        $this->desc = '';
    }

    public function close()
    {
        $this->resetInputs();
    }

    public function editCourse($id)
    {
        $course = Course::where('id', $id)->first();
        $this->course_edit_id = $id;
        $this->title = $course->title;
        $this->sub_title = $course->sub_title;
        $this->desc = $course->desc;
        $this->price = $course->price;
        $this->price_after_discount = $course->price_after_discount;
        $this->video = $course->video;
       
        

        $this->dispatchBrowserEvent('show-edit-user-modal');
    }
    
    public function editCourseData()
    {
        //on form submit validation
        $this->validate([
            'title' => 'required',
            'sub_title' => 'required',
            'desc' => 'required',
        ]);

        $course = Course::where('id', $this->course_edit_id)->first();
        
        if(!empty($this->image))
        {
            $name = md5($this->image . microtime()).'.'.$this->image->extension();
            $this->image->storeAs('courses', $name);
            $course->image = $name;
        }
        $course->video = $this->video;
        $course->title = $this->title;
        $course->sub_title = $this->sub_title;
        $course->desc = $this->desc;
        $course->price = $this->price;
        $course->price_after_discount = $this->price_after_discount;
        $course->save();

      

        session()->flash('message', 'تم التعديل بنجاح');

        //For hide modal after add category success
        $this->dispatchBrowserEvent('close-modal');
    }

    //Delete Confirmation
    public function deleteConfirmation($id)
    {
        $this->course_delete_id = $id; 

        $this->dispatchBrowserEvent('show-delete-confirmation-modal');
    }

    public function deleteCourseData()
    {
        $course = Course::where('id', $this->course_delete_id)->first();
        $course->delete();

        session()->flash('message', 'تم الحذف بنجاح');

        $this->dispatchBrowserEvent('close-modal');

        $this->course_delete_id = '';
    }

   

    public function cancel()
    {
        $this->course_delete_id = '';
    }

    public function render()
    {
        $courses = Course::latest()->get();
        return view('livewire.courses', compact('courses'));
    }
}
