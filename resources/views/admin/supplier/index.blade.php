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
                                        <li class="breadcrumb-item"><a href="javascript:void(0);">{{trans('main.suppliers_data')}}</a></li>
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
                        
                                                <form action="{{route('admin.supplier.store')}}" method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <label for="">{{trans('main.name')}}</label>
                                                            <input type="text" name="name" class="form-control" value="{{old('name')}}">
                                                            @if($errors->has('name'))
                                                                <div class="error">{{ $errors->first('name') }}</div>
                                                            @endif
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label for="">{{trans('main.email')}}</label>
                                                            <input type="email" name="email" class="form-control" value="{{old('email')}}">
                                                            @if($errors->has('email'))
                                                                <div class="error">{{ $errors->first('email') }}</div>
                                                            @endif
                                                        </div>

                                                        <div class="col-md-4">
                                                            <label for="">{{trans('main.phone')}}</label>
                                                            <input type="text" name="phone" class="form-control" value="{{old('phone')}}">
                                                            @if($errors->has('phone'))
                                                                <div class="error">{{ $errors->first('phone') }}</div>
                                                            @endif
                                                        </div>

                                                        <div class="col-md-4">
                                                            <label for="">{{trans('main.address')}}</label>
                                                            <input type="text" name="address" class="form-control" value="{{old('address')}}">
                                                            @if($errors->has('address'))
                                                                <div class="error">{{ $errors->first('address') }}</div>
                                                            @endif
                                                        </div>

                                                        <div class="col-md-4">
                                                            <label for="">code</label>
                                                            <input type="text" name="code" class="form-control" value="{{old('code')}}">
                                                            @if($errors->has('code'))
                                                                <div class="error">{{ $errors->first('code') }}</div>
                                                            @endif
                                                        </div>

                                                        <div class="col-md-4">
                                                            <label for="">sheet name</label>
                                                            <input type="text" name="sheet_name" class="form-control" value="{{old('sheet_name')}}">
                                                            @if($errors->has('sheet_name'))
                                                                <div class="error">{{ $errors->first('sheet_name') }}</div>
                                                            @endif
                                                        </div>

                                                         <div class="col-md-4">
                                                            <label for="">{{trans('main.image')}}</label>
                                                            <input type="file" name="image" class="form-control">
                                                            @if($errors->has('image'))
                                                                <div class="error">{{ $errors->first('image') }}</div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                            
                                        
                                                                
                                                                
                                    
                                                    <div class="form-group row">
                                                        <label for="" class="col-3"></label>
                                                        <div class="col-9">
                                                            <button type="submit" id="plus" class="btn btn-sm btn-primary">{{trans('main.save')}}</button>
                                                        </div>
                                                    </div>

                                                </form>


                                                <br>

                                                <form action="supplier_import_excel" method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    <h3 class="text-center">upload excel</h3>
                                                    <div class="form-group row">
                                                            <label for="name" class="col-3">file</label>
                                                            <div class="col-9">
                                                                <input type="file" id="image"  name="data">
                                                            
                                                            </div>
                                                        </div> 
                                    
                                                    
                                    
                                                        <div class="form-group row">
                                                            <label for="" class="col-3"></label>
                                                            <div class="col-9">
                                                                <button type="submit" class="btn btn-sm btn-primary">update</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                              
                                                
                        
                                                <div class="row">
                                                    <div class="col-lg-12 col-sm-12 col-md-6 col-xl-12">
                                                        <div class="card overflow-hidden">
                                                            <div class="card-body">
                                                                <div class="table-responsive export-table">
                                                                    <table  id="file-datatable" class="table table-bordered text-nowrap key-buttons border-bottom  w-100">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>*</th>
                                                                                
                                                                               
                                                                                <th>code</th>
                                                                                <th>{{trans('main.name')}}</th>
                                                                                <th>{{trans('main.email')}}</th>
                                                                                <th>{{trans('main.phone')}}</th>
                                                                                <th>{{trans('main.status')}}</th>
                                                                                
                                                                                <th>{{trans('main.action')}}</th>
                                                                                <th>{{trans('main.image')}}</th>
                                                                                <th>{{trans('main.address')}}</th>
                                                                                
                                                                                
                                                                                 <th>sheet name</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            
                                                                                
                                                                                    @foreach ($suppliers as $key => $supplier)
                                                                                        <tr>
                                                                                            <td>{{$key+1}}</td>
                                                                                            
                                                                                            <td>{{ $supplier->code}}</td>
                                                                                            <td>{{ $supplier->name}} </td>
                                                                                            <td>{{ $supplier->email}}</td>
                                                                                            <td>{{ $supplier->phone}}</td>
                                                                                            <td>
                                                                                                @if($supplier->status == 0)
                                                                                                    {{trans('main.active')}}
                                                                                                @else
                                                                                                    {{trans('main.not_active')}}
                                                                                                @endif
                                                                                            </td>
                                                                                                <td style="text-align: center;">
                                                                                                                                                                                               
                                                                                                    
                        
                                                                                                    <a href="{{route('admin.supplier.edit',$supplier->id)}}" class="btn btn-success">{{trans('main.edit')}}</a>
                                                                                                    {{-- <form action="{{ route('admin.supplier.destroy', $supplier->id) }}"
                                                                                                        onsubmit="return confirm('are you sure')"
                                                                                                        method="post">
                                                                                                        @method('delete')
                                                                                                        @csrf
                                                                                                        <button class="btn btn-danger">{{trans('main.delete')}}</button>
                                                                                                    </form> --}}
                                                                                                
                                                                                               
                                                                                               
                                                                                                </td>
                                                                                                <td>
                                                                                                    <img src="{{asset('suppliers/' .$supplier->image)}}" style="width:150px;" alt="">
                                                                                                </td>
                                                                                            <td>{{ $supplier->address}}</td>
                                                                                            
                                                                                            
                                                                                            
                                                                                            
                                                                                           

                                                                                                
                                                                                                <td>{{ $supplier->sheet_name}}</td>
                                                                                        </tr>

                                                                                        

                                                                                    @endforeach
                                                                               
                                                                        
                                                            
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
                          

                            
                        </div>
                    </div>
                </div>
                    <!-- CONTAINER CLOSED -->
            
@endsection
         

            
		

        
      
