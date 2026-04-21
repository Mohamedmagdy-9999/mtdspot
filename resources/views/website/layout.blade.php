<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Grostore - Your trusted online furniture shopping destination">
    <title>BarQ</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{asset('website/css/main.css')}}?v={{ time() }}">
</head>
<body>
<style>
.nav__dropdown {
    position: relative;
}
.nav__dropdown-content {
    position: absolute;
    right: 0;
    top: 100%;
    background: #fff;
    border: 1px solid #ddd;
    border-radius: 5px;
    display: none;
    min-width: 150px;
    z-index: 1000;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}
.nav__dropdown-content a,
.nav__dropdown-content .btn-logout {
    display: block;
    width: 100%;
    text-align: left;
    padding: 0.5rem 1rem;
    color: #333;
    text-decoration: none;
    background: none;
    border: none;
    cursor: pointer;
    font-size: 0.9rem;
}
.nav__dropdown-content a:hover,
.nav__dropdown-content .btn-logout:hover {
    background-color: #f5f5f5;
    color: #e74c3c;
}

/* Optional: show dropdown on hover for desktop */
@media(min-width: 768px){
    .nav__dropdown:hover .nav__dropdown-content {
        display: block;
    }
}
</style>
    <header class="header">
    <div class="header__main">
        <div class="container">
            <div class="header__content">
                <!-- Logo -->
                <a href="{{ route('home') }}" class="header__logo">
                    <span class="header__logo-icon"><i class="fas fa-leaf"></i></span>
                    <span>BarQ</span>
                </a>

                <!-- Navigation -->
                <nav class="nav">
                    <ul class="nav__list">
                        <li class="nav__item"><a href="{{ route('home') }}" class="nav__link">Home</a></li>
                        <li class="nav__item nav__item--dropdown">
                            <a href="#" class="nav__link">Categories <i class="fas fa-chevron-down" style="margin-left:5px; font-size:0.8rem;"></i></a>
                            <ul class="nav__dropdown-menu">
                                @php $categories = App\Models\Category::latest()->get(); @endphp
                                @foreach($categories as $category)
                                    <li><a href="{{ route('single_category', $category->id) }}" class="nav__dropdown-link">{{ $category->name_en }}</a></li>
                                @endforeach
                            </ul>
                        </li>
                        <li class="nav__item"><a href="{{ route('website_about_us') }}" class="nav__link">About Us</a></li>
                        <li class="nav__item"><a href="#contact" class="nav__link contact-link">Contact Us</a></li>
                    </ul>
                </nav>

                <!-- Header Actions -->
                <div class="header__actions">
                    <!-- Search Button -->
                    <button class="header__action-btn header__action-btn--search" aria-label="Search">
                        <i class="fas fa-search"></i>
                    </button>

                    <!-- User Dropdown -->
                    @auth
                    <div class="nav__dropdown header__action-btn">
                        <a href="javascript:void(0);" class="nav__link">
                            <i class="fas fa-user"></i> {{ auth()->user()->name }}
                            <i class="fas fa-chevron-down" style="margin-left:5px; font-size:0.8rem;"></i>
                        </a>
                        <div class="nav__dropdown-content">
                            <a href="{{ route('profile') }}">Profile</a>
                            <form method="POST" action="{{ route('user_logout') }}">
                                @csrf
                                <button type="submit" class="btn-logout">Logout</button>
                            </form>
                        </div>
                    </div>
                    @else
                    <a href="{{ route('login') }}" class="header__action-btn">
                        <i class="fas fa-user"></i>
                    </a>
                    @endauth

                    <!-- Wishlist -->
                    @auth
                    <a href="{{route('user_wishlist')}}" class="header__action-btn header__action-btn--badge" aria-label="Wishlist">
                        <i class="fas fa-heart"></i>
                        <span class="header__badge wishlist-count" style="display: none;">0</span>
                    </a>

                    <!-- Cart -->
                    <a href="{{route('user_cart')}}" class="header__action-btn header__action-btn--badge" aria-label="Cart">
                        <i class="fas fa-shopping-bag"></i>
                        <span class="header__badge" style="display: none;">0</span>
                    </a>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</header>
            
            

    <!-- Social Media Sidebar -->
    <aside class="social-sidebar">
        <div class="social-sidebar__text">
            Follow on <span class="social-sidebar__arrow"><i class="fas fa-arrow-right"></i></span>
        </div>
        <ul class="social-sidebar__list">
            <li><a href="#" class="social-sidebar__link" aria-label="Twitter"><i class="fab fa-twitter"></i></a></li>
            <li><a href="#" class="social-sidebar__link" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a></li>
            <li><a href="#" class="social-sidebar__link" aria-label="Instagram"><i class="fab fa-instagram"></i></a></li>
            <li><a href="#" class="social-sidebar__link" aria-label="Pinterest"><i class="fab fa-pinterest"></i></a></li>
            <li><a href="#" class="social-sidebar__link" aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a></li>
        </ul>
    </aside>


    @yield('content')


    <footer class="footer" style="background-color: var(--bg-dark); color: var(--text-primary);">
                <div class="container">
                    <div class="footer__content">
                        <div class="footer__section">
                            <h3 class="footer__section-title">ShopHub</h3>
                            <p style="color: rgba(255, 255, 255, 0.7); margin-bottom: 1rem;">
                                Your trusted online shopping destination for quality products at great prices.
                            </p>
                        </div>
                        <div class="footer__section">
                            <h3 class="footer__section-title">Quick Links</h3>
                            <ul class="footer__list">
                                <li class="footer__item"><a href="index.html" class="footer__link">Home</a></li>
                                <li class="footer__item"><a href="products.html" class="footer__link">Products</a></li>
                                <li class="footer__item"><a href="about.html" class="footer__link">About Us</a></li>
                                <li class="footer__item"><a href="return-policy.html" class="footer__link">Return Policy</a></li>
                            </ul>
                        </div>
                        <div class="footer__section">
                            <h3 class="footer__section-title">Customer Service</h3>
                            <ul class="footer__list">
                                <li class="footer__item"><a href="#" class="footer__link">Contact Us</a></li>
                                <li class="footer__item"><a href="#" class="footer__link">Shipping Info</a></li>
                                <li class="footer__item"><a href="#" class="footer__link">FAQs</a></li>
                                <li class="footer__item"><a href="#" class="footer__link">Track Order</a></li>
                            </ul>
                        </div>
                        <div class="footer__section">
                            <h3 class="footer__section-title">Connect</h3>
                            <ul class="footer__list">
                                <li class="footer__item"><a href="#" class="footer__link">Facebook</a></li>
                                <li class="footer__item"><a href="#" class="footer__link">Twitter</a></li>
                                <li class="footer__item"><a href="#" class="footer__link">Instagram</a></li>
                                <li class="footer__item"><a href="#" class="footer__link">LinkedIn</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="footer__bottom">
                        <p>&copy; 2026 BarQ. All rights reserved.by <a href="https://wa.me/2011144862907" 
                        target="_blank">
                        
                            Eng.Mohamed Magdy
                        </a></p>
                    </div>
                </div>
            </footer>




    <!-- Data -->
    <script src="{{asset('website/js/data.js')}}"></script>
    
    <!-- Utilities -->
    <script src="{{asset('website/js/utils/cart.js')}}"></script>
    <script src="{{asset('website/js/utils/wishlist.js')}}"></script>
    <script src="{{asset('website/js/utils/animations.js')}}"></script>
    <script src="{{asset('website/js/utils/forms.js')}}"></script>
    <script src="{{asset('website/js/utils/modal.js')}}"></script>
    
    <!-- Components -->
    <script src="{{asset('website/js/components/ui.js')}}"></script>
    <script src="{{asset('website/js/components.js')}}"></script>
    
    <!-- Main Initialization -->
    <script src="{{asset('website/js/main.js')}}"></script>
    <script>
        document.querySelectorAll('.nav__dropdown').forEach(function(dropdown){
            const link = dropdown.querySelector('.nav__link');
            const content = dropdown.querySelector('.nav__dropdown-content');

            link.addEventListener('click', function(e){
                e.preventDefault();
                content.style.display = content.style.display === 'block' ? 'none' : 'block';
            });

            // Close dropdown if clicked outside
            document.addEventListener('click', function(event){
                if (!dropdown.contains(event.target)) {
                    content.style.display = 'none';
                }
            });
        });
</script>
    @stack('scripts')

</body>
</html>
