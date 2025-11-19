// Live search
document.getElementById("searchInput").addEventListener("keyup", function() {
    const keyword = this.value.toLowerCase();
    const posts = document.querySelectorAll(".post-card");

    posts.forEach(p => {
        let text = p.innerText.toLowerCase();
        p.style.display = text.includes(keyword) ? "block" : "none";
    });
});

// Report
function reportPost(id) {
    if (!confirm("Laporkan posting ini?")) return;

    fetch("report_post.php?id=" + id)
        .then(res => res.text())
        .then(alert);
}

// Forum JavaScript - SDG 14 Life Below Water
// Forum JavaScript - SDG 14 Life Below Water

document.addEventListener('DOMContentLoaded', function() {
    // Search functionality enhancement
    const searchInput = document.querySelector('.search-bar input[name="q"]');
    const searchForm = document.querySelector('.search-bar');
    
    if (searchInput) {
        // Real-time search counter
        const updateSearchCounter = () => {
            const length = searchInput.value.length;
            if (length > 0) {
                searchInput.parentElement.classList.add('has-value');
            } else {
                searchInput.parentElement.classList.remove('has-value');
            }
        };
        
        searchInput.addEventListener('input', updateSearchCounter);
        updateSearchCounter();
        
        // Search suggestions (autocomplete)
        let searchTimeout;
        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            
            const query = this.value.trim();
            if (query.length >= 2) {
                searchTimeout = setTimeout(() => {
                    // Bisa ditambahkan AJAX call untuk suggestions
                    console.log('Search query:', query);
                }, 300);
            }
        });
        
        // Keyboard shortcut untuk focus search (Ctrl/Cmd + K)
        document.addEventListener('keydown', function(e) {
            if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
                e.preventDefault();
                searchInput.focus();
                searchInput.select();
            }
            
            // ESC untuk clear search
            if (e.key === 'Escape' && document.activeElement === searchInput) {
                searchInput.value = '';
                searchInput.blur();
            }
        });
        
        // Add clear button inside search input
        if (searchInput.value.length > 0) {
            addClearButton();
        }
        
        searchInput.addEventListener('input', function() {
            if (this.value.length > 0) {
                addClearButton();
            } else {
                removeClearButton();
            }
        });
    }
    
    function addClearButton() {
        if (document.querySelector('.search-clear-btn')) return;
        
        const clearBtn = document.createElement('button');
        clearBtn.type = 'button';
        clearBtn.className = 'search-clear-btn';
        clearBtn.innerHTML = '<i class="fas fa-times"></i>';
        clearBtn.style.cssText = `
            position: absolute;
            right: 90px;
            background: none;
            border: none;
            color: #9ca3af;
            cursor: pointer;
            padding: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 4px;
            transition: all 0.2s;
        `;
        
        clearBtn.addEventListener('mouseenter', function() {
            this.style.background = '#f3f4f6';
            this.style.color = '#ef4444';
        });
        
        clearBtn.addEventListener('mouseleave', function() {
            this.style.background = 'none';
            this.style.color = '#9ca3af';
        });
        
        clearBtn.addEventListener('click', function() {
            searchInput.value = '';
            searchInput.focus();
            removeClearButton();
            
            // Auto submit jika ada query sebelumnya
            if (window.location.search.includes('q=')) {
                searchForm.submit();
            }
        });
        
        searchForm.appendChild(clearBtn);
    }
    
    function removeClearButton() {
        const clearBtn = document.querySelector('.search-clear-btn');
        if (clearBtn) {
            clearBtn.remove();
        }
    }
    
    // Auto-submit form when category changes
    const categorySelect = document.querySelector('.search-form select[name="category"]');
    if (categorySelect) {
        categorySelect.addEventListener('change', function() {
            showLoadingState();
            this.form.submit();
        });
    }
    
    // Smooth scroll for pagination
    document.querySelectorAll('.page-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            showLoadingState();
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    });
    
    // Loading state
    function showLoadingState() {
        const postList = document.getElementById('postList');
        if (postList) {
            postList.style.opacity = '0.5';
            postList.style.pointerEvents = 'none';
            
            const loader = document.createElement('div');
            loader.className = 'loading-spinner';
            loader.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Memuat...';
            loader.style.cssText = `
                position: fixed;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                background: white;
                padding: 20px 30px;
                border-radius: 10px;
                box-shadow: 0 4px 12px rgba(0,0,0,0.15);
                z-index: 9999;
                display: flex;
                align-items: center;
                gap: 10px;
                font-size: 14px;
                color: #2563eb;
            `;
            document.body.appendChild(loader);
        }
    }
    
    // Prevent card click when clicking on action buttons
    document.querySelectorAll('.post-footer .btn-balas').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.stopPropagation();
        });
    });
    
    // Add loading indicator for post cards
    document.querySelectorAll('.post-card').forEach(card => {
        card.addEventListener('click', function() {
            const loader = document.createElement('div');
            loader.className = 'loading-overlay';
            loader.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
            this.appendChild(loader);
        });
    });
    
    // Back to top button
    const backToTopBtn = document.createElement('button');
    backToTopBtn.innerHTML = '<i class="fas fa-arrow-up"></i>';
    backToTopBtn.className = 'back-to-top';
    backToTopBtn.setAttribute('aria-label', 'Back to top');
    backToTopBtn.style.cssText = `
        position: fixed;
        bottom: 30px;
        right: 30px;
        width: 45px;
        height: 45px;
        background-color: #2563eb;
        color: white;
        border: none;
        border-radius: 50%;
        cursor: pointer;
        display: none;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
        z-index: 999;
        transition: all 0.3s;
    `;
    
    backToTopBtn.addEventListener('click', () => {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    });
    
    document.body.appendChild(backToTopBtn);
    
    window.addEventListener('scroll', () => {
        if (window.pageYOffset > 300) {
            backToTopBtn.style.display = 'flex';
        } else {
            backToTopBtn.style.display = 'none';
        }
    });
    
    // Search highlighting animation
    const highlights = document.querySelectorAll('.search-highlight');
    highlights.forEach((highlight, index) => {
        setTimeout(() => {
            highlight.style.animation = 'highlight-pulse 0.5s ease-out';
        }, index * 50);
    });
});

