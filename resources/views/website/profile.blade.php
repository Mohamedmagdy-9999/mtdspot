@extends('website.layout')

@section('content')
<main>

<style>
/* Dashboard Redesign */
.profile-dash-grid {
    display: grid;
    grid-template-columns: 280px 1fr;
    gap: 2rem;
    align-items: start;
    margin-top: 1rem;
    margin-bottom: 4rem;
}

@media(max-width: 900px) {
    .profile-dash-grid {
        grid-template-columns: 1fr;
    }
}

.profile-sidebar {
    background: var(--bg-secondary);
    border: 1px solid var(--border-color);
    border-radius: 1rem;
    padding: 1.5rem 1rem;
    position: sticky;
    top: 100px;
    box-shadow: var(--shadow-sm);
}

.profile-tab-btn {
    display: flex;
    align-items: center;
    gap: 1rem;
    width: 100%;
    padding: 1rem;
    background: transparent;
    border: none;
    text-align: left;
    color: var(--text-secondary);
    font-size: 1.1rem;
    font-weight: 600;
    border-radius: 0.75rem;
    cursor: pointer;
    transition: all 0.3s ease;
    margin-bottom: 0.5rem;
}

.profile-tab-btn:hover {
    background: var(--bg-tertiary);
    color: var(--text-primary);
}

.profile-tab-btn.active {
    background: var(--primary-color);
    color: var(--bg-dark);
}

.profile-content-area {
    min-height: 500px;
}

.profile-tab-content {
    display: none;
    animation: fadeIn 0.4s ease;
}

.profile-tab-content.active {
    display: block;
}

/* Personal Info Panel */
.profile-panel {
    background: var(--bg-secondary);
    border: 1px solid var(--border-color);
    border-radius: 1rem;
    padding: 2.5rem;
    box-shadow: var(--shadow-sm);
}

.profile-form-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1.5rem;
}

.profile-form-grid .full-col {
    grid-column: 1 / -1;
}

@media(max-width: 768px) {
    .profile-form-grid {
        grid-template-columns: 1fr;
    }
}

/* Modern Order Card */
.order-card-modern {
    background: var(--bg-secondary);
    border: 1px solid var(--border-color);
    border-radius: 1rem;
    padding: 1.5rem 2rem;
    margin-bottom: 2rem;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.order-card-modern:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-md);
    border-color: var(--border-color);
}

.order-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-bottom: 1px dashed var(--border-color);
    padding-bottom: 1rem;
    margin-bottom: 1.5rem;
}

.order-header h3 {
    font-size: 1.25rem;
    font-weight: 800;
    color: var(--text-primary);
    margin-bottom: 0.25rem;
}

.order-amount {
    background: rgba(255,183,3, 0.1);
    color: var(--primary-color);
    padding: 0.5rem 1rem;
    border-radius: 2rem;
    font-weight: 800;
    font-size: 1.1rem;
}

.order-product {
    display: flex;
    align-items: center;
    gap: 1rem;
    background: var(--bg-primary);
    padding: 1rem;
    border-radius: 0.75rem;
    margin-bottom: 0.5rem;
    border: 1px solid transparent;
}

.order-product:hover {
    border-color: var(--border-color);
}

.order-product img {
    width: 60px;
    height: 60px;
    object-fit: contain;
    border-radius: 0.5rem;
    background: var(--bg-tertiary);
    padding: 0.25rem;
}

/* Address Card Modern */
.address-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 1.5rem;
    margin-bottom: 3rem;
}

.address-card-modern {
    background: var(--bg-primary);
    border: 1px solid var(--border-color);
    border-radius: 1rem;
    padding: 1.5rem;
    position: relative;
    transition: transform 0.3s ease;
}

.address-card-modern:hover {
    transform: translateY(-3px);
    border-color: var(--primary-color);
}

.address-delete-btn {
    position: absolute;
    top: 1rem;
    right: 1rem;
    background: rgba(239, 68, 68, 0.1);
    color: #ef4444;
    border: none;
    width: 35px;
    height: 35px;
    border-radius: 50%;
    cursor: pointer;
    display: flex;
    justify-content: center;
    align-items: center;
    transition: all 0.3s ease;
}

