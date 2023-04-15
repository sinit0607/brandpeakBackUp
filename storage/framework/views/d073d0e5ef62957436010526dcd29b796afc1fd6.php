<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
  <title>Dashboard - <?php echo e(App\Models\AppSetting::getAppSetting('app_title')); ?></title>
  <link rel="icon" href="<?php if(App\Models\StorageSetting::getStorageSetting('storage') == 'DigitalOcean'): ?><?php echo e(\Storage::disk('spaces')->url('uploads/'.App\Models\AppSetting::getAppSetting('admin_favicon'))); ?> <?php else: ?> <?php echo e(asset('uploads/'.App\Models\AppSetting::getAppSetting('admin_favicon'))); ?> <?php endif; ?>">
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo e(asset('assets/plugins/font-awesome/css/font-awesome.min.css')); ?>">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/fontawesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?php echo e(asset('assets/css/ionicons.min.css')); ?>">
  <!-- fullCalendar 2.2.5-->
  <link rel="stylesheet" href="<?php echo e(asset('assets/plugins/fullcalendar/fullcalendar.min.css')); ?>">
  <link rel="stylesheet" href="<?php echo e(asset('assets/plugins/fullcalendar/fullcalendar.print.css')); ?>" media="print">
  <!-- DataTables -->
  <link rel="stylesheet" href="<?php echo e(asset('assets/plugins/datatables/dataTables.bootstrap4.min.css')); ?>">
  <link rel="stylesheet" type="text/css" href="<?php echo e(asset('assets/css/cdn/buttons.dataTables.min.css')); ?>">
    <!-- Select2 -->
  <link rel="stylesheet" href="<?php echo e(asset('assets/plugins/select2/select2.min.css')); ?>">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo e(asset('assets/css/dist/adminlte.min.css')); ?>">
  <!-- iCheck -->
  <link rel="stylesheet" href="<?php echo e(asset('assets/plugins/iCheck/flat/blue.css')); ?>">
    <!-- iCheck for checkboxes and radio inputs -->
  <link rel="stylesheet" href="<?php echo e(asset('assets/plugins/iCheck/all.css')); ?>">
  <!-- Morris chart -->
  <link rel="stylesheet" href="<?php echo e(asset('assets/plugins/morris/morris.css')); ?>">
  <!-- jvectormap -->
  <link rel="stylesheet" href="<?php echo e(asset('assets/plugins/jvectormap/jquery-jvectormap-1.2.2.css')); ?>">
  <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" href="<?php echo e(asset('assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css')); ?>">
  <!-- Google Font: Source Sans Pro -->
  <link href="<?php echo e(asset('assets/css/fonts/fonts.css')); ?>" rel="stylesheet">
  <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-colorpicker/2.5.3/css/bootstrap-colorpicker.min.css" rel="stylesheet">
  <link href="<?php echo e(asset('assets/css/pnotify.custom.min.css')); ?>" media="all" rel="stylesheet" type="text/css" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"/>
  <!--toaster--alert -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css"/>
  <?php echo $__env->yieldContent("extra_css"); ?>
  
  <!-- browser notification -->
  <!-- <script type="text/javascript" src="<?php echo e(asset('assets/push_notification/app.js')); ?>"></script> -->
  <style type="text/css">
    tfoot input {
        width: 100%;
        padding: 3px;
        box-sizing: border-box;
        font-size: 0.6em;
        height: 35px !important;
    }
    body
    {
        font-family: 'Poppins', sans-serif;
    }
    .dropdown:hover .dropdown-menu 
    {
      display: block;
    }
    .main-sidebar {
      min-height: 100% !important;
    }
    .content-wrapper {
      min-height: 1000px !important;
    }
    .card-title
    {
      font-size: 1.4rem;
    }
  </style>
</head>

