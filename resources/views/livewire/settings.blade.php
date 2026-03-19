<div>
    <div class="container mt-5">
        <div class="row mb-5">
            
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    
                    <div class="card-body">
                        

                       
                        @if (session()->has('message'))
                            <div class="alert alert-success text-center">{{ session('message') }}</div>
                        @endif

                        
                        <div class="row">
                            <div class="col-lg-12 col-sm-12 col-md-6 col-xl-12">
                                <div class="card overflow-hidden">
                                    <div class="card-body">
                                        <img src="{{asset('storage/setting/' . $setting->logo)}}" alt="" style="width:150px;">
                                        <br>
                                        <form wire:submit.prevent="update">
                       
                                            <div class="form-group row">
                                                <label for="name" class="col-3">name</label>
                                                <div class="col-9">
                                                    <input type="text"  class="form-control" wire:model="name">
                                                    @error('name')
                                                        <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="name" class="col-3">email</label>
                                                <div class="col-9">
                                                    <input type="email" class="form-control" wire:model="email">
                                                    @error('email')
                                                        <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="name" class="col-3">phone</label>
                                                <div class="col-9">
                                                    <input type="text" class="form-control" wire:model="phone">
                                                    @error('phone')
                                                        <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="name" class="col-3">whatsapp</label>
                                                <div class="col-9">
                                                    <input type="text" class="form-control" wire:model="whatsapp">
                                                    @error('whatsapp')
                                                        <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="name" class="col-3">address</label>
                                                <div class="col-9">
                                                    <input type="text" class="form-control" wire:model="address">
                                                    @error('address')
                                                        <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="name" class="col-3">facebook</label>
                                                <div class="col-9">
                                                    <input type="text"  class="form-control" wire:model="facebook">
                                                    @error('facebook')
                                                        <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="name" class="col-3">twitter</label>
                                                <div class="col-9">
                                                    <input type="text"  class="form-control" wire:model="twitter">
                                                    @error('twitter')
                                                        <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="name" class="col-3">instagram</label>
                                                <div class="col-9">
                                                    <input type="text"  class="form-control" wire:model="instagram">
                                                    @error('instagram')
                                                        <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="name" class="col-3">telegram</label>
                                                <div class="col-9">
                                                    <input type="text"  class="form-control" wire:model="telegram">
                                                    @error('telegram')
                                                        <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="name" class="col-3">keyword</label>
                                                <div class="col-9">
                                                    <input type="text"  class="form-control" wire:model="keyword">
                                                    @error('keyword')
                                                        <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="name" class="col-3">logo</label>
                                                <div class="col-9">
                                                    <input type="file"  class="form-control" wire:model="logo">
                                                    @error('logo')
                                                        <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>


                                            <div wire:ignore class="form-group row">
                                                <label for="name" class="col-3">policy</label>
                                                <div class="col-9">
                                                    <textarea wire:model="policy"
                                                    class="min-h-fit"
                                                    name="policy"
                                                    id="policy"></textarea>
                                                    @error('policy')
                                                        <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div wire:ignore class="form-group row">
                                                <label for="name" class="col-3">sales terms</label>
                                                <div class="col-9">
                                                    <textarea wire:model="sales_terms"
                                                    class="min-h-fit h-48 "
                                                    name="sales_terms"
                                                    id="sales_terms"></textarea>
                                                    @error('sales_terms')
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

                       
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    

   

   
</div>

@push('scripts')



  

    <script src="https://cdn.ckeditor.com/ckeditor5/27.1.0/classic/ckeditor.js"></script>

    <script>
        ClassicEditor
            .create(document.querySelector('#policy'))
            .then(editor => {
                editor.model.document.on('change:data', () => {
                @this.set('policy', editor.getData());
                })
            })
            // .catch(error => {
            //     console.error(error);
            // });
    </script>

<script>
    ClassicEditor
        .create(document.querySelector('#sales_terms'))
        .then(editor => {
            editor.model.document.on('change:data', () => {
            @this.set('sales_terms', editor.getData());
            })
        })
        // .catch(error => {
        //     console.error(error);
        // });
</script>






@endpush




