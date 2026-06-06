<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Online Saptari</title>
<link rel="shortcut icon" href="<?php echo e(asset('web/images/favicon.png')); ?>">
<link rel="stylesheet" href="<?php echo e(asset('web/css/stylesheet.css')); ?>">
<link rel="stylesheet" href="<?php echo e(asset('web/css/mmenu.css')); ?>">
<link rel="stylesheet" href="<?php echo e(asset('web/css/style.css')); ?>" id="colors">

<!-- Magnific Popup CSS (used for the inline modal) -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.min.css" integrity="sha512-8m4b8Hq8mE8q3FzP1QmNFq+FZq4y0c7c4aX1qz2z2vQZ2lVv0t3c9m6K2oTq4g1o0oJ7k1Y8G2p1H1a2V3J4w==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<!-- Fonts -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<link href="https://fonts.googleapis.com/css?family=Nunito:300,400,600,700,800&display=swap&subset=latin-ext,vietnamese" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,500,600,700,800" rel="stylesheet">
<style>
/* small style to avoid flash if JS disabled */
.dropdown-menu {
  border-radius: 12px;
  padding: 0.5rem 0;
  font-size: 14px;
}
.dropdown-menu .dropdown-item {
  padding: 10px 20px;
  transition: background 0.2s;
}
.dropdown-menu .dropdown-item:hover {
  background: #f8f9fa;
}

.tab_content { display: none; }
.utf_tabs_nav li.active > a { font-weight:700; }
.my-mfp-zoom-in { /* Magnific popup zoom animation */
  -webkit-animation: zoomIn .3s;
  animation: zoomIn .3s;
}
@keyframes zoomIn {
  from { transform: scale(0.9); opacity:0; }
  to { transform: scale(1); opacity:1; }
}
/* Modern floating search dropdown */
#search-results {
    position: absolute;
    top: 100%;
    left: 0;
    width: 100%;
    max-height: 350px;
    overflow-y: auto;
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.15);
    display: none;
    z-index: 3000;
    padding: 5px 0;
    transition: opacity 0.3s, transform 0.3s;
}

#search-results.show {
    display: block;
    opacity: 1;
    transform: translateY(0);
}

#search-results a {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 10px 15px;
    text-decoration: none;
    color: #333;
    transition: background 0.2s, transform 0.2s;
}

#search-results a:hover,
#search-results a.active {
    background: #f1f1f1;
    transform: translateX(3px);
}

#search-results a img {
    width: 40px;
    height: 40px;
    border-radius: 8px;
    object-fit: cover;
}

#search-results .item-info {
    display: flex;
    flex-direction: column;
}

#search-results .item-title {
    font-weight: 600;
    font-size: 14px;
}

#search-results .item-subtitle {
    font-size: 12px;
    color: #777;
}

#search-results::-webkit-scrollbar {
    width: 6px;
}
#search-results::-webkit-scrollbar-thumb {
    background-color: rgba(0,0,0,0.2);
    border-radius: 3px;
}

</style>
</head>
<body class="header-one">

<!-- Preloader -->
<div id="preloader">
  <div class="loader">
    <div class="ring"></div>
    <div class="text">GenZ <span>Kart</span></div>
  </div>
</div>
<div id="main_wrapper">
  <header id="header_part" class="fullwidth">
    <div id="header">
      <div class="container">
        <div class="utf_left_side">
          <div id="logo">
            <a href="<?php echo e(route('home')); ?>">
              <img src="<?php echo e(asset('web/images/Logo.jpg')); ?>" alt="Online Saptari">
            </a>
          </div>

          <!-- Mobile Hamburger -->
          <div class="mmenu-trigger">
            <button class="hamburger utfbutton_collapse" type="button">
              <span class="utf_inner_button_box">
                <span class="utf_inner_section"></span>
              </span>
            </button>
          </div>

          <!-- Navigation -->
          <nav id="navigation" class="style_one">
            <ul id="responsive">
              <li><a class="<?php echo e(request()->routeIs('home') ? 'current' : ''); ?>" href="<?php echo e(route('home')); ?>">Home</a></li>

              <?php if(auth()->guard()->check()): ?>
                <?php if(auth()->user()->role !== 'user'): ?>
                  <li><a href="<?php echo e(route('item.index')); ?>">Listings</a></li>
                  <li><a href="#">User Panel</a>
                    <ul>
                      <li><a href="<?php echo e(route('dashboard')); ?>">Dashboard</a></li>
                      <li><a href="<?php echo e(route('user.add')); ?>">Add Listing</a></li>
                      <li><a href="<?php echo e(route('item.profile')); ?>">My Profile</a></li>
                    </ul>
                  </li>
                <?php endif; ?>
              <?php endif; ?>

              <li><a href="<?php echo e(route('user.orders')); ?>">My Orders</a></li>
            </ul>
          </nav>
          <div class="d-flex gap-2 align-items-center" style="width: 250px;">
    <input type="text" id="search-box" class="form-control form-control-sm" placeholder="Search items...">
    <div id="search-results" class="list-group position-absolute w-100 mt-3 shadow" style="z-index: 2000; display: none;"></div>
