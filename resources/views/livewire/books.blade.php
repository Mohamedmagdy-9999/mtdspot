<div>
    <div class="container mt-5">
        <div class="row mb-5">
            
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    
                    <div class="card-body">
                        

                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">
                            add  
                        </button>
                        @if (session()->has('message'))
                            <div class="alert alert-success text-center">{{ session('message') }}</div>
                        @endif

                        <div class="row">
                            <div class="col-lg-12 col-sm-12 col-md-6 col-xl-12">
                                <div class="card overflow-hidden">
                                    <div class="card-body">
                                        <div class="table-responsive export-table">
                                            <table  id="file-datatable" class="table table-bordered text-nowrap key-buttons border-bottom  w-100">
                                                <thead>
                                                    <tr>
                                                        <th class="wd-15p border-bottom-0">category</th>
                                                        <th class="wd-15p border-bottom-0">name</th>
                                                        <th class="wd-15p border-bottom-0">rate</th>
                                                        <th class="wd-15p border-bottom-0">image</th>>
                                                        <th class="wd-15p border-bottom-0">action</th>
                                                        
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    
                                                        @if ($books->count() > 0)
                                                            @foreach ($books as $book)
                                                                <tr>
                                                                    <td>{{ $book->category->name}}</td>
                                                                    <td>{{ $book->name}}</td>
                                                                    <td>{{ $book->rate}}</td>
                                                                    <td>
                                                                        <img src="{{ asset('storage/books/' . $book->image) }}" style="width:100px;">
                                                                    </td>
                                                                    
                                                                
                                                                    <td style="text-align: center;">
                                                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editBookModal" wire:click="editBook({{ $book->id }})">
                                                                            edit
                                                                        </button> 

                                                                        
                                                                        
                                                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#deleteBookModal" wire:click="deleteConfirmation({{ $book->id }})">
                                                                                delete
                                                                            </button>
                                                                        
                                                                       
                                                                       
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        @else
                                                            <tr>
                                                                <td colspan="4" style="text-align: center;"><small>No book  Found</small></td>
                                                            </tr>
                                                        @endif
                                                
                                    
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                           
                        </div>

                       
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
        <div wire:ignore.self class="modal fade" id="addModal" tabindex="-1" data-backdrop="static" data-keyboard="false" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">add book</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" wire:click="close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <form wire:submit.prevent="storeBookData">
                            

                            
                            <div class="form-group row">
                                <label for="name" class="col-3">name</label>
                                <div class="col-9">
                                    <input type="text" class="form-control" wire:model="name">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="name" class="col-3">category</label>
                                <div class="col-9">
                                <select wire:model="book_category_id" class="form-control" id="">
                                        <option selected>--</option>
                                        @php $category = App\Models\BookCategory::latest()->get(); @endphp
                                        @foreach($category as $cat)
                                            <option value="{{$cat->id}}">{{$cat->name}}</option>
                                        @endforeach
                                </select>
                                </div>
                            </div>
                        

                            <div class="form-group row">
                                <label for="name" class="col-3">description</label>
                                <div class="col-9">
                                    <input type="text" class="form-control" wire:model="desc">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="name" class="col-3">rate</label>
                                <div class="col-9">
                                    <input type="text" class="form-control" wire:model="rate">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="name" class="col-3">price</label>
                                <div class="col-9">
                                    <input type="text" class="form-control" wire:model="price">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="name" class="col-3">price after discount</label>
                                <div class="col-9">
                                    <input type="text" class="form-control" wire:model="price_after_discount">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="name" class="col-3">image</label>
                                <div class="col-9">
                                    <input type="file" class="form-control" wire:model="image">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="name" class="col-3">sample</label>
                                <div class="col-9">
                                    <input type="file" class="form-control" wire:model="sample">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="name" class="col-3">book</label>
                                <div class="col-9">
                                    <input type="file" class="form-control" wire:model="book">
                                </div>
                            </div>

                            <div class="row">
                                    <h3 class="form-control">units</h3>
                                <div class="col-md-5">
                                    <label for="">unit name</label>
                                    <input type="text" class="form-control" wire:model="unit_name.0">
                                </div>
                                <div class="col-md-5">
                                    <label for="">unit image</label>
                                    <input type="file" class="form-control" wire:model="unit_image.0">
                                </div>
                                
                                <div class="col-md-2">
                                    <br>
                                    <button class="btn text-white btn-info btn-sm" wire:click.prevent="adds({{$v}})"> <i class="fa fa-plus"></i></button>
                                </div>

                            </div>

                            @foreach($items as $key => $values)
                                <div class="row">
                                    
                                    <div class="col-md-5">
                                        <label for="">unit name</label>
                                        <input type="text" class="form-control" wire:model="unit_name.{{$values}}">
                                    </div>
                                    <div class="col-md-5">
                                        <label for="">unit upload</label>
                                        <input type="file" class="form-control" wire:model="unit_image.{{$values}}">
                                    </div>
                                    
                                    <div class="col-md-2">
                                        <br>
                                        <button class="btn btn-danger btn-sm" wire:click.prevent="removes({{$key}})"> <i class="fa fa-trash"></i></button>
                                    </div>
                                </div>
                            @endforeach
                            <hr>


                            <div class="row">

                                <div class="col-md-5">
                                    <label for="">text</label>
                                    <input type="text" class="form-control" wire:model="text.0">
                                </div>
                                <div class="col-md-5">
                                    <label for="">value</label>
                                    <input type="text" class="form-control" wire:model="val.0">
                                </div>
                                
                                <div class="col-md-2">
                                    <br>
                                    <button class="btn text-white btn-info btn-sm" wire:click.prevent="add({{$i}})"> <i class="fa fa-plus"></i></button>
                                </div>

                            </div>
                            
                            
                    
                            @foreach($inputs as $key => $value)
                                <div class="row">
                                    
                                    <div class="col-md-5">
                                        <label for="">text</label>
                                        <input type="text" class="form-control" wire:model="text.{{$value}}">
                                    </div>
                                    <div class="col-md-5">
                                        <label for="">value</label>
                                        <input type="text" class="form-control" wire:model="val.{{$value}}">
                                    </div>
                                    
                                    <div class="col-md-2">
                                        <br>
                                        <button class="btn btn-danger btn-sm" wire:click.prevent="remove({{$key}})"> <i class="fa fa-trash"></i></button>
                                    </div>
                                </div>
                            @endforeach
                            

                            <div class="form-group row">
                                <label for="" class="col-3"></label>
                                <div class="col-9">
                                    <button type="submit" id="plus" class="btn btn-sm btn-primary">submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div wire:ignore.self class="modal fade" id="editBookModal" tabindex="-1" data-backdrop="static" data-keyboard="false" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">edit book</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" wire:click="close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <form wire:submit.prevent="editBookData">
                        
                            
                            <div class="form-group row">
                                <label for="name" class="col-3">name</label>
                                <div class="col-9">
                                    <input type="text" class="form-control" wire:model="name">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="name" class="col-3">category</label>
                                <div class="col-9">
                                <select wire:model="book_category_id" class="form-control" id="">
                                        <option selected>--</option>
                                        @php $category = App\Models\BookCategory::latest()->get(); @endphp
                                        @foreach($category as $cat)
                                            <option value="{{$cat->id}}">{{$cat->name}}</option>
                                        @endforeach
                                </select>
                                </div>
                            </div>
                        

                            <div class="form-group row">
                                <label for="name" class="col-3">description</label>
                                <div class="col-9">
                                    <input type="text" class="form-control" wire:model="desc">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="name" class="col-3">rate</label>
                                <div class="col-9">
                                    <input type="text" class="form-control" wire:model="rate">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="name" class="col-3">price</label>
                                <div class="col-9">
                                    <input type="text" class="form-control" wire:model="price">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="name" class="col-3">price after discount</label>
                                <div class="col-9">
                                    <input type="text" class="form-control" wire:model="price_after_discount">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="name" class="col-3">image</label>
                                <div class="col-9">
                                    <input type="file" class="form-control" wire:model="image">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="name" class="col-3">sample</label>
                                <div class="col-9">
                                    <input type="file" class="form-control" wire:model="sample">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="name" class="col-3">book</label>
                                <div class="col-9">
                                    <input type="file" class="form-control" wire:model="book">
                                </div>
                            </div>

                            @php $units = App\Models\BookUnit::where('book_id', $book_edit_id)->get(); @endphp
                                @foreach($units as $keys=> $unit)
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="">unit name</label>
                                            <input type="text" class="form-control" wire:model="unit_name.{{$keys}}">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="">val</label>
                                            <input type="file" class="form-control"  wire:model="unit_image.{{$keys}}">
                                        </div>
                                        
                                    
                                        
                                    </div>
                                @endforeach
                                <hr>

                            @php $details = App\Models\BookDetail::where('book_id', $book_edit_id)->get(); @endphp
                                @foreach($details as $key=> $detail)
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="">text</label>
                                            <input type="text" class="form-control" wire:model="text.{{$key}}">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="">val</label>
                                            <input type="text" class="form-control"  wire:model="val.{{$key}}">
                                        </div>
                                        
                                    
                                        
                                    </div>
                                @endforeach

                            


                            <div class="form-group row">
                                <label for="" class="col-3"></label>
                                <div class="col-9">
                                    <button type="submit" class="btn btn-sm btn-primary">update</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div> 

        

        <div wire:ignore.self class="modal fade" id="deleteBookModal" tabindex="-1" data-backdrop="static" data-keyboard="false" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">confirm delete</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body pt-4 pb-4">
                        <h6>Do you really to delete ?</h6>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-sm btn-primary" wire:click="cancel()" data-dismiss="modal" aria-label="Close">close</button>
                        <button class="btn btn-sm btn-danger" wire:click="deleteBookData()">yes ! delete</button>
                    </div>
                </div>
            </div>
        </div>

</div>

@push('scripts')
    <script>
        window.addEventListener('close-modal', event =>{
            $('#addModal').modal('hide');
            $('#editBookModal').modal('hide');
            $('#deleteBookModal').modal('hide');
        });
        window.addEventListener('show-edit-Book-modal', event =>{
            $('#editBookModal').modal('show');
        });

        window.addEventListener('show-delete-confirmation-modal', event =>{
            $('#deleteBookModal').modal('show');
        });

     
    
    </script>
@endpush



