/**
 * UI Components
 * Reusable UI component modules
 */

// Slider Component
const Slider = {
    init(containerSelector) {
        // Accept either a selector string or a DOM element
        const container = typeof containerSelector === 'string' 
            ? document.querySelector(containerSelector) 
            : containerSelector;
        if (!container) return;
        
        const slides = container.querySelectorAll('.slider__slide');
        const prevBtn = container.querySelector('.slider__nav--prev');
        const nextBtn = container.querySelector('.slider__nav--next');
        const indicators = container.querySelectorAll('.slider__indicator');
        const slideContainer = container.querySelector('.slider__container');
        
        if (!slideContainer) return;
        
        let currentSlide = 0;
        const totalSlides = slides.length;
        
        const goToSlide = (index) => {
            currentSlide = (index + totalSlides) % totalSlides;
            slideContainer.style.transform = `translateX(-${currentSlide * 100}%)`;
            
            indicators.forEach((indicator, i) => {
                indicator.classList.toggle('slider__indicator--active', i === currentSlide);
            });
        };
        
        const nextSlide = () => goToSlide(currentSlide + 1);
        const prevSlide = () => goToSlide(currentSlide - 1);
        
        if (nextBtn) nextBtn.addEventListener('click', nextSlide);
        if (prevBtn) prevBtn.addEventListener('click', prevSlide);
        
        indicators.forEach((indicator, index) => {
            indicator.addEventListener('click', () => goToSlide(index));
        });
        
        // Auto-play slider
        if (totalSlides > 1) {
            setInterval(nextSlide, 5000);
        }
    }
};

// Tabs Component
const Tabs = {
    init(containerSelector) {
        // Accept either a selector string or a DOM element
        const container = typeof containerSelector === 'string' 
            ? document.querySelector(containerSelector) 
            : containerSelector;
        if (!container) return;
        
        const tabs = container.querySelectorAll('.tabs__tab');
        const contents = container.querySelectorAll('.tabs__content');
        
        tabs.forEach(tab => {
            tab.addEventListener('click', () => {
                const targetId = tab.dataset.tab;
                
                tabs.forEach(t => t.classList.remove('tabs__tab--active'));
                contents.forEach(c => c.classList.remove('tabs__content--active'));
                
                tab.classList.add('tabs__tab--active');
                const targetContent = container.querySelector(`[data-content="${targetId}"]`);
                if (targetContent) {
                    targetContent.classList.add('tabs__content--active');
                }
            });
        });
    }
};

// Quantity Selector
const QuantitySelector = {
    init() {
        document.querySelectorAll('.quantity').forEach(quantityEl => {
            const decreaseBtn = quantityEl.querySelector('.quantity__btn--decrease');
            const increaseBtn = quantityEl.querySelector('.quantity__btn--increase');
            const input = quantityEl.querySelector('.quantity__input');
            
            decreaseBtn?.addEventListener('click', () => {
                const value = parseInt(input.value) || 1;
                if (value > 1) {
                    input.value = value - 1;
                    input.dispatchEvent(new Event('change'));
                }
            });
            
            increaseBtn?.addEventListener('click', () => {
                const value = parseInt(input.value) || 1;
                input.value = value + 1;
                input.dispatchEvent(new Event('change'));
            });
            
            input?.addEventListener('change', () => {
                const value = parseInt(input.value) || 1;
                if (value < 1) input.value = 1;
            });
        });
    }
};
