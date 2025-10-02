// تفعيل القائمة المتنقلة على الأجهزة الصغيرة
document.addEventListener('DOMContentLoaded', function () {
  const navToggle = document.querySelector('.nav-toggle');
  const navMenu = document.querySelector('.nav-menu');

  if (navToggle) {
    navToggle.addEventListener('click', function () {
      navMenu.classList.toggle('active');
    });
  }

  // Product filters
  const filterButtons = document.querySelectorAll('.filter-btn');
  const productCards = document.querySelectorAll('.product-card');

  filterButtons.forEach(button => {
    button.addEventListener('click', function () {
      filterButtons.forEach(btn => btn.classList.remove('active'));
      this.classList.add('active');
      const category = this.getAttribute('data-category');
      productCards.forEach(card => {
        if (category === 'all' || card.getAttribute('data-category') === category) {
          card.style.display = 'block';
        } else {
          card.style.display = 'none';
        }
      });
    });
  });

  // Handle simple add-to-cart buttons (non-product list)
  const simpleAddButtons = document.querySelectorAll('.add-to-cart');
  simpleAddButtons.forEach(button => {
    button.addEventListener('click', function () {
      const card = this.closest('.product-card');
      let productName = '';
      if (card) {
        const title = card.querySelector('.card-title, h3, h5');
        productName = title ? title.textContent.trim() : '';
      }
      alert(`Added ${productName} to the cart`);
    });
  });

  const contactForm = document.getElementById('contactForm');
  if (contactForm) {
    contactForm.addEventListener('submit', function (e) {
      e.preventDefault();
      alert('Thank you for contacting us! We will get back to you shortly.');
      this.reset();
    });
  }
});

// Language & Dark Mode
document.addEventListener("DOMContentLoaded", () => {
  // Persist and initialize dark mode. Language is handled centrally below
  const darkBtn = document.getElementById("darkToggle");
  // read saved preference
  const savedDark = (function () { try { return localStorage.getItem('darkMode'); } catch (e) { return null; } })();
  if (savedDark === 'on') {
    document.body.classList.add('dark-mode');
  } else if (savedDark === 'off') {
    document.body.classList.remove('dark-mode');
  }

  if (darkBtn) {
    darkBtn.addEventListener("click", () => {
      const isDark = document.body.classList.toggle("dark-mode");
      try { localStorage.setItem('darkMode', isDark ? 'on' : 'off'); } catch (e) { /* ignore */ }
      // Optionally flip icon/text inside button for accessibility
      // (kept simple - CSS handles appearance)
    });
  }
});
// Enhanced form validation and error handling

function validateEmail(email) {
  const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  return re.test(email);
}

function showError(message) {
  const displayMessage = message;

  // Create error alert
  const errorDiv = document.createElement('div');
  errorDiv.className = 'alert alert-danger alert-dismissible fade show';
  errorDiv.innerHTML = `
      <i class="fas fa-exclamation-triangle me-2"></i>
      ${displayMessage}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  `;

  // Insert at the top of the form
  const form = document.querySelector('form');
  if (form) {
    // Remove any existing alerts first
    const existingAlerts = form.querySelectorAll('.alert');
    existingAlerts.forEach(alert => alert.remove());

    form.insertBefore(errorDiv, form.firstChild);

    // Auto-dismiss after 5 seconds
    setTimeout(() => {
      if (errorDiv.parentNode) {
        errorDiv.remove();
      }
    }, 5000);
  }
}

function showSuccess(message) {
  const displayMessage = message;

  const successDiv = document.createElement('div');
  successDiv.className = 'alert alert-success alert-dismissible fade show';
  successDiv.innerHTML = `
      <i class="fas fa-check-circle me-2"></i>
      ${displayMessage}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  `;

  const form = document.querySelector('form');
  if (form) {
    // Remove any existing alerts first
    const existingAlerts = form.querySelectorAll('.alert');
    existingAlerts.forEach(alert => alert.remove());

    form.insertBefore(successDiv, form.firstChild);

    setTimeout(() => {
      if (successDiv.parentNode) {
        successDiv.remove();
      }
    }, 5000);
  }
}







function showError(message) {
  const displayMessage = message;

  // Create a more professional error display
  const errorDiv = document.createElement('div');
  errorDiv.className = 'alert alert-danger alert-dismissible fade show';
  errorDiv.innerHTML = `
      <i class="fas fa-exclamation-triangle me-2"></i>
      ${displayMessage}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  `;

  // Insert at the top of the form
  const form = document.querySelector('form');
  if (form) {
    form.insertBefore(errorDiv, form.firstChild);

    // Auto-dismiss after 5 seconds
    setTimeout(() => {
      if (errorDiv.parentNode) {
        errorDiv.remove();
      }
    }, 5000);
  }
}

