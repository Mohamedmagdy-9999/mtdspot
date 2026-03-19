@extends('website.layout')

@section('content')
<style>
    .product-card {
        position: relative;
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0,0,0,.1);
        overflow: hidden;
        display: flex;
        flex-direction: column;
    }

    .product-card__image img {
        width: 100%;
        height: 220px;
        object-fit: cover;
    }

    .product-card__content {
        padding: 15px;
        text-align: center;
    }

    .product-card__title {
        font-size: 16px;
        margin-bottom: 8px;
    }

    .product-card__price {
        color: #555;
        margin-bottom: 10px;
    }

    .wishlist-remove {
        position: absolute;
        top: 10px;
        right: 10px;
        background: #fff;
        border: none;
        font-size: 18px;
        cursor: pointer;
        border-radius: 50%;
        padding: 6px 9px;
        box-shadow: 0 2px 6px rgba(0,0,0,.2);
    }

    .empty-state {
        text-align: center;
        padding: 4rem 1rem;
    }

    .empty-state__icon {
        font-size: 48px;
        margin-bottom: 1rem;
    }
</style>

<main>
    <div class="page-header">
        <div class="container">
            <h1 class="page-header__title">My Wishlist</h1>
            <nav class="page-header__breadcrumb" aria-label="Breadcrumb">
                <a href="{{ route('home') }}" class="page-header__breadcrumb-link">Home</a>
                <span class="page-header__breadcrumb-separator">/</span>
                <span>Wishlist</span>
            </nav>
        </div>
    </div>

    <div class="container">
        <!-- Wishlist Items -->
        <div id="wishlist-items" class="grid grid--4"></div>

        <!-- Empty State -->
        <div id="empty-wishlist" class="empty-state" style="display:none;">
            <div class="empty-state__icon">❤️</div>
            <h3 class="empty-state__title">Your wishlist is empty</h3>
            <p class="empty-state__description">Start adding items you love</p>
            <a href="{{ route('home') }}" class="btn btn--primary" style="margin-top:1rem;">
                Browse Products
            </a>
        </div>
    </div>
</main>
@endsection


@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    loadWishlist();
});

function loadWishlist() {
    fetch("{{ route('myFavorites') }}", {
        method: 'GET',
        headers: {
            'Accept': 'application/json'
        }
    })
    .then(res => res.json())
    .then(data => {
        const container = document.getElementById('wishlist-items');
        const emptyState = document.getElementById('empty-wishlist');

        container.innerHTML = '';

        if (data.status !== 200 || data.data.length === 0) {
            emptyState.style.display = 'block';
            return;
        }

        emptyState.style.display = 'none';

        data.data.forEach(product => {
            container.innerHTML += `
                <div class="product-card">
                    <div class="product-card__image">
                        <img src="${product.clean_image_link_1}" alt="${product.name_en}">
                        <button class="wishlist-remove"
                            onclick="toggleFavorite(${product.id})"
                            title="Remove from wishlist">
                            ❤️
                        </button>
                    </div>

                    <div class="product-card__content">
                        <h3 class="product-card__title">${product.name_en}</h3>
                        <p class="product-card__price">${product.price}</p>
                        <a href="{{ url('product') }}/${product.id}"
                           class="btn btn--primary">
                           View Details
                        </a>
                    </div>
                </div>
            `;
        });
    })
    .catch(error => {
        console.error(error);
    });
}

function toggleFavorite(productId) {
    fetch("{{ route('toggleFavorite') }}", {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ product_id: productId })
    })
    .then(res => res.json())
    .then(data => {
        if (data.status === 200) {
            loadWishlist(); // تحديث القائمة
        }
    });
}
</script>
@endpush
