@extends('website.layout')

@section('content')

<style>
.cart-item{
    display:flex;
    justify-content:space-between;
    margin-bottom:1rem;
    align-items:center;
}
.cart-item img{
    width:50px;
    height:50px;
    object-fit:cover;
    margin-right:10px;
    border-radius:5px;
}
.cart-item-info{
    display:flex;
    align-items:center;
    flex:1;
}
.checkout-summary{
    border:1px solid var(--border-color);
    background: var(--bg-secondary);
    padding:1rem;
    border-radius:5px;
}
.checkout-summary__row{
    display:flex;
    justify-content:space-between;
    margin-bottom:0.5rem;
}
.checkout-summary__total{
    font-weight:bold;
    font-size:1.1rem;
}
.selection-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1rem;
    margin-bottom: 2rem;
}

@media(max-width: 600px) {
    .selection-grid {
        grid-template-columns: 1fr;
    }
}

.selection-card {
    border: 2px solid var(--border-color);
    background: var(--bg-secondary);
    border-radius: 1rem;
    padding: 1.5rem;
    cursor: pointer;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    display: flex;
    align-items: flex-start;
    gap: 1rem;
    position: relative;
    overflow: hidden;
}

.selection-card:hover {
    border-color: var(--primary-color);
    transform: translateY(-2px);
    box-shadow: var(--shadow-md);
}

.selection-card.selected {
    border-color: var(--primary-color);
    background: rgba(255, 183, 3, 0.05);
    box-shadow: 0 4px 15px rgba(255, 183, 3, 0.15);
}

.selection-card.selected::before {
    content: '\f058'; /* fa-check-circle */
    font-family: 'Font Awesome 5 Free';
    font-weight: 900;
    position: absolute;
    top: 1rem;
    right: 1rem;
    color: var(--primary-color);
    font-size: 1.5rem;
}

.selection-card-icon {
    font-size: 2rem;
    color: var(--text-secondary);
    transition: color 0.3s ease;
}

.selection-card.selected .selection-card-icon {
    color: var(--primary-color);
}

.selection-card input[type="radio"] {
    display: none;
}

.selection-content {
    flex: 1;
}

.selection-title {
    font-size: 1.1rem;
    font-weight: 700;
    color: var(--text-primary);
    margin-bottom: 0.25rem;
}

.selection-desc {
    color: var(--text-secondary);
    font-size: 0.95rem;
    line-height: 1.5;
}
label{
    cursor:pointer;
    display:block;
}
input, select{
    width:100%;
    padding:8px;
    margin-bottom:8px;
    border:1px solid var(--border-color);
    background: var(--bg-primary);
    color: var(--text-primary);
}
</style>

<main>
<div class="container">
    <h1>Checkout</h1>

    <div style="display:grid; grid-template-columns:1fr 320px; gap:2rem;">

        <!-- LEFT -->
        <div>
            <form id="checkout-form">

                <!-- Addresses -->
                <h3>Shipping Address</h3>
                <div id="addresses-list">
                    <p>Loading addresses...</p>
                </div>

               

                <!-- Payment -->
                <h3 style="margin-top:2.5rem; margin-bottom: 1.5rem;">Payment Method</h3>
                <div class="selection-grid">
                    <label class="selection-card selected" onclick="selectPaymentCard(this)">
                        <input type="radio" name="status" value="0" checked>
                        <div class="selection-card-icon"><i class="fas fa-money-bill-wave"></i></div>
                        <div class="selection-content">
                            <div class="selection-title">Cash on Delivery</div>
                            <div class="selection-desc">Pay when your order arrives</div>
                        </div>
                    </label>

                    <label class="selection-card" onclick="selectPaymentCard(this)">
                        <input type="radio" name="status" value="1">
                        <div class="selection-card-icon"><i class="fas fa-credit-card"></i></div>
                        <div class="selection-content">
                            <div class="selection-title">Visa / Mastercard</div>
                            <div class="selection-desc">Safe & secure online payment</div>
                        </div>
                    </label>
                </div>

                <button type="submit" class="btn btn--primary btn--lg" style="width:100%;">
                    Make Order
                </button>

            </form>
        </div>

        <!-- RIGHT -->
        <div>
            <div class="checkout-summary">
                <h3>Order Summary</h3>

                <div id="checkout-items"></div>

                <div class="checkout-summary__row">
                    <span>Subtotal</span>
                    <span id="checkout-subtotal">$0.00</span>
                </div>

                <div style="margin:1rem 0;">
                    <input id="coupon-code" placeholder="Coupon Code">
                    <button type="button" class="btn btn--outline" onclick="applyCoupon()">
                        Apply Coupon
                    </button>
                    <small id="coupon-msg"></small>
                </div>

                <div class="checkout-summary__row checkout-summary__total">
                    <span>Total</span>
                    <span id="checkout-total">$0.00</span>
                </div>
            </div>
        </div>

    </div>
</div>
</main>

<script>
let cartItems = [];
let subtotal = 0;
let discount = 0;
let appliedCoupon = null;
let selectedAddressId = null;

