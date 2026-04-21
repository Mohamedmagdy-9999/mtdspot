@extends('website.layout')
@section('content')
<style>
/* Modern Product Redesign */
.modern-product-grid {
    display: grid;
    grid-template-columns: 1.2fr 1fr;
    gap: 4rem;
    align-items: start;
    margin-bottom: 4rem;
}

@media(max-width: 900px) {
    .modern-product-grid {
        grid-template-columns: 1fr;
        gap: 2rem;
    }
}

.gallery-modern {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

.gallery-modern__main {
    border-radius: 1.5rem;
    overflow: hidden;
    background: var(--bg-tertiary);
    position: relative;
    box-shadow: var(--shadow-lg);
    aspect-ratio: 4/3;
}

.gallery-modern__main img {
    width: 100%;
    height: 100%;
    object-fit: contain;
    transition: transform 0.5s cubic-bezier(0.25, 0.46, 0.45, 0.94);
}

.gallery-modern__main:hover img {
    transform: scale(1.08);
}

.gallery-modern__thumbs {
    display: flex;
    gap: 1rem;
    overflow-x: auto;
    padding-bottom: 0.5rem;
}

.gallery-modern__thumb {
    width: 80px;
    height: 80px;
    border-radius: 0.75rem;
    cursor: pointer;
    border: 2px solid transparent;
    opacity: 0.5;
    transition: all 0.3s ease;
    object-fit: cover;
    background: var(--bg-tertiary);
}

.gallery-modern__thumb.active, .gallery-modern__thumb:hover {
    opacity: 1;
    border-color: var(--primary-color);
    box-shadow: 0 4px 12px rgba(255, 183, 3, 0.2);
    transform: translateY(-2px);
}

.product-info-modern {
    padding: 2.5rem;
    background: var(--bg-secondary);
    border-radius: 1.5rem;
    border: 1px solid var(--border-color);
    box-shadow: var(--shadow-md);
}

.product-title {
    font-size: 2.5rem;
    font-weight: 800;
    line-height: 1.2;
    margin-bottom: 1rem;
    color: var(--text-primary);
    letter-spacing: -0.5px;
}

.product-price-badge {
    display: inline-block;
    background: var(--primary-color);
    color: var(--bg-dark);
    padding: 0.5rem 1.5rem;
    border-radius: 2rem;
    font-size: 1.5rem;
    font-weight: 800;
    margin-bottom: 2rem;
    box-shadow: 0 4px 15px rgba(255, 183, 3, 0.3);
}

.action-bar {
    display: flex;
    gap: 1rem;
    margin-top: 2rem;
    align-items: stretch;
    flex-wrap: wrap;
}

.qty-modern {
    display: flex;
    align-items: center;
    background: var(--bg-primary);
    border: 1px solid var(--border-color);
    border-radius: 0.75rem;
    overflow: hidden;
}

.qty-modern button {
    padding: 0 1.25rem;
    height: 100%;
    font-size: 1.2rem;
    background: var(--bg-tertiary);
    color: var(--text-primary);
    border: none;
    cursor: pointer;
    transition: background 0.3s ease;
}

.qty-modern button:hover {
    background: var(--border-color);
}

.qty-modern input {
    width: 60px;
    text-align: center;
    background: transparent;
    border: none;
    color: var(--text-primary);
    font-weight: bold;
    font-size: 1.1rem;
}

.qty-modern input:focus {
    outline: none;
}

.btn-anim {
    transition: transform 0.2s ease, box-shadow 0.2s ease, background 0.3s ease;
    border-radius: 0.75rem;
    padding: 1rem 2rem;
    font-weight: 700;
    flex: 1;
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 8px;
}

.btn-anim:active {
    transform: scale(0.96);
}

.review-card {
    background: var(--bg-primary);
    padding: 1.5rem 2rem;
    border-radius: 1rem;
    border: 1px solid var(--border-color);
    margin-bottom: 1rem;
    position: relative;
    box-shadow: var(--shadow-sm);
    transition: transform 0.3s ease;
}

.review-card:hover {
    transform: translateX(5px);
    border-color: var(--primary-color);
}

.review-card::before {
    content: '\201D';
    position: absolute;
    top: -10px;
    right: 20px;
    font-size: 6rem;
    color: var(--bg-tertiary);
    font-family: serif;
    line-height: 1;
    z-index: 0;
    opacity: 0.5;
}

.review-card-content {
    position: relative;
    z-index: 1;
}

.review-author {
    font-weight: 700;
    color: var(--primary-color);
    font-size: 1.1rem;
    margin-bottom: 0.25rem;
}

.review-rating {
    color: var(--warning-color);
    font-size: 0.9rem;
    margin-bottom: 1rem;
}

.tabs-modern {
    display: flex;
    gap: 1rem;
    margin-bottom: 2rem;
}

.tab-pill {
    padding: 0.75rem 2rem;
    border-radius: 2rem;
    background: var(--bg-secondary);
    border: 1px solid var(--border-color);
    color: var(--text-secondary);
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
}

.tab-pill:hover, .tab-pill.active {
    background: var(--primary-color);
    color: var(--bg-dark);
    border-color: var(--primary-color);
}
</style>
<main>
    <div class="page-header">
        <div class="container">
            <nav class="page-header__breadcrumb" aria-label="Breadcrumb">
                <a href="{{ route('home') }}" class="page-header__breadcrumb-link">Home</a>
                <span class="page-header__breadcrumb-separator">/</span>
                <a href="" class="page-header__breadcrumb-link">Products</a>
                <span class="page-header__breadcrumb-separator">/</span>
                <span id="breadcrumb-product">{{ $product->name_en }}</span>
            </nav>
        </div>
    </div>

    <div class="container">
        <!-- Product Details Modern -->
        <div id="product-details" class="modern-product-grid">
            
            <!-- Gallery -->
            <div class="gallery-modern">
                <div class="gallery-modern__main">
                    <img src="{{ $product->clean_image_link_1 }}" alt="{{ $product->name_en }}" id="main-image">
                </div>
                <div class="gallery-modern__thumbs">
                    @forelse($product->colors ?? [] as $color)
                        <img src="{{ $product->clean_image_link_1 }}" alt="{{ $product->name_en }}" 
                             class="gallery-modern__thumb {{ $loop->first ? 'active' : '' }}"
                             onclick="changeMainImage(this.src, this)">
                    @empty
                        <img src="{{ $product->clean_image_link_1 }}" alt="{{ $product->name_en }}" 
                             class="gallery-modern__thumb active"
                             onclick="changeMainImage(this.src, this)">
                    @endforelse
                </div>
            </div>

            <!-- Product Info -->
            <div class="product-info-modern">
                <h1 class="product-title">{{ $product->name_en }}</h1>

                <div class="product-price-badge">
                    {{ number_format($product->price, 2) }} EGP
                </div>

                <p style="color: var(--text-secondary); margin-bottom: 2rem; line-height: 1.8; font-size: 1.1rem;">
                    {{ $product->desc_en }}
                </p>

                <!-- Colors -->
                @if($product->colors)
                    <div style="margin-bottom: 2rem;">
                        <label style="display:block; margin-bottom:0.75rem; color:var(--text-secondary); font-weight:600;">Available Colors</label>
                        <div style="display: flex; gap: 0.75rem; flex-wrap: wrap;">
                            @foreach($product->colors as $color)
                                <button class="btn btn--outline" style="border-radius: 2rem;" onclick="selectColor(this, '{{ $color->color }}')">{{ $color->color }}</button>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Action Bar (Qty, Cart, Favorite) -->
                <div class="action-bar">
                    <div class="qty-modern">
                        <button onclick="decreaseQuantity()">-</button>
                        <input type="number" id="quantity-input" value="1" min="1">
                        <button onclick="increaseQuantity()">+</button>
                    </div>

                    <button class="btn btn--primary btn-anim" onclick="addToCart({{ $product->id }})">
                        <i class="fas fa-shopping-cart"></i> Add to Cart
                    </button>
                    
                    <button class="btn btn--outline btn-anim" onclick="toggleFavorite({{ $product->id }})" id="favorite-btn" style="flex: 0 0 auto; width: 60px; padding: 0;">
                        ❤️
                    </button>
                </div>
            </div>
        </div>

        <!-- Product Tabs Modern -->
        <div class="tabs" style="margin-bottom: 4rem;">
            <div class="tabs-modern">
                <button class="tab-pill active" data-tab="description" onclick="switchTab('description', this)">Description</button>
                <button class="tab-pill" data-tab="reviews" onclick="switchTab('reviews', this)">Reviews</button>
            </div>

            <div class="tabs__content tabs__content--active" id="tab-description">
                <div style="padding: 2rem; background: var(--bg-secondary); border-radius: 1rem; border: 1px solid var(--border-color); line-height: 1.8;">
                    {{ $product->desc_en }}
                </div>
            </div>

            <div class="tabs__content" id="tab-reviews" style="display: none;">
                <div style="padding: 1rem 0;">
                   @forelse($product->comments as $comment) 
                   <div class="review-card">
                       <div class="review-card-content">
                           <div class="review-author">{{ $comment->user->name ?? 'User' }}</div>
                           <div class="review-rating">
                               @for($i=1; $i<=5; $i++)
                                   @if($i <= $comment->rate)
                                       <i class="fas fa-star" style="color:var(--primary-color)"></i>
                                   @else
                                       <i class="far fa-star"></i>
                                   @endif
                               @endfor
                           </div>
                           <p style="color: var(--text-secondary); line-height: 1.6;">{{ $comment->comment }}</p> 
                       </div>
                   </div> 
                   @empty 
                   <div style="padding: 3rem; text-align: center; background: var(--bg-secondary); border-radius: 1rem; border: dashed 2px var(--border-color); color: var(--text-secondary);">
                        <i class="fas fa-comment-slash" style="font-size: 3rem; margin-bottom: 1rem; opacity: 0.5;"></i>
                        <p>No reviews yet. Be the first to review this product!</p>
                   </div>
                   @endforelse
                </div>
            </div>
        </div>

        <!-- Similar Products -->
        <section class="section">
            <h2 class="section__title">Similar Products</h2>
            <div class="grid grid--4" id="similar-products">
                @foreach($similarProducts as $sp)
                    <div class="product-card" style="background: var(--bg-secondary); border: 1px solid var(--border-color); border-radius: 8px; overflow: hidden; position: relative; transition: box-shadow 0.3s ease; display: flex; flex-direction: column; text-align: center;">
                        <a href="{{route('single_product', $sp->id)}}" style="display: block; text-decoration: none; color: inherit; height: 100%;">
                            
                            <!-- Product Image -->
                            <div style="padding: 1.5rem; border-bottom: 1px solid var(--border-color); background: var(--bg-secondary);">
                                <img src="{{ $sp->clean_image_link_1 }}" alt="{{ $sp->name_en }}" style="width: 100%; height: 180px; object-fit: contain;">
                            </div>

                            <!-- Product Details -->
                            <div style="padding: 1rem;">
                                <h3 style="color: var(--text-primary); font-size: 15px; margin-bottom: 6px; font-weight: 600; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $sp->name_en }}</h3>
                                
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
                                    <span style="font-weight: 700; font-size: 16px; color: var(--text-primary);">{{ number_format($sp->price, 2) }} EGP</span>
                                    <i class="fas fa-shopping-cart product-card__cart" style="color: var(--primary-color); font-size: 18px; cursor: pointer; padding: 5px;" onclick="event.preventDefault(); addToCartQuick({{ $sp->id }});"></i>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </section>
    </div>
</main>



@endsection
@push('scripts')


<script>
let selectedColor=null;

function switchTab(tabId, element) {
    document.querySelectorAll('.tab-pill').forEach(t => t.classList.remove('active'));
    element.classList.add('active');
    document.getElementById('tab-description').style.display = 'none';
    document.getElementById('tab-reviews').style.display = 'none';
    document.getElementById('tab-' + tabId).style.display = 'block';
}

function changeMainImage(src, element){
    document.getElementById('main-image').src=src;
    document.querySelectorAll('.gallery__thumbnail').forEach(t=>t.classList.remove('gallery__thumbnail--active'));
    element.classList.add('gallery__thumbnail--active');
}

function decreaseQuantity(){
    const input=document.getElementById('quantity-input');
    let val=parseInt(input.value)||1;
    if(val>1) input.value=val-1;
}
function increaseQuantity(){
    const input=document.getElementById('quantity-input');
    let val=parseInt(input.value)||1;
    input.value=val+1;
}

function addToCart(productId){
    const input = document.getElementById('quantity-input');
    const quantity = input ? (parseInt(input.value) || 1) : 1;
    fetch("{{ route('addtocart') }}",{
        method:'POST',
        headers:{'Content-Type':'application/json','X-CSRF-TOKEN':'{{ csrf_token() }}'},
        body:JSON.stringify({product_id:productId, quantity:quantity})
    }).then(res=>res.json()).then(data=>{
        if(data.status===200) alert(data.message);
        else alert('حدث خطأ');
    });
}

function addToCartQuick(productId){
    fetch("{{ route('addtocart') }}",{
        method:'POST',
        headers:{'Content-Type':'application/json','X-CSRF-TOKEN':'{{ csrf_token() }}'},
        body:JSON.stringify({product_id:productId, quantity:1})
    }).then(res=>res.json()).then(data=>{
        if(data.status===200) alert('Item added to cart!');
        else alert('حدث خطأ');
    });
}
</script>
<script>
function toggleFavorite(productId){
    fetch("{{ route('toggleFavorite') }}", {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            product_id: productId
        })
    })
    .then(res => res.json())
    .then(data => {
        if(data.status === 200){
            alert(data.message);

            const btn = document.getElementById('favorite-btn');

            if(data.data === true){
                btn.innerHTML = '❤️ In Favorites';
                btn.style.color = 'red';
            }else{
                btn.innerHTML = '🤍 Add to Favorites';
                btn.style.color = '';
            }
        }else{
            alert('Something went wrong');
        }
    })
    .catch(err => {
        console.error(err);
        alert('Error occurred');
    });
}
</script>

@endpush