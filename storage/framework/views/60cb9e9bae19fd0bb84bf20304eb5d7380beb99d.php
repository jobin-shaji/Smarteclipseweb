  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MAIN NAVIGATION</li>
        <li class="bg-info">
          <a href="<?php echo e(url('/home')); ?>">
            <i class="fa fa-home"> </i> <span>Home</span>
          </a>
        </li>
        <?php if(auth()->check() && auth()->user()->hasRole('root')): ?>
            <?php echo $__env->make('layouts.sections.root', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <?php endif; ?>
        <?php if(auth()->check() && auth()->user()->hasRole('dealer')): ?>
            <?php echo $__env->make('layouts.sections.dealer', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <?php endif; ?>
        <?php if(auth()->check() && auth()->user()->hasRole('sub_dealer')): ?>
            <?php echo $__env->make('layouts.sections.sub-dealer', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <?php endif; ?>
        <?php if(auth()->check() && auth()->user()->hasRole('client')): ?>
            <?php echo $__env->make('layouts.sections.client', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <?php endif; ?>
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>
