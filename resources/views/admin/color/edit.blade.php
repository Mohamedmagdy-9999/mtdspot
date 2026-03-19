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
                                    <h1 class="page-title">{{trans('main.dashboard')}}</h1>
                                </div>
                                <div class="ms-auto pageheader-btn">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="javascript:void(0);">{{trans('main.edit_color')}} {{$color->name}}</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">{{trans('main.dashboard')}}</li>
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

                                            @if (session('error'))
                                                <div class="alert alert-danger">{{ session('error') }}</div>
                                            @endif

                                                <form action="{{route('admin.color.update', $color->id)}}" method="POST" enctype="multipart/form-data">
                                                    @method('PUT')
                                                    @csrf
                                                    
                                                   

                                                    <div class="form-group-row">
                                                        <label for="name">{{trans('main.name')}}</label>
                                                        
                                                        <input type="text" class="form-control" name="name" value="{{$color->name}}">
                                                        @if($errors->has('name'))
                                                            <div class="error">{{ $errors->first('name') }}</div>
                                                        @endif
                                                        
                                                    </div>

                                                    <div class="form-group-row">
                                                        <label for="name">{{trans('main.color')}}</label>
                                                        
                                                        <input type="color" class="form-control" name="color" value="{{$color->color}}">
                                                        @if($errors->has('color'))
                                                            <div class="error">{{ $errors->first('color') }}</div>
                                                        @endif
                                                        
                                                    </div>

                                                  
                                                    
                                                  
                                                <div class="form-group row">
                                                    <label for="" class="col-3"></label>
                                                    <div class="col-9">
                                                        <button type="submit" id="plus" class="btn btn-sm btn-primary">{{trans('main.update')}}</button>
                                                    </div>
                                                </div>

                                                </form>
                                                
                                                <br>
                                                @if (session()->has('message'))
                                                    <div class="alert alert-success text-center">{{ session('message') }}</div>
                                                @endif

                                                @if (session('error'))
                                                    <div class="alert alert-danger">{{ session('error') }}</div>
                                                @endif
                        
                                                
                        
                                               
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



@endpush 
		

        
      
