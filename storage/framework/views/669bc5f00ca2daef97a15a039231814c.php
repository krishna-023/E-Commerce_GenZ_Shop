<header id="page-topbar">
    <?php
    use Illuminate\Support\Facades\Auth;
    $user = Auth::user(); // Get the authenticated user
?>
    <div class="layout-width">
        <div class="navbar-header">
            <div class="d-flex">
                <!-- LOGO -->
                <div class="navbar-brand-box horizontal-logo">
                    <a href="index" class="logo logo-dark">
                        <span class="logo-sm">
                            <img src="<?php echo e(URL::asset('build/images/logo-sm.png')); ?>" alt="" height="22">
                        </span>
                        <span class="logo-lg">
                            <img src="<?php echo e(URL::asset('build/images/logo-dark.png')); ?>" alt="" height="22">
                        </span>
                    </a>

                    <a href="index" class="logo logo-light">
                        <span class="logo-sm">
                            <img src="<?php echo e(URL::asset('build/images/logo-sm.png')); ?>" alt="" height="22">
                        </span>
                        <span class="logo-lg">
                            <img src="<?php echo e(URL::asset('build/images/logo-light.png')); ?>" alt="" height="22">
                        </span>
                    </a>
                </div>

                <button type="button"
                    class="btn btn-sm px-3 fs-16 header-item vertical-menu-btn topnav-hamburger shadow-none"
                    id="topnav-hamburger-icon">
                    <span class="hamburger-icon">
                        <span></span>
                        <span></span>
                        <span></span>
                    </span>
                </button>

                <form class="app-search d-none d-md-inline-flex">
                    <div class="position-relative">
                        <input type="text" class="form-control" placeholder="Search..." autocomplete="off"
                            id="search-options" value="">
                        <span class="mdi mdi-magnify search-widget-icon"></span>
                        <span class="mdi mdi-close-circle search-widget-icon search-widget-icon-close d-none"
                            id="search-close-options"></span>
                    </div>
                    <div class="dropdown-menu dropdown-menu-lg" id="search-dropdown">
                        <div data-simplebar style="max-height: 320px;">
                            <!-- item-->
                            <div class="dropdown-header">
                                <h6 class="text-overflow text-muted mb-0 text-uppercase">Recent Searches</h6>
                            </div>

                            <div class="dropdown-item bg-transparent text-wrap">
                                <a href="index" class="btn btn-subtle-secondary btn-sm btn-rounded">how to setup <i
                                        class="mdi mdi-magnify ms-1"></i></a>
                                <a href="index" class="btn btn-subtle-secondary btn-sm btn-rounded">buttons <i
                                        class="mdi mdi-magnify ms-1"></i></a>
                            </div>
                            <!-- item-->
                            <div class="dropdown-header mt-2">
                                <h6 class="text-overflow text-muted mb-1 text-uppercase">Pages</h6>
                            </div>

                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item notify-item">
                                <i class="ri-bubble-chart-line align-middle fs-18 text-muted me-2"></i>
                                <span>Analytics Dashboard</span>
                            </a>

                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item notify-item">
                                <i class="ri-lifebuoy-line align-middle fs-18 text-muted me-2"></i>
                                <span>Help Center</span>
                            </a>

                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item notify-item">
                                <i class="ri-user-settings-line align-middle fs-18 text-muted me-2"></i>
                                <span>My account settings</span>
                            </a>

                            <!-- item-->
                            <div class="dropdown-header mt-2">
                                <h6 class="text-overflow text-muted mb-2 text-uppercase">Members</h6>
                            </div>

                            <div class="notification-list">
                                <!-- item -->
                                <a href="javascript:void(0);" class="dropdown-item notify-item py-2">
                                    <div class="d-flex">
                                        <img src="<?php echo e(URL::asset('build/images/users/avatar-2.jpg')); ?>"
                                            class="me-3 rounded-circle avatar-xs" alt="user-pic">
                                        <div class="flex-1">
                                            <h6 class="m-0">Angela Bernier</h6>
                                            <span class="fs-2xs mb-0 text-muted">Manager</span>
                                        </div>
                                    </div>
                                </a>
                                <!-- item -->
                                <a href="javascript:void(0);" class="dropdown-item notify-item py-2">
                                    <div class="d-flex">
                                        <img src="<?php echo e(URL::asset('build/images/users/avatar-3.jpg')); ?>"
                                            class="me-3 rounded-circle avatar-xs" alt="user-pic">
                                        <div class="flex-1">
                                            <h6 class="m-0">David Grasso</h6>
                                            <span class="fs-2xs mb-0 text-muted">Web Designer</span>
                                        </div>
                                    </div>
                                </a>
                                <!-- item -->
                                <a href="javascript:void(0);" class="dropdown-item notify-item py-2">
                                    <div class="d-flex">
                                        <img src="<?php echo e(URL::asset('build/images/users/avatar-5.jpg')); ?>"
                                            class="me-3 rounded-circle avatar-xs" alt="user-pic">
                                        <div class="flex-1">
                                            <h6 class="m-0">Mike Bunch</h6>
                                            <span class="fs-2xs mb-0 text-muted">React Developer</span>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>

                        <div class="text-center pt-3 pb-1">
                            <a href="#" class="btn btn-primary btn-sm">View All Results <i
                                    class="ri-arrow-right-line ms-1"></i></a>
                        </div>
                    </div>
                </form>
            </div>


            <div class="d-flex justify-content-end align-items-center">
                <!-- Language Dropdown -->
                <div class="dropdown ms-1 topbar-head-dropdown header-item">
                    <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle"
                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <?php switch(Session::get('lang')):
                            case ('ru'): ?>
                                <img src="<?php echo e(URL::asset('build/images/flags/russia.svg')); ?>" class="rounded" alt="Header Language" height="20">
                            <?php break; ?>

                            <?php case ('it'): ?>
                                <img src="<?php echo e(URL::asset('build/images/flags/italy.svg')); ?>" class="rounded" alt="Header Language" height="20">
                            <?php break; ?>

                            <?php case ('sp'): ?>
                                <img src="<?php echo e(URL::asset('build/images/flags/spain.svg')); ?>" class="rounded" alt="Header Language" height="20">
                            <?php break; ?>

                            <?php case ('ch'): ?>
                                <img src="<?php echo e(URL::asset('build/images/flags/china.svg')); ?>" class="rounded" alt="Header Language" height="20">
                            <?php break; ?>

                            <?php case ('fr'): ?>
                                <img src="<?php echo e(URL::asset('build/images/flags/french.svg')); ?>" class="rounded" alt="Header Language" height="20">
                            <?php break; ?>

                            <?php case ('gr'): ?>
                                <img src="<?php echo e(URL::asset('build/images/flags/germany.svg')); ?>" class="rounded" alt="Header Language" height="20">
                            <?php break; ?>

                            <?php case ('ae'): ?>
                                <img src="<?php echo e(URL::asset('build/images/flags/ae.svg')); ?>" class="rounded" alt="Header Language" height="20">
                            <?php break; ?>

                            <?php default: ?>
                                <img src="<?php echo e(URL::asset('build/images/flags/us.svg')); ?>" class="rounded" alt="Header Language" height="20">
                        <?php endswitch; ?>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end">
                        <a href="<?php echo e(url('index/en')); ?>" class="dropdown-item notify-item language py-2" data-lang="en" title="English">
                            <img src="<?php echo e(URL::asset('build/images/flags/us.svg')); ?>" alt="user-image" class="me-2 rounded" height="20">
                            <span class="align-middle">English</span>
                        </a>
                        <a href="<?php echo e(url('index/sp')); ?>" class="dropdown-item notify-item language" data-lang="sp" title="Spanish">
                            <img src="<?php echo e(URL::asset('build/images/flags/spain.svg')); ?>" alt="user-image" class="me-2 rounded" height="20">
                            <span class="align-middle">Española</span>
                        </a>
                        <a href="<?php echo e(url('index/gr')); ?>" class="dropdown-item notify-item language" data-lang="gr" title="German">
                            <img src="<?php echo e(URL::asset('build/images/flags/germany.svg')); ?>" alt="user-image" class="me-2 rounded" height="20">
                            <span class="align-middle">Deutsche</span>
                        </a>
                        <a href="<?php echo e(url('index/it')); ?>" class="dropdown-item notify-item language" data-lang="it" title="Italian">
                            <img src="<?php echo e(URL::asset('build/images/flags/italy.svg')); ?>" alt="user-image" class="me-2 rounded" height="20">
                            <span class="align-middle">Italiana</span>
                        </a>
                        <a href="<?php echo e(url('index/ru')); ?>" class="dropdown-item notify-item language" data-lang="ru" title="Russian">
                            <img src="<?php echo e(URL::asset('build/images/flags/russia.svg')); ?>" alt="user-image" class="me-2 rounded" height="20">
                            <span class="align-middle">русский</span>
                        </a>
                        <a href="<?php echo e(url('index/ch')); ?>" class="dropdown-item notify-item language" data-lang="ch" title="Chinese">
                            <img src="<?php echo e(URL::asset('build/images/flags/china.svg')); ?>" alt="user-image" class="me-2 rounded" height="20">
                            <span class="align-middle">中国人</span>
                        </a>
                        <a href="<?php echo e(url('index/fr')); ?>" class="dropdown-item notify-item language" data-lang="fr" title="French">
                            <img src="<?php echo e(URL::asset('build/images/flags/french.svg')); ?>" alt="user-image" class="me-2 rounded" height="20">
                            <span class="align-middle">français</span>
                        </a>
                        <a href="<?php echo e(url('index/ae')); ?>" class="dropdown-item notify-item language" data-lang="ae" title="Arabic">
                            <img src="<?php echo e(URL::asset('build/images/flags/ae.svg')); ?>" alt="user-image" class="me-2 rounded" height="18">
                            <span class="align-middle">عربي</span>
                        </a>
                    </div>
                </div>


            <div class="dropdown ms-sm-3 header-item topbar-user">
                <button type="button" class="btn shadow-none" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="d-flex align-items-center">
                        <img class="rounded-circle header-profile-user" src="<?php echo e(URL::asset('build/images/users/32/umesh.jpg')); ?>" alt="Header Avatar">
                        <span class="text-start ms-xl-2">
                            <?php if($user): ?>
                                <span class="d-none d-xl-inline-block ms-1 fw-medium user-name-text"><?php echo e($user->name); ?></span>
                                <span class="d-none d-xl-block ms-1 fs-sm user-name-sub-text"><?php echo e($user->role ?? 'User'); ?></span>
                            <?php else: ?>
                                <span class="d-none d-xl-inline-block ms-1 fw-medium user-name-text">Guest</span>
                                <span class="d-none d-xl-block ms-1 fs-sm user-name-sub-text">Not Logged In</span>
                            <?php endif; ?>

                    </span>
                </button>
                <div class="dropdown-menu dropdown-menu-end">
                        <h6 class="dropdown-header">
                            Welcome <?php echo e($user->name ?? 'Guest'); ?>!
                        </h6>
                    <a class="dropdown-item" href="<?php echo e(route('item.profile')); ?>">
                        <i class="mdi mdi-account-circle text-muted fs-lg align-middle me-1"></i>
                        <span class="align-middle"> <?php echo app('translator')->get('translation.profile'); ?></span>
                    </a>
                    <a class="dropdown-item" href="pages-faqs">
                        <i class="mdi mdi-lifebuoy text-muted fs-lg align-middle me-1"></i>
                        <span class="align-middle">Help</span>
                    </a>
                    <a class="dropdown-item" href="<?php echo e(route('pages-profile-settings')); ?>">
                        <i class="mdi mdi-settings text-muted fs-lg align-middle me-1"></i>
                        <span class="align-middle"> <?php echo app('translator')->get('translation.settings'); ?></span>
                    </a>
                    <a class="dropdown-item" href="<?php echo e(route('password.confirm')); ?>">
                        <i class="mdi mdi-lock text-muted fs-lg align-middle me-1"></i>
                        <span class="align-middle"> <?php echo app('translator')->get('translation.lock-screen'); ?></span>
                    </a>
                    <a class="dropdown-item" href="<?php echo e(route('logout')); ?>"
                        onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                        <i class="mdi mdi-logout text-muted fs-lg align-middle me-1"></i>
                        <span class="align-middle" data-key="t-logout"><?php echo app('translator')->get('translation.logout'); ?></span>
                    </a>
                    <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" class="d-none">
                        <?php echo csrf_field(); ?>
                    </form>
                </div>
            </div>
            </div>
        </div>
    </div>
