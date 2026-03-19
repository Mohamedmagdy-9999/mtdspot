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
                                        <li class="breadcrumb-item"><a href="javascript:void(0);">{{trans('main.edit_supplier_data')}} {{$supplier->name}}</a></li>
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
                                                <br>
                                                
                                                <img src="{{asset('suppliers/'.$supplier->image)}}" style="width:300px;" alt="">
                                                    <br>
                                                    <br>
                        
                                                <form action="{{route('admin.supplier.update',$supplier->id)}}" method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    @method('PUT')
                                                    
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <label for="">{{trans('main.name')}}</label>
                                                            <input type="text" name="name" class="form-control" value="{{$supplier->name}}">
                                                            @if($errors->has('name'))
                                                                <div class="error">{{ $errors->first('name') }}</div>
                                                            @endif
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label for="">{{trans('main.email')}}</label>
                                                            <input type="email" name="email" class="form-control" value="{{$supplier->email}}">
                                                            @if($errors->has('email'))
                                                                <div class="error">{{ $errors->first('email') }}</div>
                                                            @endif
                                                        </div>

                                                        <div class="col-md-6">
                                                            <label for="">{{trans('main.phone')}}</label>
                                                            <input type="text" name="phone" class="form-control" value="{{$supplier->phone}}">
                                                            @if($errors->has('phone'))
                                                                <div class="error">{{ $errors->first('phone') }}</div>
                                                            @endif
                                                        </div>

                                                        <div class="col-md-6">
                                                            <label for="">{{trans('main.address')}}</label>
                                                            <input type="text" name="address" class="form-control" value="{{$supplier->address}}">
                                                            @if($errors->has('address'))
                                                                <div class="error">{{ $errors->first('address') }}</div>
                                                            @endif
                                                        </div>

                                                        <div class="col-md-6">
                                                            <label for="">code</label>
                                                            <input type="text" name="code" class="form-control" value="{{$supplier->code}}">
                                                            @if($errors->has('code'))
                                                                <div class="error">{{ $errors->first('code') }}</div>
                                                            @endif
                                                        </div>

                                                        <div class="col-md-6">
                                                            <label for="">sheet name</label>
                                                            <input type="text" name="sheet_name" class="form-control" value="{{$supplier->sheet_name}}">
                                                            @if($errors->has('sheet_name'))
                                                                <div class="error">{{ $errors->first('sheet_name') }}</div>
                                                            @endif
                                                        </div>

                                                         <div class="col-md-6">
                                                            <label for="">{{trans('main.image')}}</label>
                                                            <input type="file" name="image" class="form-control">
                                                            @if($errors->has('image'))
                                                                <div class="error">{{ $errors->first('image') }}</div>
                                                            @endif
                                                        </div>

                                                        <div class="col-md-6">
                                                            <label for="">{{trans('main.status')}}</label>
                                                            <select name="status" class="form-control" id="">
                                                                <option value="0" {{$supplier->status == 0 ? 'selected' : ''}}>{{trans('main.active')}}</option>
                                                                <option value="1" {{$supplier->status == 1 ? 'selected' : ''}}>{{trans('main.not_active')}}</option>
                                                            </select>
                                                            @if($errors->has('status'))
                                                                <div class="error">{{ $errors->first('status') }}</div>
                                                            @endif
                                                        </div>

                                                        <div class="col-md-6">
                                                            <label for="">password</label>
                                                            <input type="text" name="password" class="form-control" >
                                                          
                                                        </div>
                                                    </div>
                                                            
                                        
                                                                
                                                                
                                    
                                                    <div class="form-group row">
                                                        <label for="" class="col-3"></label>
                                                        <div class="col-9">
                                                            <button type="submit" id="plus" class="btn btn-sm btn-primary">{{trans('main.update')}}</button>
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
                    <!-- CONTAINER CLOSED -->
            
@endsection
         

            
		

        
      
