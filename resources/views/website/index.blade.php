@extends('website.layout')
@section('content')
    <main>
        <!-- Custom Hero Section from user image -->
        <section style="background-color: var(--bg-primary); color: var(--text-primary); padding: 4rem 2rem; position: relative; overflow: hidden; min-height: 80vh; display: flex; align-items: center;">
            <div class="container" style="position: relative; z-index: 2;">
                <div style="max-width: 600px;">
                    <h1 style="font-size: 4rem; font-weight: 600; line-height: 1.1; margin-bottom: 1.5rem; color: #ffffff;">
                        Interior Design You<br>Don't Have to<br>Imagine
                    </h1>
                    <p style="font-size: 1.1rem; line-height: 1.6; color: var(--text-secondary); margin-bottom: 2.5rem; max-width: 450px;">
                        Bring your dream home to life with one-on-one design help & hand-picked products tailored to your style, space, and budget.
                    </p>
                    <a href="#" class="btn" style="background-color: var(--primary-color); color: #000; padding: 1rem 2.5rem; font-weight: 600; border-radius: 8px; font-size: 1.1rem; display: inline-block; text-decoration: none;">
                        Buy Now
                    </a>
                </div>
            </div>
            
            <!-- Decorative Elements -->
            <div style="position: absolute; right: 0; top: 0; bottom: 0; width: 50%; pointer-events: none; z-index: 1;">
                <!-- Abstract ring / circle -->
                <div style="position: absolute; top: -10%; right: 10%; width: 80vh; height: 80vh; border: 2px solid rgba(251, 191, 36, 0.4); border-radius: 50%;"></div>
                
                <!-- 3D Box / Placeholder -->
                <div style="position: absolute; top: 35%; right: 25%; width: 220px; height: 220px; background: linear-gradient(135deg, #b4855d, #5a3c26); box-shadow: -15px 15px 25px rgba(0,0,0,0.5); transform: rotateX(20deg) rotateY(-30deg) rotateZ(10deg);"></div>
                
                <!-- Dark cylinder behind box -->
                <div style="position: absolute; top: 40%; right: 15%; width: 60px; height: 160px; background: #0b1120; border-radius: 30px; transform: rotate(-15deg); box-shadow: -5px 5px 15px rgba(0,0,0,0.6); z-index: -1;"></div>

                <!-- Yellow glowing spheres -->
                <div style="position: absolute; top: 25%; right: 15%; width: 45px; height: 45px; background-color: #fef08a; border-radius: 50%; box-shadow: 0 0 20px #fef08a;"></div>
                <div style="position: absolute; bottom: 20%; left: 15%; width: 55px; height: 55px; background-color: #fef08a; border-radius: 50%; box-shadow: 0 0 25px #fef08a;"></div>
            </div>
        </section>

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
                <h2 class="section__title animate-on-scroll">Choose Your Category</h2>
                <div class="grid grid--5">
                    @foreach($cats as $cat)
                        <a href="{{route('single_category',$cat->id)}}">
                        <div class="category-card animate-on-scroll">
                            <div class="category-card__icon"></div>
                            <h3 class="category-card__title">{{$cat->name_en}}</h3>
                            {{-- <div class="category-card__count">• 25 Items Chair</div> --}}
                        
                        </div>
                        </a>
                    @endforeach
                   
                </div>
            </section>

            <!-- Best Selling Products Section -->
            <section class="section" style="margin-top: 4rem;">
                <h2 class="section__title animate-on-scroll">Best Selling Products</h2>
                <div class="grid grid--4" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap: 20px;">
                    @if(isset($best_products))
                        @forelse($best_products as $product)
                            <div class="product-card" style="background: #fff; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,.1); overflow: hidden; display: flex; flex-direction: column;">
                                <div class="product-card__image">
                                    <img src="{{ $product->clean_image_link_1 }}" alt="{{ $product->name_en }}" style="width: 100%; height: 220px; object-fit: cover;">
                                </div>
                                <div class="product-card__content" style="padding: 15px; text-align: center;">
                                    <h3 class="product-card__title" style="color: #111; font-size: 16px; margin-bottom: 8px;">{{ $product->name_en }}</h3>
                                    <p class="product-card__price" style="color: #555; margin-bottom: 10px;">{{ number_format($product->price, 2) }} EGP</p>
                                    <a href="{{route('single_product',$product->id)}}" class="btn btn--primary btn--sm" style="display: inline-block; padding: 8px 12px; background: var(--primary-color); color: #fff; text-decoration: none; border-radius: 5px; font-size: 14px; font-weight: bold;">
                                        View Details
                                    </a>
                                </div>
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
    