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
                                        <li class="breadcrumb-item"><a href="javascript:void(0);">Purchases</a></li>
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
                                                                                <th class="wd-15p border-bottom-0">details</th>
                                                                                
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            
                                                                                @if ($users->count() > 0)
                                                                                    @foreach ($users as $user)
                                                                                        <tr>
                                                                                            <td>{{ $user->name}} {{ $user->last_name}}</td>
                                                                                            <td>{{ $user->email}}</td>
                                                                                            <td>{{ $user->phone}}</td>
                                                                                        
                                                                                                <td style="text-align: center;">
                                                                                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#view{{$user->id}}">
                                                                                                        view
                                                                                                    </button>
                        
                                                                                                </td>
                                                                                        </tr>

                                                                                        <div class="modal fade" id="view{{$user->id}}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                                                            <div class="modal-dialog modal-xl">
                                                                                              <div class="modal-content">
                                                                                                <div class="modal-header">
                                                                                                  <h1 class="modal-title fs-5" id="staticBackdropLabel">view details</h1>
                                                                                                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                                                </div>
                                                                                                <div class="modal-body">
                                                                                                    
                                                                                                    @php $purchases = App\Models\UserOrder::where('user_id', $user->id)->latest()->get();  @endphp
                                                                                                    @foreach($purchases as $purchase)
                                                                                                        <div class="row">
                                                                                                            <div class="col-md-6">
                                                                                                                @if($purchase->course_id == null)
                                                                                                                    <p>product :  {{$purchase->book->category->name}}  {{$purchase->book->name}}</p>
                                                                                                                @else
                                                                                                                    <p>product : {{$purchase->course->title}}  {{$purchase->course->sub_title}}</p>
                                                                                                                @endif
                                                                                                            </div>
                                                                                                            <div class="col-md-6">
                                                                                                                <p>price : {{$purchase->price}}</p>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    @endforeach
                                                                                
                                                                                                     
                                                                                                        
                                                                            
                                                                                                       
                                        
                                                                                                    
                                                                                                </div>
                                                                                                <div class="modal-footer">
                                                                                                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                                                
                                                                                                </div>
                                                                                              </div>
                                                                                            </div>
                                                                                        </div>

                                                                                    @endforeach
                                                                                @else
                                                                                    <tr>
                                                                                        <td colspan="4" style="text-align: center;"><small>No course  Found</small></td>
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
         

            
		

        
      