// Toast notification function
function showToast(message, type = 'info') {
    const toast = document.createElement('div');
    toast.className = `toast toast-${type}`;
    toast.textContent = message;
    
    Object.assign(toast.style, {
        position: 'fixed',
        bottom: '20px',
        right: '20px',
        padding: '15px 20px',
        backgroundColor: type === 'success' ? '#10b981' : type === 'error' ? '#ef4444' : '#3b82f6',
        color: 'white',
        borderRadius: '8px',
        boxShadow: '0 4px 12px rgba(0,0,0,0.15)',
        zIndex: '9999',
        animation: 'slideIn 0.3s ease-out'
    });
    
    document.body.appendChild(toast);
    
    setTimeout(() => {
        toast.style.animation = 'slideOut 0.3s ease-out';
        setTimeout(() => toast.remove(), 300);
    }, 3000);
}

// Add CSS animations
const style = document.createElement('style');
style.textContent = `
    @keyframes slideIn {
        from {
            transform: translateX(400px);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
    
    @keyframes slideOut {
        from {
            transform: translateX(0);
            opacity: 1;
        }
        to {
            transform: translateX(400px);
            opacity: 0;
        }
    }
    
    @keyframes highlight-pulse {
        0%, 100% {
            background-color: #fef08a;
        }
        50% {
            background-color: #fde047;
        }
    }
    
    .loading-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(255, 255, 255, 0.9);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        color: #2563eb;
        border-radius: 10px;
        z-index: 10;
    }
    
    .back-to-top:hover {
        background-color: #1d4ed8;
        transform: translateY(-3px);
        box-shadow: 0 6px 16px rgba(37, 99, 235, 0.4);
    }
    
    .search-bar.has-value input {
        padding-right: 130px;
    }
    
    .page-btn.disabled {
        pointer-events: none;
        color: #9ca3af;
        border-color: #f3f4f6;
    }
    
    @media (max-width: 768px) {
        .back-to-top {
            bottom: 20px !important;
            right: 20px !important;
            width: 40px !important;
            height: 40px !important;
        }
        
        .search-clear-btn {
            right: 70px !important;
        }
    }
`;
document.head.appendChild(style);

