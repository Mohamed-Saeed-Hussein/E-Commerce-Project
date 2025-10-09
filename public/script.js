// Helper functions for form validation and user feedback
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

function displayFormMessage(message, type = 'error') {
  const form = document.querySelector('form');
  if (!form) return;

  // Remove any existing alerts first
  const existingAlerts = form.querySelectorAll('.alert');
  existingAlerts.forEach(alert => alert.remove());

  const isSuccess = type === 'success';
  const alertClass = isSuccess ? 'alert-success' : 'alert-danger';
  const iconClass = isSuccess ? 'fa-check-circle' : 'fa-exclamation-triangle';

  const messageDiv = document.createElement('div');
  messageDiv.className = `alert ${alertClass} alert-dismissible fade show`;
  messageDiv.innerHTML = `
    <i class="fas ${iconClass} me-2"></i>
    ${message}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  `;

  form.insertBefore(messageDiv, form.firstChild);

  setTimeout(() => {
    if (messageDiv.parentNode) {
      messageDiv.remove();
    }
  }, 5000);
}

const showError = (message) => displayFormMessage(message, 'error');
const showSuccess = (message) => displayFormMessage(message, 'success');

// Main application logic for cart, auth, and UI interactions
(function () {
  const AUTH_KEY = 'authUser';
  const CART_KEY = 'cartItems';
  const GUEST_CART_KEY = 'guestCartItems';

  function readLS(key, def) {
    try {
      const v = localStorage.getItem(key);
      return v ? JSON.parse(v) : def;
    } catch (e) {
      return def;
    }
  }

  function writeLS(key, val) {
    try {
      localStorage.setItem(key, JSON.stringify(val));
    } catch (e) {
      // Ignore write errors
    }
  }

  function isAuthenticated() {
    return !!readLS(AUTH_KEY, null);
  }

  function getCart() {
    return readLS(CART_KEY, []);
  }

  function setCart(items) {
    writeLS(CART_KEY, items);
    updateCartBadge();
  }

  function getGuestCart() {
    return readLS(GUEST_CART_KEY, []);
  }

  function setGuestCart(items) {
    writeLS(GUEST_CART_KEY, items);
    updateCartBadge();
  }

  function addItemToCart(item) {
    const isAuth = isAuthenticated();
    const cart = isAuth ? getCart() : getGuestCart();
    const existingIndex = cart.findIndex(p => p.id === item.id);

    if (existingIndex !== -1) {
      cart[existingIndex].qty += item.qty;
    } else {
      cart.push(item);
    }

    if (isAuth) {
      setCart(cart);
    } else {
      setGuestCart(cart);
    }
  }

  function migrateGuestToUserCart() {
    const guestCart = getGuestCart();
    if (!guestCart || guestCart.length === 0) return;
    const userCart = getCart();

    guestCart.forEach(guestItem => {
      const userItemIndex = userCart.findIndex(p => p.id === guestItem.id);
      if (userItemIndex !== -1) {
        userCart[userItemIndex].qty += guestItem.qty;
      } else {
        userCart.push(guestItem);
      }
    });

    setCart(userCart);
    setGuestCart([]);
  }

  function getTotalCartCount() {
    const cart = isAuthenticated() ? getCart() : getGuestCart();
    return cart.reduce((sum, item) => sum + (parseInt(item.qty) || 0), 0);
  }

  function updateCartBadge() {
    const badge = document.getElementById('cartCountBadge');
    if (!badge) return;
    const count = getTotalCartCount();
    badge.textContent = count > 99 ? '99+' : String(count);
    badge.style.display = count > 0 ? 'inline-flex' : 'none';
  }

  function updateCartIconsForTheme() {
    const isDark = document.body.classList.contains('dark-mode');
    document.querySelectorAll('.cart-icon.light-visible').forEach(el => el.style.display = isDark ? 'none' : 'inline-flex');
    document.querySelectorAll('.cart-icon.dark-visible').forEach(el => el.style.display = isDark ? 'inline-flex' : 'inline-flex');
  }

  function updateActiveNav() {
    try {
      const path = location.pathname.split('/').pop() || 'index.html';
      document.querySelectorAll('.navbar .nav-link').forEach(a => {
        const href = (a.getAttribute('href') || '').split('?')[0];
        if (href && href === path) {
          a.classList.add('active');
        } else {
          a.classList.remove('active');
        }
      });
    } catch (e) {
      // Ignore errors
    }
  }

  window.addToCart = function (productName, price, btn) {
    const card = btn ? btn.closest('.product-card') : null;
    const titleEl = card ? card.querySelector('.card-title, h3, h5') : null;
    const idBase = titleEl ? titleEl.textContent.trim() : (productName || 'item');
    const id = idBase.toLowerCase().replace(/\s+/g, '-').slice(0, 60);
    const qtyInput = card ? card.querySelector('.qty-input') : null;
    const qty = Math.max(1, parseInt(qtyInput ? qtyInput.value : '1') || 1);
    const item = { id, name: productName || idBase, price: parseFloat(price) || 0, qty };

    addItemToCart(item);
    updateCartBadge();
    alert(`Added ${qty} x ${item.name} to cart`);
  };

  function initializeCartPage() {
    const cartRoot = document.getElementById('cartRoot');
    if (!cartRoot) return;

    const getActiveItems = () => isAuthenticated() ? getCart() : getGuestCart();
    const setActiveItems = (items) => isAuthenticated() ? setCart(items) : setGuestCart(items);

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
        const lineTotal = (it.price || 0) * (it.qty || 0);
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
          <td>${lineTotal.toFixed(2)} EGP</td>
          <td>
            <button class="btn btn-sm btn-outline-danger cart-remove" aria-label="Remove item"><i class="fas fa-trash"></i></button>
          </td>
        </tr>`;
      }).join('');

      const total = items.reduce((s, i) => s + (i.price || 0) * (i.qty || 0), 0);
      const guestMessage = authed ? '' : `<div class="alert alert-info mb-3">You are shopping as a guest. <a href="signin.html" class="alert-link">Sign in</a> or <a href="signup.html" class="alert-link">create an account</a> to save your cart.</div>`;
      const checkoutText = authed ? 'Proceed to Checkout' : 'Sign in to Checkout';
      const checkoutLink = authed ? 'checkout.html' : 'signin.html';

      cartRoot.innerHTML = `
        <div class="card p-3">
          ${guestMessage}
          <div class="table-responsive">
            <table class="table align-middle">
              <thead><tr><th>#</th><th>Item</th><th>Qty</th><th>Price</th><th>Subtotal</th><th></th></tr></thead>
              <tbody>${rows}</tbody>
              <tfoot><tr><th colspan="4" class="text-end">Total</th><th>${total.toFixed(2)} EGP</th><th></th></tr></tfoot>
            </table>
          </div>
          <div class="d-flex justify-content-end gap-2">
            <a href="products.html" class="btn btn-outline-secondary">Continue Shopping</a>
            <a href="${checkoutLink}" class="btn btn-danger">${checkoutText}</a>
          </div>
        </div>`;
    }

    cartRoot.addEventListener('click', function (ev) {
      const row = ev.target.closest('tr[data-id]');
      if (!row) return;

      const id = row.getAttribute('data-id');
      let items = getActiveItems();
      const idx = items.findIndex(p => p.id === id);
      if (idx === -1) return;

      if (ev.target.closest('.cart-plus')) {
        items[idx].qty = (parseInt(items[idx].qty) || 0) + 1;
      } else if (ev.target.closest('.cart-minus')) {
        items[idx].qty = Math.max(0, (parseInt(items[idx].qty) || 0) - 1);
        if (items[idx].qty === 0) items.splice(idx, 1);
      } else if (ev.target.closest('.cart-remove')) {
        items.splice(idx, 1);
      }

      setActiveItems(items);
      renderCart();
    });

    cartRoot.addEventListener('change', function (ev) {
      const input = ev.target.closest('.cart-qty-input');
      const row = ev.target.closest('tr[data-id]');
      if (!input || !row) return;

      const id = row.getAttribute('data-id');
      let items = getActiveItems();
      const idx = items.findIndex(p => p.id === id);
      if (idx === -1) return;

      const newQty = Math.max(0, parseInt(input.value) || 0);
      if (newQty === 0) {
        items.splice(idx, 1);
      } else {
        items[idx].qty = newQty;
      }

      setActiveItems(items);
      renderCart();
    });

    renderCart();
  }

  document.addEventListener('DOMContentLoaded', function () {
    // Initial UI updates
    updateCartBadge();
    updateActiveNav();
    updateCartIconsForTheme();
    const user = readLS(AUTH_KEY, null);
    const accountLink = document.getElementById('accountLink');
    if (accountLink) {
      accountLink.style.display = user ? 'inline-flex' : 'none';
    }

    // Mobile navigation
    const navToggle = document.querySelector('.nav-toggle');
    const navMenu = document.querySelector('.nav-menu');
    if (navToggle && navMenu) {
      navToggle.addEventListener('click', () => navMenu.classList.toggle('active'));
    }

    // Product filtering
    const filterButtons = document.querySelectorAll('.filter-btn');
    const productCards = document.querySelectorAll('.product-card');
    filterButtons.forEach(button => {
      button.addEventListener('click', function () {
        filterButtons.forEach(btn => btn.classList.remove('active'));
        this.classList.add('active');
        const category = this.getAttribute('data-category');
        productCards.forEach(card => {
          card.style.display = (category === 'all' || card.getAttribute('data-category') === category) ? 'block' : 'none';
        });
      });
    });

    // Dark mode toggle
    const darkBtn = document.getElementById("darkToggle");
    if (readLS('darkMode') === 'on') {
        document.body.classList.add('dark-mode');
    }
    if (darkBtn) {
      darkBtn.addEventListener("click", () => {
        const isDark = document.body.classList.toggle("dark-mode");
        writeLS('darkMode', isDark ? 'on' : 'off');
        updateCartIconsForTheme();
      });
    }

    // Scroll-in animations
    const animatedElements = document.querySelectorAll('.fade-in, .slide-in-left, .slide-in-right, .scale-in, .stagger-animation');
    if ('IntersectionObserver' in window) {
      const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
          entry.target.classList.toggle('visible', entry.isIntersecting);
        });
      }, { threshold: 0.1 });
      animatedElements.forEach(el => observer.observe(el));
    }

    // Sign In form
    const signinForm = document.getElementById('signinForm');
    if (signinForm) {
      signinForm.addEventListener('submit', function (ev) {
        ev.preventDefault();
        const email = signinForm.querySelector('#email').value;
        const password = signinForm.querySelector('#password').value;
        if (!validateEmail(email)) return showError('Please enter a valid email address');
        if (!validatePassword(password)) return showError('Password must be at least 6 characters long');
        
        writeLS(AUTH_KEY, { email: email.trim() });
        migrateGuestToUserCart();
        updateCartBadge();
        showSuccess('Signed in successfully');
        setTimeout(() => { location.href = 'index.html'; }, 600);
      });
    }

    // Sign Up form
    const signupForm = document.getElementById('signupForm');
    if (signupForm) {
      signupForm.addEventListener('submit', function (ev) {
        ev.preventDefault();
        const fullName = signupForm.querySelector('#fullName').value;
        const email = signupForm.querySelector('#email').value;
        const phone = signupForm.querySelector('#phone').value;
        const password = signupForm.querySelector('#password').value;
        const confirmPassword = signupForm.querySelector('#confirmPassword').value;
        const terms = signupForm.querySelector('#terms').checked;

        if (!fullName.trim()) return showError('Please enter your full name');
        if (!validateEmail(email)) return showError('Please enter a valid email address');
        if (phone.trim() && !validatePhone(phone)) return showError('Please enter a valid phone number');
        if (!validatePassword(password)) return showError('Password must be at least 6 characters long');
        if (password !== confirmPassword) return showError('Passwords do not match');
        if (!terms) return showError('Please agree to the Terms and Conditions');

        writeLS(AUTH_KEY, { email: email.trim(), name: fullName.trim() });
        migrateGuestToUserCart();
        updateCartBadge();
        showSuccess('Account created successfully');
        setTimeout(() => { location.href = 'index.html'; }, 600);
      });
    }

    // Initialize cart page if present
    initializeCartPage();
  });

  // Delegated event for product quantity controls
  document.addEventListener('click', function (ev) {
    const btn = ev.target.closest('.qty-btn');
    if (!btn) return;

    const card = ev.target.closest('.product-card');
    const input = card ? card.querySelector('.qty-input') : null;
    if (!input) return;

    let value = parseInt(input.value) || 1;
    if (btn.classList.contains('plus')) {
      value += 1;
    } else if (btn.classList.contains('minus')) {
      value = Math.max(1, value - 1);
    }
    input.value = value;
  });
})();