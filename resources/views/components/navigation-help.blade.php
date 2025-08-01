<!-- Navigation Help Component -->
<div class="navigation-help-banner" id="navHelpBanner">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-auto">
                <i class="fas fa-info-circle text-primary"></i>
            </div>
            <div class="col">
                <small class="text-muted">
                    <strong>Quick Tip:</strong> You can easily switch between the 
                    <span class="text-primary">Frontend Website</span> and 
                    <span class="text-success">Dashboard</span> using the navigation links and floating buttons.
                </small>
            </div>
            <div class="col-auto">
                <button type="button" class="btn-close btn-sm" onclick="hideNavBanner()" aria-label="Close">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
    </div>
</div>

<style>
    .navigation-help-banner {
        background: linear-gradient(45deg, #f8f9fa, #e9ecef);
        border-bottom: 1px solid #dee2e6;
        padding: 8px 0;
        font-size: 13px;
        position: relative;
        z-index: 1000;
    }
    
    .btn-close {
        background: none;
        border: none;
        color: #6c757d;
        font-size: 12px;
        padding: 2px 6px;
    }
    
    .btn-close:hover {
        color: #495057;
    }
    
    @media (max-width: 768px) {
        .navigation-help-banner {
            display: none;
        }
    }
</style>

<script>
    function hideNavBanner() {
        document.getElementById('navHelpBanner').style.display = 'none';
        localStorage.setItem('navHelpBannerHidden', 'true');
    }
    
    // Auto-hide after showing for first time users
    document.addEventListener('DOMContentLoaded', function() {
        if (localStorage.getItem('navHelpBannerHidden') === 'true') {
            document.getElementById('navHelpBanner').style.display = 'none';
        }
    });
</script>
