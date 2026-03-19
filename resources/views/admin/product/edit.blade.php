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
                                       <li class="breadcrumb-item"><a href="javascript:void(0);">{{trans('main.edit_product')}} {{$product->name_ar}}</a></li>
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
                                        
                                            
                                               
                                                @if (session()->has('message'))
                                                    <div class="alert alert-success text-center">{{ session('message') }}</div>
                                                @endif

                                                @if (session('error'))
                                                    <div class="alert alert-danger">{{ session('error') }}</div>
                                                @endif
                                                <div class="form-group">
                                                   
                                                    @foreach(explode(',', $product->images) as $img)
                                                        <img src="{{ asset('products/' . $img) }}" alt="img" style="width: 100px; height:100px; margin:5px;">
                                                    @endforeach
                                                </div>
                                                <br>
                                                <form action="{{route('admin.product.update',$product->id)}}" method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    @method('PUT')
                                                    
                                                    <div class="row">

                                                        <div class="col-md-6">
                                                            <label for="name">{{trans('main.arabic_name')}}</label>
                                                            
                                                            <input type="text" class="form-control" name="name_ar" value="{{$product->name_ar}}">
                                                            @error('name_ar')
                                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                            
                                                        </div>

                                                        <div class="col-md-6">
                                                            <label for="name">{{trans('main.english_name')}}</label>
                                                            
                                                            <input type="text" class="form-control" name="name_en" value="{{$product->name_en}}">
                                                            @error('name_en')
                                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                            
                                                        </div>

                                                        <div class="col-md-4">
                                                            <label for="name">{{trans('main.code')}}</label>
                                                            
                                                            <input type="text" class="form-control" name="code" value="{{$product->code}}">
                                                            @error('code')
                                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                            
                                                        </div>

                                                        <div class="col-md-4">
                                                            <label for="name">{{trans('main.supplier_price')}}</label>
                                                            
                                                            <input type="text" class="form-control" name="supplier_price" value="{{$product->supplier_price}}">
                                                            @error('supplier_price')
                                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                            
                                                        </div>

                                                        <div class="col-md-4">
                                                            <label for="name">{{trans('main.price')}}</label>
                                                            
                                                            <input type="text" class="form-control" name="price" value="{{$product->price}}">
                                                            @error('price')
                                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                            
                                                        </div>

                                                        <div class="col-md-4">
                                                            <label for="name">{{trans('main.discount')}}</label>
                                                            
                                                            <input type="text" class="form-control" name="discount" value="{{$product->discount}}">
                                                            @error('discount')
                                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                            
                                                        </div>

                                                        <div class="col-md-4">
                                                            <label for="name">{{trans('main.warranty_period')}}</label>
                                                            
                                                            <input type="text" class="form-control" name="warranty_period" value="{{$product->warranty_period}}">
                                                            @error('warranty_period')
                                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                            
                                                        </div>

                                                        <div class="col-md-6">
                                                            <label for="">{{trans('main.arabic_desc')}}</label>
                                                            <input type="text" name="desc_ar" class="form-control" value="{{$product->desc_ar}}">
                                                            @error('desc_ar')
                                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>

                                                        <div class="col-md-6">
                                                            <label for="">{{trans('main.english_desc')}}</label>
                                                            <input type="text" name="desc_en" class="form-control" value="{{$product->desc_en}}">
                                                            @error('desc_en')
                                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                      
                                                        
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="name">{{trans('main.category')}}</label>
                                                                
                                                                <select name="category_id" class="form-control select2-show-search form-select" data-placeholder="Choose one">
                                                                    <option selected disabled>--</option>
                                                                    @php $categories = App\Models\Category::latest()->get(); @endphp
                                                                    @foreach($categories as $category)
                                                                        <option value="{{$category->id}}" {{ $product->category_id == $category->id ? 'selected' : '' }}>{{$category->name_ar}}</option>
                                                                    @endforeach
                                                                </select>
                                                                @error('category_id')
                                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                                @enderror                                                            
                                                            </div>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="name">{{trans('main.supplier')}}</label>
                                                                
                                                                <select name="supplier_id" class="form-control select2-show-search form-select" data-placeholder="Choose one">
                                                                    <option selected disabled>--</option>
                                                                    @php $suppliers = App\Models\Supplier::latest()->get(); @endphp
                                                                    @foreach($suppliers as $supplier)
                                                                        <option value="{{$supplier->id}}" {{ $product->supplier_id == $supplier->id ? 'selected' : '' }}>{{$supplier->name}}</option>
                                                                    @endforeach
                                                                </select>
                                                                @error('supplier_id')
                                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                                @enderror                                                            
                                                            </div>
                                                        </div>

                                                        <div class="col-md-12">
                                                            <label for="">{{trans('main.images')}}</label>
                                                            <input type="file" name="images[]" class="form-control" multiple>
                                                        </div>

                                                        <div class="col-md-3">
                                                            <label for="">image link 1</label>
                                                            <input type="text" name="image_link_1" class="form-control" value="{{$product->image_link_1}}">
                                                            
                                                        </div>

                                                       

                                                        <div class="col-md-3">
                                                            <label for="">image link 2</label>
                                                            <input type="text" name="image_link_2" class="form-control" value="{{$product->image_link_2}}">
                                                            
                                                        </div>

                                                        <div class="col-md-3">
                                                            <label for="">image link 3</label>
                                                            <input type="text" name="image_link_3" class="form-control" value="{{$product->image_link_3}}">
                                                            
                                                        </div>

                                                         <div class="col-md-3">
                                                            <label for="">image link 4</label>
                                                            <input type="text" name="image_link_4" class="form-control" value="{{$product->image_link_4}}">
                                                            
                                                        </div>
                                                        

                                                    </div>
                                                    <hr>
                                                    <div id="variant-container">
                                                        @php $index = 0; @endphp
                                                        @foreach($product->colors as $color)
                                                            <div class="row variant mb-3">
                                                                <div class="col-md-9">
                                                                    <div class="form-group">
                                                                        <label class="form-label">{{ trans('main.color') }}</label>
                                                                        <select name="variants[{{ $index }}][color_id]" class="form-control">
                                                                            <option disabled>--</option>
                                                                            @foreach(App\Models\Color::latest()->get() as $c)
                                                                                <option value="{{ $c->id }}" {{ $c->id == $color->id ? 'selected' : '' }}>
                                                                                    {{ $c->name }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-3">
                                                                    <label class="form-label d-block">&nbsp;</label>
                                                                    <button type="button" class="btn btn-danger remove-variant"><i class="fa fa-trash"></i></button>
                                                                </div>
                                                            </div>
                                                            @php $index++; @endphp
                                                        @endforeach
                                                    </div>

                                                    
                                                    <!-- Add Variant Button -->
                                                    <div class="text-end mt-3">
                                                        <button type="button" id="add-variant" class="btn btn-primary"><i class="fa fa-plus"></i></button>
                                                    </div>
                                                    
                                                    
                                                    
                                                    
                                                    
                                                    
                                                    
                                                      
                                                    <div class="form-group row">
                                                        <label for="" class="col-3"></label>
                                                        <div class="col-9">
                                                            <button type="submit"  class="btn btn-sm btn-primary">{{trans('main.save')}}</button>
                                                        </div>
                                                    </div>

                                                </form>

                                               
                                               
                                                
                        
                                    </div>
                                </div>
                            </div>
                        
                            
                        
                        
                                
                        
                              
                          

                            
                        </div>
                    </div>
                </div>
                    <!-- CONTAINER CLOSED -->
            
@endsection
         
@push('scripts')

    <script>
    let variantIndex = {{ $index ?? 0 }};

    document.getElementById('add-variant').addEventListener('click', function () {
        const container = document.getElementById('variant-container');
        const html = `
        <div class="row variant mb-3">
            <div class="col-md-9">
                <div class="form-group">
                    <label class="form-label">{{ trans('main.color') }}</label>
                    <select name="variants[${variantIndex}][color_id]" class="form-control">
                        <option disabled selected>--</option>
                        @foreach(App\Models\Color::latest()->get() as $c)
                            <option value="{{ $c->id }}">{{ $c->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col-md-3">
                <label class="form-label d-block">&nbsp;</label>
                <button type="button" class="btn btn-danger remove-variant"><i class="fa fa-trash"></i></button>
            </div>
        </div>
        `;
        container.insertAdjacentHTML('beforeend', html);
        variantIndex++;
    });

    document.addEventListener('click', function (e) {
        if (e.target.closest('.remove-variant')) {
            e.target.closest('.variant').remove();
        }
    });
</script>


@endpush
		

        
      