// Intersection Observer for lazy loading images
const observerOptions = {
    root: null,
    rootMargin: '50px',
    threshold: 0.1
};

const imageObserver = new IntersectionObserver((entries, observer) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            const img = entry.target;
            if (img.dataset.src) {
                img.src = img.dataset.src;
                img.removeAttribute('data-src');
                observer.unobserve(img);
            }
        }
    });
}, observerOptions);

// Observe all images with data-src
document.querySelectorAll('img[data-src]').forEach(img => {
    imageObserver.observe(img);
});

// Handle filter tab clicks with smooth transition
document.querySelectorAll('.filter-tabs .tab').forEach(tab => {
    tab.addEventListener('click', function(e) {
        showLoadingState();
    });
});

// Keyboard shortcuts info
document.addEventListener('keydown', function(e) {
    // N for new question
    if (e.key === 'n' && !e.ctrlKey && !e.metaKey && !e.shiftKey) {
        const activeElement = document.activeElement;
        if (activeElement.tagName !== 'INPUT' && activeElement.tagName !== 'TEXTAREA') {
            window.location.href = 'create_post.php';
        }
    }
    
    // ? untuk show keyboard shortcuts
    if (e.key === '?' && !e.ctrlKey && !e.metaKey && !e.shiftKey) {
        const activeElement = document.activeElement;
        if (activeElement.tagName !== 'INPUT' && activeElement.tagName !== 'TEXTAREA') {
            e.preventDefault();
            showKeyboardShortcuts();
        }
    }
});

function showKeyboardShortcuts() {
    const modal = document.createElement('div');
    modal.className = 'shortcuts-modal';
    modal.innerHTML = `
        <div class="shortcuts-content">
            <h3><i class="fas fa-keyboard"></i> Keyboard Shortcuts</h3>
            <ul>
                <li><kbd>Ctrl</kbd> + <kbd>K</kbd> - Focus search bar</li>
                <li><kbd>N</kbd> - Create new question</li>
                <li><kbd>Esc</kbd> - Clear search / Close modal</li>
                <li><kbd>?</kbd> - Show this help</li>
            </ul>
            <button onclick="this.parentElement.parentElement.remove()">Close</button>
        </div>
    `;
    
    modal.style.cssText = `
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.5);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 10000;
    `;
    
    const content = modal.querySelector('.shortcuts-content');
    content.style.cssText = `
        background: white;
        padding: 30px;
        border-radius: 12px;
        max-width: 400px;
        box-shadow: 0 8px 24px rgba(0,0,0,0.2);
    `;
    
    modal.addEventListener('click', function(e) {
        if (e.target === modal) {
            modal.remove();
        }
    });
    
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            modal.remove();
        }
    });
    
    document.body.appendChild(modal);
}

// Save search history to localStorage
function saveSearchHistory(query) {
    if (!query.trim()) return;
    
    let history = JSON.parse(localStorage.getItem('searchHistory') || '[]');
    history = [query, ...history.filter(q => q !== query)].slice(0, 5);
    localStorage.setItem('searchHistory', JSON.stringify(history));
}

// Show search history dropdown
function showSearchHistory() {
    const history = JSON.parse(localStorage.getItem('searchHistory') || '[]');
    if (history.length === 0) return;
    
    // Implementation untuk dropdown search history bisa ditambahkan di sini
    console.log('Search history:', history);
}

console.log('Forum JavaScript loaded - Press ? for keyboard shortcuts');
