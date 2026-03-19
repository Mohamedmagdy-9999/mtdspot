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
                                        <li class="breadcrumb-item"><a href="javascript:void(0);">{{trans('main.city')}} {{$item->name_ar}}</a></li>
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
                                               
                                                <form action="{{route('admin.city.update',$item->id)}}" method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    @method('PUT')
                                                    
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <label for="">{{trans('main.arabic_name')}}</label>
                                                            <input type="text" name="name_ar" class="form-control" value="{{$item->name_ar}}">
                                                            @if($errors->has('name_ar'))
                                                                <div class="error">{{ $errors->first('name_ar') }}</div>
                                                            @endif
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label for="">{{trans('main.english_name')}}</label>
                                                            <input type="text" name="name_en" class="form-control" value="{{$item->name_en}}">
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
                                                                    <option value="{{$gov->id}}" {{$item->governorate_id == $gov->id ? 'selected' :''}}>{{$gov->name_ar}}</option>
                                                                @endforeach
                                                            </select>
                                                            @if($errors->has('governorate_id'))
                                                                <div class="error">{{ $errors->first('governorate_id') }}</div>
                                                            @endif
                                                        </div>

                                                        <div class="col-md-4">
                                                            <label for="">{{trans('main.shipping_price')}}</label>
                                                            <input type="text" name="shipping_price" class="form-control" value="{{$item->shipping_price}}">
                                                            @if($errors->has('shipping_price'))
                                                                <div class="error">{{ $errors->first('shipping_price') }}</div>
                                                            @endif
                                                        </div>

                                                        <div class="col-md-4">
                                                            <label for="">{{trans('main.delivery_days')}}</label>
                                                            <input type="text" name="delivery_days" class="form-control" value="{{$item->delivery_days}}">
                                                            @if($errors->has('delivery_days'))
                                                                <div class="error">{{ $errors->first('delivery_days') }}</div>
                                                            @endif
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
         

            
		

        
      
