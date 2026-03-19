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
    border:1px solid #eee;
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
.box{
    border:1px solid #ddd;
    padding:10px;
    border-radius:5px;
    margin-bottom:10px;
}
label{
    cursor:pointer;
    display:block;
}
input, select{
    width:100%;
    padding:8px;
    margin-bottom:8px;
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
                <h3 style="margin-top:2rem;">Payment Method</h3>
                <div class="box">
                    <label>
                        <input type="radio" name="status" value="0" checked>
                        Cash on Delivery
                    </label>
                    <label>
                        <input type="radio" name="status" value="1">
                        Visa / Card
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
                    <label class="box">
                        <input type="radio" name="address_id" value="${a.id}">
                        ${a.address} - B:${a.building_no}
                        F:${a.floor_no} A:${a.flat_no}
                        <br><small>${a.phone}</small>
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
</script>

@endsection
