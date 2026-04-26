@extends('website.layout')
@section('content')
<style>
/* Modern Cart Layout */
.cart-grid {
    display: grid;
    grid-template-columns: 1fr 350px;
    gap: 2rem;
    margin-top: 2rem;
    align-items: start;
}

@media(max-width: 900px) {
    .cart-grid {
        grid-template-columns: 1fr;
    }
}

.cart-item-modern {
    display: flex;
    align-items: stretch;
    background: var(--bg-secondary);
    border: 1px solid var(--border-color);
    border-radius: 1rem;
    margin-bottom: 1.5rem;
    overflow: hidden;
    position: relative;
    box-shadow: var(--shadow-sm);
    transition: transform 0.3s ease;
}

.cart-item-modern:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-md);
    border-color: var(--primary-color);
}

.cart-item-modern img {
    width: 130px;
    height: 130px;
    object-fit: contain;
    background: var(--bg-tertiary);
    padding: 0.5rem;
}

.cart-item-info-modern {
    padding: 1.5rem;
    display: flex;
    flex-direction: column;
    justify-content: center;
    flex: 1;
}

.cart-item-title {
    font-size: 1.25rem;
    font-weight: 700;
    color: var(--text-primary);
    margin-bottom: 0.5rem;
}

.cart-item-price {
    color: var(--primary-color);
    font-weight: 800;
    font-size: 1.1rem;
    margin-bottom: 0.5rem;
}

.cart-item-qty {
    color: var(--text-secondary);
    font-size: 0.9rem;
}

.cart-item-remove {
    position: absolute;
    top: 1rem;
    right: 1rem;
    background: rgba(239, 68, 68, 0.1);
    color: #ef4444;
    border: none;
    width: 35px;
    height: 35px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s ease;
}

.cart-item-remove:hover {
    background: #ef4444;
    color: white;
}

.cart-summary-modern {
    background: var(--bg-secondary);
    border: 1px solid var(--border-color);
    border-radius: 1rem;
    padding: 2rem;
    position: sticky;
    top: 100px;
    box-shadow: var(--shadow-md);
}

.cart-summary-title {
    font-size: 1.5rem;
    font-weight: 800;
    margin-bottom: 1.5rem;
    padding-bottom: 1rem;
    border-bottom: 1px dashed var(--border-color);
    color: var(--text-primary);
}

.summary-row {
    display: flex;
    justify-content: space-between;
    margin-bottom: 1rem;
    font-size: 1.1rem;
    color: var(--text-secondary);
}

.summary-total {
    font-size: 1.5rem;
    font-weight: 800;
    color: var(--primary-color);
    margin-top: 1rem;
    padding-top: 1rem;
    border-top: 1px dashed var(--border-color);
}
</style>

<main>
    <div class="page-header">
        <div class="container">
            <h1 class="page-header__title">Shopping Cart</h1>
            <nav class="page-header__breadcrumb" aria-label="Breadcrumb">
                <a href="{{ route('home') }}" class="page-header__breadcrumb-link">Home</a>
                <span class="page-header__breadcrumb-separator">/</span>
                <span>Cart</span>
            </nav>
        </div>
    </div>
    <div class="container">
        <div class="cart-grid">
            <div>
                <div id="cart-items"></div>
                <div id="empty-cart" style="display:none; text-align:center; padding: 4rem 0; background: var(--bg-secondary); border-radius: 1rem; border: 1px dashed var(--border-color);">
                    <i class="fas fa-shopping-cart" style="font-size: 4rem; color: var(--text-secondary); opacity: 0.5; margin-bottom: 1rem;"></i>
                    <h3 style="color: var(--text-primary); margin-bottom: 0.5rem;">Your cart is empty</h3>
                    <p style="color: var(--text-secondary);">Looks like you haven't added anything yet.</p>
                    <a href="{{ route('home') }}" class="btn btn--primary" style="margin-top: 1.5rem;">Continue Shopping</a>
                </div>
            </div>

            <div>
                <div class="cart-summary-modern">
                    <h2 class="cart-summary-title">Order Summary</h2>
                    <div class="summary-row">
                        <span>Subtotal</span>
                        <span id="subtotal">0.00 EGP</span>
                    </div>
                    <div class="summary-row summary-total">
                        <span>Total</span>
                        <span id="total">0.00 EGP</span>
                    </div>
                    <a href="{{route('checkout')}}" class="btn btn--primary btn-anim" style="width:100%; margin-top:2rem; padding: 1rem; font-size: 1.1rem; border-radius: 0.75rem; text-align: center;">
                        Proceed to Checkout <i class="fas fa-arrow-right" style="margin-left: 5px;"></i>
                    </a>
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
                    <div class="cart-item-modern">
                        <img src="${item.product_image}" alt="${item.product_name}">
                        <div class="cart-item-info-modern">
                            <h3 class="cart-item-title">${item.product_name}</h3>
                            <div class="cart-item-price">${parseFloat(item.price).toFixed(2)} EGP</div>
                            <div class="cart-item-qty">Quantity: <strong>${item.quantity}</strong></div>
                        </div>
                        <button class="cart-item-remove" onclick="removeItem(${item.id})" title="Remove Item">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                `;
            });
            subtotalEl.innerText=`${subtotal.toFixed(2)} EGP`;
            totalEl.innerText=`${subtotal.toFixed(2)} EGP`;
        } else {
            container.innerHTML='';
            emptyCart.style.display='block';
            subtotalEl.innerText='0.00 EGP';
            totalEl.innerText='0.00 EGP';
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