</div>
          <div class="clearfix"></div>
        </div>

       <!-- Right Side Buttons -->
      <div class="d-flex gap-2 align-items-center">
        <?php if(auth()->guard()->guest()): ?>
          <a href="#dialog_signin_part" class="button border sign-in popup-with-zoom-anim">Sign In</a>
          <a href="<?php echo e(route('user.add')); ?>" class="button border with-icon">Add Listing</a>
        <?php else: ?>
  <div class="dropdown">
    <button class="btn btn-light d-flex align-items-center gap-2 dropdown-toggle border-0 bg-transparent"
            type="button" id="userDropdown"
            data-bs-toggle="dropdown" aria-expanded="false">
      <img src="<?php echo e(Auth::user()->profile_picture ? asset('storage/' . Auth::user()->profile_picture) : asset('web/images/default-profile.png')); ?>"
           alt="<?php echo e(Auth::user()->name); ?>" class="rounded-circle" width="40" height="40">
      <span><?php echo e(Auth::user()->name); ?></span>
    </button>
    <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="userDropdown">
      <li>
        <a class="dropdown-item" href="<?php echo e(route('item.profile')); ?>">
          <i class="fa fa-user me-2"></i> My Profile
        </a>
      </li>
      <li>
        <a class="dropdown-item" href="<?php echo e(route('account.settings')); ?>">
          <i class="fa fa-cog me-2"></i> Settings
        </a>
      </li>
      <li><hr class="dropdown-divider"></li>
      <li>
        <form action="<?php echo e(route('logout')); ?>" method="POST">
          <?php echo csrf_field(); ?>
          <button type="submit" class="dropdown-item">
            <i class="fa fa-sign-out-alt me-2"></i> Logout
          </button>
        </form>
      </li>
    </ul>
  </div>
<?php endif; ?>
        <a href="<?php echo e(route('cart.index')); ?>" class="cart-button position-relative">
          <i class="fa fa-shopping-cart"></i>
          <span class="cart-count position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
            <?php echo e(session('cart') ? count(session('cart')) : 0); ?>

            <span class="visually-hidden">items in cart</span>
          </span>
        </a>

      </div>

    </div>
  </div>
</header>

<!-- Login/Register Popup -->
<div id="dialog_signin_part" class="zoom-anim-dialog mfp-hide">
  <div class="small_dialog_header"><h3>Sign In</h3></div>
  <div class="utf_signin_form style_one">
    <ul class="utf_tabs_nav d-flex gap-2">
      <li class="active"><a href="#tab1">Log In</a></li>
      <li><a href="#tab2">Register</a></li>
    </ul>
    <div class="tab_container alt">
      <div class="tab_content" id="tab1">
        <form method="POST" action="<?php echo e(route('login.submit')); ?>">
          <?php echo csrf_field(); ?>
          <p><input type="email" name="email" placeholder="Email" required></p>
          <p><input type="password" name="password" placeholder="Password" required></p>
          <button type="submit" class="button border">Login</button>
        </form>
      </div>
      <div class="tab_content" id="tab2">
        <form method="POST" action="<?php echo e(route('register')); ?>">
          <?php echo csrf_field(); ?>
          <p><input type="text" name="name" placeholder="Full Name" required></p>
          <p><input type="email" name="email" placeholder="Email" required></p>
          <p><input type="password" name="password" placeholder="Password" required></p>
          <p><input type="password" name="password_confirmation" placeholder="Confirm Password" required></p>
          <button type="submit" class="button border">Register</button>
        </form>
      </div>
    </div>
  </div>
</div>


  <!-- rest of page... -->

  <!-- jQuery (required for Magnific Popup) -->
  <script src="<?php echo e(asset('web/js/jquery-3.6.0.min.js')); ?>"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/jquery.magnific-popup.min.js"></script>
