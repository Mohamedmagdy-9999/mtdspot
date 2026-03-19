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
                                        <li class="breadcrumb-item"><a href="javascript:void(0);">{{trans('main.slider')}}</a></li>
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
                        
                                                <form action="{{route('admin.slider.store')}}" method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                   
                                                        <div class="form-group">
                                                            <label for="">{{trans('main.arabic_name')}}</label>
                                                            <input type="text" name="name_ar" class="form-control">
                                                           
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="">{{trans('main.english_name')}}</label>
                                                            <input type="text" name="name_en" class="form-control">
                                                           
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="">{{trans('main.arabic_desc')}}</label>
                                                            <input type="text" name="desc_ar" class="form-control">
                                                           
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="">{{trans('main.english_desc')}}</label>
                                                            <input type="text" name="desc_en" class="form-control">
                                                           
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="">{{trans('main.price')}}</label>
                                                            <input type="text" name="price" class="form-control">
                                                           
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="">{{trans('main.discount')}}</label>
                                                            <input type="text" name="discount" class="form-control">
                                                           
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="">{{trans('main.products')}}</label>
                                                            <select name="product_id[]" multiple class="form-control select2-show-search form-select" data-placeholder="Choose one">
                                                                <option selected disabled>--</option>
                                                                @php $products = App\Models\Product::latest()->get(); @endphp
                                                                @foreach($products as $product)
                                                                    <option value="{{$product->id}}">{{$product->name_ar}}</option>
                                                                @endforeach
                                                            </select>
                                                           
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="">{{trans('main.image')}}</label>
                                                            <input type="file" name="image" class="form-control">
                                                           
                                                        </div>

                                                   
                                    
                                                    <div class="form-group row">
                                                        <label for="" class="col-3"></label>
                                                        <div class="col-9">
                                                            <button type="submit" id="plus" class="btn btn-sm btn-primary">{{trans('main.save')}}</button>
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
                                                                                <th>{{trans('main.image')}}</th>
                                                                                <th>{{trans('main.action')}}</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            
                                                                                
                                                                                    @foreach ($sliders as $key => $slider)
                                                                                        <tr>
                                                                                            <td>{{$key+1}}</td>
                                                                                            
                                                                                          
                                                                                            <td>
                                                                                                <img src="{{asset('sliders/' .$slider->image)}}" style="width:150px;" alt="">
                                                                                            </td>
                                                                                           

                                                                                                <td style="text-align: center;">
                                                                                                                                                                                               
                                                                                                    
                        
                                                                                                    {{-- <a href="{{route('admin.slider.edit',$slider->id)}}" class="btn btn-success">{{trans('main.edit')}}</a> --}}
                                                                                                    <form action="{{ route('admin.slider.destroy', $slider->id) }}"
                                                                                                        onsubmit="return confirm('are you sure')"
                                                                                                        method="post">
                                                                                                        @method('delete')
                                                                                                        @csrf
                                                                                                        <button class="btn btn-danger">{{trans('main.delete')}}</button>
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
         

            
		

        
      
