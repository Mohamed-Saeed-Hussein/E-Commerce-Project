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