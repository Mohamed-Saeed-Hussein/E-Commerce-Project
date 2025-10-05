<nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold" href="{{ url('/home') }}">Style Haven</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <div class="mx-auto">
                <ul class="navbar-nav">
                    <li class="nav-item"><a class="nav-link" href="{{ url('/home') }}">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('/catalog') }}">Products</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('/about') }}">About</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('/contact') }}">Contact</a></li>
                    <li class="nav-item">
                        <a href="{{ url('/cart') }}" class="nav-link cart-link" aria-label="Cart">
                            <span class="cart-icon light-visible"><i class="fas fa-shopping-cart"></i></span>
                            <span class="cart-icon dark-visible" style="display:none"><i class="fas fa-shopping-basket"></i></span>
                            <span id="cartCountBadge" class="cart-count-badge">0</span>
                        </a>
                    </li>
                </ul>
            </div>

            <div class="nav-actions">
                <button id="darkToggle" class="btn-custom"><i class="fas fa-moon"></i></button>
                <a id="accountLink" href="{{ url('/profile') }}" class="btn-custom" style="display:none"><i class="fas fa-user"></i> Account</a>
                <a href="{{ url('/login') }}" class="btn-custom {{ request()->is('login') ? 'active' : '' }}">Sign In</a>
                <a href="{{ url('/register') }}" class="btn-custom {{ request()->is('register') ? 'active' : '' }}">Sign Up</a>
            </div>
        </div>
    </div>
</nav>


