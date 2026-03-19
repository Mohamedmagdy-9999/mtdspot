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
                                        <li class="breadcrumb-item"><a href="javascript:void(0);">import Supplier excel</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                                    </ol>
                                </div>
                            </div>
                            <!-- PAGE-HEADER END -->

                            <!-- ROW-1 -->
                            <form action="supplier_import_excel" method="POST" enctype="multipart/form-data">
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
                                        <button type="submit" class="btn btn-sm btn-primary">update</button>
                                    </div>
                                </div>
                            </form>
                          

                            
                        </div>
                    </div>
                </div>
                    <!-- CONTAINER CLOSED -->
            
@endsection
         

            
		

        
      
