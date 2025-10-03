<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Style Haven - Checkout</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="/style.css">
</head>
<body>
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
          <button id="darkToggle" class="btn-custom" aria-label="Toggle dark mode"><i class="fas fa-moon"></i></button>
          <a id="accountLink" href="{{ url('/profile') }}" class="btn-custom" style="display:none"><i class="fas fa-user"></i> Account</a>
          <a href="{{ url('/login') }}" class="btn-custom">Sign In</a>
          <a href="{{ url('/register') }}" class="btn-custom">Sign Up</a>
        </div>
      </div>
    </div>
  </nav>

  <section class="container py-5">
    <div id="checkoutRoot" class="row g-4">
      <!-- Filled by JS -->
    </div>
  </section>

  <footer class="bg-dark text-white pt-5 pb-3 mt-5">
    <div class="container">
      <div class="row">
        <div class="col-md-4">
          <h5>Style Haven</h5>
          <p>Your trusted store for trendy fashion</p>
        </div>
        <div class="col-md-4">
          <h6>Quick Links</h6>
          <ul class="list-unstyled">
            <li><a href="{{ url('/home') }}" class="text-white">Home</a></li>
            <li><a href="{{ url('/catalog') }}" class="text-white">Products</a></li>
            <li><a href="{{ url('/about') }}" class="text-white">About</a></li>
            <li><a href="{{ url('/contact') }}" class="text-white">Contact</a></li>
          </ul>
        </div>
        <div class="col-md-4">
          <h6>Follow Us</h6>
          <div class="d-flex gap-2">
            <a href="#" class="btn btn-outline-light btn-sm"><i class="fab fa-facebook"></i></a>
            <a href="#" class="btn btn-outline-light btn-sm"><i class="fab fa-instagram"></i></a>
            <a href="#" class="btn btn-outline-light btn-sm"><i class="fab fa-twitter"></i></a>
          </div>
        </div>
      </div>
      <div class="text-center mt-4">
        <p class="mb-0">&copy; {{ date('Y') }} Style Haven. All rights reserved.</p>
      </div>
    </div>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="/script.js"></script>
  <script>
    (function(){
      function readLS(key, def){ try{ const v = localStorage.getItem(key); return v ? JSON.parse(v) : def; }catch(e){ return def; } }
      function isAuthed(){ return !!readLS('authUser', null); }
      function getCart(){ return readLS('cartItems', []); }

      document.addEventListener('DOMContentLoaded', function(){
        const root = document.getElementById('checkoutRoot');
        const authed = isAuthed();
        const items = getCart();
        if (!authed){
          root.innerHTML = '<div class="col-12"><div class="empty-cart-container text-center"><div class="empty-cart-icon mb-3"><i class="fas fa-user-lock fa-4x text-muted"></i></div><h2>Please sign in to checkout</h2><p class="text-muted">Create an account or sign in to proceed to payment.</p><div class="d-flex justify-content-center gap-2"><a class="btn btn-outline-secondary" href="'+ ("{{ url('/login') }}") +'">Sign In</a><a class="btn btn-danger" href="'+ ("{{ url('/register') }}") +'">Create Account</a></div></div></div>';
          return;
        }
        if (!items.length){
          root.innerHTML = '<div class="col-12"><div class="empty-cart-container text-center"><div class="empty-cart-icon mb-3"><i class="fas fa-shopping-cart fa-4x text-muted"></i></div><h2>Your cart is empty</h2><p class="text-muted">Add items to your cart before checking out.</p><a class="btn btn-danger" href="'+ ("{{ url('/catalog') }}") +'">Start Shopping</a></div></div>';
          return;
        }

        const summary = items.map(it => {
          const line = (it.price||0) * (it.qty||0);
          return `<tr><td>${it.name}</td><td>${it.qty}</td><td>${(it.price||0).toFixed(2)} EGP</td><td>${line.toFixed(2)} EGP</td></tr>`
        }).join('');
        const total = items.reduce((s,i)=> s + (i.price||0)*(i.qty||0), 0);

        root.innerHTML = `
          <div class="col-lg-7">
            <div class="card p-3">
              <h5 class="mb-3">Shipping Information</h5>
              <form id="checkoutForm" novalidate>
                <div class="row g-3">
                  <div class="col-md-6">
                    <label class="form-label" for="fullName">Full Name</label>
                    <input class="form-control" id="fullName" required>
                  </div>
                  <div class="col-md-6">
                    <label class="form-label" for="email">Email</label>
                    <input type="email" class="form-control" id="email" required>
                  </div>
                  <div class="col-md-6">
                    <label class="form-label" for="address">Address</label>
                    <input class="form-control" id="address" required>
                  </div>
                  <div class="col-md-3">
                    <label class="form-label" for="city">City</label>
                    <input class="form-control" id="city" required>
                  </div>
                  <div class="col-md-3">
                    <label class="form-label" for="zip">ZIP</label>
                    <input class="form-control" id="zip" required>
                  </div>
                </div>
                <hr class="my-4">
                <h5 class="mb-3">Payment</h5>
                <div class="row g-3">
                  <div class="col-md-8">
                    <label class="form-label" for="cardNumber">Card Number</label>
                    <input class="form-control" id="cardNumber" maxlength="19" placeholder="1234 5678 9012 3456" required>
                  </div>
                  <div class="col-md-2">
                    <label class="form-label" for="exp">MM/YY</label>
                    <input class="form-control" id="exp" maxlength="5" placeholder="MM/YY" required>
                  </div>
                  <div class="col-md-2">
                    <label class="form-label" for="cvc">CVC</label>
                    <input class="form-control" id="cvc" maxlength="4" placeholder="123" required>
                  </div>
                </div>
                <div class="d-flex justify-content-end mt-4">
                  <button class="btn btn-danger" type="submit">Pay ${total.toFixed(2)} EGP</button>
                </div>
              </form>
            </div>
          </div>
          <div class="col-lg-5">
            <div class="card p-3">
              <h5 class="mb-3">Order Summary</h5>
              <div class="table-responsive">
                <table class="table">
                  <thead><tr><th>Item</th><th>Qty</th><th>Price</th><th>Subtotal</th></tr></thead>
                  <tbody>${summary}</tbody>
                  <tfoot><tr><th colspan="3" class="text-end">Total</th><th>${total.toFixed(2)} EGP</th></tr></tfoot>
                </table>
              </div>
            </div>
          </div>
        `;

        const form = document.getElementById('checkoutForm');
        form.addEventListener('submit', function(ev){
          ev.preventDefault();
          const fullName = document.getElementById('fullName').value.trim();
          const email = document.getElementById('email').value.trim();
          const address = document.getElementById('address').value.trim();
          const city = document.getElementById('city').value.trim();
          const zip = document.getElementById('zip').value.trim();
          const card = document.getElementById('cardNumber').value.replace(/\s+/g,'');
          const exp = document.getElementById('exp').value.trim();
          const cvc = document.getElementById('cvc').value.trim();

          const emailOk = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
          if (!fullName || !emailOk || !address || !city || !zip || card.length < 12 || !/^\d+$/.test(card) || !/^\d{2}\/?\d{2}$/.test(exp) || !/^\d{3,4}$/.test(cvc)){
            alert('Please fill out all fields correctly.');
            return;
          }

          // Simulated success
          alert('Payment successful! Thank you for your order.');
          try { localStorage.setItem('cartItems', '[]'); } catch(e){}
          setTimeout(()=>{ location.href = '{{ url('/home') }}'; }, 800);
        });
      });
    })();
  </script>
</body>
</html>