function showSuccess(message) {
  const displayMessage = message;

  const successDiv = document.createElement('div');
  successDiv.className = 'alert alert-success alert-dismissible fade show';
  successDiv.innerHTML = `
      <i class="fas fa-check-circle me-2"></i>
      ${displayMessage}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  `;

  const form = document.querySelector('form');
  if (form) {
    form.insertBefore(successDiv, form.firstChild);

    setTimeout(() => {
      if (successDiv.parentNode) {
        successDiv.remove();
      }
    }, 5000);
  }
}

// Enhanced form validation
function validateEmail(email) {
  const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  return re.test(email);
}

function validatePassword(password) {
  return password.length >= 6;
}

function validatePhone(phone) {
  const re = /^\+?[0-9\s\-]{6,}$/;
  return re.test(phone.trim());
}

// Legacy auth handlers removed to prevent duplicate submit messages on signup/signin

// Scroll-in animations: reveal elements on intersection
document.addEventListener('DOMContentLoaded', () => {
  const animated = Array.from(document.querySelectorAll('.fade-in, .slide-in-left, .slide-in-right, .scale-in, .stagger-animation'));
  if (!('IntersectionObserver' in window)) {
    // Fallback: toggle based on scroll position
    const toggle = () => {
      animated.forEach(el => {
        const rect = el.getBoundingClientRect();
        const inView = rect.top < window.innerHeight * 0.85 && rect.bottom > window.innerHeight * 0.15;
        el.classList.toggle('visible', inView);
      });
    };
    window.addEventListener('scroll', toggle, { passive: true });
    window.addEventListener('resize', toggle);
    toggle();
    return;
  }
  // IO version: we want to re-trigger both when entering and leaving viewport
  const io = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      const el = entry.target;
      if (entry.isIntersecting) {
        el.classList.add('visible');
      } else {
        el.classList.remove('visible');
      }
    });
  }, { threshold: [0, 0.15, 0.5, 1] });
  animated.forEach(el => io.observe(el));
});
// All products & featured products: quantity controls (generic, delegated)
document.addEventListener('click', function (ev) {
  const minus = ev.target.closest('.qty-btn.minus');
  const plus = ev.target.closest('.qty-btn.plus');
  if (!minus && !plus) return;
  const card = ev.target.closest('.product-card');
  const input = card ? card.querySelector('.qty-input') : null;
  if (!input) return;
  let value = parseInt(input.value || '1');
  if (plus) value += 1; else if (minus) value = Math.max(1, value - 1);
  input.value = value;
});


