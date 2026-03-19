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
                                        <li class="breadcrumb-item"><a href="javascript:void(0);">{{trans('main.products')}}</a></li>
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

                                                <form action="{{route('admin.product.store')}}" method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    
                                                    <div class="row">

                                                        <div class="col-md-6">
                                                            <label for="name">{{trans('main.arabic_name')}}</label>
                                                            
                                                            <input type="text" class="form-control" name="name_ar" value="{{old('name_ar')}}">
                                                            @error('name_ar')
                                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                            
                                                        </div>

                                                        <div class="col-md-6">
                                                            <label for="name">{{trans('main.english_name')}}</label>
                                                            
                                                            <input type="text" class="form-control" name="name_en" value="{{old('name_en')}}">
                                                            @error('name_en')
                                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                            
                                                        </div>

                                                        <div class="col-md-4">
                                                            <label for="name">{{trans('main.code')}}</label>
                                                            
                                                            <input type="text" class="form-control" name="code" value="{{old('code')}}">
                                                            @error('code')
                                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                            
                                                        </div>

                                                        <div class="col-md-4">
                                                            <label for="name">{{trans('main.supplier_price')}}</label>
                                                            
                                                            <input type="text" class="form-control" name="supplier_price" value="{{old('supplier_price')}}">
                                                            @error('supplier_price')
                                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                            
                                                        </div>

                                                        <div class="col-md-4">
                                                            <label for="name">{{trans('main.price')}}</label>
                                                            
                                                            <input type="text" class="form-control" name="price" value="{{old('price')}}">
                                                            @error('price')
                                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                            
                                                        </div>

                                                        <div class="col-md-4">
                                                            <label for="name">{{trans('main.discount')}}</label>
                                                            
                                                            <input type="text" class="form-control" name="discount" value="{{old('discount')}}">
                                                            @error('discount')
                                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                            
                                                        </div>

                                                        <div class="col-md-4">
                                                            <label for="name">{{trans('main.warranty_period')}}</label>
                                                            
                                                            <input type="text" class="form-control" name="warranty_period" value="{{old('warranty_period')}}">
                                                            @error('warranty_period')
                                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                            
                                                        </div>

                                                        

                                                        

                                                        

                                                        <div class="col-md-6">
                                                            <label for="">{{trans('main.arabic_desc')}}</label>
                                                            <input type="text" name="desc_ar" class="form-control" value="{{old('desc_ar')}}">
                                                            @error('desc_ar')
                                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>

                                                        <div class="col-md-6">
                                                            <label for="">{{trans('main.english_desc')}}</label>
                                                            <input type="text" name="desc_en" class="form-control" value="{{old('desc_en')}}">
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
                                                                        <option value="{{$category->id}}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{$category->name_ar}}</option>
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
                                                                        <option value="{{$supplier->id}}" {{ old('supplier_id') == $supplier->id ? 'selected' : '' }}>{{$supplier->name}}</option>
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
                                                        

                                                    </div>
                                                    <hr>
                                                    <div id="variant-container">
                                                        <div class="row variant mb-3">
                                                            
                                                    
                                                            <div class="col-md-9">
                                                                <div class="form-group">
                                                                    <label class="form-label">{{trans('main.color')}}</label>
                                                                    <select  name="variants[0][color_id]" class="form-control">
                                                                        <option selected disabled>--</option>
                                                                        @php $colors = App\Models\Color::latest()->get(); @endphp
                                                                        @foreach($colors as $color)
                                                                            <option value="{{$color->id}}" style="background-color: {{$color->color}}; color:#fff;">{{$color->name}}</option>      
                                                                        @endforeach                                                                                          
                                                                    </select>
                                                                    
                                                                </div>
                                                            </div>
															
                                                            
                                                    
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label class="form-label">Delete</label>
                                                                    <button type="button" class="btn btn-danger remove-variant"><i class="fa fa-trash"></i></button>
                                                                </div>
                                                            </div>
                                                        </div>
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
                        
                            
                        
                        
                            <!-- Modal HTML -->
                            <div id="errorModal" class="modal fade" tabindex="-1" role="dialog">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Validation Errors</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            @if ($errors->any())
                                                <div class="alert alert-danger">
                                                    <ul>
                                                        @foreach ($errors->all() as $error)
                                                            <li>{{ $error }}</li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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
<script>

let variantIndex = document.querySelectorAll('#variant-container .variant').length || 0;

// Function to update the input names dynamically
function updateVariantIndices() {
    const rows = document.querySelectorAll('#variant-container .variant');
    rows.forEach((row, index) => {
        row.querySelectorAll('select, input').forEach((input) => {
            const name = input.getAttribute('name');
            if (name) {
                const updatedName = name.replace(/variants\[\d+\]/, `variants[${index}]`);
                input.setAttribute('name', updatedName);
            }
        });
    });
}

// Add Variant Row
document.getElementById('add-variant').addEventListener('click', () => {
    const container = document.getElementById('variant-container');

    // Create a new variant row
    const newRow = document.createElement('div');
    newRow.classList.add('variant', 'row', 'mb-3');

    newRow.innerHTML = `
        

        <div class="col-md-9">
            <div class="form-group">
                <label class="form-label">{{trans('main.color')}}</label>
                <select name="variants[${variantIndex}][color_id]" class="form-control">
                    <option selected disabled>--</option>
                    @php $colors = App\Models\Color::latest()->get(); @endphp
                    @foreach($colors as $color)
                        <option value="{{$color->id}}" style="background-color: {{$color->color}}; color:#fff;">{{$color->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
			

       

        <div class="col-md-1">
            <div class="form-group">
                <label class="form-label">Delete</label>
                <button type="button" class="btn btn-danger remove-variant"><i class="fa fa-trash"></i></button>
            </div>
        </div>
    `;

    // Append the new row to the container
    container.appendChild(newRow);

    // Reinitialize Select2 for new rows
    $(newRow).find('.select2-show-search').select2();

    // Increment the variant index
    variantIndex++;
});

// Remove Variant Row
document.getElementById('variant-container').addEventListener('click', (e) => {
    if (e.target.closest('.remove-variant')) {
        const row = e.target.closest('.variant');
        row.remove();

        // Update all input field names
        updateVariantIndices();
    }
});


</script>


<script>
    document.addEventListener('DOMContentLoaded', function () {
        @if ($errors->any())
            var errorModal = new bootstrap.Modal(document.getElementById('errorModal'));
            errorModal.show();
        @endif
    });
</script>






@endpush 
		

        
      
