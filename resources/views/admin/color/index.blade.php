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
                                        <li class="breadcrumb-item"><a href="javascript:void(0);">{{trans('main.colors')}}</a></li>
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
                                                

                                                <form action="{{route('admin.color.store')}}" method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    
                                                        

                                                        <div class="form-group-row">
                                                            <label for="name">{{trans('main.name')}}</label>
                                                            
                                                            <input type="text" class="form-control" name="name">
                                                            @if($errors->has('name'))
                                                                <div class="error">{{ $errors->first('name') }}</div>
                                                            @endif
                                                            
                                                        </div>

                                                        <div class="form-group-row">
                                                            <label for="name">{{trans('main.color')}}</label>
                                                            
                                                            <input type="color" class="form-control" name="color">
                                                            @if($errors->has('color'))
                                                                <div class="error">{{ $errors->first('color') }}</div>
                                                            @endif
                                                            
                                                        </div>

                                                        
                                                        
                                                      
                                                    <div class="form-group row">
                                                        <label for="" class="col-3"></label>
                                                        <div class="col-9">
                                                            <button type="submit" id="plus" class="btn btn-sm btn-primary">{{trans('main.save')}}</button>
                                                        </div>
                                                    </div>

                                                </form>
                                                <br>
                                               
                        
                                                <div class="row">
                                                    <div class="col-lg-12 col-sm-12 col-md-6 col-xl-12">
                                                        <div class="card overflow-hidden">
                                                            <div class="card-body">
                                                                <div class="table-responsive export-table">
                                                                    <table  id="file-datatable" class="table table-bordered text-nowrap key-buttons border-bottom  w-100">
                                                                        <thead>
                                                                            <tr>
                                                                                <th class="wd-15p border-bottom-0">#</th>
                                                                                <th class="wd-15p border-bottom-0">{{trans('main.name')}}</th>
                                                                                <th class="wd-15p border-bottom-0">{{trans('main.color')}}</th>
                                                                                
                                                                                <th class="wd-15p border-bottom-0">{{trans('main.action')}}</th>
                                                                                
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            
                                                                                @if ($colors->count() > 0)
                                                                                    @foreach ($colors as $key=> $color)
                                                                                        <tr>
                                                                                            <td>{{$key+1}}</td>
                                                                                            <td>{{ $color->name}}</td>
                                                                                            <td>
                                                                                                <span style="display: inline-block; width: 20px; height: 20px; background-color: {{ $color->color }};"></span>
                                                                                            </td>
                                                                                            
                                                                                            
                                                                                         
                                                                                          
                                                                                        
                                                                                            <td style="text-align: center;">
                                                                                                
                                                                                                    
                                                                                               <a href="{{route('admin.color.edit',$color->id)}}" class="btn btn-success">{{trans('main.edit')}}</a>
                        
                                                                                               
                                                                                                    {{-- <form action="{{ route('color.destroy', $color->id) }}"
                                                                                                        onsubmit="return confirm('are you sure')"
                                                                                                        method="post">
                                                                                                        @method('delete')
                                                                                                        @csrf
                                                                                                        <button class="btn btn-danger">{{trans('main.delete')}}</button>
                                                                                                    </form> --}}
                                                                                                
                                                                                                
                                                                                               
                                                                                               
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
		

        
      