<script src="<?php echo e(asset('web/js/mmenu.js')); ?>"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

  <script>
  jQuery(document).ready(function($) {
    // initialize popup
    $('.popup-with-zoom-anim').magnificPopup({
      type: 'inline',
      preloader: false,
      focus: '#email',
      removalDelay: 300,
      mainClass: 'my-mfp-zoom-in',
      callbacks: {
        open: function() {
          // when opening ensure first tab is visible properly
          $('.tab_content').hide();
          $('#tab1').show();
          $('.utf_tabs_nav li').removeClass('active');
          $('.utf_tabs_nav li:first').addClass('active');
        },
        beforeOpen: function() {
          if($(window).width() < 700) {
            this.st.focus = false;
          } else {
            this.st.focus = this.st.focus || '#email';
          }
        }
      }
    });

    // Tabs switching
    $('.utf_tabs_nav a').on('click', function(e){
      e.preventDefault();
      var target = $(this).attr('href');
      $(this).closest('.utf_tabs_nav').find('li').removeClass('active');
      $(this).parent().addClass('active');
      $(this).closest('.tab_container').find('.tab_content').hide();
      $(target).show();
    });

    // Show first tab content by default (if popup opened manually)
    $('.tab_container').each(function(){
      $(this).find('.tab_content').hide();
      $(this).find('.tab_content').first().show();
    });

    // Auto-open modal if there are validation errors (login/register)
    <?php if($errors->any()): ?>
      // open popup and show relevant tab based on which fields have errors
      $.magnificPopup.open({
        items: { src: '#dialog_signin_part' },
        type: 'inline',
        removalDelay: 300,
        mainClass: 'my-mfp-zoom-in',
        callbacks: {
          open: function() {
            // decide which tab to show: if registration fields present in old input show tab2
            <?php if(old('name') || session()->has('open_register') ): ?>
              $('#tab1, #tab2').hide();
              $('#tab2').show();
              $('.utf_tabs_nav li').removeClass('active');
              $('.utf_tabs_nav li:has(a[href="#tab2"])').addClass('active');
            <?php else: ?>
              $('#tab1, #tab2').hide();
              $('#tab1').show();
              $('.utf_tabs_nav li').removeClass('active');
              $('.utf_tabs_nav li:has(a[href="#tab1"])').addClass('active');
            <?php endif; ?>
          }
        }
      }, 0);
    <?php endif; ?>
  });
  </script>
  <script>
// Optional JS: auto-hide after 1.5s
document.addEventListener("DOMContentLoaded", function() {
  setTimeout(() => {
    document.getElementById("preloader").style.display = "none";
  }, 1000);
});
</script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    const searchBox = document.getElementById("search-box");
    const resultsDiv = document.getElementById("search-results");
    let activeIndex = -1;

    const clearActive = () => {
        resultsDiv.querySelectorAll("a").forEach(el => el.classList.remove("active"));
    };

    const updateActive = (index) => {
        clearActive();
        const items = resultsDiv.querySelectorAll("a");
        if (items[index]) {
            items[index].classList.add("active");
            items[index].scrollIntoView({ block: "nearest" });
        }
    };

    searchBox.addEventListener("keyup", function (e) {
        let query = this.value.trim();

        if (e.key === "ArrowDown") {
            const items = resultsDiv.querySelectorAll("a");
            if (items.length) {
                activeIndex = (activeIndex + 1) % items.length;
                updateActive(activeIndex);
            }
            return;
        }
        if (e.key === "ArrowUp") {
            const items = resultsDiv.querySelectorAll("a");
            if (items.length) {
                activeIndex = (activeIndex - 1 + items.length) % items.length;
                updateActive(activeIndex);
            }
            return;
        }
        if (e.key === "Enter") {
            const items = resultsDiv.querySelectorAll("a");
            if (items[activeIndex]) {
                window.location.href = items[activeIndex].href;
            }
            return;
        }

        // Normal typing search
        if (query.length > 1) {
            fetch("<?php echo e(route('items.ajax.search')); ?>?q=" + query)
                .then(res => res.json())
                .then(data => {
                    resultsDiv.innerHTML = "";
                    activeIndex = -1;
                    if (data.length > 0) {
                        data.forEach(item => {
                            resultsDiv.innerHTML += `
                                <a href="/item/${item.id}">
                                    ${item.image ? `<img src="/storage/${item.image}" alt="${item.title}">`
                                                : `<img src='<?php echo e(asset("web/images/default-profile.png")); ?>' alt='No Image'>`}
                                    <div class="item-info">
                                        <div class="item-title">${item.title}</div>
                                        <div class="item-subtitle">${item.subtitle ?? ''}</div>
                                    </div>
                                </a>
                            `;
                        });
                        resultsDiv.classList.add("show");
                    } else {
                        resultsDiv.innerHTML = `<div class="text-center text-muted py-2">No items found</div>`;
                        resultsDiv.classList.add("show");
                    }
                });
        } else {
            resultsDiv.classList.remove("show");
        }
    });

    document.addEventListener("click", function (e) {
        if (!searchBox.contains(e.target) && !resultsDiv.contains(e.target)) {
            resultsDiv.classList.remove("show");
        }
    });
});

</script>



</div> <!-- #main_wrapper -->
</body>
</html>
<?php /**PATH C:\xampp\htdocs\Genz_Shop\resources\views/web/layouts/header.blade.php ENDPATH**/ ?>