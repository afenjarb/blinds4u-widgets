window.addEventListener('elementor/frontend/init', () => {
    class BlindsGridHandler extends elementorModules.frontend.handlers.Base {
        getDefaultSettings() {
            return {
                selectors: {
                    container: '.blinds-category-item',
                    title: '.blinds-category-item-title',
                    content: '.blinds-category-item-content'
                }
            };
        }

        onInit() {
            super.onInit();
            this.initializeItems();
        }

        isMobile() {
            return window.innerWidth <= 767;
        }

        initializeItems() {
            const element = this.$element?.[0] || this.$element;
            const items = element.querySelectorAll(this.getSettings('selectors.container'));
            
            items.forEach(item => {
                const title = item.querySelector(this.getSettings('selectors.title'));
                const content = item.querySelector(this.getSettings('selectors.content'));
                
                const calculateHeight = () => {
                    if (this.isMobile()) return 0;
                    
                    const prevStyle = content.style.cssText;
                    content.style.cssText = 'display: block; visibility: hidden; position: absolute;';
                    const contentHeight = content.offsetHeight;
                    content.style.cssText = prevStyle;
                    return contentHeight;
                };

                let contentHeight = calculateHeight();

                const handleResize = () => {
                    contentHeight = calculateHeight();
                    if (!this.isMobile() && item.matches(':hover')) {
                        requestAnimationFrame(() => {
                            title.style.transform = `translateY(-${contentHeight + 5}px)`;
                        });
                    } else {
                        title.style.transform = 'translateY(0)';
                    }
                };

                const handleMouseEnter = () => {
                    if (this.isMobile()) return;
                    
                    requestAnimationFrame(() => {
                        title.style.transform = `translateY(-${contentHeight + 5}px)`;
                    });
                };

                const handleMouseLeave = () => {
                    if (this.isMobile()) return;
                    
                    requestAnimationFrame(() => {
                        title.style.transform = 'translateY(0)';
                    });
                };

                window.addEventListener('resize', handleResize);
                item.addEventListener('mouseenter', handleMouseEnter);
                item.addEventListener('mouseleave', handleMouseLeave);

                // Store cleanup function
                item._cleanup = () => {
                    window.removeEventListener('resize', handleResize);
                    item.removeEventListener('mouseenter', handleMouseEnter);
                    item.removeEventListener('mouseleave', handleMouseLeave);
                };
            });
        }

        onDestroy() {
            const element = this.$element?.[0] || this.$element;
            const items = element.querySelectorAll(this.getSettings('selectors.container'));
            
            items.forEach(item => {
                if (item._cleanup) {
                    item._cleanup();
                    delete item._cleanup;
                }
            });
        }
    }

    // Register the handler
    elementorFrontend.hooks.addAction('frontend/element_ready/categories_grid.default', (element) => {
        elementorFrontend.elementsHandler.addHandler(BlindsGridHandler, {
            $element: element
        });
    });
});