@extends('website.layout')

@section('content')
<main>

<div class="container">

<h1>My Profile</h1>

{{-- Messages --}}
@if(session('message'))
    <div class="alert alert--success">{{ session('message') }}</div>
@endif

@if($errors->any())
    <div class="alert alert--danger">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="tabs">

{{-- Tabs --}}
<div class="tabs__list">
    <button class="tabs__tab tabs__tab--active" data-tab="info">Personal Info</button>
    <button class="tabs__tab" data-tab="orders">Orders</button>
    <button class="tabs__tab" data-tab="addresses">Addresses</button>
</div>

{{-- Personal Info --}}
<div class="tabs__content tabs__content--active" data-content="info">
<form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="form">
@csrf

<div class="form__group">
<label>Name</label>
<input class="form__input" name="name" value="{{ old('name',$user->name) }}">
</div>

<div class="form__group">
<label>Email</label>
<input class="form__input" name="email" value="{{ old('email',$user->email) }}">
</div>

<div class="form__group">
<label>Phone</label>
<input class="form__input" name="phone" value="{{ old('phone',$user->phone) }}">
</div>

<div class="form__group">
<label>New Password</label>
<input type="password" class="form__input" name="password">
</div>

<div class="form__group">
<label>Confirm Password</label>
<input type="password" class="form__input" name="password_confirmation">
</div>

<div class="form__group">
<label>Profile Image</label>
<input type="file" class="form__input" name="image">
</div>

<button class="btn btn--primary">Save Changes</button>
</form>
</div>

{{-- Orders --}}
{{-- Orders --}}
<div class="tabs__content" data-content="orders">
    @if($orders->count())
        @foreach($orders as $order)
            <div class="card card--order" style="margin-bottom: 1.5rem; padding: 1rem; border: 1px solid #ddd; border-radius: 10px;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                    <div>
                        <strong>Order #{{ $order->id }}</strong><br>
                        <small>{{ $order->created_at->format('d M Y, h:i A') }}</small>
                    </div>
                    <div>
                        <span style="font-weight: bold; color: #007bff;">{{ $order->price }} EGP</span>
                    </div>
                </div>

                <div>
                    <h4 style="margin-bottom: 0.5rem;">Products:</h4>
                    <ul style="list-style: none; padding-left: 0;">
                        @foreach($order->details as $item)
                            <li style="display: flex; align-items: center; margin-bottom: 0.5rem;">
                                <img src="{{ $item->product->clean_image_link_1 }}" alt="" style="width: 50px; height: 50px; object-fit: cover; margin-right: 0.5rem; border-radius: 5px;">
                                <div>
                                    <strong>{{ $item->product_name }}</strong><br>
                                    @if($item->color_name)
                                        Color: {{ $item->color_name }} |
                                    @endif
                                    Qty: {{ $item->quantity }} |
                                    Price: {{ $item->price }} EGP
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <div style="margin-top: 1rem;">
                    <strong>Delivery Time:</strong> {{ $order->delivery_date ?? 'Not specified' }} Days
                </div>

                @if($order->address)
                    <div style="margin-top: 0.5rem;">
                        <strong>Address:</strong> {{ $order->address->address }}, Building {{ $order->address->building_no }}, Floor {{ $order->address->floor_no }}, Flat {{ $order->address->flat_no }}
                    </div>
                @endif
            </div>
        @endforeach
    @else
        <div class="empty-state" style="text-align: center; margin-top: 2rem;">
            <div class="empty-state__icon" style="font-size: 3rem;">📦</div>
            <h3 class="empty-state__title">No orders yet</h3>
            <p class="empty-state__description">Start shopping to see your orders here</p>
            <a href="{{ route('home') }}" class="btn btn--primary" style="margin-top: 1rem;">Browse Products</a>
        </div>
    @endif
</div>


{{-- Addresses --}}
<div class="tabs__content" data-content="addresses">

@foreach($addresses as $address)
<div class="card">
    <p>
        {{ $address->address }} <br>
        Governorate : {{$address->governorate_name}},
        City : {{$address->city_name}},
        Building: {{ $address->building_no }},
        Floor: {{ $address->floor_no }},
        Flat: {{ $address->flat_no }}
    </p>

    <form method="POST" action="{{ route('profile.address.delete',$address->id) }}">
        @csrf
        <button class="btn btn--danger btn--sm">Delete</button>
    </form>
</div>
@endforeach


<hr>
<form method="POST" action="{{ route('profile.address.add') }}" class="form">
    @csrf
    <h3>Add New Address</h3>

    <div class="form__group">
        <label>Governorate</label>
        <select name="governorate_id" class="form__input" id="governorate" required>
            <option value="">Select Governorate</option>
            @php $govs = App\Models\Governorate::latest()->get(); @endphp
            @foreach($govs as $gov)
                <option value="{{ $gov->id }}">{{ $gov->name_en }}</option>
            @endforeach
        </select>
    </div>

    <div class="form__group">
        <label>City</label>
        <select name="city_id" class="form__input" id="city" required>
            <option value="">Select City</option>
            {{-- سيتم ملء المدن هنا تلقائي --}}
        </select>
    </div>

    <div class="form__group">
        <label>Address</label>
        <input class="form__input" name="address" required>
    </div>

    <div class="form__group">
        <label>Building No</label>
        <input class="form__input" name="building_no" required>
    </div>

    <div class="form__group">
        <label>Floor No</label>
        <input class="form__input" name="floor_no" required>
    </div>

    <div class="form__group">
        <label>Flat No</label>
        <input class="form__input" name="flat_no" required>
    </div>

    <div class="form__group">
        <label>Phone</label>
        <input class="form__input" name="phone">
    </div>

    <button class="btn btn--primary">Add Address</button>
</form>



</div>

</div>
</div>
</main>
@endsection
@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $('#governorate').change(function() {
        var gov_id = $(this).val();
        if(gov_id) {
            $.ajax({
                url: '/cities/' + gov_id,
                type: 'GET',
                success: function(data) {
                    $('#city').empty();
                    $('#city').append('<option value="">Select City</option>');
                    $.each(data, function(key, value){
                        $('#city').append('<option value="'+ value.id +'">'+ value.name_en +'</option>');
                    });
                }
            });
        } else {
            $('#city').empty();
            $('#city').append('<option value="">Select City</option>');
        }
    });
});
</script>
@endpush

