<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{ $item->title }} - Online Saptari</title>
  <link rel="shortcut icon" href="{{ asset('web/images/favicon.png') }}">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('web/css/stylesheet.css') }}">
  <link rel="stylesheet" href="{{ asset('web/css/mmenu.css') }}">
  <link rel="stylesheet" href="{{ asset('web/css/style.css') }}" id="colors">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.min.css"/>
  <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700|Open+Sans:400,600,700&display=swap" rel="stylesheet">
</head>
<body class="header-one">

<!-- Preloader -->
<div id="preloader">
  <div class="loader d-flex flex-column align-items-center">
    <div class="ring"></div>
    <div class="text">GenZ <span>Kart</span></div>
  </div>
</div>

<div id="main_wrapper">
  <!-- Header/Navbar -->
  <header id="header_part" class="shadow-sm bg-white">
    <div class="container d-flex justify-content-between align-items-center py-2">
      <a href="{{ route('home') }}"><img src="{{ asset('web/images/Logo.jpg') }}" alt="Online Saptari" height="45"></a>
      <nav class="d-none d-lg-block">
        <ul class="d-flex gap-3 mb-0 list-unstyled">
          <li><a class="{{ request()->routeIs('home') ? 'current' : '' }}" href="{{ route('home') }}">Home</a></li>
          <li><a href="{{ route('user.orders') }}">My Orders</a></li>
        </ul>
      </nav>
      <div class="d-flex gap-3 align-items-center">
        <a href="{{ route('cart.index') }}" class="cart-button position-relative">
          <i class="fa fa-shopping-cart"></i>
          <span class="cart-count position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
            {{ session('cart') ? count(session('cart')) : 0 }}
          </span>
        </a>
      </div>
    </div>
  </header>

  <!-- Item Detail Section -->
  <div class="container py-5">
    <div class="row mb-5">
      <div class="col-md-6 text-center">
        <img src="{{ asset('storage/' . ($item->image ?? 'no-image.png')) }}"
             alt="{{ $item->title }}" class="img-fluid rounded shadow-sm">
      </div>
      <div class="col-md-6">
        <h2>{{ $item->title }}</h2>
        @if($item->subtitle)
          <h5 class="text-muted">{{ $item->subtitle }}</h5>
        @endif

        <p class="mt-3"><strong>Category:</strong> {{ $item->category->Category_Name ?? 'Uncategorized' }}</p>

        <div class="mb-3">
          @if($item->discount_percentage > 0)
            <h4 class="text-danger">
              Rs. {{ number_format($item->price - ($item->price * $item->discount_percentage / 100), 2) }}
              <small class="text-muted"><del>Rs. {{ number_format($item->price, 2) }}</del></small>
            </h4>
            <span class="badge bg-success">{{ $item->discount_percentage }}% Off</span>
          @else
            <h4>Rs. {{ number_format($item->price, 2) }}</h4>
          @endif
        </div>

        @if($item->description)
          <p>{{ $item->description }}</p>
        @endif

        <a href="#" class="btn btn-primary btn-lg mt-3">
          <i class="bi bi-cart"></i> Add to Cart
        </a>
      </div>
    </div>

    <!-- Related Items -->
    @if($relatedItems->count())
    <div class="related-items">
      <h4 class="mb-4">Related Items</h4>
      <div class="row">
        @foreach($relatedItems as $related)
          <div class="col-md-3 mb-4">
            <div class="card h-100 shadow-sm">
              <a href="{{ route('items.show', $related->id) }}">
                <img src="{{ asset('storage/' . ($related->image ?? 'no-image.png')) }}"
                     class="card-img-top" alt="{{ $related->title }}">
              </a>
              <div class="card-body">
                <h6 class="card-title">
                  <a href="{{ route('items.show', $related->id) }}" class="text-dark">
                    {{ $related->title }}
                  </a>
                </h6>
                <p class="text-muted small mb-1">{{ $related->category->Category_Name ?? '' }}</p>
                <p class="mb-0 fw-bold">Rs. {{ number_format($related->price, 2) }}</p>
              </div>
            </div>
          </div>
        @endforeach
      </div>
    </div>
    @endif
  </div>
</div>

<script src="{{ asset('web/js/jquery-3.6.0.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener("DOMContentLoaded", () => {
  setTimeout(() => document.getElementById("preloader").style.display = "none", 800);
});
</script>
</body>
</html>
