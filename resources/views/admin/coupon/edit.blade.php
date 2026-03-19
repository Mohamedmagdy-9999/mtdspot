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
                                        <li class="breadcrumb-item"><a href="javascript:void(0);">{{trans('main.edit_coupon')}} {{$coupon->code}}</a></li>
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
                                              
                                                <form action="{{route('admin.coupon.update',$coupon->id)}}" method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    @method('PUT')
                                                    
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <label for="">{{trans('main.code')}}</label>
                                                            <input type="text" name="code" class="form-control" value="{{$coupon->code}}">
                                                            @if($errors->has('code'))
                                                                <div class="error">{{ $errors->first('code') }}</div>
                                                            @endif
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label for="">{{trans('main.value')}}</label>
                                                            <input type="text" name="value" class="form-control" value="{{$coupon->value}}">
                                                            @if($errors->has('value'))
                                                                <div class="error">{{ $errors->first('value') }}</div>
                                                            @endif
                                                        </div>
                                                        
                                                        <div class="col-md-4">
                                                            <label for="">{{trans('main.end_date')}}</label>
                                                            <input type="date" name="end_date" class="form-control" value="{{$coupon->end_date}}">
                                                           
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
         

            
		

        
      
