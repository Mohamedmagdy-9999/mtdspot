@extends('website.layout')
@section('content')
    <main>
        <div class="container">
            <!-- Hero Slider -->
            <section class="slider">
                <div class="slider__container">
                    @foreach($sliders as $slider)
                    <div class="slider__slide">
                        
                        <div class="slider__image-wrapper">
                            <img src="{{$slider->image_url}}" alt="Modern Furniture" class="slider__image">
                        </div>
                    </div>
                    @endforeach
                </div>
                <button class="slider__nav slider__nav--prev" aria-label="Previous slide"><i class="fas fa-chevron-left"></i></button>
                <button class="slider__nav slider__nav--next" aria-label="Next slide"><i class="fas fa-chevron-right"></i></button>
                <div class="slider__indicators">
                    <button class="slider__indicator slider__indicator--active" aria-label="Slide 1"></button>
                    <button class="slider__indicator" aria-label="Slide 2"></button>
                </div>
            </section>

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
    