@extends('supplier.layout')
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
                                        <li class="breadcrumb-item"><a href="javascript:void(0);">{{trans('main.orders')}}</a></li>
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
                                                                                <th class="wd-15p border-bottom-0">{{trans('main.code')}}</th>
                                                                                <th class="wd-15p border-bottom-0">{{trans('main.stock')}}</th>
                                                                                <th class="wd-15p border-bottom-0">{{trans('main.color')}}</th>
                                                                                <th class="wd-15p border-bottom-0">{{trans('main.action')}}</th>
                                                                              
                                                                                
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            
                                                                               
                                                                                    @foreach ($orders as $key=> $order)
                                                                                      <tr>
                                                                                            <td>{{$key+1}}</td>
                                                                                            <td>{{ $order->product_name}}</td>
                                                                                            
                                                                                            <td>{{ $order->quantity}}</td>

                                                                                            <td>
                                                                                                {{$order->product_code}}
                                                                                            </td>
                                                                                            <td>
                                                                                                {{$order->product_stock}}
                                                                                            </td>
                                                                                            <td>
                                                                                                {{$order->color_name}}
                                                                                            </td>
                                                                                            <td>
                                                                                                <form action="{{ route('supplier.delivered', $order->id) }}"
                                                                                                            onsubmit="return confirm('are you sure')"
                                                                                                            method="post">
                                                                                                            @method('PUT')
                                                                                                            
                                                                                                            @csrf
                                                                                                            <button class="btn btn-success">{{trans('main.delivered')}}</button>
                                                                                                </form>
                                                                                            </td>
                                                                                         
                                                                                            
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
		

        
      
