@extends('website.layout')

@section('content')
<main>

<style>
/* === General Styles === */
.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 1rem;
}

/* === Filters Sidebar === */
.filters {
    background: var(--bg-secondary);
    color: var(--text-primary);
    padding: 20px;
    border-radius: 10px;
    font-family: sans-serif;
}

.filters__title {
    font-size: 18px;
    font-weight: bold;
    margin-bottom: 15px;
}

.filters__group {
    margin-bottom: 20px;
}

.filters__group-title {
    font-weight: 600;
    margin-bottom: 10px;
}

.filters__option {
    display: flex;
    align-items: center;
    margin-bottom: 8px;
}

.filters__option input[type="radio"],
.filters__option input[type="checkbox"] {
    margin-right: 8px;
}

.filters__option label {
    font-size: 14px;
    cursor: pointer;
}

.filters input[type="number"] {
    width: 100%;
    padding: 6px 10px;
    border-radius: 5px;
    border: 1px solid var(--border-color);
    background: var(--bg-primary);
    color: var(--text-primary);
}

.filters button {
    padding: 10px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-weight: 600;
}

.filters button.btn--primary {
    background: #007bff;
    color: #fff;
    margin-top: 10px;
}

.filters button.btn--primary:hover {
    background: #0056b3;
}

/* === Products Grid === */
.grid--3 {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
    gap: 20px;
}

/* === Page Header === */
.page-header {
    padding: 20px 0;
    background: var(--bg-secondary);
    color: var(--text-primary);
    margin-bottom: 30px;
}

.page-header__title {
    font-size: 28px;
    margin-bottom: 5px;
}

.page-header__breadcrumb a {
    text-decoration: none;
    color: #007bff;
    margin-right: 5px;
}

.page-header__breadcrumb span {
    margin-right: 5px;
    color: var(--text-secondary);
}

/* === Responsive === */
@media(max-width: 768px){
    .container > div {
        grid-template-columns: 1fr;
    }

    .filters {
        margin-bottom: 20px;
    }
}
</style>

<!-- Page Header -->
<div class="page-header">
    <div class="container">
        <h1 class="page-header__title">{{ $category->name }}</h1>

        <nav class="page-header__breadcrumb">
            <a href="{{ route('home') }}">Home</a>
            <span>/</span>
            <span>{{ $category->name_en }}</span>
        </nav>
    </div>
</div>