.address-delete-btn:hover {
    background: #ef4444;
    color: white;
}
</style>

    <div class="page-header">
        <div class="container">
            <h1 class="page-header__title">Dashboard</h1>
            <nav class="page-header__breadcrumb" aria-label="Breadcrumb">
                <a href="{{ route('home') }}" class="page-header__breadcrumb-link">Home</a>
                <span class="page-header__breadcrumb-separator">/</span>
                <span>Profile Dashboard</span>
            </nav>
        </div>
    </div>

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

<div class="profile-dash-grid">

{{-- Sidebar Navigation --}}
<div class="profile-sidebar">
    <button class="profile-tab-btn active" data-tab="info" onclick="switchProfileTab('info', this)">
        <i class="fas fa-user-circle"></i> Personal Info
    </button>
    <button class="profile-tab-btn" data-tab="orders" onclick="switchProfileTab('orders', this)">
        <i class="fas fa-box"></i> My Orders
    </button>
    <button class="profile-tab-btn" data-tab="addresses" onclick="switchProfileTab('addresses', this)">
        <i class="fas fa-map-marker-alt"></i> Addresses
    </button>
    <form method="POST" action="{{ route('user_logout') }}">
        @csrf
        <button type="submit" class="profile-tab-btn" style="color: #ef4444; margin-top: 2rem;">
            <i class="fas fa-sign-out-alt"></i> Logout
        </button>
    </form>
</div>

<div class="profile-content-area">

{{-- Personal Info --}}
<div class="profile-tab-content active" id="tab-info">
    <div class="profile-panel">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
            <h2 style="font-size: 1.5rem; color: var(--text-primary);">Personal Information</h2>
            <button class="btn btn--outline" onclick="openProfileModal('editInfoModal')">
                <i class="fas fa-edit"></i> Edit Profile
            </button>
        </div>
        
        <div class="profile-form-grid" style="grid-template-columns: 1fr;">
            <div style="background: var(--bg-primary); padding: 2rem; border-radius: 1rem; border: 1px solid var(--border-color); display: flex; align-items: center; gap: 2rem;">
                <div style="font-size: 5rem; color: var(--text-secondary); opacity: 0.8;">
                    @if($user->image)
                        <img src="{{ asset('storage/' . $user->image) }}" alt="Avatar" style="width: 100px; height: 100px; border-radius: 50%; object-fit: cover;">
                    @else
                        <i class="fas fa-user-circle"></i>
                    @endif
                </div>
                <div>
                    <h3 style="color: var(--text-primary); margin-bottom: 0.75rem; font-size: 1.5rem; font-weight: 800;">{{ $user->name }}</h3>
                    <p style="color: var(--text-secondary); margin-bottom: 0.5rem; font-size: 1.1rem;"><i class="fas fa-envelope"></i> {{ $user->email }}</p>
                    <p style="color: var(--text-secondary); font-size: 1.1rem;"><i class="fas fa-phone"></i> {{ $user->phone ?? 'No phone string provided' }}</p>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Orders --}}
{{-- Orders --}}
<div class="profile-tab-content" id="tab-orders">
    @if($orders->count())
        @foreach($orders as $order)
            <div class="order-card-modern">
                <div class="order-header">
                    <div>
                        <h3>Order #{{ $order->id }}</h3>
                        <small style="color: var(--text-secondary);"><i class="far fa-calendar-alt"></i> {{ $order->created_at->format('d M Y, h:i A') }}</small>
                    </div>
                    <div class="order-amount">
                        {{ number_format($order->price, 2) }} EGP
                    </div>
                </div>

                <div style="margin-bottom: 1.5rem;">
                    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 1rem;">
                        @foreach($order->details as $item)
                            <div class="order-product">
                                <img src="{{ $item->product->clean_image_link_1 }}" alt="">
                                <div>
                                    <strong style="display:block; margin-bottom: 0.25rem; color: var(--text-primary);">{{ $item->product_name }}</strong>
                                    <small style="color: var(--text-secondary);">
                                        @if($item->color_name) Color: {{ $item->color_name }} | @endif Qty: {{ $item->quantity }}
                                    </small>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div style="background: var(--bg-tertiary); padding: 1rem; border-radius: 0.75rem; border: 1px dashed var(--border-color); font-size: 0.95rem; line-height: 1.6;">
                    <strong style="color: var(--text-primary);"><i class="fas fa-truck"></i> Delivery Time:</strong> <span style="color: var(--text-secondary);">{{ $order->delivery_date ?? 'Not specified' }} Days</span><br>
                    @if($order->address)
                        <strong style="color: var(--text-primary);"><i class="fas fa-map-marker-alt"></i> Delivery Address:</strong> <span style="color: var(--text-secondary);">{{ $order->address->address }}, Building {{ $order->address->building_no }}, Floor {{ $order->address->floor_no }}, Flat {{ $order->address->flat_no }}</span>
                    @endif
                </div>
            </div>
        @endforeach
    @else
        <div class="empty-state" style="text-align: center; margin-top: 2rem; background: var(--bg-secondary); border-radius: 1rem; border: 1px dashed var(--border-color); padding: 4rem 1rem;">
            <div class="empty-state__icon" style="font-size: 4rem; opacity: 0.5;">📦</div>
            <h3 class="empty-state__title" style="margin-bottom: 0.5rem; color: var(--text-primary);">No orders yet</h3>
            <p class="empty-state__description" style="color: var(--text-secondary);">Start shopping to see your orders here</p>
            <a href="{{ route('home') }}" class="btn btn--primary" style="margin-top: 1rem;">Browse Products</a>
        </div>
    @endif
