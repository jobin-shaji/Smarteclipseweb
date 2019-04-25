<table>
    <thead>
    <tr>
        <th>Si.No</th>
        <th>Waybill</th>
        <th>Inspector</th>
        <th>Penalty Type</th>
        <th>Employee</th>
        <th>Amount</th>
    </tr>
    </thead>
    <tbody>
    <?php $__currentLoopData = $penalties; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $penalty): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <tr>
            <td><?php echo e($loop->iteration); ?></td>
            <td><?php echo e($penalty->waybill->code); ?></td>
            <td><?php echo e($penalty->inspector->name); ?></td>
            <td><?php echo e($penalty->concession->name); ?></td>
            <?php
                if($penalty->employee_id == null){
                    $employee = '--';
                }else{
                    $employee = $penalty->employee->name;
                }
            ?>
            <td><?php echo e($employee); ?></td>
            <td><?php echo e($penalty->amount); ?></td>
        </tr>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </tbody>
</table>