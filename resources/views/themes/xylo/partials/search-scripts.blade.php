<script>
document.addEventListener('DOMContentLoaded', function() {
    // Elements
    const searchInput = document.getElementById('search-input-new');
    const clearBtn = document.querySelector('.clear-search-btn');
    const categorySelector = document.querySelector('.category-selector-modern');
    const categoryTrigger = document.querySelector('.category-trigger');
    const categoryOptions = document.querySelectorAll('.category-option');
    const categorySelectHidden = document.querySelector('.category-select-hidden');
    const selectedCategoryText = document.querySelector('.selected-category-text');

    // Clear button functionality
    if (searchInput && clearBtn) {
        searchInput.addEventListener('input', function() {
            if (this.value.length > 0) {
                clearBtn.style.display = 'flex';
            } else {
                clearBtn.style.display = 'none';
            }
        });

        clearBtn.addEventListener('click', function() {
            searchInput.value = '';
            this.style.display = 'none';
            searchInput.focus();
        });
    }

    // Category dropdown functionality
    if (categorySelector && categoryTrigger) {
        categoryTrigger.addEventListener('click', function(e) {
            e.stopPropagation();
            categorySelector.classList.toggle('active');
        });

        // Close dropdown when clicking outside
        document.addEventListener('click', function(e) {
            if (!categorySelector.contains(e.target)) {
                categorySelector.classList.remove('active');
            }
        });

        // Category option selection
        categoryOptions.forEach(option => {
            option.addEventListener('click', function() {
                const value = this.dataset.value;
                const text = this.querySelector('span').textContent;

                // Update hidden select
                if (categorySelectHidden) {
                    categorySelectHidden.value = value;
                }

                // Update visible text
                if (selectedCategoryText) {
                    selectedCategoryText.textContent = text;
                }

                // Update selected state
                categoryOptions.forEach(opt => opt.classList.remove('selected'));
                this.classList.add('selected');

                // Close dropdown
                categorySelector.classList.remove('active');
            });
        });
    }

    // Live search suggestions with AJAX
    if (searchInput) {
        let searchTimeout;
        const suggestionBox = document.getElementById('search-suggestions-new');
        const currentLocale = '{{ app()->getLocale() }}';

        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            const query = this.value.trim();

            if (query.length >= 2) {
                searchTimeout = setTimeout(() => {
                    // AJAX call to fetch suggestions
                    fetch(`/search-suggestions?q=${encodeURIComponent(query)}&locale=${currentLocale}`)
                        .then(response => response.json())
                        .then(products => {
                            if (products.length > 0) {
                                displaySuggestions(products);
                                suggestionBox.classList.add('show');
                            } else {
                                suggestionBox.innerHTML = `
                                    <div class="no-suggestions">
                                        <i class="fas fa-search"></i>
                                        <p>{{ __('store.search.no_suggestions_found') }}</p>
                                    </div>
                                `;
                                suggestionBox.classList.add('show');
                            }
                        })
                        .catch(error => {
                            console.error('Search suggestion error:', error);
                            suggestionBox.classList.remove('show');
                        });
                }, 300);
            } else {
                if (suggestionBox) {
                    suggestionBox.classList.remove('show');
                }
            }
        });

        // Display suggestions function
        function displaySuggestions(products) {
            let html = '<div class="suggestions-list">';

            products.forEach(product => {
                html += `
                    <a href="/product/${product.slug}" class="suggestion-item">
                        <div class="suggestion-image">
                            <img src="${product.thumbnail}" alt="${product.name}" onerror="this.src='https://via.placeholder.com/60x60?text=No+Image'">
                        </div>
                        <div class="suggestion-details">
                            <div class="suggestion-name">${product.name}</div>
                        </div>
                        <div class="suggestion-arrow">
                            <i class="fas fa-arrow-right"></i>
                        </div>
                    </a>
                `;
            });

            html += '</div>';
            suggestionBox.innerHTML = html;
        }

        // Close suggestions when clicking outside
        document.addEventListener('click', function(e) {
            if (!e.target.closest('.ultra-modern-search') && suggestionBox) {
                suggestionBox.classList.remove('show');
            }
        });

        // Navigate to product when clicking suggestion
        suggestionBox.addEventListener('click', function(e) {
            const suggestionItem = e.target.closest('.suggestion-item');
            if (suggestionItem) {
                // Link will handle navigation
                suggestionBox.classList.remove('show');
            }
        });
    }

    // Add smooth animation on form submit
    const searchForm = document.querySelector('.ultra-modern-search');
    if (searchForm) {
        searchForm.addEventListener('submit', function(e) {
            const submitBtn = this.querySelector('.search-btn-ultra');
            if (submitBtn) {
                submitBtn.style.transform = 'scale(0.95)';
                setTimeout(() => {
                    submitBtn.style.transform = '';
                }, 200);
            }
        });
    }
});
</script>
