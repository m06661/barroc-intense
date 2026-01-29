<?php $__env->startSection('title', 'Lease Contracts'); ?>

<?php $__env->startSection('content'); ?>
    <div class="min-h-screen py-12 px-6 lg:px-8" style="background-color: #FFFBEA;">
        <div class="text-center mb-6">
            <h1 class="text-4xl font-extrabold text-gray-900">Lease Contracts</h1>
            <p class="mt-2 text-gray-700">Beheer alle leasecontracten van klanten.</p>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6 max-w-4xl mx-auto">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-semibold text-gray-800">Overzicht</h2>
                <a href="<?php echo e(route('leases.create')); ?>" class="bg-yellow-500 text-white font-semibold py-2 px-4 rounded-lg hover:bg-yellow-600">
                    + Nieuw Leasecontract
                </a>
            </div>

            <table class="table-auto w-full">
                <thead>
                <tr class="bg-gray-200 text-gray-700">
                    <th class="px-4 py-2">Titel</th>
                    <th class="px-4 py-2">Beschrijving</th>
                    <th class="px-4 py-2">Klant</th>
                    <th class="px-4 py-2">Startdatum</th>
                    <th class="px-4 py-2">Einddatum</th>
                    <th class="px-4 py-2">BKR Check</th>
                    <th class="px-4 py-2">Acties</th>
                </tr>
                </thead>
                <tbody>
                <?php $__currentLoopData = $leases; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lease): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td class="border px-4 py-2"><?php echo e($lease->title); ?></td>
                        <td class="border px-4 py-2"><?php echo e(Str::limit($lease->description, 50)); ?></td>
                        <td class="border px-4 py-2"><?php echo e($lease->customer->name ?? 'Geen klant'); ?></td>
                        <td class="border px-4 py-2"><?php echo e($lease->start_date); ?></td>
                        <td class="border px-4 py-2"><?php echo e($lease->end_date); ?></td>
                        <td class="border px-4 py-2"><?php echo e($lease->bkr_check ? 'Ja' : 'Nee'); ?></td>
                        <td class="border px-4 py-2">
                            <a href="<?php echo e(route('leases.edit', $lease->id)); ?>" class="text-yellow-500 hover:underline">Bewerken</a>

                            <form action="<?php echo e(route('leases.destroy', $lease->id)); ?>" method="POST" style="display: inline;">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="text-red-500 hover:underline"
                                        onclick="return confirm('Weet je zeker dat je dit wilt verwijderen?')">Verwijderen</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\merta\Documents\GitHub\barroc-intense\resources\views/leases/index.blade.php ENDPATH**/ ?>