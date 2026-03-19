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
                                                        <th class="wd-15p border-bottom-0">image</th>
                                                        <th class="wd-15p border-bottom-0">text</th>
                                                        <th class="wd-15p border-bottom-0">action</th>
                                                        
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    
                                                        @if ($sliders->count() > 0)
                                                            @foreach ($sliders as $slider)
                                                                <tr>
                                                                
                                                                   
                                                                    <td>
                                                                        <img src="{{asset('storage/sliders/' . $slider->image)}}" alt="" style="width:50%">
                                                                    </td>
                                                                    <td>{{$slider->text}}</td>
                                                                   
                                                                    <td style="text-align: center;">
                                                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editSliderModal" wire:click="editSlider({{ $slider->id }})">
                                                                           edit
                                                                        </button>

                                                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#deleteSliderModal" wire:click="deleteConfirmation({{ $slider->id }})">
                                                                            delete
                                                                        </button>
                                                                       
                                                                       
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        @else
                                                            <tr>
                                                                <td colspan="4" style="text-align: center;"><small>no data found</small></td>
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
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                   
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" wire:click="close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <form wire:submit.prevent="storeSliderData">
                        

                        <div class="form-group row">
                            <label for="name" class="col-3">image</label>
                            <div class="col-9">
                                <input type="file"  class="form-control" wire:model="image">
                                @error('image')
                                    <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="name" class="col-3">text</label>
                            <div class="col-9">
                                <input type="text"  class="form-control" wire:model="text">
                                @error('text')
                                    <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                     

                        <div class="form-group row">
                            <label for="" class="col-3"></label>
                            <div class="col-9">
                                <button type="submit" class="btn btn-sm btn-primary">save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div wire:ignore.self class="modal fade" id="editSliderModal" tabindex="-1" data-backdrop="static" data-keyboard="false" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" wire:click="close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <form wire:submit.prevent="editSliderData">
                       
         

                        <div class="form-group row">
                            <label for="name" class="col-3">image</label>
                            <div class="col-9">
                                <input type="file"  class="form-control" wire:model="image">
                                @error('image')
                                    <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="name" class="col-3">text</label>
                            <div class="col-9">
                                <input type="text"  class="form-control" wire:model="text">
                                @error('text')
                                    <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span>
                                @enderror
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

    <div wire:ignore.self class="modal fade" id="deleteSliderModal" tabindex="-1" data-backdrop="static" data-keyboard="false" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
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
                    <button class="btn btn-sm btn-danger" wire:click="deleteSliderData()">yes ! delete</button>
                </div>
            </div>
        </div>
    </div>

</div>

@push('scripts')
    <script>
        window.addEventListener('close-modal', event =>{
            $('#addModal').modal('hide');
            $('#editSliderModal').modal('hide');
            $('#deleteSliderModal').modal('hide');
        });
        window.addEventListener('show-edit-Slider-modal', event =>{
            $('#editSliderModal').modal('show');
        });
        window.addEventListener('show-delete-confirmation-modal', event =>{
            $('#deleteSliderModal').modal('show');
        });
    
    </script>




@endpush