</header>

<!-- removeNotificationModal -->
<div id="removeNotificationModal" class="modal fade zoomIn" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                    id="NotificationModalbtn-close"></button>
            </div>
            <div class="modal-body p-md-5">
                <div class="text-center">
                    <div class="text-danger">
                        <i class="bi bi-trash display-4"></i>
                    </div>
                    <div class="mt-4 fs-base">
                        <h4 class="mb-1">Are you sure ?</h4>
                        <p class="text-muted mx-4 mb-0">Are you sure you want to remove this Notification ?</p>
                    </div>
                </div>
                <div class="d-flex gap-2 justify-content-center mt-4 mb-2">
                    <button type="button" class="btn w-sm btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn w-sm btn-danger" id="delete-notification">Yes, Delete
                        It!</button>
                </div>
            </div>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- removeCartModal -->
<div id="removeCartModal" class="modal fade zoomIn" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                    id="close-cartmodal"></button>
            </div>
            <div class="modal-body p-md-5">
                <div class="text-center">
                    <div class="text-danger">
                        <i class="bi bi-trash display-5"></i>
                    </div>
                    <div class="mt-4">
                        <h4>Are you sure ?</h4>
                        <p class="text-muted mx-4 mb-0">Are you sure you want to remove this product ?</p>
                    </div>
                </div>
                <div class="d-flex gap-2 justify-content-center mt-4 mb-2">
                    <button type="button" class="btn w-sm btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn w-sm btn-danger" id="remove-cartproduct">Yes, Delete
                        It!</button>
                </div>
            </div>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<?php /**PATH C:\xampp\htdocs\Genz_Shop\resources\views/admin/layouts/topbar.blade.php ENDPATH**/ ?>