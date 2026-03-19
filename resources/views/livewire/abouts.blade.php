<div>
    <div class="container mt-5">
        <div class="row mb-5">
            
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    
                    <div class="card-body">
                        

                        @if ($abouts->count() == 0)
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
                                                        <th class="wd-15p border-bottom-0">image</th>
                                                        <th class="wd-15p border-bottom-0">content</th>
                                                        <th class="wd-15p border-bottom-0">action</th>
                                                        
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    
                                                        @if ($abouts->count() > 0)
                                                            @foreach ($abouts as $about)
                                                                <tr>
                                                                
                                                                   
                                                                    <td>
                                                                        <img src="{{asset('storage/about/' . $about->image)}}" alt="" style="width:50%">
                                                                    </td>
                                                                    <td>{!! Str::limit($about->content, 100, ' ...') !!}</td>
                                                                   
                                                                    <td style="text-align: center;">
                                                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editAboutModal" wire:click="editAbout({{ $about->id }})">
                                                                           edit
                                                                        </button>

                                                                        {{-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#deleteAboutModal" wire:click="deleteConfirmation({{ $about->id }})">
                                                                            delete
                                                                        </button> --}}
                                                                       
                                                                       
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
    

    <div wire:ignore.self class="modal fade" id="editAboutModal" tabindex="-1" data-backdrop="static" data-keyboard="false" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" wire:click="close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <form wire:submit.prevent="editAboutData">
                       
                        <div wire:ignore class="form-group row">
                            <label for="name" class="col-3">content</label>
                            <div class="col-9">
                                <textarea wire:model="content"
                                class="min-h-fit h-48 "
                                name="content"
                                id="content"></textarea>
                                @error('content')
                                    <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

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

    <div wire:ignore.self class="modal fade" id="deleteAboutModal" tabindex="-1" data-backdrop="static" data-keyboard="false" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
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
                    <button class="btn btn-sm btn-danger" wire:click="deleteAboutData()">yes ! delete</button>
                </div>
            </div>
        </div>
    </div>

</div>

@push('scripts')

{{-- <script src="{{asset('admin/assets/plugins/wysiwyag/jquery.richtext.js')}}"></script>
<script src="{{asset('admin/assets/plugins/wysiwyag/wysiwyag.js')}}"></script>

<!-- FORMEDITOR JS -->
<script src="{{asset('admin/assets/plugins/quill/quill.min.js')}}"></script>
<script src="{{asset('admin/assets/js/form-editor2.js')}}"></script> --}}

{{-- <script src="//cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script>
    <script>
        $(document).ready(function() {
            $('.ckeditor').ckeditor();
        });
    
    </script> --}}

    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/trix/1.3.1/trix.min.js"></script> --}}

    <script src="https://cdn.tailwindcss.com"></script>

    <script src="https://cdn.ckeditor.com/ckeditor5/27.1.0/classic/ckeditor.js"></script>

    <script>
        ClassicEditor
            .create(document.querySelector('#content'))
            .then(editor => {
                editor.model.document.on('change:data', () => {
                @this.set('content', editor.getData());
                })
            })
            .catch(error => {
                console.error(error);
            });
    </script>


    <script>
        window.addEventListener('close-modal', event =>{
            $('#addModal').modal('hide');
            $('#editAboutModal').modal('hide');
            $('#deleteAboutModal').modal('hide');
        });
        window.addEventListener('show-edit-About-modal', event =>{
            $('#editAboutModal').modal('show');
        });
        window.addEventListener('show-delete-confirmation-modal', event =>{
            $('#deleteAboutModal').modal('show');
        });
    
    </script>




@endpush




