@extends('website.layout')
@section('content')

<main>
    <div class="page-header">
        <div class="container">
            <h1 class="page-header__title">About Us</h1>
            <nav class="page-header__breadcrumb" aria-label="Breadcrumb">
                <a href="{{ route('home') }}" class="page-header__breadcrumb-link">Home</a>
                <span class="page-header__breadcrumb-separator">/</span>
                <span>About Us</span>
            </nav>
        </div>
    </div>

    <div class="container">
        
        <section style="display: flex; flex-wrap: wrap; align-items: center; gap: 2rem; margin-bottom: 3rem;">
            <!-- النص -->
            <div style="flex: 1; min-width: 300px;">
              
                <p style="color: var(--text-secondary); line-height: 1.8; margin-bottom: 1rem;">
                    {!! $about->text !!}
                </p>
               
            </div>

            <!-- الصورة -->
            
            <div style="flex: 1; min-width: 300px;">
                <img src="{{ $about->image_url }}" alt="About Image" style="width: 100%; border-radius: 0.5rem; object-fit: cover;">
            </div>
            
        </section>
       

    </div>
</main>

@endsection
