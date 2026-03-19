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
                                        <li class="breadcrumb-item"><a href="javascript:void(0);">{{trans('main.product')}}</a></li>
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
                                                
                                                 <form action="product_import_excel" method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    
                                                    <div class="form-group row">
                                                        <label for="name" class="col-3">file</label>
                                                        <div class="col-9">
                                                            <input type="file" id="image"  name="data">
                                                        
                                                        </div>
                                                    </div> 
                                
                                                
                                
                                                    <div class="form-group row">
                                                        <label for="" class="col-3"></label>
                                                        <div class="col-9">
                                                            <button type="submit" class="btn btn-sm btn-primary">upload</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            
                        
                                                <a href="{{route('admin.product.create')}}" class="btn btn-primary">
                                                    {{trans('main.add')}}
                                                </a>
                                            

                                               
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
                                                                                <th class="wd-15p border-bottom-0">{{trans('main.arabic_name')}}</th>
                                                                                <th class="wd-15p border-bottom-0">{{trans('main.english_name')}}</th>
                                                                                <th class="wd-15p border-bottom-0">{{trans('main.code')}}</th>
                                                                                <th class="wd-15p border-bottom-0">{{trans('main.supplier_price')}}</th>
                                                                                <th class="wd-15p border-bottom-0">{{trans('main.price')}}</th>
                                                                                <th class="wd-15p border-bottom-0">{{trans('main.category')}}</th>
                                                                                <th class="wd-15p border-bottom-0">{{trans('main.supplier')}}</th>
                                                                                <th class="wd-15p border-bottom-0">{{trans('main.action')}}</th>
                                                                                
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            
                                                                                @if ($products->count() > 0)
                                                                                    @foreach ($products as $key=> $product)
                                                                                        <tr>
                                                                                            <td>{{$key+1}}</td>
                                                                                            <td> {{ $product->name_ar}}</td>
                                                                                            <td> {{ $product->name_en}}</td>
                                                                                            <td>{{ $product->code}}</td>
                                                                                            <td>{{ $product->supplier_price}}</td>
                                                                                            <td>{{ $product->price}}</td>
                                                                                            <td>{{ $product->category->name_ar ?? ''}}</td>
                                                                                            <td>{{ $product->supplier->name ?? ''}}</td>
                                                                                         

                                                                                        
                                                                                            <td style="text-align: center;">
                                                                                                
                                                                                                    <a href="{{route('admin.product.edit',$product->id)}}" class="btn btn-primary">
                                                                                                        {{trans('main.edit')}}
                                                                                                    </a>

                                                                                                    
                                                                                               
                        
                                                                                                
                                                                                                    <form action="{{ route('admin.product.destroy', $product->id) }}"
                                                                                                        onsubmit="return confirm('are you sure')"
                                                                                                        method="post">
                                                                                                        @method('delete')
                                                                                                        @csrf
                                                                                                        <button class="btn btn-danger">{{trans('main.delete')}}</button>
                                                                                                    </form>
                                                                                               
                                                                                                
                                                                                               
                                                                                               
                                                                                            </td>
                                                                                        </tr>

                                                                                        

                                                                                    @endforeach
                                                                                @else
                                                                                    <tr>
                                                                                        <td colspan="4" style="text-align: center;"><small></small></td>
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
                        
                            
                        
                        
                                
                        
                              
                          

                            
                        </div>
                    </div>
                </div>
                    <!-- CONTAINER CLOSED -->
            
@endsection
         

                    
@push('scripts')





@endpush 
		

        
      
