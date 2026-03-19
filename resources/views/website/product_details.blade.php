@extends('website.layout')
@section('content')
<style>
    .product-card {
    position: relative;
    overflow: visible; /* بدل hidden لو كان معمول hidden */
}
.grid--3 {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
    gap: 20px;
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
        <!-- Product Details -->
        <div id="product-details" style="display: grid; grid-template-columns: 1fr 1fr; gap: 3rem; margin-bottom: 3rem;">
            <!-- Gallery -->
            <div class="gallery">
                <div class="gallery__thumbnails">
                    @foreach($product->colors ?? ['default'] as $color)
                        <img src="{{ $product->clean_image_link_1 }}" alt="{{ $product->name_en }}" 
                             class="gallery__thumbnail {{ $loop->first ? 'gallery__thumbnail--active' : '' }}"
                             onclick="changeMainImage(this.src, this)">
                    @endforeach
                </div>
                <div class="gallery__main">
                    <img src="{{ $product->clean_image_link_1 }}" alt="{{ $product->name_en }}" 
                         class="gallery__main-image" id="main-image">
                </div>
            </div>

            <!-- Product Info -->
            <div>
                <div style="margin-bottom: 1rem;">
                   
                </div>
                <h1 style="font-size: 2rem; font-weight: 700; margin-bottom: 1rem;">{{ $product->name_en }}</h1>

                <div style="margin-bottom: 1.5rem;">
                    <span class="product-card__price" style="font-size: 2rem;">
                        
                        {{ $product->price }}
                    </span>
                </div>

                <p style="color: var(--text-secondary); margin-bottom: 2rem; line-height: 1.8;">{{ $product->desc_en }}</p>

                <!-- Colors -->
                @if($product->colors)
                    <div style="margin-bottom: 1.5rem;">
                        <label class="form__label">Color</label>
                        <div style="display: flex; gap: 0.75rem;">
                            @foreach($product->colors as $color)
                                <button class="btn btn--outline" style="min-width: 80px;" onclick="selectColor(this, '{{ $color->color }}')">{{ $color->color }}</button>
                            @endforeach
                        </div>
                    </div>
                @endif

               

                <!-- Quantity -->
                <div class="quantity">
                    <button onclick="decreaseQuantity()">-</button>
                    <input type="number" id="quantity-input" value="1" min="1">
                    <button onclick="increaseQuantity()">+</button>
                </div>

                <button class="btn btn--primary" onclick="addToCart({{ $product->id }})">Add to Cart</button>
                <button 
                    class="btn btn--outline"
                    onclick="toggleFavorite({{ $product->id }})"
                    id="favorite-btn"
                >
                    ❤️ Add to Favorites
                </button>
                            
            </div>
        </div>

        <!-- Product Tabs -->
        <div class="tabs">
            <div class="tabs__list">
                <button class="tabs__tab tabs__tab--active" data-tab="description">Description</button>
                <button class="tabs__tab" data-tab="reviews">Reviews</button>
            </div>

            <div class="tabs__content tabs__content--active" data-content="description">
                <div id="product-description" style="padding: 1.5rem;">
                    <p style="margin-bottom: 1rem; line-height: 1.8;">{{ $product->desc_en }}</p>
                </div>
            </div>

            <div class="tabs__content" data-content="reviews">
                <div id="product-reviews" style="padding: 1.5rem;">
                   @forelse($product->comments as $comment) <div style="border-bottom:1px solid #eee; padding:10px 0;"> <strong>{{ $comment->user->name ?? 'User' }}</strong> <span> - Rating: {{ $comment->rate }}/5</span> <p>{{ $comment->comment }}</p> </div> @empty <p>No reviews yet</p> @endforelse
                </div>
            </div>
        </div>

        <!-- Similar Products -->
        <section class="section">
            <h2 class="section__title">Similar Products</h2>
            <div class="grid grid--4" id="similar-products">
                @foreach($similarProducts as $sp)
                    <div class="product-card" style="background: #fff; border: 1px solid #f0f0f0; border-radius: 8px; overflow: hidden; position: relative; transition: box-shadow 0.3s ease; display: flex; flex-direction: column; text-align: center;">
                        <a href="{{route('single_product', $sp->id)}}" style="display: block; text-decoration: none; color: inherit; height: 100%;">
                            
                            <!-- Product Image -->
                            <div style="padding: 1.5rem; border-bottom: 1px solid #f8f9fa;">
                                <img src="{{ $sp->clean_image_link_1 }}" alt="{{ $sp->name_en }}" style="width: 100%; height: 180px; object-fit: contain;">
                            </div>

                            <!-- Product Details -->
                            <div style="padding: 1rem;">
                                <h3 style="color: #333; font-size: 15px; margin-bottom: 6px; font-weight: 600; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $sp->name_en }}</h3>
                                
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
                                    <span style="font-weight: 700; font-size: 16px; color: #2d3748;">{{ number_format($sp->price, 2) }} EGP</span>
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