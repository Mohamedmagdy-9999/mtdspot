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
    background: #f9f9f9;
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
    border: 1px solid #ccc;
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

/* === Product Card === */
.product-card {
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
    color: #111;
    font-size: 16px;
    margin-bottom: 8px;
    line-height: 1.4;
}

.product-card__price {
    color: #555;
    margin-bottom: 10px;
}

.product-card a.btn--primary {
    display: inline-block;
    padding: 8px 12px;
    background: #007bff;
    color: #fff;
    text-decoration: none;
    border-radius: 5px;
    font-size: 14px;
}

.product-card a.btn--primary:hover {
    background: #0056b3;
}

/* === Page Header === */
.page-header {
    padding: 20px 0;
    background: #f1f1f1;
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
    color: #555;
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
                        data-category="{{ $category->name_en }}">
                        
                        <div class="product-card__image">
                            <img src="{{ $product->clean_image_link_1 }}" alt="{{ $product->name_en }}">
                        </div>

                        <div class="product-card__content">
                            <h3 class="product-card__title">{{ $product->name_en }}</h3>
                            <p class="product-card__price">{{ number_format($product->price, 2) }} EGP</p>
                            <a href="{{route('single_product',$product->id)}}" class="btn btn--primary btn--sm">
                                View Details
                            </a>
                        </div>

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
</script>
@endpush