<body class="hold-transition sidebar-mini layout-navbar-fixed">
<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand bg-white navbar-light border-bottom">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#"><i class="fa fa-bars"></i></a>
      </li>
    </ul>

    <a class="ml-3" href="<?php echo e(url('admin/clear-cache')); ?>"><img src="<?php echo e(asset('assets/images/icon/clean.png')); ?>" width="30px" height="30px"/></a>
    <!-- <a class="ml-4 text-success" href="<?php echo e(url('admin/sql-database')); ?>"><i class="fa-solid fa-xl fa-database"></i></a> -->
    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <li class="dropdown mt-1 mr-3">
          <a data-toggle="dropdown" href="#">
              <img class="rounded-circle" src="<?php if(Auth::user()->image): ?> <?php if(App\Models\StorageSetting::getStorageSetting('storage') == 'DigitalOcean'): ?><?php echo e(\Storage::disk('spaces')->url('uploads/'.Auth::user()->image)); ?> <?php else: ?> <?php echo e(asset('uploads/'.Auth::user()->image)); ?> <?php endif; ?> <?php else: ?> <?php echo e(asset('assets/images/user.png')); ?> <?php endif; ?>" width="40px" height="40px">
              <span class="badge badge-danger navbar-badge"></span>
          </a>
          <div class="dropdown-menu dropdown-menu-right">
              <a class="dropdown-item" href="<?php echo e(url('admin/user-profile')); ?>">Profile</a>
              <?php if(Auth::user()->user_type == 'A'): ?><a class="dropdown-item" href="<?php echo e(url('admin/')); ?>">Administration</a><?php endif; ?>
              <a class="dropdown-item" href="<?php echo e(route('logout')); ?>" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
          </div>
          <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" style="display: none;">
              <?php echo e(csrf_field()); ?>

          </form>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar elevation-4" style="background-color: #056FED;">
    <!-- Brand Logo -->
    <a href="<?php echo e(url('admin/')); ?>" class="brand-link text-center" style="color: white;background-color: #056FED;height: 60px;">
      <h3><?php echo e(App\Models\AppSetting::getAppSetting('app_title')); ?></h3>
      <!-- <img src="<?php echo e(asset('uploads/'.App\Models\AppSetting::getAppSetting('app_logo'))); ?>" class="mt-2" width="50px" height="50px"> -->
    </a>
    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <!-- <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
        <img src="<?php echo e(asset('uploads/'.Auth::user()->image)); ?>" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="<?php echo e(url('admin/user/'.Auth::user()->id.'/edit')); ?>" class="d-block"><?php echo e(Auth::user()->name); ?></a>
        </div>
      </div> -->

      <!-- Sidebar Menu -->
     <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false" style="color: white;">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <!-- user-type S or O -->
          
          
          <li class="nav-item">
            <a href="<?php echo e(url('admin/')); ?>" class="nav-link <?php if(Request::is('admin') || Request::is('admin/user-profile')): ?> active <?php endif; ?>" style="color: white;">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
                <span class="right badge badge-danger"></span>
              </p>
            </a>
          </li>

          <!-- <?php if(Request::is('admin/members*')): ?>
              <?php ($class="menu-open"); ?>
              <?php ($active="active"); ?>
          <?php else: ?>
              <?php ($class=""); ?>
              <?php ($active=""); ?>
          <?php endif; ?>

          
          <li class="nav-item has-treeview <?php echo e($class); ?>">
            <a href="<?php echo e(url('/admin/members')); ?>" class="nav-link <?php echo e($active); ?>" style="color: white;"> 
              <i class="nav-icon fa fa-user"></i>
              <p>
                Members
              </p>
            </a>
          </li> -->

          <?php if(Request::is('admin/language*')): ?>
              <?php ($class="menu-open"); ?>
              <?php ($active="active"); ?>
          <?php else: ?>
              <?php ($class=""); ?>
              <?php ($active=""); ?>
          <?php endif; ?>

          <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Language')): ?>
          <li class="nav-item has-treeview <?php echo e($class); ?>">
            <a href="<?php echo e(route('language.index')); ?>" class="nav-link <?php echo e($active); ?>" style="color: white;">
              <i class="nav-icon fa fa-language"></i>
              <p>
                Language
              </p>
            </a>
          </li>
          <?php endif; ?>

          <?php if(Request::is('admin/category*') || Request::is('admin/category-frame*') || Request::is('admin/category-get*')): ?>
              <?php ($class="menu-open"); ?>
              <?php ($active="active"); ?>
          <?php else: ?>
              <?php ($class=""); ?>
              <?php ($active=""); ?>
          <?php endif; ?>

          <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['Category','CategoryFrame'])): ?>
          <li class="nav-item has-treeview <?php echo e($class); ?>">
            <a href="#" class="nav-link <?php echo e($active); ?>" style="color: white;">
              <i class="nav-icon fa fa-sitemap"></i>
              <p>
                Category Post
                <i class="right fa fa-angle-right"></i>
              </p>
            </a>

            <ul class="nav nav-treeview">
              <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Category')): ?>
              <li class="nav-item">
                <a href="<?php echo e(route('category.index')); ?>" class="nav-link <?php if(Request::is('admin/category*') && !Request::is('admin/category-frame*') && !Request::is('admin/category-get*')): ?> active <?php endif; ?>" style="color: white;">
                  <p><i class="fa fa-angle-right ml-3 mr-1"></i> Category</p>
                </a>
              </li>
              <?php endif; ?>
              <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('CategoryFrame')): ?>
              <li class="nav-item">
                <a href="<?php echo e(route('category-frame.index')); ?>" class="nav-link <?php if(Request::is('admin/category-frame*') || Request::is('admin/category-get*')): ?> active <?php endif; ?>" style="color: white;">
                  <p><i class="fa fa-angle-right ml-3 mr-1"></i> Category Frame</p>
                </a>
              </li>
              <?php endif; ?>
            </ul>
          </li>
          <?php endif; ?>

          <?php if(Request::is('admin/festivals*') || Request::is('admin/festivals_frame*') || Request::is('admin/festival*')): ?>
              <?php ($class="menu-open"); ?>
              <?php ($active="active"); ?>
          <?php else: ?>
              <?php ($class=""); ?>
              <?php ($active=""); ?>
          <?php endif; ?>

          <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['Festival','FestivalFrame'])): ?>
          <li class="nav-item has-treeview <?php echo e($class); ?>">
            <a href="#" class="nav-link <?php echo e($active); ?>" style="color: white;">
              <i class="nav-icon fa fa-gifts"></i>
              <p>
                Festivals Post
                <i class="right fa fa-angle-right"></i>
              </p>
            </a>

            <ul class="nav nav-treeview">
              <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Festival')): ?>
              <li class="nav-item">
                <a href="<?php echo e(route('festivals.index')); ?>" class="nav-link <?php if(Request::is('admin/festivals*') && !Request::is('admin/festivals-frame*')): ?> active <?php endif; ?>" style="color: white;">
                  <p><i class="fa fa-angle-right ml-3 mr-1"></i> Festivals</p>
                </a>
              </li>
              <?php endif; ?>
              <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('FestivalFrame')): ?>
              <li class="nav-item">
                <a href="<?php echo e(route('festivals-frame.index')); ?>" class="nav-link <?php if(Request::is('admin/festivals-frame*') || Request::is('admin/festival*') && !Request::is('admin/festivals*')): ?> active <?php endif; ?>" style="color: white;">
                  <p><i class="fa fa-angle-right ml-3 mr-1"></i> Festivals Frame</p>
                </a>
              </li>
              <?php endif; ?>
            </ul>
          </li>
          <?php endif; ?>

          <?php if(Request::is('admin/custom-post*') || Request::is('admin/custom-post-frame*') || Request::is('admin/custom-post-get*')): ?>
              <?php ($class="menu-open"); ?>
              <?php ($active="active"); ?>
          <?php else: ?>
              <?php ($class=""); ?>
              <?php ($active=""); ?>
          <?php endif; ?>

          <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['CustomCategory','CustomFrame'])): ?>
          <li class="nav-item has-treeview <?php echo e($class); ?>">
            <a href="#" class="nav-link <?php echo e($active); ?>" style="color: white;">
              <i class="nav-icon fa-solid fa-image"></i>
              <p>
                Custom Post
                <i class="right fa fa-angle-right"></i>
              </p>
            </a>

            <ul class="nav nav-treeview">
              <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('CustomCategory')): ?>
              <li class="nav-item">
                <a href="<?php echo e(route('custom-post.index')); ?>" class="nav-link <?php if(Request::is('admin/custom-post*') && !Request::is('admin/custom-post-frame*') && !Request::is('admin/custom-post-get*')): ?> active <?php endif; ?>" style="color: white;">
                  <p><i class="fa fa-angle-right ml-3 mr-1"></i> Custom Category</p>
                </a>
              </li>
              <?php endif; ?>
              <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('CustomFrame')): ?>
              <li class="nav-item">
                <a href="<?php echo e(route('custom-post-frame.index')); ?>" class="nav-link <?php if(Request::is('admin/custom-post-frame*') || Request::is('admin/custom-post-get*')): ?> active <?php endif; ?>" style="color: white;">
                  <p><i class="fa fa-angle-right ml-3 mr-1"></i> Custom Frame</p>
                </a>
              </li>
              <?php endif; ?>
            </ul>
          </li>
          <?php endif; ?>

          <?php if(Request::is('admin/business-category*') || Request::is('admin/business-sub-category*') || Request::is('admin/business-frame*') || Request::is('admin/business-category-get*')): ?>
              <?php ($class="menu-open"); ?>
              <?php ($active="active"); ?>
          <?php else: ?>
              <?php ($class=""); ?>
              <?php ($active=""); ?>
          <?php endif; ?>

          <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['BusinessCategory','BusinessSubCategory','BusinessFrame'])): ?>
          <li class="nav-item has-treeview <?php echo e($class); ?>">
            <a href="#" class="nav-link <?php echo e($active); ?>" style="color: white;">
              <i class="nav-icon fa-solid fa-business-time"></i>
              <p>
                Business Post
                <i class="right fa fa-angle-right"></i>
              </p>
            </a>

            <ul class="nav nav-treeview">
              <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('BusinessCategory')): ?>
              <li class="nav-item">
                <a href="<?php echo e(route('business-category.index')); ?>" class="nav-link <?php if(Request::is('admin/business-category*') && !Request::is('admin/business-frame*') && !Request::is('admin/business-category-get*')): ?> active <?php endif; ?>" style="color: white;">
                  <p><i class="fa fa-angle-right ml-3 mr-1"></i> Business Category</p>
                </a>
              </li>
              <?php endif; ?>
              <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('BusinessSubCategory')): ?>
              <li class="nav-item">
                <a href="<?php echo e(route('business-sub-category.index')); ?>" class="nav-link <?php if(Request::is('admin/business-sub-category*') && !Request::is('admin/business-frame*') && !Request::is('admin/business-category-get*')): ?> active <?php endif; ?>" style="color: white;">
                  <p><i class="fa fa-angle-right ml-3 mr-1"></i> Sub Category</p>
                </a>
              </li>
              <?php endif; ?>
              <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('BusinessFrame')): ?>
              <li class="nav-item">
                <a href="<?php echo e(route('business-frame.index')); ?>" class="nav-link <?php if(Request::is('admin/business-frame*') || Request::is('admin/business-category-get*')): ?> active <?php endif; ?>" style="color: white;">
                  <p><i class="fa fa-angle-right ml-3 mr-1"></i> Business Frame</p>
                </a>
              </li>
              <?php endif; ?>
            </ul>
          </li>
          <?php endif; ?>

          <?php if(Request::is('admin/sticker-category*') || Request::is('admin/sticker*') || Request::is('admin/sticker-category-get*')): ?>
              <?php ($class="menu-open"); ?>
              <?php ($active="active"); ?>
          <?php else: ?>
              <?php ($class=""); ?>
              <?php ($active=""); ?>
          <?php endif; ?>

          <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['StickerCategory','Sticker'])): ?>
          <li class="nav-item has-treeview <?php echo e($class); ?>">
            <a href="#" class="nav-link <?php echo e($active); ?>" style="color: white;">
              <i class="nav-icon fa-solid fa-face-smile"></i>
              <p>
                Stickers
                <i class="right fa fa-angle-right"></i>
              </p>
            </a>

            <ul class="nav nav-treeview">
              <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('StickerCategory')): ?>
              <li class="nav-item">
                <a href="<?php echo e(route('sticker-category.index')); ?>" class="nav-link <?php if(Request::is('admin/sticker-category*') && !Request::is('admin/sticker-category-get*')): ?> active <?php endif; ?>" style="color: white;">
                  <p><i class="fa fa-angle-right ml-3 mr-1"></i> Sticker Category</p>
                </a>
              </li>
              <?php endif; ?>
              <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Sticker')): ?>
              <li class="nav-item">
                <a href="<?php echo e(route('sticker.index')); ?>" class="nav-link <?php if(Request::is('admin/sticker*') && !Request::is('admin/sticker-category*') || Request::is('admin/sticker-category-get*')): ?> active <?php endif; ?>" style="color: white;">
                  <p><i class="fa fa-angle-right ml-3 mr-1"></i> Stickers</p>
                </a>
              </li>
              <?php endif; ?>
            </ul>
          </li>
          <?php endif; ?>

          <?php if(Request::is('admin/product-category*') || Request::is('admin/product*') || Request::is('admin/inquiry*')): ?>
              <?php ($class="menu-open"); ?>
              <?php ($active="active"); ?>
          <?php else: ?>
              <?php ($class=""); ?>
              <?php ($active=""); ?>
          <?php endif; ?>

          <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['ProductCategory','Product','Inquiry'])): ?>
          <li class="nav-item has-treeview <?php echo e($class); ?>">
            <a href="#" class="nav-link <?php echo e($active); ?>" style="color: white;">
              <i class="nav-icon fa-solid fa-store"></i>
              <p>
                Product
                <i class="right fa fa-angle-right"></i>
              </p>
            </a>

            <ul class="nav nav-treeview">
              <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('ProductCategory')): ?>
              <li class="nav-item">
                <a href="<?php echo e(route('product-category.index')); ?>" class="nav-link <?php if(Request::is('admin/product-category*')): ?> active <?php endif; ?>" style="color: white;">
                  <p><i class="fa fa-angle-right ml-3 mr-1"></i> Product Category</p>
                </a>
              </li>
              <?php endif; ?>
              <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Product')): ?>
              <li class="nav-item">
                <a href="<?php echo e(route('product.index')); ?>" class="nav-link <?php if(Request::is('admin/product*') && !Request::is('admin/product-category*')): ?> active <?php endif; ?>" style="color: white;">
                  <p><i class="fa fa-angle-right ml-3 mr-1"></i> Product</p>
                </a>
              </li>
              <?php endif; ?>
              <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Inquiry')): ?>
              <li class="nav-item">
                <a href="<?php echo e(route('inquiry.index')); ?>" class="nav-link <?php if(Request::is('admin/inquiry*')): ?> active <?php endif; ?>" style="color: white;">
                  <p><i class="fa fa-angle-right ml-3 mr-1"></i> Inquiry</p>
                </a>
              </li>
              <?php endif; ?>
            </ul>
          </li>
          <?php endif; ?>

          <?php if(Request::is('admin/referral-system*') || Request::is('admin/withdraw-request*') || Request::is('admin/subscription-plan*') || Request::is('admin/coupon-code*') || Request::is('admin/transaction*') || Request::is('admin/offer*')): ?>
              <?php ($class="menu-open"); ?>
              <?php ($active="active"); ?>
          <?php else: ?>
              <?php ($class=""); ?>
              <?php ($active=""); ?>
          <?php endif; ?>

          <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['ReferralSystem','WithdrawRequest','SubscriptionPlan','CouponCode','FinancialStatistics','Offer'])): ?>
          <li class="nav-item has-treeview <?php echo e($class); ?>">
            <a href="#" class="nav-link <?php echo e($active); ?>" style="color: white;">
              <i class="nav-icon fa-solid fa-landmark"></i>
              <p>
                Finance
                <i class="right fa fa-angle-right"></i>
              </p>
            </a>

            <ul class="nav nav-treeview">
              <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('ReferralSystem')): ?>
              <li class="nav-item">
                <a href="<?php echo e(url('admin/referral-system')); ?>" class="nav-link <?php if(Request::is('admin/referral-system*')): ?> active <?php endif; ?>" style="color: white;">
                  <p><i class="fa fa-angle-right ml-3 mr-1"></i> Referral System</p>
                </a>
              </li>
              <?php endif; ?>
              <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('WithdrawRequest')): ?>
              <li class="nav-item">
                <a href="<?php echo e(url('admin/withdraw-request')); ?>" class="nav-link <?php if(Request::is('admin/withdraw-request*') && !Request::is('admin/product-category*')): ?> active <?php endif; ?>" style="color: white;">
                  <p><i class="fa fa-angle-right ml-3 mr-1"></i> Withdraw Request</p>
                </a>
              </li>
              <?php endif; ?>
              <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('SubscriptionPlan')): ?>
              <li class="nav-item">
                <a href="<?php echo e(route('subscription-plan.index')); ?>" class="nav-link <?php if(Request::is('admin/subscription-plan*')): ?> active <?php endif; ?>" style="color: white;">
                  <p><i class="fa fa-angle-right ml-3 mr-1"></i> Subscriptions Plan</p>
                </a>
              </li>
              <?php endif; ?>
              <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('CouponCode')): ?>
              <li class="nav-item">
                <a href="<?php echo e(route('coupon-code.index')); ?>" class="nav-link <?php if(Request::is('admin/coupon-code*')): ?> active <?php endif; ?>" style="color: white;">
                  <p><i class="fa fa-angle-right ml-3 mr-1"></i> Coupon Code</p>
                </a>
              </li>
              <?php endif; ?>
              <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('FinancialStatistics')): ?>
              <li class="nav-item">
                <a href="<?php echo e(url('admin/transaction')); ?>" class="nav-link <?php if(Request::is('admin/transaction*')): ?> active <?php endif; ?>" style="color: white;">
                  <p><i class="fa fa-angle-right ml-3 mr-1"></i> Transactions</p>
                </a>
              </li>
              <?php endif; ?>
              <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Offer')): ?>
              <li class="nav-item">
                <a href="<?php echo e(url('admin/offer')); ?>" class="nav-link <?php if(Request::is('admin/offer*')): ?> active <?php endif; ?>" style="color: white;">
                  <p><i class="fa fa-angle-right ml-3 mr-1"></i> Offer</p>
                </a>
              </li>
              <?php endif; ?>
            </ul>
          </li>
          <?php endif; ?>

          <?php if(Request::is('admin/poster-category*') || Request::is('admin/poster-maker*')): ?>
              <?php ($class="menu-open"); ?>
              <?php ($active="active"); ?>
          <?php else: ?>
              <?php ($class=""); ?>
              <?php ($active=""); ?>
          <?php endif; ?>

          <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['PosterCategory','PosterMaker'])): ?>
          <li class="nav-item has-treeview <?php echo e($class); ?>">
            <a href="#" class="nav-link <?php echo e($active); ?>" style="color: white;">
              <i class="nav-icon fas fa-images"></i>
              <p>
                Frame
                <i class="right fa fa-angle-right"></i>
              </p>
            </a>

            <ul class="nav nav-treeview">
              <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('PosterCategory')): ?>
              <li class="nav-item">
                <a href="<?php echo e(route('poster-category.index')); ?>" class="nav-link <?php if(Request::is('admin/poster-category*')): ?> active <?php endif; ?>" style="color: white;">
                  <p><i class="fa fa-angle-right ml-3 mr-1"></i> Frame Category</p>
                </a>
              </li>
              <?php endif; ?>
              <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('PosterMaker')): ?>
              <li class="nav-item">
                <a href="<?php echo e(route('poster-maker.index')); ?>" class="nav-link <?php if(Request::is('admin/poster-maker*')): ?> active <?php endif; ?>" style="color: white;">
                  <p><i class="fa fa-angle-right ml-3 mr-1"></i> Frame</p>
                </a>
              </li>
              <?php endif; ?>
            </ul>
          </li>
          <?php endif; ?>
          
          <?php if(Request::is('admin/video*')): ?>
              <?php ($class="menu-open"); ?>
              <?php ($active="active"); ?>
          <?php else: ?>
              <?php ($class=""); ?>
              <?php ($active=""); ?>
          <?php endif; ?>

          <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Video')): ?>
          <li class="nav-item has-treeview <?php echo e($class); ?>">
            <a href="<?php echo e(route('video.index')); ?>" class="nav-link <?php echo e($active); ?>" style="color: white;">
              <i class="nav-icon fas fa-video"></i>
              <p>
                Video
              </p>
            </a>
          </li>
          <?php endif; ?>

          <?php if(Request::is('admin/news*')): ?>
              <?php ($class="menu-open"); ?>
              <?php ($active="active"); ?>
          <?php else: ?>
              <?php ($class=""); ?>
              <?php ($active=""); ?>
          <?php endif; ?>

          <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('News')): ?>
          <li class="nav-item has-treeview <?php echo e($class); ?>">
            <a href="<?php echo e(route('news.index')); ?>" class="nav-link <?php echo e($active); ?>" style="color: white;">
              <i class="nav-icon fa fa-gift"></i>
              <p>
                News
              </p>
            </a>
          </li>
          <?php endif; ?>

          <?php if(Request::is('admin/story*')): ?>
              <?php ($class="menu-open"); ?>
              <?php ($active="active"); ?>
          <?php else: ?>
              <?php ($class=""); ?>
              <?php ($active=""); ?>
          <?php endif; ?>

          <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Stories')): ?>
          <li class="nav-item has-treeview <?php echo e($class); ?>">
            <a href="<?php echo e(route('story.index')); ?>" class="nav-link <?php echo e($active); ?>" style="color: white;">
              <i class="nav-icon fa fa-map"></i>
              <p>
                Stories
              </p>
            </a>
          </li>
          <?php endif; ?>

          <?php if(Request::is('admin/user*') && !Request::is('admin/user-profile')): ?>
              <?php ($class="menu-open"); ?>
              <?php ($active="active"); ?>
          <?php else: ?>
              <?php ($class=""); ?>
              <?php ($active=""); ?>
          <?php endif; ?>

          <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Users')): ?>
          <li class="nav-item has-treeview <?php echo e($class); ?>">
            <a href="<?php echo e(route('user.index')); ?>" class="nav-link <?php echo e($active); ?>" style="color: white;">
              <i class="nav-icon fa fa-users"></i>
              <p>
                User
              </p>
            </a>
          </li>
          <?php endif; ?>

          <?php if(Request::is('admin/business*') && !Request::is('admin/business-category*') && !Request::is('admin/business-sub-category*') && !Request::is('admin/business-card*') && !Request::is('admin/business-frame*')): ?>
              <?php ($class="menu-open"); ?>
              <?php ($active="active"); ?>
          <?php else: ?>
              <?php ($class=""); ?>
              <?php ($active=""); ?>
          <?php endif; ?>

          <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Businesses')): ?>
          <li class="nav-item has-treeview <?php echo e($class); ?>">
            <a href="<?php echo e(route('business.index')); ?>" class="nav-link <?php echo e($active); ?>" style="color: white;">
              <i class="nav-icon fa fa-briefcase"></i>
              <p>
                Businesses
              </p>
            </a>
          </li>
          <?php endif; ?>

          <?php if(Request::is('admin/business-card*')): ?>
              <?php ($class="menu-open"); ?>
              <?php ($active="active"); ?>
          <?php else: ?>
              <?php ($class=""); ?>
              <?php ($active=""); ?>
          <?php endif; ?>

          <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('BusinessCard')): ?>
          <li class="nav-item has-treeview <?php echo e($class); ?>">
            <a href="<?php echo e(route('business-card.index')); ?>" class="nav-link <?php echo e($active); ?>" style="color: white;">
              <i class="nav-icon fa-solid fa-address-card"></i>
              <p>
                Business Card
              </p>
            </a>
          </li>
          <?php endif; ?>

          <?php if(Request::is('admin/entry*') || Request::is('admin/subject*')): ?>
              <?php ($class="menu-open"); ?>
              <?php ($active="active"); ?>
          <?php else: ?>
              <?php ($class=""); ?>
              <?php ($active=""); ?>
          <?php endif; ?>

          <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['Entry','Subject'])): ?>
          <li class="nav-item has-treeview <?php echo e($class); ?>">
            <a href="" class="nav-link <?php echo e($active); ?>" style="color: white;">
              <i class="nav-icon fa fa-envelope"></i>
              <p>
                Contact List
                <i class="right fa fa-angle-right"></i>
              </p>
            </a>

            <ul class="nav nav-treeview">
              <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Entry')): ?>
              <li class="nav-item">
                <a href="<?php echo e(route('entry.index')); ?>" class="nav-link <?php if(Request::is('admin/entry*')): ?> active <?php endif; ?>" style="color: white;">
                  <p><i class="fa fa-angle-right ml-3 mr-1"></i> Entry</p>
                </a>
              </li>
              <?php endif; ?>
              <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Subject')): ?>
              <li class="nav-item">
                <a href="<?php echo e(route('subject.index')); ?>" class="nav-link <?php if(Request::is('admin/subject*')): ?> active <?php endif; ?>" style="color: white;">
                  <p><i class="fa fa-angle-right ml-3 mr-1"></i> Subject</p>
                </a>
              </li>
              <?php endif; ?>
            </ul>
          </li>
          <?php endif; ?>

          <?php if(Request::is('admin/notification*')): ?>
              <?php ($class="menu-open"); ?>
              <?php ($active="active"); ?>
          <?php else: ?>
              <?php ($class=""); ?>
              <?php ($active=""); ?>
          <?php endif; ?>

          <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Notification')): ?>
          <li class="nav-item has-treeview <?php echo e($class); ?>">
            <a href="<?php echo e(url('admin/notification')); ?>" class="nav-link <?php echo e($active); ?>" style="color: white;">
              <i class="nav-icon fa fa-paper-plane"></i>
              <p>
                Notification
              </p>
            </a>
          </li>
          <?php endif; ?>

          <?php if(Request::is('admin/whatsapp-message*')): ?>
              <?php ($class="menu-open"); ?>
              <?php ($active="active"); ?>
          <?php else: ?>
              <?php ($class=""); ?>
              <?php ($active=""); ?>
          <?php endif; ?>

          <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('WhatsAppMessage')): ?>
          <li class="nav-item has-treeview <?php echo e($class); ?>">
            <a href="<?php echo e(url('admin/whatsapp-message')); ?>" class="nav-link <?php echo e($active); ?>" style="color: white;">
              <i class="nav-icon fab fa-whatsapp"></i>
              <p>
                WhatsApp Message
              </p>
            </a>
          </li>
          <?php endif; ?>

          <?php if(Request::is('admin/roles*')): ?>
              <?php ($class="menu-open"); ?>
              <?php ($active="active"); ?>
          <?php else: ?>
              <?php ($class=""); ?>
              <?php ($active=""); ?>
          <?php endif; ?>

          <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('UserRoleManagement')): ?>
          <li class="nav-item has-treeview <?php echo e($class); ?>">
            <a href="<?php echo e(url('admin/roles')); ?>" class="nav-link <?php echo e($active); ?>" style="color: white;">
              <i class="nav-icon fa-solid fa-user-gear"></i>
              <p>
                Role Manager
              </p>
            </a>
          </li>
          <?php endif; ?>

          <?php if(Request::is('admin/settings*')): ?>
              <?php ($class="menu-open"); ?>
              <?php ($active="active"); ?>
          <?php else: ?>
              <?php ($class=""); ?>
              <?php ($active=""); ?>
          <?php endif; ?>

          <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Settings')): ?>
          <li class="nav-item has-treeview <?php echo e($class); ?>">
            <a href="<?php echo e(url('admin/settings')); ?>" class="nav-link <?php echo e($active); ?>" style="color: white;">
              <i class="nav-icon fa fa-cog"></i>
              <p>
                Setting
              </p>
            </a>
          </li>
          <?php endif; ?>

          <?php if(Request::is('admin/backup*')): ?>
              <?php ($class="menu-open"); ?>
              <?php ($active="active"); ?>
          <?php else: ?>
              <?php ($class=""); ?>
              <?php ($active=""); ?>
          <?php endif; ?>
          
          <?php if(Auth::user()->user_type == "Super Admin" || Auth::user()->user_type == "Demo"): ?>
          <li class="nav-item has-treeview <?php echo e($class); ?>">
            <a href="<?php echo e(route('backup.index')); ?>" class="nav-link <?php echo e($active); ?>" style="color: white;">
              <i class="nav-icon fa fa-database"></i>
              <p>
                Backup
              </p>
            </a>
          </li>
          <?php endif; ?>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h4 class="m-0 text-dark"><?php echo $__env->yieldContent('heading'); ?> </h4>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <!-- <ol class="breadcrumb float-sm-right">
              <?php if(!(Request::is('admin'))): ?>
              <li class="breadcrumb-item"><a href="<?php echo e(url('admin/')); ?>"></a></li>
              <?php endif; ?>
              <?php echo $__env->yieldContent('breadcrumb'); ?>
            </ol> -->
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>

    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <?php echo $__env->yieldContent('content'); ?>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer" style="background: url(<?php echo e(asset('assets/images/cultrl-bottom-bg2.png')); ?>) no-repeat;background-size: cover; background-position: bottom; min-height: 333px; width: auto;">
    <div class="row d-flex justify-content-between text-light" style="margin-top: 270px;color:black;">
      <div class="float-left d-sm-inline-block text-dark">
        <strong>Power by <?php echo e(App\Models\AppSetting::getAppSetting('app_title')); ?></strong>
      </div>
      <div class="float-right d-none d-sm-inline-block text-dark">
        <b>© <?php echo e(date("Y")); ?> All Rights Reserved.</b>
      </div>
    </div>
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->
<?php echo $__env->yieldContent('script2'); ?>
<!-- jQuery -->
<script src="<?php echo e(asset('assets/plugins/jquery/jquery.min.js')); ?>"></script>
<!-- jQuery UI 1.11.4 -->
<script src="<?php echo e(asset('assets/js/jquery-ui.min.js')); ?>"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/js/fontawesome.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?php echo e(asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js')); ?>"></script>
<!-- Select2 -->
<script src="<?php echo e(asset('assets/plugins/select2/select2.full.min.js')); ?>"></script>
<!-- iCheck 1.0.1 -->
<script src="<?php echo e(asset('assets/plugins/iCheck/icheck.min.js')); ?>"></script>
<!-- FastClick -->
<script src="<?php echo e(asset('assets/plugins/fastclick/fastclick.js')); ?>"></script>
<!-- DataTables -->
<script src="<?php echo e(asset('assets/js/cdn/jquery.dataTables.min.js')); ?>"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-colorpicker/2.5.3/js/bootstrap-colorpicker.min.js"></script>
<script src="<?php echo e(asset('assets/plugins/datatables/dataTables.bootstrap4.min.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('assets/js/cdn/dataTables.buttons.min.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('assets/js/cdn/buttons.print.min.js')); ?>"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo e(asset('assets/js/adminlte.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/fontawesome.js')); ?>"></script>
<script type="text/javascript">
$(document).ready(function() {
  $('#data_table tfoot th').each( function () {
    // console.log($('#data_table tfoot th').length);
    if($(this).index() != $('#data_table tfoot th').length - 1) {
      var title = $(this).text();
      $(this).html( '<input type="text" placeholder="'+title+'" />' );
    }
  });

  //alert($('.content').height());
  //alert($('.content-wrapper').height());
  
  var table = $('#data_table').DataTable({
      "order": [[ 0, 'desc' ]],
     columnDefs: [ { orderable: false, targets: [0] } ],
     // individual column search
     "initComplete": function() {
            table.columns().every( function () {
                var that = this;
                $('input', this.footer()).on('keyup change', function () {
                  // console.log($(this).parent().index());
                    that.search(this.value).draw();
                });
              });
            }
  });

  $('[data-toggle="tooltip"]').tooltip();

  $('.ToastrButton').click(function() {
    toastr.error('This Action Not Available Demo User');
  });
});
</script>
<script type="text/javascript" src="<?php echo e(asset('assets/js/pnotify.custom.min.js')); ?>"></script>
<!-- AdminLTE for demo purposes -->
<!-- <script src="<?php echo e(asset('assets/js/demo.js')); ?>"></script> -->
<?php echo $__env->yieldContent('script'); ?>
</body>
</html><?php /**PATH C:\xampp\htdocs\brandkit\resources\views/layouts/app.blade.php ENDPATH**/ ?>