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
                                        <li class="breadcrumb-item"><a href="javascript:void(0);">{{trans('main.details')}}</a></li>
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
                                                

                                               <h3>{{trans('main.address')}}  : {{$order->address->governorate_name}} - {{$order->address->city_name}} - {{$order->address->address}} - {{$order->address->building_no}} - {{$order->address->floor_no}} - {{$order->address->flat_no}}</h3>
                        
                                                <div class="row">
                                                    <div class="col-lg-12 col-sm-12 col-md-6 col-xl-12">
                                                        <div class="card overflow-hidden">
                                                            <div class="card-body">
                                                                <div class="table-responsive export-table">
                                                                    <table  id="file-datatable" class="table table-bordered text-nowrap key-buttons border-bottom  w-100">
                                                                        <thead>
                                                                            <tr>
                                                                                <th class="wd-15p border-bottom-0">#</th>
                                                                                <th class="wd-15p border-bottom-0">{{trans('main.product')}}</th>
                                                                                <th class="wd-15p border-bottom-0">{{trans('main.quantity')}}</th>
                                                                                <th class="wd-15p border-bottom-0">{{trans('main.price')}}</th>
                                                                                <th class="wd-15p border-bottom-0">{{trans('main.category')}}</th>
                                                                                <th class="wd-15p border-bottom-0">{{trans('main.supplier')}}</th>
                                                                                
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            
                                                                               
                                                                                    @foreach ($order->details as $key=> $detail)
                                                                                      <tr>
                                                                                            <td>{{$key+1}}</td>
                                                                                            
                                                                                            @if(app()->isLocale('ar'))
                                                                                                <td>{{ $detail->product->name_ar ?? ''}}</td>
                                                                                            @else
                                                                                                <td>{{ $detail->product->name_en ?? ''}}</td>
                                                                                            @endif
                                                                                            
                                                                                            <td>
                                                                                                <input type="text" name="quantity" class="form-control" value="{{ $detail->quantity}}">
                                                                                                
                                                                                            </td>

                                                                                            <td>{{ $detail->price}}</td>

                                                                                            @if(app()->isLocale('ar'))
                                                                                                <td>{{ $detail->category->name_ar ?? ''}}</td>
                                                                                            @else
                                                                                                <td>{{ $detail->category->name_en ?? ''}}</td>
                                                                                            @endif
                                                                                            <td>{{ $detail->supplier->name ?? ''}}</td>
                                                                                         
                                                                                          
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
         

                    
@push('scripts')



@endpush 
		

        
      
