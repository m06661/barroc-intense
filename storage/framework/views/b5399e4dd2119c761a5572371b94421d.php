<?php $__env->startSection('title', 'Issues Overview'); ?>

<?php $__env->startSection('content'); ?>
    <div class="bg-yellow-50 min-h-screen py-10">

        <!-- Page Header -->
        <div class="text-center mb-10">
            <h1 class="text-5xl font-bold text-yellow-700">Storing Overzicht</h1>
        </div>

        <!-- STORING DASHBOARD -->
        <div class="max-w-6xl mx-auto mb-10 grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="bg-white p-4 rounded shadow">
                <div class="text-sm text-gray-500">Storingen (7 dagen)</div>
                <div class="text-2xl font-bold"><?php echo e($stats['last_7_days']); ?></div>
            </div>
            <div class="bg-white p-4 rounded shadow">
                <div class="text-sm text-gray-500">Storingen (30 dagen)</div>
                <div class="text-2xl font-bold"><?php echo e($stats['last_30_days']); ?></div>
            </div>
            <div class="bg-white p-4 rounded shadow">
                <div class="text-sm text-gray-500">Open storingen</div>
                <div class="text-2xl font-bold text-red-600"><?php echo e($stats['open']); ?></div>
            </div>
        </div>

        <!-- Filters -->
        <div class="max-w-6xl mx-auto bg-white rounded-lg shadow-md p-6 mb-10">
            <h2 class="text-2xl font-semibold text-gray-800 mb-6">Filters</h2>
            <form method="GET" action="<?php echo e(route('issues.index')); ?>" class="grid grid-cols-1 md:grid-cols-4 gap-6">

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                    <input type="text" name="search" value="<?php echo e(request('search')); ?>"
                           class="w-full border-gray-300 rounded p-2"
                           placeholder="Search issues, machines, customers...">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select name="status" class="w-full border-gray-300 rounded p-2">
                        <option value="all">All</option>
                        <option value="open" <?php echo e(request('status')=='open' ? 'selected' : ''); ?>>Open</option>
                        <option value="in progress" <?php echo e(request('status')=='in progress' ? 'selected' : ''); ?>>In Progress</option>
                        <option value="resolved" <?php echo e(request('status')=='resolved' ? 'selected' : ''); ?>>Resolved</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Priority</label>
                    <select name="priority" class="w-full border-gray-300 rounded p-2">
                        <option value="all">All</option>
                        <option value="low" <?php echo e(request('priority')=='low' ? 'selected' : ''); ?>>Low</option>
                        <option value="medium" <?php echo e(request('priority')=='medium' ? 'selected' : ''); ?>>Medium</option>
                        <option value="high" <?php echo e(request('priority')=='high' ? 'selected' : ''); ?>>High</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Customer</label>
                    <select name="customer" class="w-full border-gray-300 rounded p-2">
                        <option value="all">All Customers</option>
                        <?php $__currentLoopData = $customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($customer->id); ?>" <?php echo e(request('customer')==$customer->id ? 'selected' : ''); ?>>
                                <?php echo e($customer->name); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>

            </form>
            <div class="mt-6 text-right">
                <button onclick="this.closest('form').submit()"
                        class="bg-yellow-500 hover:bg-yellow-600 text-white py-2 px-4 rounded shadow-md">
                    Apply Filters
                </button>
            </div>
        </div>

        <!-- Issues Table -->
        <div class="max-w-6xl mx-auto bg-white rounded-lg shadow-md p-6">
            <h2 class="text-2xl font-semibold text-gray-800 mb-6">All Issues</h2>
            <div class="overflow-auto">
                <table class="min-w-full bg-white border border-gray-300 rounded-md">
                    <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2 text-left">ID</th>
                        <th class="px-4 py-2 text-left">Machine</th>
                        <th class="px-4 py-2 text-left">Customer</th>
                        <th class="px-4 py-2 text-left">Priority</th>
                        <th class="px-4 py-2 text-left">Status</th>
                        <th class="px-4 py-2 text-left">Reported At</th>
                        <th class="px-4 py-2 text-left"></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $issues; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $issue): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr class="border-b">
                            <td class="px-4 py-2 font-semibold"><?php echo e($issue->id); ?></td>
                            <td class="px-4 py-2">
                                <?php echo e($issue->machine->type); ?><br>
                                <span class="text-gray-500 text-sm"><?php echo e($issue->machine->serial_number); ?></span>
                            </td>
                            <td class="px-4 py-2"><?php echo e($issue->machine->customer->name); ?></td>
                            <td class="px-4 py-2">
                                <span class="
                                    px-2 py-1 rounded text-white text-sm
                                    <?php if($issue->priority == 'high'): ?> bg-red-600
                                    <?php elseif($issue->priority == 'medium'): ?> bg-yellow-500
                                    <?php else: ?> bg-gray-500 <?php endif; ?>
                                ">
                                    <?php echo e(ucfirst($issue->priority)); ?>

                                </span>
                            </td>
                            <td class="px-4 py-2">
                                <span class="
                                    px-2 py-1 rounded text-white text-sm
                                    <?php if($issue->status == 'open'): ?> bg-red-600
                                    <?php elseif($issue->status == 'in progress'): ?> bg-yellow-500
                                    <?php else: ?> bg-green-600 <?php endif; ?>
                                ">
                                    <?php echo e(ucfirst($issue->status)); ?>

                                </span>
                            </td>
                            <td class="px-4 py-2"><?php echo e($issue->reported_at); ?></td>
                            <td class="px-4 py-2 flex items-center gap-2">
                                <a href="<?php echo e(route('issues.show', $issue->id)); ?>"
                                   class="bg-yellow-500 hover:bg-yellow-600 text-white py-1 px-3 rounded shadow">
                                    View
                                </a>

                                
                                <?php
                                    $recent_count = $issue->machine->issues()
                                        ->where('created_at', '>=', now()->subDays(30))
                                        ->count();
                                ?>
                                <?php if($recent_count >= 3): ?>
                                    <span class="ml-2 text-red-600 font-bold">⚠</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="7" class="text-center py-4 text-gray-500">No issues found.</td>
                        </tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-6">
                <?php echo e($issues->withQueryString()->links('pagination::tailwind')); ?>

            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\merta\Documents\GitHub\barroc-intense\resources\views/issues/index.blade.php ENDPATH**/ ?>