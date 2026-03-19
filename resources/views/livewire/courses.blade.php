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
                                                        <th class="wd-15p border-bottom-0">title</th>
                                                        <th class="wd-15p border-bottom-0">sub title</th>
                                                       
                                                        <th class="wd-15p border-bottom-0">image</th>>
                                                        <th class="wd-15p border-bottom-0">action</th>
                                                        
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    
                                                        @if ($courses->count() > 0)
                                                            @foreach ($courses as $course)
                                                                <tr>
                                                                
                                                                    <td>{{ $course->title}}</td>
                                                                    <td>{{ $course->sub_title}}</td>
                                                                   
                                                                    
                                                                    <td>
                                                                        <img src="{{ asset('storage/courses/' . $course->image) }}" style="width:150px;">
                                                                    </td>
                                                                    
                                                                
                                                                    <td style="text-align: center;">
                                                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editCourseModal" wire:click="editCourse({{ $course->id }})">
                                                                            edit
                                                                        </button> 

                                                                        
                                                                        
                                                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#deleteCourseModal" wire:click="deleteConfirmation({{ $course->id }})">
                                                                                delete
                                                                            </button>
                                                                        
                                                                       
                                                                       
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        @else
                                                            <tr>
                                                                <td colspan="4" style="text-align: center;"><small>No course  Found</small></td>
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
                    <h5 class="modal-title">add course</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" wire:click="close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <form wire:submit.prevent="storeCourseData">
                        

                        
                        <div class="form-group row">
                            <label for="name" class="col-3">title</label>
                            <div class="col-9">
                                <input type="text" class="form-control" wire:model="title">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-3">sub title</label>
                            <div class="col-9">
                                <input type="text" class="form-control" wire:model="sub_title">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="name" class="col-3">description</label>
                            <div class="col-9">
                                <textarea wire:model="desc" class="form-control ckeditor"></textarea>
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
                            <label for="name" class="col-3">video link</label>
                            <div class="col-9">
                                <input type="text" class="form-control" wire:model="video">
                            </div>
                        </div>
                       
                        
                        
                 
                        
                        

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

  <div wire:ignore.self class="modal fade" id="editCourseModal" tabindex="-1" data-backdrop="static" data-keyboard="false" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">edit course</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" wire:click="close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <form wire:submit.prevent="editCourseData">
                       
                        
                        <div class="form-group row">
                            <label for="name" class="col-3">title</label>
                            <div class="col-9">
                                <input type="text" class="form-control" wire:model="title">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-3">sub title</label>
                            <div class="col-9">
                                <input type="text" class="form-control" wire:model="sub_title">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="name" class="col-3">description</label>
                            <div class="col-9">
                                <textarea wire:model="desc" class="form-control ckeditor"></textarea>
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
                            <label for="name" class="col-3">video link</label>
                            <div class="col-9">
                                <input type="text" class="form-control" wire:model="video">
                            </div>
                        </div>
                        

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

    

    <div wire:ignore.self class="modal fade" id="deleteCourseModal" tabindex="-1" data-backdrop="static" data-keyboard="false" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
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
                    <button class="btn btn-sm btn-danger" wire:click="deleteCourseData()">yes ! delete</button>
                </div>
            </div>
        </div>
    </div>

</div>

@push('scripts')
    <script>
        window.addEventListener('close-modal', event =>{
            $('#addModal').modal('hide');
            $('#editCourseModal').modal('hide');
            $('#deleteCourseModal').modal('hide');
        });
        window.addEventListener('show-edit-Course-modal', event =>{
            $('#editCourseModal').modal('show');
        });

        window.addEventListener('show-view-details-modal', event =>{
            $('#viewDetailsModal').modal('show');
        });
        window.addEventListener('show-delete-confirmation-modal', event =>{
            $('#deleteCourseModal').modal('show');
        });

     
    
    </script>
@endpush



