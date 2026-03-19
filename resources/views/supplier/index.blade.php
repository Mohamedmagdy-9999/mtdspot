@extends('supplier.layout')
@section('content')
		

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
                        <li class="breadcrumb-item"><a href="javascript:void(0);">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                    </ol>
                </div>
            </div>
            <!-- PAGE-HEADER END -->
            <div class="row">
                <div class="col-lg-6 col-sm-12 col-md-6 col-xl-6">
                    <div class="card bg-primary overflow-hidden">
                        <div class="card-body">
                            <div class="row">
                            <div class="col">
                                <div class="row">
                                <div class="col-6">
                                    <h2 class="mb-2 fw-semibold">Total Order Products</h2>
                                </div>
                                <div class="col-6">
                                    @php
                                        $orders = App\Models\UserPurchaseDetail::where('supplier_id', auth('supplier')->id()) ->where('transefer', 'created')->count();
                                      
                                    @endphp
                                    <h3 class="mb-2 fw-semibold">{{$orders}}</h3>                                                    
                                </div>
                                </div>
                            </div>

                            
                                <div class="col col-auto top-icn dash">
                                    <div class="counter-icon bg-primary dash ms-auto box-shadow-primary">
                                        <i class="zmdi zmdi-account" data-bs-toggle="tooltip" title="Total User" ></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- <div class="col-lg-6 col-sm-12 col-md-6 col-xl-6">
                    <div class="card bg-azure overflow-hidden">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                <div class="row">
                                <div class="col-6">
                                    <h2 class="mb-2 fw-semibold">Total Sales</h2>
                                    </div>
                                <div class="col-6">
                                    @php
                                        $orders = App\Models\UserPurchase::sum('total');
                                       
                                    @endphp
                                    <h3 class="mb-2 fw-semibold">{{$orders}} LE</h3>                                                    
                                </div>
                                </div>
                            </div>
                                <div class="col col-auto top-icn dash">
                                    <div class="counter-icon bg-azure dash ms-auto box-shadow-primary">
                                        <i class="zmdi zmdi-money" data-bs-toggle="tooltip" title="Total Sales" ></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> --}}
                <div class="col-lg-3 col-sm-12 col-md-3 col-xl-3">
                    <div class="card overflow-hidden">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                   <h4 class="mb-2 fw-semibold">Total Products Delivered </h4>
                                    @php
                                        $orders = App\Models\UserPurchaseDetail::where('supplier_id', auth('supplier')->id()) ->where('transefer', 'delivered')->count();
                                      
                                    @endphp
                                    <h3 class="mb-2 fw-semibold">{{$orders}}</h3> 
                                </div>
                                <div class="col col-auto top-icn dash">
                                    <div class="counter-icon bg-azure-dark dash ms-auto box-shadow-info">
                                        <i class="zmdi zmdi-book" data-bs-toggle="tooltip" title="Books Sales " ></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-12 col-md-3 col-xl-3">
                    <div class="card overflow-hidden">
                        <div class="card-body">
                            <div class="row">
                                {{-- <div class="col">
                                   <h4 class="mb-2 fw-semibold">Books Sales out</h4>
                                    @php
                                        $totalsalesbooks = App\Models\UserOrder::where('book_id', '!=', null)->sum('price');
                                    
                                    @endphp
                                    <h3 class="mb-2 fw-semibold">{{$totalsalesbooks}} LE</h3> 
                                </div> --}}
                                <div class="col col-auto top-icn dash">
                                    <div class="counter-icon bg-blue dash ms-auto box-shadow-info">
                                        <i class="zmdi zmdi-money-box" data-bs-toggle="tooltip" title="Books Sales Out" ></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-sm-12 col-md-6 col-xl-3">
                    <div class="card overflow-hidden">
                        <div class="card-body">
                            <div class="row">
                                {{-- <div class="col">
                                    <h4 class="mb-2 fw-semibold"># of Courses Sales</h4>
                                    @php
                                    $courses = App\Models\UserOrder::where('course_id', '!=', null)->count();
                                
                                    @endphp
                                    <h3 class="mb-2 fw-semibold">{{$courses}}</h3> 
                                </div> --}}
                                <div class="col col-auto top-icn dash">
                                    <div class="counter-icon bg-warning dash ms-auto box-shadow-warning">
                                        <i class="zmdi zmdi-badge-check"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- <div class="col-lg-6 col-sm-12 col-md-6 col-xl-3">
                    <div class="card overflow-hidden">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <h4 class="mb-2 fw-semibold">Courses Sales Out</h4>
                                    @php
                                        $totalsalescourses = App\Models\UserOrder::where('course_id', '!=', null)->sum('price');
                                
                                    @endphp
                                    <h3 class="mb-2 fw-semibold">{{$totalsalescourses}} LE</h3> 
                                </div>
                                <div class="col col-auto top-icn dash">
                                    <div class="counter-icon bg-warning-gradient dash ms-auto box-shadow-warning">
                                        <i class="zmdi zmdi-money-box"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-sm-12 col-md-6 col-xl-4">
                    <div class="card overflow-hidden">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <h3 class="mb-2 fw-semibold"># of Teacher Package Sales</h3>
                                    @php
                                        $packages = App\Models\UserOrder::where('package_id', '!=', null)->count();
                                
                                    @endphp
                                    <h3 class="mb-2 fw-semibold">{{$packages}}</h3> 
                                </div>
                                <div class="col col-auto top-icn dash">
                                    <div class="counter-icon bg-teal dash ms-auto box-shadow-warning">
                                        <i class="zmdi zmdi-assignment-account"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-sm-12 col-md-6 col-xl-4">
                    <div class="card overflow-hidden">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <h3 class="mb-2 fw-semibold"> Package Sales Out</h3>
                                    @php
                                        $totalsalespackages = App\Models\UserOrder::where('package_id', '!=', null)->sum('price');
                                
                                    @endphp
                                    <h3 class="mb-2 fw-semibold">{{$totalsalespackages}} LE</h3> 
                                </div>
                                <div class="col col-auto top-icn dash">
                                    <div class="counter-icon bg-teal-dark dash ms-auto box-shadow-warning">
                                        <i class="zmdi zmdi-money-box"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-sm-12 col-md-6 col-xl-4">
                    <div class="card bg-purple overflow-hidden">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <h3 class="mb-2 fw-semibold">Free Books Downloads</h3>
                                    @php $downloads = App\Models\Download::count(); @endphp
                                    <h3 class="mb-2 fw-semibold">{{$downloads}}</h3> 
                                </div>
                                <div class="col col-auto top-icn dash">
                                    <div class="counter-icon bg-purple dash ms-auto box-shadow-warning">
                                        <i class="zmdi zmdi-download"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> --}}
            </div>
            <!-- ROW-1 END-->


            <!-- ROW-3 -->
            <div class="row">
                
                <div class="col-xl-12 col-md-12">
                    <div class="card">
                        {{-- <div class="card-header border-bottom">
                            <h5 class="card-title fw-semibold">Top Pages Visits</h5>
                            
                        </div> --}}
                        {{-- <div class="card-body pb-0">
                            <ul class="task-list">
                                @php $visits = App\Models\Visits::take(10)->orderBy('views', 'DESC')->get(); @endphp
                                
                                @foreach($visits as $visit)
                                <li>
                                    <i class="task-icon bg-primary"></i>
                                    <p class="fw-semibold mb-1 fs-13">{{$visit->free_book_name}}<span class="text-muted fs-12 ms-2 ms-auto float-end">{{$visit->views}}</span></p>
                                    
                                </li>
                                @endforeach
                                                                              
                                                                              
                            </ul>
                        </div> --}}
                    </div>
                    
                </div>
                {{-- <div class="col-xl-6 col-sm-12">
                    <div class="card">
                            <div class="card-header border-bottom">
                                <h5 class="card-title fw-semibold">Countries Visits Counter</h5>
                            </div>
                            <div class="card-body pb-0">
                                <ul class="task-list">
                                
                                                                            
                                </ul>
                            </div>
                        </div>
                                                                                    
                </div> --}}
                {{-- <div class="col-lg-6 col-sm-12">
                   <livewire:book-report />
                </div>
                <div class="col-lg-6 col-sm-12">
                    <livewire:package-report />
                </div>
                <div class="col-lg-6 col-sm-12">
                    <livewire:course-report />
                </div>
                <div class="col-lg-6 col-sm-12">
                    <livewire:user-report />
                </div> --}}
            </div>
            <!-- ROW-1 -->
           
            <!-- ROW-3 END -->

         
            
        </div>
    </div>
</div>

              
                    <!-- CONTAINER CLOSED -->
            
@endsection
         

            
		

        
      
