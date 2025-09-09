/**
 * Lightbox for Gallery Slider
 * Accessible lightbox with keyboard and touch support
 * 
 * @author Friends Of REDAXO
 * @version 1.2.0
 */

class Lightbox {
    constructor(images, startIndex = 0) {
        this.images = images;
        this.currentIndex = startIndex;
        this.overlay = null;
        this.content = null;
        this.image = null;
        this.caption = null;
        
        this.init();
    }
    
    init() {
        this.createLightbox();
        this.bindEvents();
        this.showImage(this.currentIndex);
        this.show();
    }
    
    createLightbox() {
        // Create overlay
        this.overlay = document.createElement('div');
        this.overlay.className = 'lightbox-overlay';
        
        // Create content container
        this.content = document.createElement('div');
        this.content.className = 'lightbox-content';
        
        // Create image
        this.image = document.createElement('img');
        this.image.className = 'lightbox-image';
        
        // Create caption
        this.caption = document.createElement('div');
        this.caption.className = 'lightbox-caption';
        
        // Create close button
        const closeBtn = document.createElement('button');
        closeBtn.className = 'lightbox-close';
        closeBtn.innerHTML = '×';
        closeBtn.setAttribute('aria-label', 'Lightbox schließen');
        
        // Create navigation buttons (if multiple images)
        let prevBtn, nextBtn;
        if (this.images.length > 1) {
            prevBtn = document.createElement('button');
            prevBtn.className = 'lightbox-nav lightbox-prev';
            prevBtn.innerHTML = `<svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                <path d="M15.41 7.41L14 6l-6 6 6 6 1.41-1.41L10.83 12z"/>
            </svg>`;
            prevBtn.setAttribute('aria-label', 'Vorheriges Bild');
            
            nextBtn = document.createElement('button');
            nextBtn.className = 'lightbox-nav lightbox-next';
            nextBtn.innerHTML = `<svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                <path d="M10 6L8.59 7.41 13.17 12l-4.58 4.59L10 18l6-6z"/>
            </svg>`;
            nextBtn.setAttribute('aria-label', 'Nächstes Bild');
        }
        
        // Assemble lightbox
        this.content.appendChild(this.image);
        this.content.appendChild(this.caption);
        this.content.appendChild(closeBtn);
        
        if (prevBtn && nextBtn) {
            this.content.appendChild(prevBtn);
            this.content.appendChild(nextBtn);
        }
        
        this.overlay.appendChild(this.content);
        document.body.appendChild(this.overlay);
        
        // Store references for event binding
        this.closeBtn = closeBtn;
        this.prevBtn = prevBtn;
        this.nextBtn = nextBtn;
    }
    
    bindEvents() {
        // Close button
        this.closeBtn.addEventListener('click', () => this.close());
        
        // Navigation buttons
        if (this.prevBtn) {
            this.prevBtn.addEventListener('click', () => this.prev());
        }
        if (this.nextBtn) {
            this.nextBtn.addEventListener('click', () => this.next());
        }
        
        // Click outside to close
        this.overlay.addEventListener('click', (e) => {
            if (e.target === this.overlay) {
                this.close();
            }
        });
        
        // Keyboard navigation
        this.keyHandler = (e) => {
            switch (e.key) {
                case 'Escape':
                    this.close();
                    break;
                case 'ArrowLeft':
                    e.preventDefault();
                    this.prev();
                    break;
                case 'ArrowRight':
                    e.preventDefault();
                    this.next();
                    break;
            }
        };
        
        document.addEventListener('keydown', this.keyHandler);
        
        // Touch/swipe support
        this.initTouchSupport();
        
        // Prevent body scroll
        document.body.style.overflow = 'hidden';
    }
    
    initTouchSupport() {
        let startX = 0;
        let isDragging = false;
        
        this.content.addEventListener('touchstart', (e) => {
            startX = e.touches[0].clientX;
            isDragging = true;
        }, { passive: true });
        
        this.content.addEventListener('touchmove', (e) => {
            if (!isDragging) return;
            
            const currentX = e.touches[0].clientX;
            const diffX = startX - currentX;
            
            // Prevent scrolling during swipe
            if (Math.abs(diffX) > 10) {
                e.preventDefault();
            }
        }, { passive: false });
        
        this.content.addEventListener('touchend', (e) => {
            if (!isDragging) return;
            
            const endX = e.changedTouches[0].clientX;
            const diffX = startX - endX;
            
            // Minimum swipe distance
            if (Math.abs(diffX) > 50) {
                if (diffX > 0) {
                    this.next();
                } else {
                    this.prev();
                }
            }
            
            isDragging = false;
        }, { passive: true });
    }
    
    showImage(index) {
        if (index < 0 || index >= this.images.length) return;
        
        this.currentIndex = index;
        const imageData = this.images[index];
        
        // Add loading state
        this.image.classList.remove('loaded');
        
        // Load new image
        const img = new Image();
        img.onload = () => {
            this.image.src = img.src;
            this.image.alt = imageData.alt || '';
            this.image.classList.add('loaded');
        };
        
        img.src = imageData.src;
        
        // Update caption
        if (imageData.title) {
            this.caption.textContent = imageData.title;
            this.caption.style.display = 'block';
        } else {
            this.caption.style.display = 'none';
        }
        
        // Update navigation button states
        if (this.prevBtn) {
            this.prevBtn.style.display = this.images.length > 1 ? 'flex' : 'none';
        }
        if (this.nextBtn) {
            this.nextBtn.style.display = this.images.length > 1 ? 'flex' : 'none';
        }
    }
    
    show() {
        // Focus trap
        this.overlay.focus();
        
        // Animate in
        requestAnimationFrame(() => {
            this.overlay.classList.add('active');
        });
    }
    
    close() {
        this.overlay.classList.remove('active');
        
        // Cleanup after animation
        setTimeout(() => {
            this.cleanup();
        }, 300);
    }
    
    next() {
        if (this.images.length <= 1) return;
        
        const nextIndex = (this.currentIndex + 1) % this.images.length;
        this.showImage(nextIndex);
    }
    
    prev() {
        if (this.images.length <= 1) return;
        
        const prevIndex = (this.currentIndex - 1 + this.images.length) % this.images.length;
        this.showImage(prevIndex);
    }
    
    cleanup() {
        // Remove event listeners
        document.removeEventListener('keydown', this.keyHandler);
        
        // Restore body scroll
        document.body.style.overflow = '';
        
        // Remove from DOM
        if (this.overlay && this.overlay.parentNode) {
            this.overlay.parentNode.removeChild(this.overlay);
        }
    }
}

// Make Lightbox globally available
window.Lightbox = Lightbox;
