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
                                        <li class="breadcrumb-item"><a href="javascript:void(0);">{{trans('main.users')}}</a></li>
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
                        
                                           

                                              
                                                
                        
                                                <div class="row">
                                                    <div class="col-lg-12 col-sm-12 col-md-6 col-xl-12">
                                                        <div class="card overflow-hidden">
                                                            <div class="card-body">
                                                                <div class="table-responsive export-table">
                                                                    <table  id="file-datatable" class="table table-bordered text-nowrap key-buttons border-bottom  w-100">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>*</th>
                                                                                <th>{{trans('main.name')}}</th>
                                                                                <th>{{trans('main.phone')}}</th>
                                                                                <th>{{trans('main.email')}}</th>
                                                                                <th>{{trans('main.status')}}</th>
                                                                                <th>{{trans('main.action')}}</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            
                                                                                
                                                                                    @foreach ($users as $key => $user)
                                                                                        <tr>
                                                                                            <td>{{$key+1}}</td>
                                                                                            <td>{{ $user->name}} </td>
                                                                                            <td>{{ $user->phone}}</td>
                                                                                            <td>{{ $user->email}}</td>
                                                                                          
                                                                                            <td>
                                                                                                @if($user->status == 0)
                                                                                                    {{trans('main.active')}}
                                                                                                @else
                                                                                                    {{trans('main.not_active')}}
                                                                                                @endif
                                                                                            </td>
                                                                                           

                                                                                                <td style="text-align: center;">
                                                                                                                                                                                               
                                                                                                    
                                                                                                    @if($user->status == 0)
                                                                                                    
                                                                                                        <form action="{{ route('admin.suspend_user', $user->id) }}"
                                                                                                            onsubmit="return confirm('are you sure')"
                                                                                                            method="post">
                                                                                                            @method('PUT')
                                                                                                            @csrf
                                                                                                            <button class="btn btn-danger">{{trans('main.suspend')}}</button>
                                                                                                        </form> 
                                                                                                    @else

                                                                                                        <form action="{{ route('admin.user.update', $user->id) }}"
                                                                                                            onsubmit="return confirm('are you sure')"
                                                                                                            method="post">
                                                                                                            @method('PUT')
                                                                                                            
                                                                                                            @csrf
                                                                                                            <button class="btn btn-success">{{trans('main.activate')}}</button>
                                                                                                        </form>

                                                                                                    @endif
                                                                                                
                                                                                               
                                                                                               
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
         

            
		

        
      
