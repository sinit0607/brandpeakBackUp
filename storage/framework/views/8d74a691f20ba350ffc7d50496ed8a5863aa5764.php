<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
    <title>Login</title>
    <link rel="icon" href="<?php if(App\Models\StorageSetting::getStorageSetting('storage') == 'DigitalOcean'): ?><?php echo e(\Storage::disk('spaces')->url('uploads/'.App\Models\AppSetting::getAppSetting('admin_favicon'))); ?> <?php else: ?> <?php echo e(asset('uploads/'.App\Models\AppSetting::getAppSetting('admin_favicon'))); ?> <?php endif; ?>">
    <style>
        a:hover
        {
            text-decoration: none;
        }
    </style>
  </head>
  <body>
    <section class="vh-100" style="background-image: url('<?php echo e(asset('assets/images/web_bg.png')); ?>');">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                    <div class="card shadow-2-strong" style="border-radius: 5px;">
                        <div class="card-body p-4 text-center">
                            <?php if(App\Models\AppSetting::getAppSetting('app_logo')): ?><img src="<?php if(App\Models\StorageSetting::getStorageSetting('storage') == 'DigitalOcean'): ?><?php echo e(\Storage::disk('spaces')->url('uploads/'.App\Models\AppSetting::getAppSetting('app_logo'))); ?> <?php else: ?> <?php echo e(asset('uploads/'.App\Models\AppSetting::getAppSetting('app_logo'))); ?> <?php endif; ?>" width="70px" height="70px"><?php endif; ?> 
                            <h3 class="mt-4 mb-1" style="color:#f77b0b">Welcome To <?php echo e(App\Models\AppSetting::getAppSetting('app_title')); ?></h3>
                            <div class="mb-3">Login to your account.</div>
                            <?php if(count($errors) > 0): ?>
                            <div class="alert alert-danger">
                                <ul>
                                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li><?php echo e($error); ?></li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>
                            </div>
                            <?php endif; ?>
                            
                            <form class="form-horizontal" role="form" method="POST" action="<?php echo e(route('login')); ?>">
                            <?php echo e(csrf_field()); ?>

                            <div class="form-outline mb-3">
                                <input type="email" class="form-control form-control-lg" style="font-size:15px;" placeholder="EMAIL" id="email" name="email" value="<?php echo e(old('email')); ?>" autofocus required>
                            </div>

                            <div class="form-outline">
                                <input type="password" class="form-control form-control-lg" style="font-size:15px;" placeholder="PASSWORD" id="password" name="password" required>
                            </div>

                            <!-- Checkbox -->
                            <div class="row">
                                <div class="col-sm-5 form-check mt-3 ml-3 text-left">
                                    <input class="form-check-input" type="checkbox" value="" id="form1Example3" />
                                    <label class="form-check-label" for="form1Example3"> Remember me </label>
                                </div>
                                <div class="col-sm-6 form-check mt-3 ml-3 text-right">
                                    <a href="<?php echo e(route('password.request')); ?>" target="_blank" class="text-dark">Forgot Password?</a>
                                </div>
                            </div>

                            <button class="btn btn-primary btn-lg btn-block mt-3" type="submit" style="font-size:17px;background-color:#f77b0b;border-color:#f77b0b">Login</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html><?php /**PATH C:\xampp\htdocs\brandkit\resources\views/auth/login.blade.php ENDPATH**/ ?>