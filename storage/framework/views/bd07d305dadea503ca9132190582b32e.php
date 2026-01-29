<?php $__env->startSection('title', 'Orderdetails'); ?>

<?php $__env->startSection('content'); ?>
    <div class="min-h-screen flex flex-col items-center justify-start pt-20 pb-12 px-6 lg:px-8" style="background-color: #FFFBEA;">

        <!-- Back button -->
        <div class="w-full max-w-4xl mb-6">
            <a href="<?php echo e(route('orders.index')); ?>"
               class="inline-flex items-center text-yellow-700 font-semibold hover:underline">
                ← Terug naar overzicht
            </a>
        </div>

        <!-- Container -->
        <div class="bg-white rounded-xl shadow-lg w-full max-w-4xl border border-gray-100 p-8">

            <!-- Titel -->
            <h1 class="text-3xl font-extrabold text-gray-900 mb-6">
                Order #<?php echo e($order->id); ?>

            </h1>

            <!-- Order Info Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-10">

                <div>
                    <h2 class="text-lg font-semibold text-gray-700 mb-2">Klant</h2>
                    <p class="text-gray-900 text-xl font-medium">
                        <?php echo e($order->customer->name ?? 'Onbekende klant'); ?>

                    </p>
                    <p class="text-gray-600 text-sm mt-1">
                        Email: <?php echo e($order->customer->email ?? 'n/a'); ?> <br>
                        Telefoon: <?php echo e($order->customer->phone ?? 'n/a'); ?>

                    </p>
                </div>

                <div>
                    <h2 class="text-lg font-semibold text-gray-700 mb-2">Orderinformatie</h2>
                    <p class="text-gray-700">
                        <strong>Datum:</strong> <?php echo e($order->order_date ?? '-'); ?>

                    </p>
                    <p class="text-gray-700">
                        <strong>Totaal:</strong> €<?php echo e(number_format($order->total_amount, 2, ',', '.')); ?>

                    </p>

                    <p class="mt-2">
                        <strong>Status:</strong>
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
                    </p>

                    <p class="mt-2">
                        <strong>Prioriteit:</strong>
                        <span class="inline-block px-3 py-1 rounded-full text-sm font-semibold
                        <?php if($order->priority === 'normaal'): ?> bg-gray-200 text-gray-800
                        <?php elseif($order->priority === 'spoed'): ?> bg-red-100 text-red-800
                        <?php elseif($order->priority === 'achterstand'): ?> bg-yellow-100 text-yellow-800
                        <?php endif; ?>
                    ">
                        <?php echo e(ucfirst($order->priority ?? 'Normaal')); ?>

                    </span>
                    </p>
                </div>

            </div>

            <!-- Status Update -->
            <div class="mb-6">
                <h2 class="text-lg font-semibold text-gray-700 mb-3">Status aanpassen</h2>

                <form action="<?php echo e(route('orders.updateStatus', $order->id)); ?>" method="POST" class="flex items-center gap-4">
                    <?php echo csrf_field(); ?>
                    <select name="status" class="border border-gray-300 rounded-lg px-4 py-2 shadow-sm">
                        <option value="quote" <?php echo e($order->status === 'quote' ? 'selected' : ''); ?>>Quote</option>
                        <option value="contract" <?php echo e($order->status === 'contract' ? 'selected' : ''); ?>>Contract</option>
                        <option value="delivery" <?php echo e($order->status === 'delivery' ? 'selected' : ''); ?>>Delivery</option>
                        <option value="invoice" <?php echo e($order->status === 'invoice' ? 'selected' : ''); ?>>Invoice</option>
                    </select>

                    <button type="submit"
                            class="bg-yellow-500 hover:bg-yellow-600 text-white font-semibold py-2 px-6 rounded-lg shadow-sm transition">
                        Update
                    </button>
                </form>
            </div>

            <!-- Prioriteit Update -->
            <div class="mb-10">
                <h2 class="text-lg font-semibold text-gray-700 mb-3">Prioriteit aanpassen</h2>

                <form action="<?php echo e(route('orders.updatePriority', $order->id)); ?>" method="POST" class="flex items-center gap-4">
                    <?php echo csrf_field(); ?>
                    <select name="priority" class="border border-gray-300 rounded-lg px-4 py-2 shadow-sm">
                        <option value="normaal" <?php echo e($order->priority === 'normaal' ? 'selected' : ''); ?>>Normaal</option>
                        <option value="spoed" <?php echo e($order->priority === 'spoed' ? 'selected' : ''); ?>>Spoed</option>
                        <option value="achterstand" <?php echo e($order->priority === 'achterstand' ? 'selected' : ''); ?>>Achterstand</option>
                    </select>

                    <button type="submit"
                            class="bg-yellow-500 hover:bg-yellow-600 text-white font-semibold py-2 px-6 rounded-lg shadow-sm transition">
                        Update
                    </button>
                </form>
            </div>

            <!-- Facturen -->
            <div>
                <h2 class="text-lg font-semibold text-gray-700 mb-3">Facturen</h2>

                <?php if($order->invoices->count() > 0): ?>
                    <ul class="space-y-3">
                        <?php $__currentLoopData = $order->invoices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $invoice): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li class="p-4 bg-gray-50 rounded-lg shadow-sm border border-gray-200">
                                <p class="text-gray-800 font-medium">Factuur #<?php echo e($invoice->id); ?></p>
                                <p class="text-gray-600 text-sm">Bedrag: €<?php echo e(number_format($invoice->amount, 2, ',', '.')); ?></p>
                                <p class="text-gray-600 text-sm">Status: <?php echo e(ucfirst($invoice->status)); ?></p>
                            </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                <?php else: ?>
                    <p class="text-gray-500">Geen facturen gekoppeld aan deze order.</p>
                <?php endif; ?>
            </div>

        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\merta\Documents\GitHub\barroc-intense\resources\views/orders/show.blade.php ENDPATH**/ ?>