</div>

{{-- Addresses --}}
<div class="profile-tab-content" id="tab-addresses">
    
    <div class="address-grid">
    @foreach($addresses as $address)
    <div class="address-card-modern">
        <h4 style="margin-bottom: 1rem; color: var(--primary-color); font-weight: 800;"><i class="fas fa-map-pin"></i> {{ $address->governorate_name }}</h4>
        <p style="color: var(--text-secondary); line-height: 1.8; margin-bottom: 1rem;">
            <strong>City:</strong> {{$address->city_name}}<br>
            <strong>Street:</strong> {{ $address->address }}<br>
            <strong>Details:</strong> Building {{ $address->building_no }}, Floor {{ $address->floor_no }}, Flat {{ $address->flat_no }}
        </p>

        <form method="POST" action="{{ route('profile.address.delete',$address->id) }}">
            @csrf
            <button class="address-delete-btn" title="Delete Address"><i class="fas fa-trash"></i></button>
        </form>
    </div>
    @endforeach
    </div>

    <!-- Add New Address Panel -->
    <div class="profile-panel" style="text-align: center; padding: 4rem 1rem; background: var(--bg-secondary);">
        <button class="btn btn--outline btn-anim" style="padding: 1.5rem 3rem; border-radius: 2rem; font-size: 1.25rem; border: 2px dashed var(--primary-color); color: var(--primary-color); cursor: pointer;" onclick="openProfileModal('addAddressModal')">
            <i class="fas fa-plus-circle" style="margin-right: 10px; font-size: 1.5rem;"></i> Add New Address
        </button>
    </div>

</div>

</div> <!-- end profile-content-area -->
</div> <!-- end profile-dash-grid -->

