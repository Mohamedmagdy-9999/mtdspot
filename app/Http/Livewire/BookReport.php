<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Book;
class BookReport extends Component
{
    public $from,$to;
    public function render()
    {
        $books = Book::whereHas('orders', function($query)
        {
            $query->whereBetween('created_at', [$this->from, $this->to]);

        })->get();
        return view('livewire.book-report', compact('books'));
    }
}
