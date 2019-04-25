<!DOCTYPE html>
<html>
    <?php echo $__env->make('layouts.sections.meta', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php echo $__env->make('layouts.sections.header', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <body class="hold-transition skin-yellow-light sidebar-mini">
        <div class="wrapper">
            <?php echo $__env->make('layouts.sections.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                <div class="content-wrapper">
                    <?php echo $__env->yieldContent('content'); ?>
                </div> 
            <?php echo $__env->make('layouts.sections.footer', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        </div>
    <!-- ./wrapper -->
    <!-- jQuery 3 -->

    <script src="<?php echo e(asset('js/jquery.min.js')); ?>"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="<?php echo e(asset('js/jquery-ui.min.js')); ?>"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <!-- Bootstrap 3.3.7 -->
    <script src="<?php echo e(asset('js/bootstrap.min.js')); ?>"></script>
    <script src="<?php echo e(asset('js/adminlte.min.js')); ?>"></script>
    <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <!-- search option in dropdown -->
    <script src="<?php echo e(asset('js/bootstrap-select.js')); ?>"></script>

    <!-- datetime picker -->
    <script src="<?php echo e(asset('js/moment-with-locales.js')); ?>"></script>
    <script src="<?php echo e(asset('js/bootstrap-datetimepicker.js')); ?>"></script>
    
    <!-- datetime picker -->
    <?php echo Toastr::render(); ?>


    <?php echo $__env->yieldContent('script'); ?>

    <script type="text/javascript">
        toastr.options.closeButton = true;
        toastr.options.escapeHtml = true;
        toastr.options.newestOnTop = false;
    </script>

    <script src="<?php echo e(asset('js/custom.js')); ?>"></script>

    </body>
</html>
