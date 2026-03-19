@extends('admin.layout')
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
            <form action="{{route('admin.uploads')}}" method="post" enctype="multipart/form-data" id="send">
                {{ csrf_field() }}
                <label>Upload Image</label>
                <br>
                <input name="img" type="file" id="file">
            </form>
            <p>Uploaded Image URL to Paste it in Editor:</p>
            <p>{{$url}}</p>
            <script type="text/javascript">
                document.getElementById("file").onchange = function() {
                    document.getElementById("send").submit();
                };
            </script>
         
            
        </div>
    </div>
</div>

              
                    <!-- CONTAINER CLOSED -->
            
@endsection
         

            
		

        
      
