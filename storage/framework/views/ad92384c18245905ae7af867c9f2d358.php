<?php $__env->startSection('title', 'Orderstatus'); ?>

<?php $__env->startSection('content'); ?>
    <div class="min-h-screen flex flex-col items-center justify-start pt-20 pb-12 px-6 lg:px-8"
         style="background-color: #FFFBEA;">

        <!-- Titel -->
        <div class="text-center mb-8">
            <h1 class="text-4xl font-extrabold text-gray-900">Orderstatus Overzicht</h1>
            <p class="mt-2 text-gray-700 text-lg">Bekijk hieronder de actuele status van al je orders — van offerte tot
                factuur.</p>
        </div>

        <!-- Flash message -->
        <?php if(session('success')): ?>
            <div class="bg-green-100 text-green-800 p-4 rounded mb-6 w-full max-w-6xl text-center">
                <?php echo e(session('success')); ?>

            </div>
        <?php endif; ?>

        <!-- Container -->
        <div class="bg-white rounded-xl shadow-lg w-full max-w-6xl border border-gray-100 overflow-hidden">
            <!-- Tabel -->
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-100">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                            Order ID
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                            Klant
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                            Datum
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                            Status
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                            Prioriteit
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                            Totaal
                        </th>
                        <th class="px-6 py-4 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider">
                            Actie
                        </th>
                    </tr>
                    </thead>

                    <tbody class="bg-white divide-y divide-gray-100">
                    <?php $__empty_1 = true; $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr class="hover:bg-yellow-50 transition-colors">
                            <td class="px-6 py-4 text-gray-800 font-medium"><?php echo e($order->id); ?></td>
                            <td class="px-6 py-4 text-gray-800"><?php echo e($order->customer->name ?? 'Onbekend'); ?></td>
                            <td class="px-6 py-4 text-gray-600"><?php echo e($order->order_date ?? '-'); ?></td>

                            <!-- Status -->
                            <td class="px-6 py-4">
                                <span class="
                                    inline-block px-3 py-1 rounded-full text-sm font-semibold
                                    <?php if($order->status === 'quote'): ?> bg-gray-200 text-gray-800
                                    <?php elseif($order->status === 'contract'): ?> bg-blue-100 text-blue-700
                                    <?php elseif($order->status === 'delivery'): ?> bg-yellow-100 text-yellow-800
                                    <?php elseif($order->status === 'invoice'): ?> bg-green-100 text-green-800
                                    <?php endif; ?>
                                ">
                                    <?php echo e(ucfirst($order->status)); ?>

                                </span>
                            </td>

                            <!-- Prioriteit -->
                            <td class="px-6 py-4">
                                <span class="
                                    inline-block px-3 py-1 rounded-full text-sm font-semibold
                                    <?php if($order->priority === 'normaal'): ?> bg-gray-200 text-gray-800
                                    <?php elseif($order->priority === 'spoed'): ?> bg-red-100 text-red-800
                                    <?php elseif($order->priority === 'achterstand'): ?> bg-yellow-100 text-yellow-800
                                    <?php endif; ?>
                                ">
                                    <?php echo e(ucfirst($order->priority ?? 'Normaal')); ?>

                                </span>
                            </td>

                            <td class="px-6 py-4 text-gray-800 font-medium">
                                €<?php echo e(number_format($order->total_amount, 2, ',', '.')); ?>

                            </td>

                            <td class="px-6 py-4 text-center">
                                <a href="<?php echo e(route('orders.show', $order->id)); ?>"
                                   class="inline-block bg-yellow-500 hover:bg-yellow-600 text-white font-semibold py-2 px-4 rounded-lg shadow-sm focus:ring-2 focus:ring-yellow-400 transition">
                                    Details
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="7" class="px-6 py-10 text-center text-gray-500 text-lg">Geen orders gevonden.
                            </td>
                        </tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- Ondertekst -->
            <div class="text-sm text-gray-500 text-center py-4 bg-gray-50">
                <p>Laatste update: <?php echo e(now()->format('d-m-Y H:i')); ?></p>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\merta\Documents\GitHub\barroc-intense\resources\views/orders/index.blade.php ENDPATH**/ ?>