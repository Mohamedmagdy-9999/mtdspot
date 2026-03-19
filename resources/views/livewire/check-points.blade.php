<div>
    <div class="container mt-5">
        <div class="row mb-5">
            
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    
                    <div class="card-body">
                        
                        @if ($checks->count() == 0)
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">
                                add
                            </button>
                        @endif
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
                                                        
                                                        <th class="wd-15p border-bottom-0">content</th>
                                                        <th class="wd-15p border-bottom-0">action</th>
                                                        
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    
                                                        @if ($checks->count() > 0)
                                                            @foreach ($checks as $check)
                                                                <tr>
                                                                
                                                                   
                                                                    
                                                                    <td>{!! Str::limit($check->content, 100, ' ...') !!}</td>
                                                                   
                                                                    <td style="text-align: center;">
                                                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editCheckModal" wire:click="editCheck({{ $check->id }})">
                                                                           edit
                                                                        </button>

                                                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#deleteCheckModal" wire:click="deleteConfirmation({{ $check->id }})">
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

                    <form wire:submit.prevent="storeCheckData">
                        

                        <div class="form-group row">
                            <label for="name" class="col-3">text</label>
                            <div class="col-9">
                                <textarea class="form-control" rows="6" cols="200" wire:model="content"></textarea>
                                @error('content')
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

    <div wire:ignore.self class="modal fade" id="editCheckModal" tabindex="-1" data-backdrop="static" data-keyboard="false" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" wire:click="close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <form wire:submit.prevent="editCheckData">
                       
         

                        <div class="form-group row">
                            <label for="name" class="col-3">text</label>
                            <div class="col-9">
                                <textarea class="form-control" rows="6" cols="200" wire:model="content"></textarea>
                                @error('content')
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

    <div wire:ignore.self class="modal fade" id="deleteCheckModal" tabindex="-1" data-backdrop="static" data-keyboard="false" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
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
                    <button class="btn btn-sm btn-danger" wire:click="deleteCheckData()">yes ! delete</button>
                </div>
            </div>
        </div>
    </div>

</div>

@push('scripts')
    <script>
        window.addEventListener('close-modal', event =>{
            $('#addModal').modal('hide');
            $('#editCheckModal').modal('hide');
            $('#deleteCheckModal').modal('hide');
        });
        window.addEventListener('show-edit-Check-modal', event =>{
            $('#editCheckModal').modal('show');
        });
        window.addEventListener('show-delete-confirmation-modal', event =>{
            $('#deleteCheckModal').modal('show');
        });
    
    </script>




@endpush




