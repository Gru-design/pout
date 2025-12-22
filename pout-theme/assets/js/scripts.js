/**
 * Pout Theme - Main JavaScript
 *
 * @package Pout_Theme
 * @version 1.0.0
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
        initShareButtons();
        initContactForm();
        initToolsFilter();
        initHeaderScroll();
        initCounterAnimation();
        initFAQAccordion();
    });

    /**
     * Mobile Menu Toggle
     */
    function initMobileMenu() {
        const menuToggle = document.querySelector('.menu-toggle');
        const mobileMenu = document.querySelector('.mobile-menu');

        if (!menuToggle || !mobileMenu) return;

        menuToggle.addEventListener('click', function() {
            const isExpanded = this.getAttribute('aria-expanded') === 'true';
            this.setAttribute('aria-expanded', !isExpanded);
            mobileMenu.classList.toggle('active');
            mobileMenu.setAttribute('aria-hidden', isExpanded);
            document.body.classList.toggle('menu-open');
        });

        // Close menu on outside click
        document.addEventListener('click', function(e) {
            if (!mobileMenu.contains(e.target) && !menuToggle.contains(e.target)) {
                menuToggle.setAttribute('aria-expanded', 'false');
                mobileMenu.classList.remove('active');
                mobileMenu.setAttribute('aria-hidden', 'true');
                document.body.classList.remove('menu-open');
            }
        });

        // Close menu on ESC key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && mobileMenu.classList.contains('active')) {
                menuToggle.setAttribute('aria-expanded', 'false');
                mobileMenu.classList.remove('active');
                mobileMenu.setAttribute('aria-hidden', 'true');
                document.body.classList.remove('menu-open');
            }
        });
    }

    /**
     * Search Overlay
     */
    function initSearchOverlay() {
        const searchToggle = document.querySelector('.search-toggle');
        const searchOverlay = document.querySelector('.search-overlay');
        const searchClose = document.querySelector('.search-close');
        const searchField = document.querySelector('.search-overlay .search-field');

        if (!searchToggle || !searchOverlay) return;

        searchToggle.addEventListener('click', function() {
            searchOverlay.classList.add('active');
            searchOverlay.setAttribute('aria-hidden', 'false');
            if (searchField) searchField.focus();
        });

        if (searchClose) {
            searchClose.addEventListener('click', function() {
                searchOverlay.classList.remove('active');
                searchOverlay.setAttribute('aria-hidden', 'true');
            });
        }

        // Close on ESC
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && searchOverlay.classList.contains('active')) {
                searchOverlay.classList.remove('active');
                searchOverlay.setAttribute('aria-hidden', 'true');
            }
        });
    }

    /**
     * Back to Top Button
     */
    function initBackToTop() {
        const backToTop = document.querySelector('.back-to-top');
        if (!backToTop) return;

        // Show/hide button based on scroll position
        function toggleBackToTop() {
            if (window.scrollY > 300) {
                backToTop.classList.add('visible');
            } else {
                backToTop.classList.remove('visible');
            }
        }

        window.addEventListener('scroll', throttle(toggleBackToTop, 100));

        // Scroll to top on click
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
                const targetId = this.getAttribute('href');
                if (targetId === '#') return;

                const targetElement = document.querySelector(targetId);
                if (targetElement) {
                    e.preventDefault();
                    const headerHeight = document.querySelector('.site-header')?.offsetHeight || 0;
                    const targetPosition = targetElement.getBoundingClientRect().top + window.scrollY - headerHeight - 20;

                    window.scrollTo({
                        top: targetPosition,
                        behavior: 'smooth'
                    });

                    // Update URL
                    history.pushState(null, null, targetId);
                }
            });
        });
    }

    /**
     * Auto-generate Table of Contents
     */
    function initTableOfContents() {
        const articleContent = document.getElementById('article-content');
        const tocList = document.getElementById('toc-list');
        const tocContainer = document.getElementById('article-toc');

        if (!articleContent || !tocList) return;

        const headings = articleContent.querySelectorAll('h2, h3');

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
            const li = document.createElement('li');
            li.className = 'toc-item toc-' + heading.tagName.toLowerCase();

            const link = document.createElement('a');
            link.href = '#' + heading.id;
            link.textContent = heading.textContent;
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const headerHeight = document.querySelector('.site-header')?.offsetHeight || 0;
                const targetPosition = heading.getBoundingClientRect().top + window.scrollY - headerHeight - 20;
                window.scrollTo({
                    top: targetPosition,
                    behavior: 'smooth'
                });
            });

            li.appendChild(link);
            tocList.appendChild(li);
        });

        // TOC toggle
        const tocToggle = document.querySelector('.toc-toggle');
        if (tocToggle) {
            tocToggle.addEventListener('click', function() {
                const isExpanded = this.getAttribute('aria-expanded') === 'true';
                this.setAttribute('aria-expanded', !isExpanded);
                tocList.classList.toggle('collapsed');
            });
        }

        // Highlight current section
        function highlightCurrentSection() {
            const scrollPosition = window.scrollY;
            const headerHeight = document.querySelector('.site-header')?.offsetHeight || 0;

            headings.forEach(function(heading) {
                const sectionTop = heading.offsetTop - headerHeight - 100;
                const sectionId = heading.id;
                const tocLink = tocList.querySelector('a[href="#' + sectionId + '"]');

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
     * Share Buttons
     */
    function initShareButtons() {
        // Floating share toggle
        const shareToggle = document.querySelector('.share-toggle');
        const shareButtons = document.querySelector('.floating-share .share-buttons');

        if (shareToggle && shareButtons) {
            shareToggle.addEventListener('click', function() {
                const isExpanded = this.getAttribute('aria-expanded') === 'true';
                this.setAttribute('aria-expanded', !isExpanded);
                shareButtons.classList.toggle('active');
            });
        }

        // Copy URL button
        document.querySelectorAll('.share-copy').forEach(function(button) {
            button.addEventListener('click', function() {
                const url = this.dataset.url || window.location.href;

                if (navigator.clipboard) {
                    navigator.clipboard.writeText(url).then(function() {
                        showToast('URLをコピーしました');
                    });
                } else {
                    // Fallback for older browsers
                    const textarea = document.createElement('textarea');
                    textarea.value = url;
                    document.body.appendChild(textarea);
                    textarea.select();
                    document.execCommand('copy');
                    document.body.removeChild(textarea);
                    showToast('URLをコピーしました');
                }
            });
        });
    }

    /**
     * Contact Form Validation & Submission
     */
    function initContactForm() {
        const form = document.getElementById('contact-form');
        if (!form) return;

        const submitButton = document.getElementById('contact-submit');
        const charCount = form.querySelector('.char-count');
        const messageField = form.querySelector('#contact-message');

        // Character count
        if (messageField && charCount) {
            messageField.addEventListener('input', function() {
                charCount.textContent = this.value.length;
            });
        }

        // Form validation
        form.addEventListener('submit', function(e) {
            let isValid = true;
            const requiredFields = form.querySelectorAll('[required]');

            requiredFields.forEach(function(field) {
                const errorElement = field.parentElement.querySelector('.form-error');
                field.classList.remove('error');
                if (errorElement) errorElement.textContent = '';

                if (!field.value.trim()) {
                    isValid = false;
                    field.classList.add('error');
                    if (errorElement) errorElement.textContent = 'この項目は必須です';
                } else if (field.type === 'email' && !isValidEmail(field.value)) {
                    isValid = false;
                    field.classList.add('error');
                    if (errorElement) errorElement.textContent = '有効なメールアドレスを入力してください';
                } else if (field.type === 'checkbox' && !field.checked) {
                    isValid = false;
                    field.classList.add('error');
                    if (errorElement) errorElement.textContent = '同意が必要です';
                }
            });

            if (!isValid) {
                e.preventDefault();
                // Focus first error field
                const firstError = form.querySelector('.error');
                if (firstError) firstError.focus();
                return;
            }

            // Show loading state
            if (submitButton) {
                submitButton.disabled = true;
                submitButton.classList.add('loading');
            }
        });

        // Real-time validation
        form.querySelectorAll('input, select, textarea').forEach(function(field) {
            field.addEventListener('blur', function() {
                validateField(this);
            });

            field.addEventListener('input', function() {
                if (this.classList.contains('error')) {
                    validateField(this);
                }
            });
        });

        function validateField(field) {
            const errorElement = field.parentElement.querySelector('.form-error');
            field.classList.remove('error');
            if (errorElement) errorElement.textContent = '';

            if (field.required && !field.value.trim()) {
                field.classList.add('error');
                if (errorElement) errorElement.textContent = 'この項目は必須です';
            } else if (field.type === 'email' && field.value && !isValidEmail(field.value)) {
                field.classList.add('error');
                if (errorElement) errorElement.textContent = '有効なメールアドレスを入力してください';
            }
        }
    }

    /**
     * Tools Filter
     */
    function initToolsFilter() {
        const filterButtons = document.querySelectorAll('.filter-btn');
        const toolCards = document.querySelectorAll('.tool-card');

        if (filterButtons.length === 0 || toolCards.length === 0) return;

        filterButtons.forEach(function(button) {
            button.addEventListener('click', function() {
                const filter = this.dataset.filter;

                // Update active button
                filterButtons.forEach(function(btn) {
                    btn.classList.remove('active');
                });
                this.classList.add('active');

                // Filter cards
                toolCards.forEach(function(card) {
                    if (filter === 'all' || card.classList.contains('tool-category-' + filter)) {
                        card.style.display = '';
                        card.classList.add('fade-in');
                    } else {
                        card.style.display = 'none';
                        card.classList.remove('fade-in');
                    }
                });
            });
        });
    }

    /**
     * Header Scroll Effect
     */
    function initHeaderScroll() {
        const header = document.querySelector('.site-header');
        if (!header) return;

        const isTransparent = header.classList.contains('header-transparent');

        function handleScroll() {
            if (window.scrollY > 50) {
                header.classList.add('scrolled');
            } else {
                header.classList.remove('scrolled');
            }
        }

        if (isTransparent) {
            window.addEventListener('scroll', throttle(handleScroll, 100));
        }
    }

    /**
     * Counter Animation
     */
    function initCounterAnimation() {
        const counters = document.querySelectorAll('.stat-number');
        if (counters.length === 0) return;

        const observerOptions = {
            threshold: 0.5
        };

        const observer = new IntersectionObserver(function(entries) {
            entries.forEach(function(entry) {
                if (entry.isIntersecting) {
                    animateCounter(entry.target);
                    observer.unobserve(entry.target);
                }
            });
        }, observerOptions);

        counters.forEach(function(counter) {
            observer.observe(counter);
        });

        function animateCounter(element) {
            const target = element.dataset.count || element.textContent;
            const numericValue = parseInt(target.replace(/[^0-9]/g, ''), 10);
            const suffix = target.replace(/[0-9]/g, '');
            const duration = 2000;
            const startTime = performance.now();

            function updateCounter(currentTime) {
                const elapsed = currentTime - startTime;
                const progress = Math.min(elapsed / duration, 1);
                const easeOutQuad = 1 - (1 - progress) * (1 - progress);
                const currentValue = Math.floor(easeOutQuad * numericValue);

                element.textContent = currentValue + suffix;

                if (progress < 1) {
                    requestAnimationFrame(updateCounter);
                } else {
                    element.textContent = target;
                }
            }

            requestAnimationFrame(updateCounter);
        }
    }

    /**
     * FAQ Accordion
     */
    function initFAQAccordion() {
        const faqItems = document.querySelectorAll('.faq-item');

        faqItems.forEach(function(item) {
            const question = item.querySelector('.faq-question');

            question.addEventListener('click', function(e) {
                // Close other items (optional - for single open behavior)
                // faqItems.forEach(function(otherItem) {
                //     if (otherItem !== item && otherItem.hasAttribute('open')) {
                //         otherItem.removeAttribute('open');
                //     }
                // });
            });
        });
    }

    /**
     * Helper: Throttle function
     */
    function throttle(func, limit) {
        let inThrottle;
        return function() {
            const args = arguments;
            const context = this;
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
        let timeout;
        return function() {
            const context = this;
            const args = arguments;
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
        const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return regex.test(email);
    }

    /**
     * Helper: Show toast notification
     */
    function showToast(message, type) {
        type = type || 'success';

        // Remove existing toast
        const existingToast = document.querySelector('.toast');
        if (existingToast) {
            existingToast.remove();
        }

        // Create toast
        const toast = document.createElement('div');
        toast.className = 'toast toast-' + type;
        toast.textContent = message;
        toast.setAttribute('role', 'alert');

        // Add styles
        Object.assign(toast.style, {
            position: 'fixed',
            bottom: '20px',
            left: '50%',
            transform: 'translateX(-50%)',
            padding: '12px 24px',
            background: type === 'success' ? '#10b981' : '#ef4444',
            color: '#fff',
            borderRadius: '8px',
            boxShadow: '0 4px 12px rgba(0,0,0,0.15)',
            zIndex: '9999',
            animation: 'fadeInUp 0.3s ease'
        });

        document.body.appendChild(toast);

        // Auto remove
        setTimeout(function() {
            toast.style.animation = 'fadeOutDown 0.3s ease';
            setTimeout(function() {
                toast.remove();
            }, 300);
        }, 3000);
    }

    // Add toast animations
    const style = document.createElement('style');
    style.textContent = '\n        @keyframes fadeInUp {\n            from {\n                opacity: 0;\n                transform: translateX(-50%) translateY(20px);\n            }\n            to {\n                opacity: 1;\n                transform: translateX(-50%) translateY(0);\n            }\n        }\n        @keyframes fadeOutDown {\n            from {\n                opacity: 1;\n                transform: translateX(-50%) translateY(0);\n            }\n            to {\n                opacity: 0;\n                transform: translateX(-50%) translateY(20px);\n            }\n        }\n    ';
    document.head.appendChild(style);

})();
