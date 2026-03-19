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
                                        <li class="breadcrumb-item"><a href="javascript:void(0);">{{trans('main.product')}}</a></li>
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
                                                
                        
                                                

                                               
                                                

                                             
                                                <div class="row">
                                                    <div class="col-lg-12 col-sm-12 col-md-6 col-xl-12">
                                                        <div class="card overflow-hidden">
                                                            <div class="card-body">
                                                                <div class="table-responsive export-table">
                                                                    <table  id="file-datatable" class="table table-bordered text-nowrap key-buttons border-bottom  w-100">
                                                                        <thead>
                                                                            <tr>
                                                                                <th class="wd-15p border-bottom-0">#</th>
                                                                                <th class="wd-15p border-bottom-0">{{trans('main.product')}}</th>
                                                                                <th class="wd-15p border-bottom-0">{{trans('main.size')}}</th>
                                                                                <th class="wd-15p border-bottom-0">{{trans('main.color')}}</th>
                                                                                <th class="wd-15p border-bottom-0">{{trans('main.image')}}</th>
                                                                                <th class="wd-15p border-bottom-0">{{trans('main.price')}}</th>
                                                                                {{-- <th class="wd-15p border-bottom-0">{{trans('main.barcode')}}</th> --}}
                                                                                <th class="wd-15p border-bottom-0">{{trans('main.label')}}</th>
                                                                                
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            
                                                                                
                                                                                    @foreach ($product->variants as $key=> $variant)
                                                                                        <tr>
                                                                                            <td>{{$key+1}}</td>
                                                                                            <td>{{ $variant->product->name ?? ''}}</td>
                                                                                            <td>{{ $variant->size->name ?? ''}}</td>
                                                                                            <td>{{ $variant->color->name ?? ''}} |  <span style="display: inline-block; width: 20px; height: 20px; background-color: {{ $variant->color->color ?? '' }};"></span></td>
                                                                                            <td>
                                                                                                <img src="{{ asset($variant->image) }}" alt="Variant Image" width="100">
                                                                                            </td>
                                                                                            <td>{{ $variant->price}}</td>
                                                                                            {{-- <td>{{ $variant->barcode}}</td> --}}

                                                                                         
                                                                                          
                                                                                        
                                                                                            <td style="text-align: center;">
																								<button onclick="printLabel('label-{{ $variant->id }}')" class="btn btn-primary mt-2">Print</button>
        <div class="label" id="label-{{ $variant->id }}">
    <div class="content">
        <div class="details-column">
		<div class="product-name">
            <img src="{{ asset('admin/assets/images/logo.png') }}" alt="Logo" style="height:20px">
        </div>
            <h5 class="product-name">{{ $variant->category->name ?? '' }} {{ $variant->sub->name ?? '' }} {{ $variant->product->name }}</h5>
            <div class="variant-details">
                <span class="color">Color: {{ $variant->color->name ?? '' }}</span>
                <span class="size">Size: {{ $variant->size->name ?? '' }}</span>
            </div>
            {{-- <h5 class="price">Price: {{ $variant->product->price }} LE</h5> --}}
            <div class="barcode-section">
                <h5 class="barcode-number">{{ $variant->barcode }}</h5>
                <img src="data:image/png;base64,{{ DNS1D::getBarcodePNG($variant->barcode, 'C128', 3, 100) }}" alt="Barcode" class="barcode">
            </div>
        </div>
    </div>
</div>

                                                                                                  
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
         

                    
@push('scripts')

<script>
    $(document).ready(function() {
    // Add new variant
    $('#add-variant').click(function() {
        var index = $('#variant-container').data('variant-index');
        var newVariantHtml = `
            <div class="variant row mb-3" data-index="${index}">
                <input type="hidden" name="variants[${index}][id]" value="">
                <div class="col-md-3">
                    <label>{{ trans('main.size') }}</label>
                    <select name="variants[${index}][size_id]" class="form-control">
                        @php $sizes = App\Models\Size::latest()->get(); @endphp
                        @foreach($sizes as $size)
                            <option value="{{ $size->id }}">{{ $size->name }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="col-md-3">
                    <label>{{ trans('main.color') }}</label>
                    <select name="variants[${index}][color_id]" class="form-control">
                        @php $colors = App\Models\Color::latest()->get(); @endphp
                        @foreach($colors as $color)
                            <option value="{{ $color->id }}">{{ $color->name }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="col-md-3">
                    <label>{{ trans('main.image') }}</label>
                    <input type="file" name="variants[${index}][image]" class="form-control" required>
                </div>
                
                <div class="col-md-3">
                    <button type="button" class="btn btn-danger remove-variant mt-4">
                        <i class="fa fa-trash"></i>
                    </button>
                </div>
            </div>
        `;
        $('#variant-container').append(newVariantHtml);
        $('#variant-container').data('variant-index', index + 1);
    });

    // Remove variant
    $(document).on('click', '.remove-variant', function() {
        $(this).closest('.variant').remove();
    });
});

