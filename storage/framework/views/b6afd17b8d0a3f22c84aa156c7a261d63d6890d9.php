

<?php $__env->startSection('extra_css'); ?>
<style type="text/css">

</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="card card-success">
        <div class="card-header">
            <h3 class="card-title">Update Profile Detail</h3>
        </div>

        <div class="card-body">
        <?php if(count($errors) > 0): ?>
            <div class="alert alert-danger">
            <ul>
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
            </div>
        <?php endif; ?>

        <?php echo Form::open(['url' => 'admin/user-profile','method'=>'post','files'=>true]); ?>

        <div class="row mt-3">
            <div class="col-12">
                <div class="form-group row">
                    <?php echo Form::label('name','Name', ['class' => 'col-xl-3 col-md-3 col-3 col-form-label']); ?>

                    <div class="col-xl-9 col-md-9 col-9">
                        <?php echo Form::text('name',$user->name,['class' => 'form-control','required']); ?>

                    </div>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-12">
                <div class="form-group row">
                    <?php echo Form::label('email','Email', ['class' => 'col-xl-3 col-md-3 col-3 col-form-label']); ?>

                    <div class="col-xl-9 col-md-9 col-9">
                        <?php echo Form::email('email',$user->email,['class'=>'form-control','required']); ?>

                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="form-group row">
                    <?php echo Form::label('mobile_no','Mobile No', ['class' => 'col-xl-3 col-md-3 col-3 col-form-label']); ?>

                    <div class="col-xl-9 col-md-9 col-9">
                        <?php echo Form::number('mobile_no',$user->mobile_no,['class' => 'form-control','required']); ?>

                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="form-group row">
                    <?php echo Form::label('password', 'Password', ['class' => 'col-xl-3 col-md-3 col-3 col-form-label']); ?>

                    <div class="col-xl-9 col-md-9 col-9">
                        <?php echo Form::password('password', ['class' => 'form-control']); ?>

                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="form-group row">
                    <?php echo Form::label('image','Select Image', ['class' => 'col-xl-3 col-md-3 col-3 col-form-label']); ?>

                    <div class="col-xl-9 col-md-9 col-9">
                        <input class="form-control" type="file" id="image" name="image">
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-3"></div>
                    <div class="col-sm-9 mb-3" id="preview">
                        <img src="<?php if($user->image): ?><?php if(substr($user->image, 0, 4)=='http'): ?> <?php echo e($user->image); ?> <?php else: ?> <?php if(App\Models\StorageSetting::getStorageSetting('storage') == 'DigitalOcean'): ?><?php echo e(\Storage::disk('spaces')->url('uploads/'.$user->image)); ?> <?php else: ?> <?php echo e(asset('uploads/'.$user->image)); ?> <?php endif; ?> <?php endif; ?> <?php else: ?> <?php echo e(asset('assets/images/no-user.jpg')); ?> <?php endif; ?>" class="mt-2" width="auto" height="100px">
                    </div> 
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 m-3 text-center">
            <?php if(Auth::user()->user_type == "Demo"): ?>
            <button type="button" class="btn btn-success ToastrButton">Save</button>
            <?php else: ?>
            <?php echo Form::submit('Save', ['class' => 'btn btn-success']); ?>

            <?php endif; ?>
            </div>
        </div>
        <?php echo Form::close(); ?>

        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection("script"); ?>
<script type="text/javascript">
    $(document).ready(function() {
        $('#status_id').select2();
    });

    function imagePreview(fileInput) 
    { 
        if (fileInput.files && fileInput.files[0]) 
        {
            var fileReader = new FileReader();
            fileReader.onload = function (event) 
            {
                $('#preview').html('<img src="'+event.target.result+'" class="shadow bg-white rounded" width="auto" alt="Select Image" height="120px"/>');
            };
            fileReader.readAsDataURL(fileInput.files[0]);
        }
    }

    $("#image").change(function () {
        imagePreview(this);
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\brandkit\resources\views/backend/profileEdit.blade.php ENDPATH**/ ?>