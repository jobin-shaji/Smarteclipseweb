<table>
    <thead>
    <tr>
        <th>Stage</th>
        <th>KM</th>
        <th>Fare</th>
    </tr>
    </thead>
    <tbody>
    <?php $__currentLoopData = $route->stages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $stage): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <tr>
            <td><?php echo e($stage->name); ?></td>
            <td><?php echo e($stage->pivot->km); ?></td>
            <td><?php echo e(\App\Vst\Fare\FareSlab::slabify($stage->id,$route->id,2)); ?></td>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </tbody>
</table>