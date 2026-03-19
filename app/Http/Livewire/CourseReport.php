<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Course;
class CourseReport extends Component
{
    public $from,$to;
    public function render()
    {
        $courses = Course::whereHas('orders', function($query)
        {
            $query->whereBetween('created_at', [$this->from, $this->to]);

        })->get();
        return view('livewire.course-report', compact('courses'));
    }
}
