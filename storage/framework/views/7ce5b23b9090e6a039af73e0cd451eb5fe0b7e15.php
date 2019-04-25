<?php $__env->startSection('content'); ?>
<section class="content-header">
      <h1>
        Upload Routes
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Routes</li>
      </ol>
</section>


<section class="content">
  <div class="row">
        <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
        <div class="panel-heading"><strong>Upload Routes</strong></div>
        <div class="panel-body">

          <form action="<?php echo e(url('/routes/upload')); ?>" method="post" enctype="multipart/form-data">
              <?php echo csrf_field(); ?>
              <div class="form-inline">
                <div class="form-group">
                  <input type="file" name="file" required>
                </div>
                <div class="form-group">
                  <label>Code</label>
                  <input class="form-control" name="code" required></input>
                </div>
                <div class="form-group">
                  <label>KM</label>
                  <input class="form-control" name="km" required></input>
                </div>
                  <input type="submit" value="Create Route" class="btn btn-sm btn-primary">
              </div>
          </form>

          <br><br>

          <!-- Progress Bar -->
          <div class="progress">
            <div class="progress-bar bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 0%;">
              <span class="sr-only percent">0%</span>
            </div>
          </div>

          <div id="status"></div>

        </div>
      </div>
        </div>
    </div>
</section>
<?php $__env->startSection('script'); ?>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.2.2/jquery.form.js"></script>
    <script src="<?php echo e(asset('js/etm/route-upload.js')); ?>"></script>
<?php $__env->stopSection(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.etm', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>