<!-- Page Content -->
<div class="container">
    <div style="display:grid; grid-template-columns:250px 1fr; gap:2rem;">

        <!-- Filters -->
        <aside class="filters">
            <h2 class="filters__title">Filters</h2>

            <div class="filters__group">
                <h3 class="filters__group-title">Category</h3>
                <div class="filters__option">
                    <input type="radio" name="category" checked>
                    <label>{{ $category->name }}</label>
                </div>
            </div>

            <div class="filters__group">
                <h3 class="filters__group-title">Price</h3>
                <div style="display:flex; gap:.5rem;">
                    <input type="number" placeholder="Min">
                    <input type="number" placeholder="Max">
                </div>
            </div>

            <div class="filters__group">
                <h3 class="filters__group-title">Rating</h3>
                <div class="filters__option">
                    <input type="radio" name="rating" checked>
                    <label>All</label>
                </div>
                <div class="filters__option">
                    <input type="radio" name="rating">
                    <label>4+ Stars</label>
                </div>
            </div>

            <button id="apply-filters" class="btn btn--primary" style="width:100%">Apply Filters</button>

        </aside>

        <!-- Products -->
        <div>

            <!-- Sort -->
            <div class="sort" style="margin-bottom:20px;">
                <span>Sort by:</span>
                <select>
                    <option>Default</option>
                    <option>Price: Low to High</option>
                    <option>Price: High to Low</option>
                </select>
            </div>

            <!-- Products Grid -->
            <div class="grid grid--3">

                @forelse($category->products as $product)
                    <div class="product-card"
                        data-price="{{ $product->price }}"
                        data-rating="{{ $product->average_rating }}"
                        data-category="{{ $category->name_en }}"
                        style="background: var(--bg-secondary); border: 1px solid var(--border-color); border-radius: 8px; overflow: hidden; position: relative; transition: box-shadow 0.3s ease; display: flex; flex-direction: column; text-align: center;">
                        
                        <a href="{{route('single_product', $product->id)}}" style="display: block; text-decoration: none; color: inherit; height: 100%;">
                            
                            <!-- Product Image -->
                            <div style="padding: 1.5rem; border-bottom: 1px solid var(--border-color); background: var(--bg-secondary);">
                                <img src="{{ $product->clean_image_link_1 }}" alt="{{ $product->name_en }}" style="width: 100%; height: 180px; object-fit: contain;">
                            </div>

                            <!-- Product Details -->
                            <div style="padding: 1rem;">
                                <h3 style="color: var(--text-primary); font-size: 15px; margin-bottom: 6px; font-weight: 600; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $product->name_en }}</h3>
                                
                                <!-- Stars -->
                                <div style="color: #fbb308; font-size: 13px; margin-bottom: 8px;">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="far fa-star"></i>
                                </div>
                                
                                <!-- Price and Cart Icon -->
                                <div style="display: flex; justify-content: center; align-items: center; gap: 8px;">
                                    <span style="font-weight: 700; font-size: 16px; color: var(--text-primary);">{{ number_format($product->price, 2) }} EGP</span>
                                    <i class="fas fa-shopping-cart product-card__cart" style="color: var(--primary-color); font-size: 18px; cursor: pointer; padding: 5px;" onclick="event.preventDefault(); addToCartQuick({{ $product->id }});"></i>
                                </div>
                            </div>
                        </a>
                    </div>
                    @empty
                    <div class="empty-state">
                        <h3>No products found</h3>
                    </div>
                @endforelse


            </div>
        </div>
    </div>
</div>

</main>
@endsection
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const applyBtn = document.getElementById('apply-filters');
    if(!applyBtn) return;

    applyBtn.addEventListener('click', function() {

        const minPrice = parseFloat(document.querySelector('input[placeholder="Min"]').value) || 0;
        const maxPrice = parseFloat(document.querySelector('input[placeholder="Max"]').value) || Infinity;
        const ratingInput = document.querySelector('input[name="rating"]:checked');
        const rating = ratingInput ? ratingInput.nextElementSibling.innerText : '';
        const categoryInput = document.querySelector('input[name="category"]:checked');
        const selectedCategory = categoryInput ? categoryInput.nextElementSibling.innerText : '';

        const products = document.querySelectorAll('.product-card');
        let visibleCount = 0;

        products.forEach(product => {
            const price = parseFloat(product.dataset.price);
            const productRating = parseFloat(product.dataset.rating);
            const category = product.dataset.category;

            let show = true;

            // Price filter
            if(price < minPrice || price > maxPrice) show = false;

            // Rating filter
            if(rating.includes('4+') && productRating < 4) show = false;

            // Category filter
            if(selectedCategory && selectedCategory !== category) show = false;

            if(show){
                product.style.display = 'flex';
                visibleCount++;
            } else {
                product.style.display = 'none';
            }
        });

        // Empty state
        const emptyState = document.querySelector('.empty-state');
        if(emptyState){
            emptyState.style.display = visibleCount === 0 ? 'block' : 'none';
        }
    });
});

function addToCartQuick(productId) {
    fetch("{{ route('addtocart') }}",{
        method:'POST',
        headers:{
            'Content-Type':'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body:JSON.stringify({product_id: productId, quantity: 1})
    }).then(res=>res.json()).then(data=>{
        if(data.status===200) {
            alert('Item added to cart!');
        } else {
            alert('حدث خطأ');
        }
    }).catch(err => console.error(err));
}
</script>
@endpush