/* CART */
function loadCheckoutItems(){
    fetch("{{ route('getCartItems') }}")
        .then(res => res.json())
        .then(data => {
            cartItems = data.items ?? [];
            subtotal = 0;
            const c = document.getElementById('checkout-items');
            c.innerHTML = '';

            if(cartItems.length === 0){
                c.innerHTML = '<p>No items</p>';
                updateTotals();
                return;
            }

            cartItems.forEach(i=>{
                subtotal += i.quantity * i.price;
                c.innerHTML += `
                    <div class="cart-item">
                        <div class="cart-item-info">
                            <img src="${i.product_image}">
                            <span>${i.product_name} x ${i.quantity}</span>
                        </div>
                        <span>$${(i.quantity*i.price).toFixed(2)}</span>
                    </div>`;
            });
            updateTotals();
        });
}

/* ADDRESSES */
function loadAddresses(){
    fetch("{{ route('user.addresses') }}")
        .then(res => res.json())
        .then(res => {
            const c = document.getElementById('addresses-list');
            c.innerHTML = '';

            if(!res.data || res.data.length === 0){
                c.innerHTML = '<p>No addresses found</p>';
                return;
            }

            res.data.forEach(a=>{
                c.innerHTML += `
                    <label class="selection-card" onclick="selectAddressCard(this)" style="margin-bottom: 1rem;">
                        <input type="radio" name="address_id" value="${a.id}">
                        <div class="selection-card-icon"><i class="fas fa-map-marker-alt"></i></div>
                        <div class="selection-content">
                            <div class="selection-title">${a.city_name || 'Shipping Address'}</div>
                            <div class="selection-desc">
                                ${a.address}, B:${a.building_no}, F:${a.floor_no}, Flat:${a.flat_no}<br>
                                <strong style="color: var(--text-primary);"><i class="fas fa-phone-alt" style="font-size:0.8rem;"></i> ${a.phone ?? 'No phone added'}</strong>
                            </div>
                        </div>
                    </label>`;
            });

            document
                .querySelectorAll('input[name="address_id"]')
                .forEach(radio=>{
                    radio.addEventListener('change', function(){
                        selectedAddressId = this.value;
                    });
                });
        });
}

function toggleAddressForm(){
    const f = document.getElementById('new-address-form');
    f.style.display = (f.style.display === 'none') ? 'block' : 'none';
}

function saveAddress(){
    fetch("{{ route('user.address.store') }}",{
        method:'POST',
        headers:{
            'Content-Type':'application/json',
            'X-CSRF-TOKEN':'{{ csrf_token() }}'
        },
        body: JSON.stringify({
            governorate_id: document.getElementById('governorate_id').value,
            city_id: document.getElementById('city_id').value,
            address: document.getElementById('address').value,
            building_no: document.getElementById('building_no').value,
            floor_no: document.getElementById('floor_no').value,
            flat_no: document.getElementById('flat_no').value,
            phone: document.getElementById('phone').value
        })
    })
    .then(()=> {
        toggleAddressForm();
        loadAddresses();
    });
}

/* COUPON */
function applyCoupon(){
    const code = document.getElementById('coupon-code').value;
    const msg  = document.getElementById('coupon-msg');

    fetch("{{ route('verify_coupon') }}",{
        method:'POST',
        headers:{
            'Content-Type':'application/json',
            'X-CSRF-TOKEN':'{{ csrf_token() }}'
        },
        body: JSON.stringify({ code })
    })
    .then(res=>res.json())
    .then(res=>{
        if(res.status !== 200){
            msg.innerText = res.message;
            discount = 0;
        }else{
            discount = subtotal * 0.1;
            appliedCoupon = code;
            msg.innerText = 'Coupon Applied';
        }
        updateTotals();
    });
}

/* TOTAL */
function updateTotals(){
    document.getElementById('checkout-subtotal').innerText = `$${subtotal.toFixed(2)}`;
    document.getElementById('checkout-total').innerText = `$${(subtotal-discount).toFixed(2)}`;
}

/* ORDER */
document.getElementById('checkout-form').addEventListener('submit',function(e){
    e.preventDefault();

    if(!selectedAddressId){
        alert('Please select address');
        return;
    }

    fetch("{{ route('create_order') }}",{
        method:'POST',
        headers:{
            'Content-Type':'application/json',
            'X-CSRF-TOKEN':'{{ csrf_token() }}'
        },
        body: JSON.stringify({
            total: subtotal,
            total_after_coupon: subtotal-discount,
            status: document.querySelector('input[name="status"]:checked').value,
            service: 0,
            code: appliedCoupon,
            payment_referrence: 'ref_'+Date.now(),
            user_address_id: selectedAddressId,
            items: cartItems.map(i=>({
                product_id:i.product_id,
                price:i.price,
                quantity:i.quantity,
                color_id:i.color_id ?? null
            }))
        })
    })
    .then(res=>res.json())
    .then(res=>{
        alert(res.message);
        if(res.status === 200){
            window.location.href = "{{ route('user_cart') }}";
        }
    });
});

document.addEventListener('DOMContentLoaded',()=>{
    loadCheckoutItems();
    loadAddresses();
});

/* SELECTION TOGGLERS */
function selectPaymentCard(element) {
    document.querySelectorAll('input[name="status"]').forEach(r => r.closest('.selection-card').classList.remove('selected'));
    element.classList.add('selected');
}

function selectAddressCard(element) {
    document.querySelectorAll('input[name="address_id"]').forEach(r => r.closest('.selection-card').classList.remove('selected'));
    element.classList.add('selected');
    selectedAddressId = element.querySelector('input').value;
}
</script>

@endsection
