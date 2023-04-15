

<?php $__env->startSection('extra_css'); ?>
<link href="<?php echo e(asset('assets/css/frame.css')); ?>" rel="stylesheet">
<link rel="stylesheet" href="<?php echo e(asset('assets/css/clean-switch.css')); ?>">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
  <div class="col-md-12">
    <?php if(count($errors) > 0): ?>
    <div class="alert alert-danger">
      <ul>
        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <li><?php echo e($error); ?></li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </ul>
    </div>
    <?php endif; ?>
    <div class="card card-primary">
      <div class="card-header">
          <h3 class="card-title float-left">
              Festivals
          </h3>
      </div> 
      
      <div class="card-body">
        <div class="row d-flex justify-content-end mb-3">
          <!-- <div class="col-md-3">
            <label style="font-weight: 400;font-size: 1em;">Filter by Date Range</label>
            <input type="text" value="" name="date" class="form-control filter" id="date_range_filter" placeholder="mm/dd/YYYY - mm/dd/YYYY">
          </div> -->
          <!-- <div class="dropdown">
              <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  Select Festival
              </button>
              <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                  <?php $__currentLoopData = $festival; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $f): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <a class="dropdown-item" href="#"><?php echo e($f->title); ?></a>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </div>
          </div> -->
          <div class="d-flex">
            <form class="form-inline" action="<?php echo e(url('admin/festivals-search')); ?>" method="GET">
              <?php echo csrf_field(); ?>
              <input class="form-control mr-sm-2" type="search" name="search" value="<?php if(!empty($name)): ?> <?php echo e($name); ?> <?php endif; ?>" placeholder="Search" aria-label="Search">
              <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
            </form>
            <a href="<?php echo e(route('festivals.create')); ?>" class="btn btn-success ml-2">Add New</a>
          </div>
        </div>

        <div class="row mt-3">
          <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $frame): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <div class="col-lg-3 col-sm-6 col-xs-12">
            <div class="block_wallpaper add_wall_category" style="box-shadow:0px 3px 8px rgba(0, 0, 0, 0.3)">
              <div class="wall_category_block" style="z-index: 1">
                <h2 style="font-size: 20px">
                  <?php echo e($frame->title); ?>               
                </h2>
                <div class="checkbox" style="float: right;z-index: 1">
                  <?php $post = App\Models\FeaturePost::where("festival_id",$frame->id)->get(); ?>
                  <input type="checkbox" name="feature_status" id="checkbox0" data-id="<?php echo e($frame->id); ?>" value="1" class="feature_status mt-1" style="width: 16px;height: 16px;" <?php if(!$post->isEmpty()): ?> checked <?php endif; ?>>
                </div>
              </div>
              <div class="wall_image_title">
                <p class="my-auto"><i class="fa fa-calendar-days mr-2"></i><?php echo e(date_format(date_create(implode("", preg_split("/[-\s:,]/",$frame->festivals_date))),"d M, y")); ?></p>
                <ul>
                  <li><a href="<?php echo e(url('admin/festivals/'.$frame->id.'/edit')); ?>" data-toggle="tooltip" data-tooltip="Edit"><i class="fa fa-edit"></i></a></li>
                  <li><a href="#" data-id="<?php echo e($frame->id); ?>" class="btn_delete_a" data-toggle="modal" data-target="#myModal"><i class="fa fa-trash"></i></a></li>
                  <li>
                    <label class="cl-switch cl-switch-red">
                      <input type="checkbox" class="festivals-switch" data-id="<?php echo e($frame->id); ?>" value="1" <?php if($frame->status==1): ?> checked <?php endif; ?>>
                      <span class="switcher"></span>
                    </label>
                  </li>
                </ul>
                <?php echo Form::open(['url' => 'admin/festivals/'.$frame->id,'method'=>'DELETE','class'=>'form-horizontal','id'=>'form_'.$frame->id]); ?>

                <?php echo Form::hidden("id",$frame->id); ?>

                <?php echo Form::close(); ?>

              </div>
              <span>
                <img src="<?php if(App\Models\StorageSetting::getStorageSetting('storage') == 'DigitalOcean'): ?><?php echo e(\Storage::disk('spaces')->url('uploads/'.$frame->image)); ?> <?php else: ?> <?php echo e(asset('uploads/'.$frame->image)); ?> <?php endif; ?>"/>
              </span>
            </div>
          </div>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        <div class="d-flex justify-content-center"><?php echo e($data->links()); ?></div>
      </div>
    </div>
  </div>
</div>

  <!-- Modal -->
  <div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Delete</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <p>Are you sure you want to Delete ?</p>
        </div>
        <div class="modal-footer">
          <?php if(Auth::user()->user_type == "Demo"): ?>
          <button type="button" class="btn btn-danger ToastrButton">Delete</button>
          <?php else: ?>
          <button id="del_btn" class="btn btn-danger" type="button" data-submit="">Delete</button>
          <?php endif; ?>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
  <!-- Modal -->
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
<script type="text/javascript">
    $("#del_btn").on("click",function(){
        var id=$(this).data("submit");
        $("#form_"+id).submit();
    });

    $('#myModal').on('show.bs.modal', function(e) {
        var id = e.relatedTarget.dataset.id;
        $("#del_btn").attr("data-submit",id);
    });

    $(".festivals-switch").change(function(){
      var checked = $(this).is(':checked');
      var id = $(this).data("id");
     
      $.ajax({
        type: "POST",
        url: "<?php echo e(url('admin/festivals-status')); ?>",
        data: { checked : checked , id : id},
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        success: function(data) {
          new PNotify({
            title: 'Success!',
            text: "Festivals Status Has Been Changed.",
            type: 'success'
          });
        },
      });
    });

    $(".feature_status").change(function(){
      var checked = $(this).is(':checked');
      var id = $(this).data("id");
      
      $.ajax({
        type: "POST",
        url: "<?php echo e(url('admin/festivals-feature-status')); ?>",
        data: { checked : checked , id : id},
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        success: function(data) {
          if(data == 1){
            new PNotify({
              title: 'Success!',
              text: "Festival Feature Set!.",
              type: 'success'
            });
          }
          else
          {
            new PNotify({
              title: 'Success!',
              text: "Festival Feature Unset!.",
              type: 'success'
            });
          }
        },
      });
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make("layouts.app", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\brandkit\resources\views/festivals/index.blade.php ENDPATH**/ ?>