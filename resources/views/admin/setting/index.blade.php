@extends('admin.layout')
@section('content')
		

              

                <!--app-content open-->
                <div class="app-content main-content mt-0">
                    <div class="side-app">

                        <!-- CONTAINER -->
                        <div class="main-container container-fluid">

                                
                            <!-- PAGE-HEADER -->
                            <div class="page-header">
                                <div>
                                    <h1 class="page-title">Dashboard</h1>
                                </div>
                                <div class="ms-auto pageheader-btn">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="javascript:void(0);">Settings</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                                    </ol>
                                </div>
                            </div>
                            <!-- PAGE-HEADER END -->

                            <!-- ROW-1 -->
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
                                                                <img src="{{asset('admin/setting/' . $setting->logo)}}" alt="" style="width:150px;">
                                                                <br>
                                                                <form action="{{route('admin.update_setting', $setting->id)}}" method="POST" enctype="multipart/form-data">
                                                                    @method('PUT')
                                                                    @csrf
                                                                    
                                               
                                                                    <div class="form-group row">
                                                                        <label for="name" class="col-3">name</label>
                                                                        <div class="col-9">
                                                                            <input type="text"  class="form-control" name="name" value="{{$setting->name}}">
                                                                            @error('name')
                                                                                <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span>
                                                                            @enderror
                                                                        </div>
                                                                    </div>
                        
                                                                    <div class="form-group row">
                                                                        <label for="name" class="col-3">email</label>
                                                                        <div class="col-9">
                                                                            <input type="email" class="form-control" name="email" value="{{$setting->email}}">
                                                                            @error('email')
                                                                                <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span>
                                                                            @enderror
                                                                        </div>
                                                                    </div>
                        
                                                                    <div class="form-group row">
                                                                        <label for="name" class="col-3">phone</label>
                                                                        <div class="col-9">
                                                                            <input type="number" class="form-control" name="phone" value="{{$setting->phone}}">
                                                                            @error('phone')
                                                                                <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span>
                                                                            @enderror
                                                                        </div>
                                                                    </div>

                                                                    {{-- <div class="form-group row">
                                                                        <label for="name" class="col-3">whtasapp</label>
                                                                        <div class="col-9">
                                                                            <input type="number" class="form-control" name="whtasapp" value="{{$setting->whtasapp}}">
                                                                            @error('whtasapp')
                                                                                <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span>
                                                                            @enderror
                                                                        </div>
                                                                    </div> --}}


                                                                    {{-- <div class="form-group row">
                                                                        <label for="name" class="col-3">address</label>
                                                                        <div class="col-9">
                                                                            <input type="text" class="form-control" name="address" value="{{$setting->address}}">
                                                                            @error('address')
                                                                                <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span>
                                                                            @enderror
                                                                        </div>
                                                                    </div> --}}

                        
                                                                    <div class="form-group row">
                                                                        <label for="name" class="col-3">facebook</label>
                                                                        <div class="col-9">
                                                                            <input type="text"  class="form-control" name="facebook" value="{{$setting->facebook}}">
                                                                            @error('facebook')
                                                                                <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span>
                                                                            @enderror
                                                                        </div>
                                                                    </div>
                        
                                                                    
                        
                                                                    <div class="form-group row">
                                                                        <label for="name" class="col-3">instagram</label>
                                                                        <div class="col-9">
                                                                            <input type="text"  class="form-control" name="instagram" value="{{$setting->instagram}}">
                                                                            @error('instagram')
                                                                                <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span>
                                                                            @enderror
                                                                        </div>
                                                                    </div>
                        
                                                                    <div class="form-group row">
                                                                        <label for="name" class="col-3">telegram</label>
                                                                        <div class="col-9">
                                                                            <input type="text"  class="form-control" name="telegram" value="{{$setting->telegram}}">
                                                                            @error('telegram')
                                                                                <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span>
                                                                            @enderror
                                                                        </div>
                                                                    </div>
                        
                                                                    <div class="form-group row">
                                                                        <label for="name" class="col-3">keyword</label>
                                                                        <div class="col-9">
                                                                            <input type="text"  class="form-control" name="keyword" value="{{$setting->keyword}}">
                                                                            @error('keyword')
                                                                                <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span>
                                                                            @enderror
                                                                        </div>
                                                                    </div>
                        
                                                                    <div class="form-group row">
                                                                        <label for="name" class="col-3">logo</label>
                                                                        <div class="col-9">
                                                                            <input type="file"  class="form-control" name="logo">
                                                                            @error('logo')
                                                                                <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span>
                                                                            @enderror
                                                                        </div>
                                                                    </div>
                        
                        
                                                                    <div class="form-group row">
                                                                        <label for="name" class="col-3">policy</label>
                                                                        <div class="col-9">
                                                                            
                                                                            <textarea name="policy" class="form-control ckeditor">
                                                                                {{$setting->policy}}
                                                                            </textarea>
                                                                           
                                                                           
                                                                        </div>
                                                                    </div>
                        
                                                                    <div  class="form-group row">
                                                                        <label for="name" class="col-3">sales terms</label>
                                                                        <div class="col-9">
                                                                            <textarea name="sales_terms" class="form-control ckeditor">
                                                                                {{$setting->sales_terms}}
                                                                            </textarea>

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
                          

                            
                        </div>
                    </div>
                </div>
                    <!-- CONTAINER CLOSED -->
            
@endsection
         
@push('scripts')

<script src="//cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('.ckeditor').ckeditor();
    });

</script>







@endpush

            
		

        
      