// -------------------- App State, Cart, Auth, UI Enhancements (English only) --------------------
(function () {
  function readLS(key, def) {
    try { const v = localStorage.getItem(key); return v ? JSON.parse(v) : def; } catch (e) { return def; }
  }
  function writeLS(key, val) { try { localStorage.setItem(key, JSON.stringify(val)); } catch (e) { } }

  const AUTH_KEY = 'authUser'; // { email: string } or null
  const CART_KEY = 'cartItems'; // array of { id, name, price, qty }
  const GUEST_CART_KEY = 'guestCartItems';

  function isAuthenticated() { return !!readLS(AUTH_KEY, null); }
  function getCart() { return readLS(CART_KEY, []); }
  function setCart(items) { writeLS(CART_KEY, items); updateCartBadge(); }
  function getGuestCart() { return readLS(GUEST_CART_KEY, []); }
  function setGuestCart(items) { writeLS(GUEST_CART_KEY, items); updateCartBadge(); }

  function addItemToStoreCart(item) {
    const items = getCart();
    const idx = items.findIndex(p => p.id === item.id);
    if (idx !== -1) items[idx].qty += item.qty; else items.push(item);
    setCart(items);
  }
  function addItemToGuestCart(item) {
    const items = getGuestCart();
    const idx = items.findIndex(p => p.id === item.id);
    if (idx !== -1) items[idx].qty += item.qty; else items.push(item);
    setGuestCart(items);
  }

  function migrateGuestToUserCart() {
    const guest = getGuestCart();
    if (!guest || guest.length === 0) return;
    const cart = getCart();
    guest.forEach(g => {
      const idx = cart.findIndex(p => p.id === g.id);
      if (idx !== -1) cart[idx].qty += g.qty; else cart.push(g);
    });
    setCart(cart);
    setGuestCart([]);
  }

  function getTotalCount() {
    const list = isAuthenticated() ? getCart() : getGuestCart();
    return list.reduce((s, i) => s + (parseInt(i.qty) || 0), 0);
  }

  function updateCartBadge() {
    const badge = document.getElementById('cartCountBadge');
    if (!badge) return;
    const count = getTotalCount();
    badge.textContent = count > 99 ? '99+' : String(count);
    badge.style.display = count > 0 ? 'inline-flex' : 'none';
  }

  // Swap cart icon based on dark-mode class
  function updateCartIconsForTheme() {
    const isDark = document.body.classList.contains('dark-mode');
    const lightIcons = document.querySelectorAll('.cart-icon.light-visible');
    const darkIcons = document.querySelectorAll('.cart-icon.dark-visible');
    lightIcons.forEach(el => el.style.display = isDark ? 'none' : 'inline-flex');
    darkIcons.forEach(el => el.style.display = isDark ? 'inline-flex' : 'none');
  }

  // Enhance global darkMode toggle to also swap icons
  document.addEventListener('DOMContentLoaded', function () {
    updateCartBadge();
    updateActiveNav();
    updateCartIconsForTheme();
    const darkBtn = document.getElementById('darkToggle');
    if (darkBtn) {
      darkBtn.addEventListener('click', function () {
        setTimeout(updateCartIconsForTheme, 0);
      });
    }
    // Show account link when logged in
    const user = (function () { try { return JSON.parse(localStorage.getItem('authUser')); } catch (e) { return null; } })();
    const accountLink = document.getElementById('accountLink');
    if (accountLink) { accountLink.style.display = user ? 'inline-flex' : 'none'; }
  });

  // Active nav based on current path
  function updateActiveNav() {
    try {
      const path = location.pathname.split('/').pop() || 'index.html';
      document.querySelectorAll('.navbar .nav-link').forEach(a => {
        const href = (a.getAttribute('href') || '').split('?')[0];
        if (href && href === path) a.classList.add('active'); else a.classList.remove('active');
      });
    } catch (e) { }
  }

  // Override global addToCart to persist items and update badge
  window.addToCart = function (productName, price, btn) {
    const card = btn ? btn.closest('.product-card') : null;
    const titleEl = card ? card.querySelector('.card-title, h3, h5') : null;
    const idBase = titleEl ? titleEl.textContent.trim() : (productName || 'item');
    const id = idBase.toLowerCase().replace(/\s+/g, '-').slice(0, 60);
    const qtyInput = card ? card.querySelector('.qty-input') : null;
    const qty = Math.max(1, parseInt(qtyInput ? qtyInput.value : '1') || 1);
    const item = { id, name: productName || idBase, price: parseFloat(price) || 0, qty };
    if (isAuthenticated()) addItemToStoreCart(item); else addItemToGuestCart(item);
    updateCartBadge();
    try { alert(`Added ${qty} x ${item.name} to cart`); } catch (e) { }
  };

  // Auth handlers: persist and migrate guest cart
  document.addEventListener('DOMContentLoaded', function () {
    const signin = document.getElementById('signinForm');
    if (signin) {
      signin.addEventListener('submit', function (ev) {
        ev.preventDefault();
        const email = signin.querySelector('#email');
        const password = signin.querySelector('#password');
        if (!email.value.trim()) { showError('Please enter your email'); return; }
        const emailOk = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email.value);
        if (!emailOk) { showError('Please enter a valid email address'); return; }
        if (!password.value.trim()) { showError('Please enter your password'); return; }
        if (password.value.length < 6) { showError('Password must be at least 6 characters long'); return; }
        writeLS(AUTH_KEY, { email: email.value.trim() });
        migrateGuestToUserCart();
        updateCartBadge();
        showSuccess('Signed in successfully');
        setTimeout(() => { location.href = 'index.html'; }, 600);
      });
    }

    const signup = document.getElementById('signupForm');
    if (signup) {
      signup.addEventListener('submit', function (ev) {
        ev.preventDefault();
        const fullName = signup.querySelector('#fullName');
        const email = signup.querySelector('#email');
        const phone = signup.querySelector('#phone');
        const password = signup.querySelector('#password');
        const confirmPassword = signup.querySelector('#confirmPassword');
        const terms = signup.querySelector('#terms');
        if (!fullName.value.trim()) { showError('Please enter your full name'); return; }
        const emailOk = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email.value);
        if (!email.value.trim() || !emailOk) { showError('Please enter a valid email address'); return; }
        if (phone.value.trim() && !/^\+?[0-9\s\-]{6,}$/.test(phone.value.trim())) { showError('Please enter a valid phone number'); return; }
        if (!password.value.trim() || password.value.length < 6) { showError('Password must be at least 6 characters long'); return; }
        if (password.value !== confirmPassword.value) { showError('Password and confirmation do not match'); return; }
        if (!terms.checked) { showError('Please agree to the Terms and Conditions'); return; }
        writeLS(AUTH_KEY, { email: email.value.trim(), name: fullName.value.trim() });
        migrateGuestToUserCart();
        updateCartBadge();
        showSuccess('Account created successfully');
        setTimeout(() => { location.href = 'index.html'; }, 600);
      });
    }
  });

  // Cart page rendering with quantity adjust and remove
  document.addEventListener('DOMContentLoaded', function () {
    const cartRoot = document.getElementById('cartRoot');
    if (!cartRoot) return;

    function getActiveItems() { return isAuthenticated() ? getCart() : getGuestCart(); }
    function setActiveItems(items) { if (isAuthenticated()) setCart(items); else setGuestCart(items); }

    function renderCart() {
      const authed = isAuthenticated();
      const items = getActiveItems();
      if (!items.length) {
        cartRoot.innerHTML = `
                  <div class="empty-cart-container text-center">
                      <div class="empty-cart-icon mb-4"><i class="fas fa-shopping-cart fa-5x text-muted"></i></div>
                      <h2 class="mb-3">Your Shopping Cart is Empty</h2>
                      <p class="text-muted mb-4">Browse categories and discover our best deals!</p>
                      <a href="products.html" class="btn btn-danger btn-lg px-4">Start Shopping</a>
                  </div>`;
        updateCartBadge();
        return;
      }
      const rows = items.map((it, idx) => {
        const line = (it.price || 0) * (it.qty || 0);
        return `<tr data-id="${it.id}">
                  <td>${idx + 1}</td>
                  <td>${it.name}</td>
                  <td style="min-width: 140px;">
                      <div class="d-inline-flex align-items-center gap-1">
                          <button class="btn btn-sm btn-outline-secondary cart-minus" aria-label="Decrease quantity">-</button>
                          <input class="form-control form-control-sm text-center cart-qty-input" style="width:60px" value="${it.qty}" inputmode="numeric">
                          <button class="btn btn-sm btn-outline-secondary cart-plus" aria-label="Increase quantity">+</button>
                      </div>
                  </td>
                  <td>${(it.price || 0).toFixed(2)} EGP</td>
                  <td>${line.toFixed(2)} EGP</td>
                  <td>
                      <button class="btn btn-sm btn-outline-danger cart-remove" aria-label="Remove item"><i class="fas fa-trash"></i></button>
                  </td>
              </tr>`;
      }).join('');
      const total = items.reduce((s, i) => s + (i.price || 0) * (i.qty || 0), 0);
      cartRoot.innerHTML = `
              <div class="card p-3">
                  ${authed ? '' : '<div class="alert alert-info mb-3">You are shopping as a guest. <a href="signin.html" class="alert-link">Sign in</a> or <a href="signup.html" class="alert-link">create an account</a> to save your cart across devices.</div>'}
                  <div class="table-responsive">
                      <table class="table align-middle">
                          <thead><tr><th>#</th><th>Item</th><th>Qty</th><th>Price</th><th>Subtotal</th><th></th></tr></thead>
                          <tbody>${rows}</tbody>
                          <tfoot><tr><th colspan="4" class="text-end">Total</th><th>${total.toFixed(2)} EGP</th><th></th></tr></tfoot>
                      </table>
                  </div>
                  <div class="d-flex justify-content-end gap-2">
                      <a href="products.html" class="btn btn-outline-secondary">Continue Shopping</a>
                      <a href="${authed ? 'checkout.html' : 'signin.html'}" class="btn btn-danger">${authed ? 'Proceed to Checkout' : 'Sign in to Checkout'}</a>
                  </div>
              </div>`;
    }

    // Delegate events for plus/minus/remove and direct qty edit
    cartRoot.addEventListener('click', function (ev) {
      const row = ev.target.closest('tr[data-id]');
      if (!row) return;
      const id = row.getAttribute('data-id');
      let items = getActiveItems();
      const idx = items.findIndex(p => p.id === id);
      if (idx === -1) return;
      if (ev.target.closest('.cart-plus')) {
        items[idx].qty = (parseInt(items[idx].qty) || 0) + 1;
        setActiveItems(items);
        renderCart();
        return;
      }
      if (ev.target.closest('.cart-minus')) {
        const next = (parseInt(items[idx].qty) || 0) - 1;
        if (next <= 0) { items.splice(idx, 1); } else { items[idx].qty = next; }
        setActiveItems(items);
        renderCart();
        return;
      }
      if (ev.target.closest('.cart-remove')) {
        items.splice(idx, 1);
        setActiveItems(items);
        renderCart();
        return;
      }
    });

    cartRoot.addEventListener('change', function (ev) {
      const input = ev.target.closest('.cart-qty-input');
      if (!input) return;
      const row = ev.target.closest('tr[data-id]');
      const id = row ? row.getAttribute('data-id') : null;
      if (!id) return;
      let items = getActiveItems();
      const idx = items.findIndex(p => p.id === id);
      if (idx === -1) return;
      const val = Math.max(0, parseInt(input.value) || 0);
      if (val <= 0) { items.splice(idx, 1); }
      else { items[idx].qty = val; }
      setActiveItems(items);
      renderCart();
    });

    renderCart();
  });
})();

