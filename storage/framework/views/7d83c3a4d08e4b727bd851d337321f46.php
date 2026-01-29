<?php $__env->startSection('content'); ?>
    <div class="max-w-7xl mx-auto py-8">
        <h1 class="text-2xl font-bold mb-6">Machines</h1>

        <table class="w-full border">
            <thead class="bg-gray-100">
            <tr>
                <th class="p-2 border">Type</th>
                <th class="p-2 border">Serial</th>
                <th class="p-2 border">Status</th>
                <th class="p-2 border">Customer</th>
            </tr>
            </thead>
            <tbody>
            <?php $__currentLoopData = $machines; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $machine): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td class="p-2 border"><?php echo e($machine->type); ?></td>
                    <td class="p-2 border"><?php echo e($machine->serial_number); ?></td>
                    <td class="p-2 border"><?php echo e($machine->status); ?></td>
                    <td class="p-2 border">
                        <?php echo e($machine->customer->name ?? '—'); ?>

                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\merta\Documents\GitHub\barroc-intense\resources\views/machines/index.blade.php ENDPATH**/ ?>