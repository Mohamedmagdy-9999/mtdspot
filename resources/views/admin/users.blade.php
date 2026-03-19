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
                                    <h1 class="page-title">Dashboard</h1>
                                </div>
                                <div class="ms-auto pageheader-btn">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="javascript:void(0);">Users</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
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
                                                
                        
                                              

                                            
                        
                                                <div class="row">
                                                    <div class="col-lg-12 col-sm-12 col-md-6 col-xl-12">
                                                        <div class="card overflow-hidden">
                                                            <div class="card-body">
                                                                <div class="table-responsive export-table">
                                                                    <table  id="file-datatable" class="table table-bordered text-nowrap key-buttons border-bottom  w-100">
                                                                        <thead>
                                                                            <tr>
                                                                                <th class="wd-15p border-bottom-0">user name</th>
                                                                                <th class="wd-15p border-bottom-0">user email</th>
                                                                                <th class="wd-15p border-bottom-0">user phone</th>
                                                                                <th class="wd-15p border-bottom-0">status</th>
                                                                                <th class="wd-15p border-bottom-0">action</th>
                                                                                
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            
                                                                                @if ($users->count() > 0)
                                                                                    @foreach ($users as $user)
                                                                                        <tr>
                                                                                            <td>{{ $user->name}} {{ $user->last_name}}</td>
                                                                                            <td>{{ $user->email}}</td>
                                                                                            <td>{{ $user->phone}}</td>
                                                                                            @if($user->status == 0)
                                                                                                <td style="background: yellow">active</td>
                                                                                            @else
                                                                                                <td style="background: green">deactive</td>
                                                                                            @endif

                                                                                            @if($user->status == 0)
                                                                                                <td>
                                                                                                    <form action="{{ route('admin.deactive', $user->id) }}"
                                                                                                        onsubmit="return confirm('are you sure')"
                                                                                                        method="post">
                                                                                                        @method('PUT')
                                                                                                        @csrf
                                                                                                        <button class="btn btn-danger">deactive</button>
                                                                                                    </form>
                                                                                                </td>

                                                                                            @else
                                                                                                <td>
                                                                                                    <form action="{{ route('admin.active', $user->id) }}"
                                                                                                        onsubmit="return confirm('are you sure')"
                                                                                                        method="post">
                                                                                                        @method('PUT')
                                                                                                        @csrf
                                                                                                        <button class="btn btn-success">active</button>
                                                                                                    </form>
                                                                                                </td>
                                                                                            @endif
                                                                                               
                                                                                        </tr>

                                                                                       

                                                                                    @endforeach
                                                                                @else
                                                                                    <tr>
                                                                                        <td colspan="4" style="text-align: center;"><small>No users  Found</small></td>
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
         

            
		

        
      