<!-- MODAL: Edit Profile -->
<div class="modal" id="editInfoModal" onclick="checkCloseModal(event, 'editInfoModal')">
    <div class="modal__overlay"></div>
    <div class="modal__content" style="max-width: 600px;">
        <button class="modal__close" onclick="closeProfileModal('editInfoModal')"><i class="fas fa-times"></i></button>
        <h2 style="font-size: 1.5rem; margin-bottom: 2rem; color: var(--text-primary);">Edit Personal Info</h2>
        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="form">
            @csrf
            <div class="profile-form-grid" style="grid-template-columns: 1fr;">
                <div class="form__group">
                    <label class="form__label">Full Name</label>
                    <input class="form__input" name="name" value="{{ old('name',$user->name) }}">
                </div>
                <div class="form__group">
                    <label class="form__label">Email Address</label>
                    <input class="form__input" name="email" value="{{ old('email',$user->email) }}">
                </div>
                <div class="form__group">
                    <label class="form__label">Phone Number</label>
                    <input class="form__input" name="phone" value="{{ old('phone',$user->phone) }}">
                </div>
                <div class="form__group">
                    <label class="form__label">Profile Image</label>
                    <input type="file" class="form__input" name="image" style="padding: 0.5rem;">
                </div>
                <div class="form__group" style="padding-top: 1rem; border-top: 1px dashed var(--border-color);">
                    <label class="form__label">New Password <small style="color: var(--text-light);">(Leave blank to keep current)</small></label>
                    <input type="password" class="form__input" name="password">
                </div>
                <div class="form__group" style="padding-top: 1rem; border-top: 1px dashed var(--border-color);">
                    <label class="form__label">Confirm Password</label>
                    <input type="password" class="form__input" name="password_confirmation">
                </div>
                <div class="form__group full-col">
                    <button class="btn btn--primary btn-anim" style="padding: 1rem 2rem; border-radius: 0.5rem; font-size: 1.1rem; width: 100%;">
                        <i class="fas fa-save"></i> Save Changes
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- MODAL: Add Address -->
<div class="modal" id="addAddressModal" onclick="checkCloseModal(event, 'addAddressModal')">
    <div class="modal__overlay"></div>
    <div class="modal__content" style="max-width: 600px;">
        <button class="modal__close" onclick="closeProfileModal('addAddressModal')"><i class="fas fa-times"></i></button>
        <h3 style="font-size: 1.5rem; font-weight: 800; color: var(--text-primary); margin-bottom: 1.5rem; border-bottom: 1px dashed var(--border-color); padding-bottom: 0.5rem;">
            <i class="fas fa-plus-circle"></i> Add New Address
        </h3>
        <form method="POST" action="{{ route('profile.address.add') }}" class="form">
            @csrf
            <div class="profile-form-grid" style="grid-template-columns: 1fr 1fr;">
                <div class="form__group">
                    <label class="form__label">Governorate *</label>
                    <select name="governorate_id" class="form__input" id="governorate" required>
                        <option value="">Select Governorate</option>
                        @php $govs = App\Models\Governorate::latest()->get(); @endphp
                        @foreach($govs as $gov)
                            <option value="{{ $gov->id }}">{{ $gov->name_en }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form__group">
                    <label class="form__label">City *</label>
                    <select name="city_id" class="form__input" id="city" required>
                        <option value="">Select City</option>
                    </select>
                </div>
                <div class="form__group full-col">
                    <label class="form__label">Street Address *</label>
                    <input class="form__input" name="address" required placeholder="123 Main St">
                </div>
                <div class="form__group">
                    <label class="form__label">Building No *</label>
                    <input class="form__input" name="building_no" required>
                </div>
                <div class="form__group">
                    <label class="form__label">Floor No *</label>
                    <input class="form__input" name="floor_no" required>
                </div>
                <div class="form__group">
                    <label class="form__label">Flat No *</label>
                    <input class="form__input" name="flat_no" required>
                </div>
                <div class="form__group">
                    <label class="form__label">Contact Phone (Optional)</label>
                    <input class="form__input" name="phone">
                </div>
                <div class="form__group full-col" style="margin-top: 1rem;">
                    <button class="btn btn--primary btn-anim" style="padding: 1rem 2rem; border-radius: 0.5rem; font-size: 1.1rem; width: 100%;">
                        <i class="fas fa-plus"></i> Save New Address
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

</div>
</main>
@endsection
@push('scripts')
<script>
// Switch tabs via our new dashboard layout styling
function switchProfileTab(tabId, btnElement) {
    document.querySelectorAll('.profile-tab-btn').forEach(btn => btn.classList.remove('active'));
    
    if(btnElement) {
        btnElement.classList.add('active');
    }
    
    document.querySelectorAll('.profile-tab-content').forEach(content => {
        content.classList.remove('active');
    });
    
    document.getElementById('tab-' + tabId).classList.add('active');
}

// Modal Logic
function openProfileModal(modalId) {
    document.getElementById(modalId).classList.add('modal--active');
    document.body.style.overflow = 'hidden';
}

function closeProfileModal(modalId) {
    document.getElementById(modalId).classList.remove('modal--active');
    document.body.style.overflow = '';
}

function checkCloseModal(e, modalId) {
    if (e.target.classList.contains('modal__overlay')) {
        closeProfileModal(modalId);
    }
}
</script>
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

