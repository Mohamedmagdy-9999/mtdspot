@extends('website.layout')
@section('content')
<style>
.cart-item { 
    display:flex; 
    justify-content:space-between; 
    margin-bottom:1rem; 
    align-items:center; 
}
.cart-item img { 
    width:60px; 
    height:60px; 
    object-fit:cover; 
    margin-right:10px; 
    border-radius:5px; 
}
.cart-item-info { 
    display:flex; 
    align-items:center; 
    flex:1;
}
.cart-item button { 
    background:red;
    color:white;
    border:none;
    padding:0.3rem 0.6rem;
    border-radius:4px; 
    cursor:pointer; 
}
</style>

<main>
    <div class="container">
        <h1>Shopping Cart</h1>
        <div style="display:grid; grid-template-columns:1fr 300px; gap:2rem;">
            <div>
                <div id="cart-items"></div>
                <div id="empty-cart" style="display:none; text-align:center; margin-top:2rem;">
                    <h3>Your cart is empty 🛒</h3>
                   
                </div>
            </div>

            <div>
                <div style="border:1px solid #eee; padding:1rem; border-radius:5px;">
                    <h2>Order Summary</h2>
                    <div style="display:flex; justify-content:space-between;"><span>Subtotal</span><span id="subtotal">$0.00</span></div>
                    <div style="display:flex; justify-content:space-between;"><span>Total</span><span id="total">$0.00</span></div>
                    <a href="{{route('checkout')}}" class="btn--primary" style="width:100%; margin-top:1rem;">Proceed to Checkout</a>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
function loadCartItems(){
    fetch("{{ route('getCartItems') }}")
    .then(res=>res.json()).then(data=>{
        const container=document.getElementById('cart-items');
        const emptyCart=document.getElementById('empty-cart');
        const subtotalEl=document.getElementById('subtotal');
        const totalEl=document.getElementById('total');

        if(data.items.length>0){
            emptyCart.style.display='none';
            container.innerHTML='';
            let subtotal=0;
            data.items.forEach(item=>{
                subtotal += item.quantity*item.price;
                container.innerHTML += `
                    <div class="cart-item">
                        <div class="cart-item-info">
                            <img src="${item.product_image}" alt="${item.product_name}">
                            <span>${item.product_name} x ${item.quantity}</span>
                        </div>
                        <span>$${(item.quantity*item.price).toFixed(2)}</span>
                        <button onclick="removeItem(${item.id})">Remove</button>
                    </div>
                `;
            });
            subtotalEl.innerText=`$${subtotal.toFixed(2)}`;
            totalEl.innerText=`$${subtotal.toFixed(2)}`;
        } else {
            container.innerHTML='';
            emptyCart.style.display='block';
            subtotalEl.innerText='$0.00';
            totalEl.innerText='$0.00';
        }
    });
}

function removeItem(id){
    fetch(`/cart_item/remove/${id}`, {
        method:'DELETE',
        headers:{'X-CSRF-TOKEN':'{{ csrf_token() }}'}
    }).then(res=>res.json()).then(data=>{
        alert(data.message);
        loadCartItems();
    });
}

document.addEventListener('DOMContentLoaded', loadCartItems);
</script>
@endsection
