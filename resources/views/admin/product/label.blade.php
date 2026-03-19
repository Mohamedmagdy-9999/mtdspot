<!DOCTYPE html>
<html>
<head>
    <title>Print Label</title>
    <style>
        .label {
            width: 180px;
            height: 120px;
            border: 1px solid #000;
            text-align: center;
            padding: 5px;
            font-family: Arial, sans-serif;
        }
        .barcode {
            margin-top: 5px;
        }
    </style>
</head>
<body>
    <div class="label">
        <h5>{{$variant->color->name ?? ''}} {{$variant->size->name ?? ''}} {{ $variant->product->name }}</h5>
        <div class="barcode">
            {!! DNS1D::getBarcodeHTML($barcode, 'C128') !!}
        </div>
        <p>{{ $barcode }}</p>
    </div>
</body>
</html>
