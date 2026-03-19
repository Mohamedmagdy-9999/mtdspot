@extends('website.layout')
@section('content')
    <main>
        <!-- Hero Slider (now secondary slider) -->
        <section class="slider" style="margin-bottom: 0;">
            <div class="slider__container">
                @foreach($sliders as $slider)
                <div class="slider__slide" style="min-height: 100vh; padding: 0; display: block; background: url('{{ $slider->image_url }}') no-repeat center center/cover; position: relative;">
                    <!-- Overlay to improve text readability -->
                    <div style="position: absolute; top:0; left:0; width:100%; height:100%; background: rgba(0,0,0,0.4);"></div>
                    
                    <div class="container" style="position: relative; height: 100vh; display: flex; align-items: center; justify-content: center; text-align: center;">
                        <div class="slider__content" style="max-width: 800px; padding: 2rem;">
                            <h1 class="slider__title" style="color: #ffffff; text-shadow: 2px 2px 4px rgba(0,0,0,0.5);">
                                {{$slider->name_en}} <span class="slider__title-highlight"></span>
                            </h1>
                            <p class="slider__description" style="color: #f8f9fa; font-size: 1.25rem; text-shadow: 1px 1px 3px rgba(0,0,0,0.5);">
                               {{$slider->desc_en}}
                            </p>
                            {{-- <a href="products.html" class="btn btn--primary btn--lg">Shop Now <i class="fas fa-arrow-right"></i></a> --}}
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <button class="slider__nav slider__nav--prev" aria-label="Previous slide" style="background: rgba(255,255,255,0.8); color: #333;"><i class="fas fa-chevron-left"></i></button>
            <button class="slider__nav slider__nav--next" aria-label="Next slide" style="background: rgba(255,255,255,0.8); color: #333;"><i class="fas fa-chevron-right"></i></button>
            <!-- <div class="slider__indicators">
                <button class="slider__indicator slider__indicator--active" aria-label="Slide 1"></button>
                <button class="slider__indicator" aria-label="Slide 2"></button>
            </div> -->
        </section>

        <div class="container" style="padding-top: 4rem;">
            <!-- Category Section -->
            <section class="section">
                <h2 class="section__title animate-on-scroll" style="text-align: center;">Choose Your Category</h2>
                <div class="grid grid--5">
                    @foreach($cats as $cat)
                        <a href="{{route('single_category',$cat->id)}}" style="text-decoration: none;">
                        <div class="category-card animate-on-scroll" style="transition: transform 0.3s ease; text-align: center;">
                            <div class="category-card__image" style="width: 120px; height: 120px; margin: 0 auto 1.5rem; border-radius: 50%; overflow: hidden; background: #f0f0f0; box-shadow: 0 4px 10px rgba(0,0,0,0.1);">
                                @if($cat->image_url)
                                    <img src="{{ $cat->image_url }}" alt="{{$cat->name_en}}" style="width: 100%; height: 100%; object-fit: cover;">
                                @else
                                    <div style="height: 100%; display: flex; align-items: center; justify-content: center;">
                                        <i class="fas fa-couch" style="font-size: 2.5rem; color: #ccc;"></i>
                                    </div>
                                @endif
                            </div>
                            <h3 class="category-card__title" style="color: var(--text-primary); font-size: 1.1rem; font-weight: bold;">{{$cat->name_en}}</h3>
                        </div>
                        </a>
                    @endforeach
                   
                </div>
            </section>

            <!-- Best Selling Products Section -->
            <section class="section" style="margin-top: 4rem;">
                <div class="section__header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2.5rem;">
                    <h2 class="section__title animate-on-scroll" style="margin-bottom: 0;">Best Selling Products</h2>
                    <a href="#" style="color: var(--primary-color); font-weight: bold; text-decoration: none; font-size: 1rem; display: flex; align-items: center;">
                        See More <i class="fas fa-arrow-right" style="margin-left: 8px;"></i>
                    </a>
                </div>
                <div class="grid grid--4" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap: 20px;">
                    @if(isset($best_products))
                        @forelse($best_products as $product)
                            <div class="product-card" style="background: #fff; border: 1px solid #f0f0f0; border-radius: 8px; overflow: hidden; position: relative; transition: box-shadow 0.3s ease; display: flex; flex-direction: column; text-align: center;">
                                <a href="{{route('single_product', $product->id)}}" style="display: block; text-decoration: none; color: inherit; height: 100%;">
                                    <!-- Product Image -->
                                    <div style="padding: 1.5rem; border-bottom: 1px solid #f8f9fa;">
                                        <img src="{{ $product->clean_image_link_1 }}" alt="{{ $product->name_en }}" style="width: 100%; height: 180px; object-fit: contain;">
                                    </div>
                                    
                                    <!-- Product Details -->
                                    <div style="padding: 1rem;">
                                        <h3 style="color: #333; font-size: 15px; margin-bottom: 6px; font-weight: 600; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $product->name_en }}</h3>
                                        
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
                                            <span style="font-weight: 700; font-size: 16px; color: #2d3748;">{{ number_format($product->price, 2) }} EGP</span>
                                            <i class="fas fa-shopping-cart" style="color: var(--primary-color); font-size: 18px; cursor: pointer; padding: 5px;" onclick="event.preventDefault(); addToCartQuick({{ $product->id }});"></i>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @empty
                            <p style="color: var(--text-secondary);">No products available.</p>
                        @endforelse
                    @endif
                </div>
            </section>


            <!-- Promotional Banners -->
            {{-- <section class="section">
                <div class="promo-banners-grid">
                    <div class="promo-banner promo-banner--dark animate-on-scroll">
                        <div class="promo-banner__content">
                            <div class="promo-banner__badge">UP TO 20% OFF</div>
                            <h3 class="promo-banner__title">Modern & Minimal</h3>
                            <p class="promo-banner__description">Don't miss avail the saving opportunity</p>
                            <a href="products.html" class="btn promo-banner__button promo-banner__button--green">Shop Now <i class="fas fa-arrow-right"></i></a>
                        </div>
                        <div class="promo-banner__image-wrapper">
                            <img src="https://via.placeholder.com/400x300?text=Modern+Furniture" alt="Modern Furniture" class="promo-banner__image">
                        </div>
                    </div>
                    <div class="promo-banner promo-banner--light animate-on-scroll">
                        <div class="promo-banner__content">
                            <div class="promo-banner__badge">UP TO 20% OFF</div>
                            <h3 class="promo-banner__title">New Sofa Collections</h3>
                            <p class="promo-banner__description">Discover our latest sofa collections</p>
                            <a href="products.html" class="btn promo-banner__button promo-banner__button--orange">Shop Now <i class="fas fa-arrow-right"></i></a>
                        </div>
                        <div class="promo-banner__image-wrapper">
                            <img src="https://via.placeholder.com/400x300?text=Sofa+Collection" alt="Sofa Collection" class="promo-banner__image">
                        </div>
                    </div>
                    <div class="promo-banner promo-banner--light promo-banner--full animate-on-scroll">
                        <div class="promo-banner__content">
                            <div class="promo-banner__badge">UP TO 20% OFF</div>
                            <h3 class="promo-banner__title">Save An Extra <span class="promo-banner__title-highlight">50%</span></h3>
                            <p class="promo-banner__description">Limited time offer on selected items</p>
                            <a href="products.html" class="btn promo-banner__button promo-banner__button--black">Shop Now <i class="fas fa-arrow-right"></i></a>
                        </div>
                        <div class="promo-banner__image-wrapper">
                            <img src="https://via.placeholder.com/600x300?text=Special+Offer" alt="Special Offer" class="promo-banner__image">
                        </div>
                    </div>
                </div>
            </section> --}}
        </div>
    </main>
@endsection
@push('scripts')
<script>
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
            // Optional: update cart badge here
        } else {
            alert('حدث خطأ');
        }
    }).catch(err => console.error(err));
}
</script>
@endpush