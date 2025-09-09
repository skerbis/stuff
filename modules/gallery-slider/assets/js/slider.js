/**
 * Gallery Slider JavaScript
 * Modern slider with touch support and accessibility
 * 
 * @author Friends Of REDAXO
 * @version 1.2.0
 */

class GallerySlider {
    constructor(selector) {
        this.slider = document.querySelector(selector);
        if (!this.slider) return;
        
        this.slides = this.slider.querySelectorAll('.slide');
        this.dots = this.slider.querySelectorAll('.dot');
        this.prevBtn = this.slider.querySelector('.slider-prev');
        this.nextBtn = this.slider.querySelector('.slider-next');
        
        this.currentSlide = 0;
        this.totalSlides = this.slides.length;
        this.autoplay = this.slider.dataset.autoplay === 'true';
        this.speed = parseInt(this.slider.dataset.speed) || 3000;
        this.showDots = this.slider.dataset.dots === 'true';
        this.showArrows = this.slider.dataset.arrows === 'true';
        
        this.autoplayTimer = null;
        this.isTransitioning = false;
        
        this.init();
    }
    
    init() {
        if (this.totalSlides <= 1) return;
        
        // Set initial state
        this.showSlide(0);
        
        // Event listeners
        this.bindEvents();
        
        // Start autoplay if enabled
        if (this.autoplay) {
            this.startAutoplay();
        }
        
        // Touch/swipe support
        this.initTouchSupport();
        
        // Keyboard support
        this.initKeyboardSupport();
    }
    
    bindEvents() {
        // Navigation buttons
        if (this.prevBtn) {
            this.prevBtn.addEventListener('click', () => this.prevSlide());
        }
        
        if (this.nextBtn) {
            this.nextBtn.addEventListener('click', () => this.nextSlide());
        }
        
        // Dots navigation
        this.dots.forEach((dot, index) => {
            dot.addEventListener('click', () => this.goToSlide(index));
        });
        
        // Pause autoplay on hover
        if (this.autoplay) {
            this.slider.addEventListener('mouseenter', () => this.pauseAutoplay());
            this.slider.addEventListener('mouseleave', () => this.startAutoplay());
        }
        
        // Click images for lightbox
        this.slides.forEach((slide, index) => {
            const image = slide.querySelector('.slide-image');
            if (image) {
                image.addEventListener('click', () => this.openLightbox(index));
                image.style.cursor = 'pointer';
            }
        });
    }
    
    showSlide(index) {
        if (this.isTransitioning) return;
        
        this.isTransitioning = true;
        
        // Remove active classes
        this.slides.forEach((slide, i) => {
            slide.classList.remove('active', 'prev');
            if (i === index) {
                slide.classList.add('active');
            } else if (i === this.currentSlide) {
                slide.classList.add('prev');
            }
        });
        
        // Update dots
        this.dots.forEach((dot, i) => {
            dot.classList.toggle('active', i === index);
        });
        
        this.currentSlide = index;
        
        // Reset transition flag
        setTimeout(() => {
            this.isTransitioning = false;
        }, 500);
    }
    
    nextSlide() {
        const next = (this.currentSlide + 1) % this.totalSlides;
        this.goToSlide(next);
    }
    
    prevSlide() {
        const prev = (this.currentSlide - 1 + this.totalSlides) % this.totalSlides;
        this.goToSlide(prev);
    }
    
    goToSlide(index) {
        if (index === this.currentSlide || this.isTransitioning) return;
        this.showSlide(index);
    }
    
    startAutoplay() {
        if (!this.autoplay || this.totalSlides <= 1) return;
        
        this.pauseAutoplay();
        this.autoplayTimer = setInterval(() => {
            this.nextSlide();
        }, this.speed);
    }
    
    pauseAutoplay() {
        if (this.autoplayTimer) {
            clearInterval(this.autoplayTimer);
            this.autoplayTimer = null;
        }
    }
    
    initTouchSupport() {
        let startX = 0;
        let startY = 0;
        let isDragging = false;
        
        this.slider.addEventListener('touchstart', (e) => {
            startX = e.touches[0].clientX;
            startY = e.touches[0].clientY;
            isDragging = true;
            this.pauseAutoplay();
        }, { passive: true });
        
        this.slider.addEventListener('touchmove', (e) => {
            if (!isDragging) return;
            
            const currentX = e.touches[0].clientX;
            const currentY = e.touches[0].clientY;
            const diffX = startX - currentX;
            const diffY = startY - currentY;
            
            // Prevent vertical scrolling if horizontal swipe detected
            if (Math.abs(diffX) > Math.abs(diffY)) {
                e.preventDefault();
            }
        }, { passive: false });
        
        this.slider.addEventListener('touchend', (e) => {
            if (!isDragging) return;
            
            const endX = e.changedTouches[0].clientX;
            const diffX = startX - endX;
            
            // Minimum swipe distance
            if (Math.abs(diffX) > 50) {
                if (diffX > 0) {
                    this.nextSlide();
                } else {
                    this.prevSlide();
                }
            }
            
            isDragging = false;
            if (this.autoplay) {
                this.startAutoplay();
            }
        }, { passive: true });
    }
    
    initKeyboardSupport() {
        // Only add keyboard support when slider is focused
        this.slider.setAttribute('tabindex', '0');
        
        this.slider.addEventListener('keydown', (e) => {
            switch (e.key) {
                case 'ArrowLeft':
                    e.preventDefault();
                    this.prevSlide();
                    break;
                case 'ArrowRight':
                    e.preventDefault();
                    this.nextSlide();
                    break;
                case ' ':
                case 'Enter':
                    e.preventDefault();
                    if (this.autoplay) {
                        if (this.autoplayTimer) {
                            this.pauseAutoplay();
                        } else {
                            this.startAutoplay();
                        }
                    }
                    break;
            }
        });
    }
    
    openLightbox(startIndex = 0) {
        if (typeof Lightbox !== 'undefined') {
            const images = Array.from(this.slides).map(slide => {
                const img = slide.querySelector('.slide-image');
                const caption = slide.querySelector('.slide-caption');
                return {
                    src: img.src,
                    alt: img.alt,
                    title: caption ? caption.textContent : img.title
                };
            });
            
            new Lightbox(images, startIndex);
        }
    }
    
    // Public API methods
    play() {
        this.autoplay = true;
        this.startAutoplay();
    }
    
    pause() {
        this.autoplay = false;
        this.pauseAutoplay();
    }
    
    destroy() {
        this.pauseAutoplay();
        // Remove event listeners if needed
    }
}

// Auto-initialize all sliders on page load
document.addEventListener('DOMContentLoaded', function() {
    const sliders = document.querySelectorAll('.gallery-slider');
    sliders.forEach(slider => {
        new GallerySlider(slider);
    });
});
