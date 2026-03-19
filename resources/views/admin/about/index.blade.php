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
                                        <li class="breadcrumb-item"><a href="javascript:void(0);">{{trans('main.about_us')}}</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">{{trans('main.dashboard')}}</li>
                                    </ol>
                                </div>
                            </div>
                            <!-- PAGE-HEADER END -->

                            <!-- ROW-1 -->
                            <div class="row">
                                <div class="col-lg-12 col-sm-12 col-md-6 col-xl-12">
                                    <div class="card overflow-hidden">
                                        <img src="{{asset('about/' . $about->image)}}" style="width: 100px;" alt="">
                                        <br>
                                        <div class="card-body">
                                            @if (session()->has('message'))
                                                <div class="alert alert-success text-center">{{ session('message') }}</div>
                                            @endif
                                            <br>
                                            <form action="{{route('admin.about.update', $about->id)}}" method="POST" enctype="multipart/form-data">
                                                @method('PUT')
                                                @csrf

                                               
                                                
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <label for="">{{trans('main.text')}}</label>
                                                        <textarea name="text" class="form-control ckeditor">
                                                            {{$about->text}}
                                                        </textarea>
                                                    </div>
                                                </div>
                                                <br>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <label for="">{{trans('main.image')}}</label>
                                                        <input type="file" name="image" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="" class="col-3"></label>
                                                    <div class="col-9">
                                                        <button type="submit" id="plus" class="btn btn-sm btn-primary">{{trans('main.save')}}</button>
                                                    </div>
                                                </div>
                                            </form>
                                            <br>
                                            
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

<script src="//cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('.ckeditor').ckeditor();
    });

</script>







@endpush