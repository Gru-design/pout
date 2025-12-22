/**
 * Pout Theme - Main JavaScript
 * Pout Consulting / MEDECHECK
 *
 * @package Pout_Theme
 * @version 2.0.0
 */

(function() {
    'use strict';

    // DOM Ready
    document.addEventListener('DOMContentLoaded', function() {
        initMobileMenu();
        initSearchOverlay();
        initBackToTop();
        initSmoothScroll();
        initTableOfContents();
        initReadingProgress();
        initShareButtons();
        initContactForm();
        initToolsFilter();
        initHeaderScroll();
        initCounterAnimation();
        initFAQAccordion();
        initViewToggle();
        initScrollAnimations();
        initLazyLoad();
    });

    /**
     * Mobile Menu Toggle
     */
    function initMobileMenu() {
        var menuToggle = document.querySelector('.menu-toggle');
        var mobileMenu = document.querySelector('.mobile-menu');

        if (!menuToggle || !mobileMenu) return;

        var focusableElements = mobileMenu.querySelectorAll('a, button');
        var firstFocusable = focusableElements[0];
        var lastFocusable = focusableElements[focusableElements.length - 1];

        menuToggle.addEventListener('click', function() {
            var isExpanded = this.getAttribute('aria-expanded') === 'true';
            this.setAttribute('aria-expanded', String(!isExpanded));
            mobileMenu.classList.toggle('active');
            mobileMenu.setAttribute('aria-hidden', String(isExpanded));
            document.body.classList.toggle('menu-open');

            if (!isExpanded && firstFocusable) {
                setTimeout(function() {
                    firstFocusable.focus();
                }, 100);
            }
        });

        // Trap focus within menu when open
        mobileMenu.addEventListener('keydown', function(e) {
            if (e.key === 'Tab') {
                if (e.shiftKey && document.activeElement === firstFocusable) {
                    e.preventDefault();
                    lastFocusable.focus();
                } else if (!e.shiftKey && document.activeElement === lastFocusable) {
                    e.preventDefault();
                    firstFocusable.focus();
                }
            }
        });

        // Close menu on outside click
        document.addEventListener('click', function(e) {
            if (mobileMenu.classList.contains('active') &&
                !mobileMenu.contains(e.target) &&
                !menuToggle.contains(e.target)) {
                closeMenu();
            }
        });

        // Close menu on ESC key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && mobileMenu.classList.contains('active')) {
                closeMenu();
                menuToggle.focus();
            }
        });

        function closeMenu() {
            menuToggle.setAttribute('aria-expanded', 'false');
            mobileMenu.classList.remove('active');
            mobileMenu.setAttribute('aria-hidden', 'true');
            document.body.classList.remove('menu-open');
        }
    }

    /**
     * Search Overlay
     */
    function initSearchOverlay() {
        var searchToggle = document.querySelector('.search-toggle');
        var searchOverlay = document.querySelector('.search-overlay');
        var searchClose = document.querySelector('.search-close');
        var searchField = document.querySelector('.search-overlay .search-field');

        if (!searchToggle || !searchOverlay) return;

        searchToggle.addEventListener('click', function() {
            openSearch();
        });

        if (searchClose) {
            searchClose.addEventListener('click', function() {
                closeSearch();
            });
        }

        // Close on overlay click
        searchOverlay.addEventListener('click', function(e) {
            if (e.target === searchOverlay) {
                closeSearch();
            }
        });

        // Close on ESC
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && searchOverlay.classList.contains('active')) {
                closeSearch();
            }
        });

        function openSearch() {
            searchOverlay.classList.add('active');
            searchOverlay.setAttribute('aria-hidden', 'false');
            document.body.style.overflow = 'hidden';
            if (searchField) {
                setTimeout(function() {
                    searchField.focus();
                }, 100);
            }
        }

        function closeSearch() {
            searchOverlay.classList.remove('active');
            searchOverlay.setAttribute('aria-hidden', 'true');
            document.body.style.overflow = '';
            searchToggle.focus();
        }
    }

    /**
     * Back to Top Button
     */
    function initBackToTop() {
        var backToTop = document.querySelector('.back-to-top');
        if (!backToTop) return;

        function toggleBackToTop() {
            if (window.scrollY > 300) {
                backToTop.classList.add('visible');
            } else {
                backToTop.classList.remove('visible');
            }
        }

        window.addEventListener('scroll', throttle(toggleBackToTop, 100));

        backToTop.addEventListener('click', function() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    }

    /**
     * Smooth Scroll for Anchor Links
     */
    function initSmoothScroll() {
        document.querySelectorAll('a[href^="#"]').forEach(function(anchor) {
            anchor.addEventListener('click', function(e) {
                var targetId = this.getAttribute('href');
                if (targetId === '#' || targetId === '#!') return;

                var targetElement = document.querySelector(targetId);
                if (targetElement) {
                    e.preventDefault();
                    var header = document.querySelector('.site-header');
                    var headerHeight = header ? header.offsetHeight : 0;
                    var targetPosition = targetElement.getBoundingClientRect().top + window.scrollY - headerHeight - 20;

                    window.scrollTo({
                        top: targetPosition,
                        behavior: 'smooth'
                    });

                    // Update URL without triggering scroll
                    if (history.pushState) {
                        history.pushState(null, null, targetId);
                    }

                    // Focus target for accessibility
                    targetElement.setAttribute('tabindex', '-1');
                    targetElement.focus();
                }
            });
        });
    }

    /**
     * Auto-generate Table of Contents
     */
    function initTableOfContents() {
        var articleContent = document.getElementById('article-content');
        var tocList = document.getElementById('toc-list');
        var tocContainer = document.getElementById('article-toc');

        if (!articleContent || !tocList) return;

        var headings = articleContent.querySelectorAll('h2, h3');

        if (headings.length < 2) {
            if (tocContainer) tocContainer.style.display = 'none';
            return;
        }

        headings.forEach(function(heading, index) {
            // Add ID to heading if not present
            if (!heading.id) {
                heading.id = 'heading-' + index;
            }

            // Create TOC item
            var li = document.createElement('li');
            li.className = 'toc-item toc-' + heading.tagName.toLowerCase();

            var link = document.createElement('a');
            link.href = '#' + heading.id;
            link.textContent = heading.textContent;
            link.addEventListener('click', function(e) {
                e.preventDefault();
                var header = document.querySelector('.site-header');
                var headerHeight = header ? header.offsetHeight : 0;
                var targetPosition = heading.getBoundingClientRect().top + window.scrollY - headerHeight - 20;
                window.scrollTo({
                    top: targetPosition,
                    behavior: 'smooth'
                });
            });

            li.appendChild(link);
            tocList.appendChild(li);
        });

        // TOC toggle
        var tocToggle = document.querySelector('.toc-toggle');
        if (tocToggle) {
            tocToggle.addEventListener('click', function() {
                var isExpanded = this.getAttribute('aria-expanded') === 'true';
                this.setAttribute('aria-expanded', String(!isExpanded));
                tocList.classList.toggle('collapsed');
            });
        }

        // Highlight current section
        function highlightCurrentSection() {
            var scrollPosition = window.scrollY;
            var header = document.querySelector('.site-header');
            var headerHeight = header ? header.offsetHeight : 0;

            headings.forEach(function(heading) {
                var sectionTop = heading.offsetTop - headerHeight - 100;
                var sectionId = heading.id;
                var tocLink = tocList.querySelector('a[href="#' + sectionId + '"]');

                if (tocLink) {
                    if (scrollPosition >= sectionTop) {
                        tocList.querySelectorAll('a').forEach(function(a) {
                            a.classList.remove('active');
                        });
                        tocLink.classList.add('active');
                    }
                }
            });
        }

        window.addEventListener('scroll', throttle(highlightCurrentSection, 100));
    }

    /**
     * Reading Progress Bar
     */
    function initReadingProgress() {
        var progressBar = document.getElementById('reading-progress');
        var articleContent = document.getElementById('article-content');

        if (!progressBar || !articleContent) return;

        var progressFill = progressBar.querySelector('.reading-progress-fill');
        if (!progressFill) return;

        function updateProgress() {
            var articleTop = articleContent.offsetTop;
            var articleHeight = articleContent.offsetHeight;
            var windowHeight = window.innerHeight;
            var scrollPosition = window.scrollY;

            var startPosition = articleTop - windowHeight / 2;
            var endPosition = articleTop + articleHeight - windowHeight / 2;
            var totalDistance = endPosition - startPosition;

            var progress = Math.max(0, Math.min(100, ((scrollPosition - startPosition) / totalDistance) * 100));
            progressFill.style.width = progress + '%';
        }

        window.addEventListener('scroll', throttle(updateProgress, 10));
    }

    /**
     * Share Buttons
     */
    function initShareButtons() {
        // Floating share toggle
        var shareToggle = document.querySelector('.share-toggle');
        var shareButtons = document.querySelector('.floating-share .share-buttons');

        if (shareToggle && shareButtons) {
            shareToggle.addEventListener('click', function() {
                var isExpanded = this.getAttribute('aria-expanded') === 'true';
                this.setAttribute('aria-expanded', String(!isExpanded));
                shareButtons.classList.toggle('active');
            });
        }

        // Copy URL button
        document.querySelectorAll('.share-copy').forEach(function(button) {
            button.addEventListener('click', function() {
                var url = this.dataset.url || window.location.href;
                copyToClipboard(url);
            });
        });
    }

    /**
     * Copy to Clipboard Helper
     */
    function copyToClipboard(text) {
        if (navigator.clipboard && navigator.clipboard.writeText) {
            navigator.clipboard.writeText(text).then(function() {
                showToast('URLをコピーしました');
            }).catch(function() {
                fallbackCopyToClipboard(text);
            });
        } else {
            fallbackCopyToClipboard(text);
        }
    }

    function fallbackCopyToClipboard(text) {
        var textarea = document.createElement('textarea');
        textarea.value = text;
        textarea.style.position = 'fixed';
        textarea.style.left = '-9999px';
        document.body.appendChild(textarea);
        textarea.select();

        try {
            document.execCommand('copy');
            showToast('URLをコピーしました');
        } catch (err) {
            showToast('コピーに失敗しました', 'error');
        }

        document.body.removeChild(textarea);
    }

    /**
     * Contact Form Validation & Submission
     */
    function initContactForm() {
        var form = document.getElementById('contact-form');
        if (!form) return;

        var submitButton = document.getElementById('contact-submit');
        var charCount = form.querySelector('.char-count');
        var messageField = form.querySelector('#contact-message');

        // Character count
        if (messageField && charCount) {
            messageField.addEventListener('input', function() {
                var count = this.value.length;
                charCount.textContent = count.toLocaleString();

                // Visual feedback when approaching limit
                if (count > 4500) {
                    charCount.parentElement.classList.add('warning');
                } else {
                    charCount.parentElement.classList.remove('warning');
                }
            });
        }

        // Form validation
        form.addEventListener('submit', function(e) {
            var isValid = true;
            var requiredFields = form.querySelectorAll('[required]');

            requiredFields.forEach(function(field) {
                if (!validateField(field)) {
                    isValid = false;
                }
            });

            if (!isValid) {
                e.preventDefault();
                // Focus first error field
                var firstError = form.querySelector('.error');
                if (firstError) {
                    firstError.focus();
                    firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }
                return;
            }

            // Show loading state
            if (submitButton) {
                submitButton.disabled = true;
                submitButton.classList.add('loading');
            }
        });

        // Real-time validation on blur
        form.querySelectorAll('input, select, textarea').forEach(function(field) {
            field.addEventListener('blur', function() {
                if (this.required || this.value) {
                    validateField(this);
                }
            });

            field.addEventListener('input', function() {
                if (this.classList.contains('error')) {
                    validateField(this);
                }
            });
        });

        function validateField(field) {
            var errorElement = field.closest('.form-group')?.querySelector('.form-error');
            field.classList.remove('error', 'valid');
            if (errorElement) errorElement.textContent = '';

            var value = field.value.trim();
            var isValid = true;

            if (field.required && !value) {
                isValid = false;
                field.classList.add('error');
                if (errorElement) errorElement.textContent = 'この項目は必須です';
            } else if (field.type === 'email' && value && !isValidEmail(value)) {
                isValid = false;
                field.classList.add('error');
                if (errorElement) errorElement.textContent = '有効なメールアドレスを入力してください';
            } else if (field.type === 'tel' && value && !isValidPhone(value)) {
                isValid = false;
                field.classList.add('error');
                if (errorElement) errorElement.textContent = '有効な電話番号を入力してください';
            } else if (field.type === 'checkbox' && field.required && !field.checked) {
                isValid = false;
                field.classList.add('error');
                if (errorElement) errorElement.textContent = '同意が必要です';
            } else if (value) {
                field.classList.add('valid');
            }

            return isValid;
        }
    }

    /**
     * Tools Filter
     */
    function initToolsFilter() {
        var filterButtons = document.querySelectorAll('.filter-btn');
        var toolCards = document.querySelectorAll('.tool-card');

        if (filterButtons.length === 0 || toolCards.length === 0) return;

        filterButtons.forEach(function(button) {
            button.addEventListener('click', function() {
                var filter = this.dataset.filter;

                // Update active button
                filterButtons.forEach(function(btn) {
                    btn.classList.remove('active');
                    btn.setAttribute('aria-selected', 'false');
                });
                this.classList.add('active');
                this.setAttribute('aria-selected', 'true');

                // Filter cards with animation
                toolCards.forEach(function(card) {
                    if (filter === 'all' || card.classList.contains('tool-category-' + filter)) {
                        card.style.display = '';
                        requestAnimationFrame(function() {
                            card.classList.add('fade-in');
                        });
                    } else {
                        card.classList.remove('fade-in');
                        card.style.display = 'none';
                    }
                });
            });
        });
    }

    /**
     * Header Scroll Effect
     */
    function initHeaderScroll() {
        var header = document.querySelector('.site-header');
        if (!header) return;

        var isTransparent = header.classList.contains('header-transparent');
        var lastScrollY = 0;

        function handleScroll() {
            var currentScrollY = window.scrollY;

            // Add/remove scrolled class
            if (currentScrollY > 50) {
                header.classList.add('scrolled');
            } else {
                header.classList.remove('scrolled');
            }

            // Hide/show header on scroll (optional - only for non-transparent headers)
            if (!isTransparent && currentScrollY > 300) {
                if (currentScrollY > lastScrollY) {
                    header.classList.add('header-hidden');
                } else {
                    header.classList.remove('header-hidden');
                }
            } else {
                header.classList.remove('header-hidden');
            }

            lastScrollY = currentScrollY;
        }

        window.addEventListener('scroll', throttle(handleScroll, 100));
    }

    /**
     * Counter Animation
     */
    function initCounterAnimation() {
        var counters = document.querySelectorAll('.stat-number, .hero-stat .stat-number');
        if (counters.length === 0) return;

        var observerOptions = {
            threshold: 0.5,
            rootMargin: '0px'
        };

        var observer = new IntersectionObserver(function(entries) {
            entries.forEach(function(entry) {
                if (entry.isIntersecting && !entry.target.classList.contains('animated')) {
                    entry.target.classList.add('animated');
                    animateCounter(entry.target);
                }
            });
        }, observerOptions);

        counters.forEach(function(counter) {
            observer.observe(counter);
        });

        function animateCounter(element) {
            var text = element.textContent;
            var numericValue = parseInt(text.replace(/[^0-9]/g, ''), 10);
            var prefix = text.match(/^[^0-9]*/)[0] || '';
            var suffix = text.match(/[^0-9]*$/)[0] || '';
            var duration = 2000;
            var startTime = null;

            function updateCounter(currentTime) {
                if (!startTime) startTime = currentTime;
                var elapsed = currentTime - startTime;
                var progress = Math.min(elapsed / duration, 1);
                var easeOutQuad = 1 - (1 - progress) * (1 - progress);
                var currentValue = Math.floor(easeOutQuad * numericValue);

                element.textContent = prefix + currentValue.toLocaleString() + suffix;

                if (progress < 1) {
                    requestAnimationFrame(updateCounter);
                } else {
                    element.textContent = text;
                }
            }

            requestAnimationFrame(updateCounter);
        }
    }

    /**
     * FAQ Accordion
     */
    function initFAQAccordion() {
        var faqItems = document.querySelectorAll('.faq-item');
        if (faqItems.length === 0) return;

        faqItems.forEach(function(item) {
            var summary = item.querySelector('summary');
            if (summary) {
                summary.addEventListener('click', function(e) {
                    // Optional: Close other items for single-open behavior
                    // Uncomment below for accordion behavior
                    /*
                    faqItems.forEach(function(otherItem) {
                        if (otherItem !== item && otherItem.hasAttribute('open')) {
                            otherItem.removeAttribute('open');
                        }
                    });
                    */
                });
            }
        });
    }

    /**
     * View Toggle (Grid/List)
     */
    function initViewToggle() {
        var viewToggleButtons = document.querySelectorAll('.view-toggle-btn');
        var postsContainer = document.getElementById('posts-container');

        if (viewToggleButtons.length === 0 || !postsContainer) return;

        // Load saved preference
        var savedView = localStorage.getItem('pout-posts-view');
        if (savedView) {
            setView(savedView);
        }

        viewToggleButtons.forEach(function(button) {
            button.addEventListener('click', function() {
                var view = this.dataset.view;
                setView(view);
                localStorage.setItem('pout-posts-view', view);
            });
        });

        function setView(view) {
            viewToggleButtons.forEach(function(btn) {
                btn.classList.remove('active');
                btn.setAttribute('aria-selected', 'false');
                if (btn.dataset.view === view) {
                    btn.classList.add('active');
                    btn.setAttribute('aria-selected', 'true');
                }
            });

            postsContainer.classList.remove('posts-grid', 'posts-list');
            postsContainer.classList.add('posts-' + view);
        }
    }

    /**
     * Scroll Animations
     */
    function initScrollAnimations() {
        var animatedElements = document.querySelectorAll('.animate-on-scroll, .service-card, .testimonial-card, .pricing-card, .step-item, .reviewer-card');

        if (animatedElements.length === 0) return;

        var observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        var observer = new IntersectionObserver(function(entries) {
            entries.forEach(function(entry) {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-visible');
                    observer.unobserve(entry.target);
                }
            });
        }, observerOptions);

        animatedElements.forEach(function(element, index) {
            element.style.transitionDelay = (index % 4) * 0.1 + 's';
            observer.observe(element);
        });
    }

    /**
     * Lazy Load Images
     */
    function initLazyLoad() {
        // Use native lazy loading if supported
        if ('loading' in HTMLImageElement.prototype) {
            document.querySelectorAll('img[data-src]').forEach(function(img) {
                img.src = img.dataset.src;
                img.removeAttribute('data-src');
            });
            return;
        }

        // Fallback for older browsers
        var lazyImages = document.querySelectorAll('img[data-src]');
        if (lazyImages.length === 0) return;

        var imageObserver = new IntersectionObserver(function(entries) {
            entries.forEach(function(entry) {
                if (entry.isIntersecting) {
                    var img = entry.target;
                    img.src = img.dataset.src;
                    img.removeAttribute('data-src');
                    img.classList.add('loaded');
                    imageObserver.unobserve(img);
                }
            });
        });

        lazyImages.forEach(function(img) {
            imageObserver.observe(img);
        });
    }

    /**
     * Helper: Throttle function
     */
    function throttle(func, limit) {
        var inThrottle;
        return function() {
            var args = arguments;
            var context = this;
            if (!inThrottle) {
                func.apply(context, args);
                inThrottle = true;
                setTimeout(function() {
                    inThrottle = false;
                }, limit);
            }
        };
    }

    /**
     * Helper: Debounce function
     */
    function debounce(func, wait) {
        var timeout;
        return function() {
            var context = this;
            var args = arguments;
            clearTimeout(timeout);
            timeout = setTimeout(function() {
                func.apply(context, args);
            }, wait);
        };
    }

    /**
     * Helper: Email validation
     */
    function isValidEmail(email) {
        var regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return regex.test(email);
    }

    /**
     * Helper: Phone validation
     */
    function isValidPhone(phone) {
        var regex = /^[\d\-\+\(\)\s]+$/;
        return regex.test(phone) && phone.replace(/\D/g, '').length >= 10;
    }

    /**
     * Helper: Show toast notification
     */
    function showToast(message, type) {
        type = type || 'success';

        // Remove existing toast
        var existingToast = document.querySelector('.toast');
        if (existingToast) {
            existingToast.remove();
        }

        // Create toast
        var toast = document.createElement('div');
        toast.className = 'toast toast-' + type;
        toast.setAttribute('role', 'alert');
        toast.setAttribute('aria-live', 'polite');

        var icon = type === 'success'
            ? '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22,4 12,14.01 9,11.01"></polyline></svg>'
            : '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>';

        toast.innerHTML = icon + '<span>' + message + '</span>';

        document.body.appendChild(toast);

        // Trigger animation
        requestAnimationFrame(function() {
            toast.classList.add('show');
        });

        // Auto remove
        setTimeout(function() {
            toast.classList.remove('show');
            setTimeout(function() {
                if (toast.parentNode) {
                    toast.remove();
                }
            }, 300);
        }, 3000);
    }

    // Add toast styles dynamically
    (function addToastStyles() {
        var style = document.createElement('style');
        style.textContent = [
            '.toast {',
            '    position: fixed;',
            '    bottom: 20px;',
            '    left: 50%;',
            '    transform: translateX(-50%) translateY(100px);',
            '    display: flex;',
            '    align-items: center;',
            '    gap: 10px;',
            '    padding: 14px 24px;',
            '    background: var(--color-navy, #0F172A);',
            '    color: #fff;',
            '    border-radius: 12px;',
            '    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.2);',
            '    z-index: 9999;',
            '    opacity: 0;',
            '    transition: all 0.3s ease;',
            '    font-size: 14px;',
            '    font-weight: 500;',
            '}',
            '.toast.show {',
            '    opacity: 1;',
            '    transform: translateX(-50%) translateY(0);',
            '}',
            '.toast-success { background: #10b981; }',
            '.toast-error { background: #ef4444; }',
            '.toast svg { flex-shrink: 0; }',
            '',
            '/* Scroll animation styles */',
            '.animate-on-scroll,',
            '.service-card,',
            '.testimonial-card,',
            '.pricing-card,',
            '.step-item,',
            '.reviewer-card {',
            '    opacity: 0;',
            '    transform: translateY(30px);',
            '    transition: opacity 0.6s ease, transform 0.6s ease;',
            '}',
            '.animate-on-scroll.is-visible,',
            '.service-card.is-visible,',
            '.testimonial-card.is-visible,',
            '.pricing-card.is-visible,',
            '.step-item.is-visible,',
            '.reviewer-card.is-visible {',
            '    opacity: 1;',
            '    transform: translateY(0);',
            '}',
            '',
            '/* Reading progress bar */',
            '.reading-progress-bar {',
            '    position: fixed;',
            '    top: 0;',
            '    left: 0;',
            '    width: 100%;',
            '    height: 3px;',
            '    background: rgba(0, 0, 0, 0.1);',
            '    z-index: 9999;',
            '}',
            '.reading-progress-fill {',
            '    height: 100%;',
            '    background: var(--color-gold, #B59458);',
            '    width: 0%;',
            '    transition: width 0.1s ease;',
            '}',
            '',
            '/* Posts list view */',
            '.posts-list .post-card {',
            '    display: flex;',
            '    flex-direction: row;',
            '}',
            '.posts-list .post-card-image {',
            '    width: 200px;',
            '    flex-shrink: 0;',
            '}',
            '@media (max-width: 768px) {',
            '    .posts-list .post-card {',
            '        flex-direction: column;',
            '    }',
            '    .posts-list .post-card-image {',
            '        width: 100%;',
            '    }',
            '}'
        ].join('\n');
        document.head.appendChild(style);
    })();

})();
