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
                                        <li class="breadcrumb-item"><a href="javascript:void(0);">{{trans('main.cities')}}</a></li>
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
                        
                                                <form action="{{route('admin.city.store')}}" method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <label for="">{{trans('main.arabic_name')}}</label>
                                                            <input type="text" name="name_ar" class="form-control" value="{{old('name_ar')}}">
                                                            @if($errors->has('name_ar'))
                                                                <div class="error">{{ $errors->first('name_ar') }}</div>
                                                            @endif
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label for="">{{trans('main.english_name')}}</label>
                                                            <input type="text" name="name_en" class="form-control" value="{{old('name_en')}}">
                                                            @if($errors->has('name_en'))
                                                                <div class="error">{{ $errors->first('name_en') }}</div>
                                                            @endif
                                                        </div>

                                                        <div class="col-md-4">
                                                            <label for="">{{trans('main.governorate')}}</label>
                                                            <select name="governorate_id" id="" class="form-control">
                                                                @php $govs = App\Models\Governorate::latest()->get();  @endphp
                                                                <option selected disabled>--</option>
                                                                @foreach($govs as $gov)
                                                                    <option value="{{$gov->id}}">{{$gov->name_ar}}</option>
                                                                @endforeach
                                                            </select>
                                                            @if($errors->has('governorate_id'))
                                                                <div class="error">{{ $errors->first('governorate_id') }}</div>
                                                            @endif
                                                        </div>

                                                        <div class="col-md-4">
                                                            <label for="">{{trans('main.shipping_price')}}</label>
                                                            <input type="text" name="shipping_price" class="form-control" value="{{old('shipping_price')}}">
                                                            @if($errors->has('shipping_price'))
                                                                <div class="error">{{ $errors->first('shipping_price') }}</div>
                                                            @endif
                                                        </div>

                                                        <div class="col-md-4">
                                                            <label for="">{{trans('main.delivery_days')}}</label>
                                                            <input type="text" name="delivery_days" class="form-control" value="{{old('delivery_days')}}">
                                                            @if($errors->has('delivery_days'))
                                                                <div class="error">{{ $errors->first('delivery_days') }}</div>
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

                                              
                                                
                        
                                                <div class="row">
                                                    <div class="col-lg-12 col-sm-12 col-md-6 col-xl-12">
                                                        <div class="card overflow-hidden">
                                                            <div class="card-body">
                                                                <div class="table-responsive export-table">
                                                                    <table  id="file-datatable" class="table table-bordered text-nowrap key-buttons border-bottom  w-100">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>*</th>
                                                                                <th>{{trans('main.arabic_name')}}</th>
                                                                                <th>{{trans('main.english_name')}}</th>
                                                                                <th>{{trans('main.governorate')}}</th>
                                                                                <th>{{trans('main.shipping_price')}}</th>
                                                                                <th>{{trans('main.delivery_days')}}</th>
                                                                            
                                                                                <th>{{trans('main.action')}}</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            
                                                                                
                                                                                    @foreach ($items as $key => $item)
                                                                                        <tr>
                                                                                            <td>{{$key+1}}</td>
                                                                                            <td>{{ $item->name_ar}} </td>
                                                                                            <td>{{ $item->name_en}}</td>
                                                                                            <td>{{ $item->governorate->name_ar}}</td>
                                                                                            <td>{{ $item->shipping_price}}</td>
                                                                                            <td>{{ $item->delivery_days}}</td>
                                                                                          
                                                                                         
                                                                                           

                                                                                                <td style="text-align: center;">
                                                                                                                                                                                               
                                                                                                    
                        
                                                                                                    <a href="{{route('admin.city.edit',$item->id)}}" class="btn btn-success">{{trans('main.edit')}}</a>
                                                                                                  
                                                                                                
                                                                                               
                                                                                               
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
         

            
		

        
      