</script>


<script>
    function printLabel(labelId) {
        var labelContent = document.getElementById(labelId);

        var labelHTML = labelContent ? labelContent.outerHTML : `
            <div class="no-label">
                <p>No label found!</p>
            </div>
        `;

        var printWindow = window.open('', '_blank', 'width=250,height=500');
        if (!printWindow) {
            alert("Unable to open print window. Please check your browser settings.");
            return;
        }

        printWindow.document.open();
        printWindow.document.write(`
            <html>
                <head>
                    <title>Print Label</title>
                    <style>
                        @page {
                            size: 5cm 2.5cm; /* Exact label dimensions */
                            margin: 0; /* Remove default margins */
                        }
                        body {
                            font-family: Arial, sans-serif;
                            margin: 0;
                            padding: 0;
                            display: flex;
                            justify-content: center;
                            align-items: center;
                            height: 100%;
                        }
                        .label {
                            display: flex;
                            width: 4.5cm;
                            height: 2.5cm;
                        }
                        .logo-column {
                            width: 20%;
                            display: flex;
                            justify-content: center;
                            align-items: center;
                            padding: 2px; /* Reduced padding */
                            box-sizing: border-box;
                        }
                        .logo-column img {
                            max-width: 100%;
                            max-height: 100%;
                        }
                        .details-column {
                            width: 100%;
                            padding: 2px; /* Reduced padding */
                            box-sizing: border-box;
							justify-content: center;
                            align-items: center;
                            display: flex;
                            flex-direction: column;
                            justify-content: space-between;
                        }
						.barcode-number {
                            margin: 0;
                            font-size: 8px; /* Reduced font size */
                            line-height: 1;
                        }
                        .product-name, .price{
                            margin: 0;
                            font-size: 12px; /* Reduced font size */
                            line-height: 1;
                        }
                        .variant-details {
                            font-size: 10px; /* Reduced font size */
                        }
                        .variant-details span {
                            margin: 1px 0;
                        }
                        .barcode-section {
                            display: flex;
                            flex-direction: column;
                            align-items: center;
                        }
                        .barcode {
                            max-width: 100%;
                            height: auto;
					        background-color: #000;
                        }
                        .no-label {
                            width: 4.5cm;
                            height: 2.5cm;
                            display: flex;
                            justify-content: center;
                            align-items: center;
                            border: 1px solid #000;
                            text-align: center;
                            box-sizing: border-box;
                            background-color: #f8f8f8;
                        }
                        .no-label p {
                            font-size: 12px;
                            color: #555;
                            margin: 0;
                        }
                    </style>
                </head>
                <body onload="window.print();window.close();">
                    ${labelHTML}
                </body>
            </html>
        `);
        printWindow.document.close();
    }
</script>



<script>
    $(document).ready(function () {
    $('#category').on('change', function () {
        var categoryId = $(this).val();

        if (categoryId) {
            $.ajax({
                url: '/get-subcategories/' + categoryId,
                type: 'GET',
                dataType: 'json',
                success: function (data) {
                    var subCategoryDropdown = $('#sub_category');
                    subCategoryDropdown.empty();
                    subCategoryDropdown.append('<option selected disabled>--</option>');

                    $.each(data, function (key, subCategory) {
                        subCategoryDropdown.append('<option value="' + subCategory.id + '">' + subCategory.name + '</option>');
                    });
                },
                error: function () {
                    alert('Unable to fetch subcategories.');
                }
            });
        } else {
            $('#sub_category').empty().append('<option selected disabled>--</option>');
        }
    });
});

</script>

<script>
    $(document).ready(function () {
    var selectedCategoryId = $('#category').val();
    var selectedSubCategoryId = '{{ $product->sub_category_id }}';

    if (selectedCategoryId) {
        $.ajax({
            url: '/get-subcategories/' + selectedCategoryId,
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                var subCategoryDropdown = $('#sub_category');
                subCategoryDropdown.empty();
                subCategoryDropdown.append('<option selected disabled>--</option>');

                $.each(data, function (key, subCategory) {
                    var selected = subCategory.id == selectedSubCategoryId ? 'selected' : '';
                    subCategoryDropdown.append('<option value="' + subCategory.id + '" ' + selected + '>' + subCategory.name + '</option>');
                });
            }
        });
    }
});

</script>

@endpush 
		

        
      
