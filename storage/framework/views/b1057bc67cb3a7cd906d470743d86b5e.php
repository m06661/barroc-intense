<?php $__env->startSection('title', 'Dashboard'); ?>

<?php $__env->startSection('content'); ?>
    <div class="bg-yellow-50 min-h-screen">

        <!-- Dashboard Header -->
        <div class="text-center py-12">
            <h1 class="text-5xl font-bold text-yellow-700">Dashboard</h1>
        </div>

        <!-- BESTELADVIES WAARSCHUWING -->
        <?php
            $lowStockProducts = $products->filter(fn($p) => $p->isLowStock());
        ?>

        <?php if($lowStockProducts->count() > 0): ?>
            <div class="max-w-6xl mx-auto bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-lg shadow-md mb-6">
                <div class="flex items-start">
                    <span class="text-2xl mr-3">⚠️</span>
                    <div class="flex-1">
                        <h3 class="font-bold text-lg mb-2">🚨 Besteladvies: Lage voorraad gedetecteerd!</h3>
                        <p class="mb-2">De volgende producten hebben een voorraad op of onder het minimum:</p>
                        <ul class="list-disc list-inside space-y-1">
                            <?php $__currentLoopData = $lowStockProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li>
                                    <strong><?php echo e($product->name); ?></strong>:
                                    <span class="font-semibold"><?php echo e($product->stock); ?> stuks</span>
                                    (minimum: <?php echo e($product->minimum_stock); ?>)
                                    <span class="ml-2 text-sm bg-red-600 text-white px-2 py-0.5 rounded">
                                        → Bestel <?php echo e($product->suggestedReorderQuantity()); ?> stuks
                                    </span>
                                </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <!-- PRODUCTEN BEHEER -->
        <div class="max-w-6xl mx-auto bg-white rounded-lg shadow-md p-6 mt-8">
            <h2 class="text-2xl font-semibold text-gray-800 mb-4">Producten</h2>

            
            <div class="bg-gray-100 p-4 rounded-lg mb-6">
                <h3 class="text-lg font-semibold mb-3">Nieuw Product Toevoegen</h3>
                <form action="<?php echo e(route('products.store')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Naam</label>
                            <input type="text" name="name" class="w-full border-gray-300 rounded p-2" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Prijs (€)</label>
                            <input type="number" name="price" step="0.01" class="w-full border-gray-300 rounded p-2" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Voorraad</label>
                            <input type="number" name="stock" value="0" class="w-full border-gray-300 rounded p-2" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Min. Voorraad</label>
                            <input type="number" name="minimum_stock" value="10" class="w-full border-gray-300 rounded p-2" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Bestel aantal</label>
                            <input type="number" name="reorder_quantity" value="50" class="w-full border-gray-300 rounded p-2" required>
                        </div>
                    </div>
                    <div class="mt-4 text-right">
                        <button type="submit" class="bg-yellow-500 hover:bg-yellow-600 text-white py-2 px-4 rounded-lg shadow-md">
                            Product Aanmaken
                        </button>
                    </div>
                </form>
            </div>

            <!-- Producten Tabel -->
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white border border-gray-300 rounded-md">
                    <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2 text-left">Productnaam</th>
                        <th class="px-4 py-2 text-left">Prijs</th>
                        <th class="px-4 py-2 text-left">Voorraad</th>
                        <th class="px-4 py-2 text-left">Min. Voorraad</th>
                        <th class="px-4 py-2 text-left">Bestel aantal</th>
                        <th class="px-4 py-2 text-left">Gereserveerd</th>
                        <th class="px-4 py-2 text-left">Status</th>
                        <th class="px-4 py-2 text-left">Acties</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr class="border-b <?php echo e($product->isCriticalStock() ? 'bg-red-50' : ($product->isLowStock() ? 'bg-yellow-50' : '')); ?>">
                            <td class="px-4 py-2">
                                <form action="<?php echo e(route('products.update', $product->id)); ?>" method="POST" class="flex items-center gap-2">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('PUT'); ?>
                                    <input type="text" name="name" value="<?php echo e($product->name); ?>" class="w-32 border-gray-300 rounded p-1">
                            </td>
                            <td class="px-4 py-2">
                                <input type="number" name="price" value="<?php echo e($product->price); ?>" step="0.01" class="w-20 border-gray-300 rounded p-1">
                            </td>
                            <td class="px-4 py-2">
                                <input type="number" name="stock" value="<?php echo e($product->stock); ?>" class="w-20 border-gray-300 rounded p-1">
                            </td>
                            <td class="px-4 py-2">
                                <input type="number" name="minimum_stock" value="<?php echo e($product->minimum_stock); ?>" class="w-20 border-gray-300 rounded p-1">
                            </td>
                            <td class="px-4 py-2">
                                <input type="number" name="reorder_quantity" value="<?php echo e($product->reorder_quantity ?? 50); ?>" class="w-20 border-gray-300 rounded p-1">
                            </td>
                            <td class="px-4 py-2"><?php echo e($product->reservedQuantity()); ?></td>
                            <td class="px-4 py-2">
                                <?php if($product->isCriticalStock()): ?>
                                    <span class="px-2 py-1 bg-red-600 text-white text-xs rounded font-bold">🚨 KRITIEK</span>
                                <?php elseif($product->isLowStock()): ?>
                                    <span class="px-2 py-1 bg-yellow-500 text-white text-xs rounded font-bold">⚠️ LAAG</span>
                                <?php else: ?>
                                    <span class="px-2 py-1 bg-green-500 text-white text-xs rounded">✓ OK</span>
                                <?php endif; ?>
                            </td>
                            <td class="px-4 py-2 flex items-center gap-2">
                                <button type="submit" class="bg-yellow-500 hover:bg-yellow-600 text-white py-1 px-2 rounded">Opslaan</button>
                                </form>
                                <form action="<?php echo e(route('products.destroy', $product->id)); ?>" method="POST" class="inline">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button class="text-red-600 hover:text-red-700" onclick="return confirm('Verwijderen?')">Verwijderen</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    <?php if($products->isEmpty()): ?>
                        <tr>
                            <td colspan="8" class="text-center py-4 text-gray-500">Geen producten gevonden.</td>
                        </tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- CATEGORIEËN BEHEER -->
        <div class="max-w-4xl mx-auto bg-white rounded-lg shadow-md p-6 mt-12 mb-12">
            <h2 class="text-2xl font-semibold text-gray-800 mb-4">Categorieën</h2>

            
            <div class="bg-gray-100 p-4 rounded-lg mb-6">
                <h3 class="text-lg font-semibold mb-3">Nieuwe Categorie</h3>
                <form action="<?php echo e(route('categories.store')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Naam</label>
                            <input type="text" name="name" class="w-full border-gray-300 rounded p-2" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Beschrijving</label>
                            <input type="text" name="description" class="w-full border-gray-300 rounded p-2">
                        </div>
                    </div>
                    <div class="mt-4 text-right">
                        <button class="bg-yellow-500 hover:bg-yellow-600 text-white py-2 px-4 rounded-lg shadow-md">
                            Categorie Aanmaken
                        </button>
                    </div>
                </form>
            </div>

            <!-- Categorieën Tabel -->
            <table class="min-w-full bg-white border border-gray-300 rounded-md">
                <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2 text-left">Naam</th>
                    <th class="px-4 py-2 text-left">Beschrijving</th>
                    <th class="px-4 py-2 text-left">Acties</th>
                </tr>
                </thead>
                <tbody>
                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr class="border-b">
                        <td class="px-4 py-2">
                            <form action="<?php echo e(route('categories.update', $category->id)); ?>" method="POST" class="flex items-center gap-2">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('PUT'); ?>
                                <input type="text" name="name" value="<?php echo e($category->name); ?>" class="w-32 border-gray-300 rounded p-1">
                        </td>
                        <td class="px-4 py-2">
                            <input type="text" name="description" value="<?php echo e($category->description); ?>" class="w-full border-gray-300 rounded p-1">
                        </td>
                        <td class="px-4 py-2 flex items-center gap-2">
                            <button type="submit" class="bg-yellow-500 hover:bg-yellow-600 text-white py-1 px-2 rounded">Opslaan</button>
                            </form>
                            <form action="<?php echo e(route('categories.destroy', $category->id)); ?>" method="POST" class="inline">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button class="text-red-600 hover:text-red-700" onclick="return confirm('Verwijderen?')">Verwijderen</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                <?php if($categories->isEmpty()): ?>
                    <tr>
                        <td colspan="3" class="text-center py-4 text-gray-500">Geen categorieën gevonden.</td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>

    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\merta\Documents\GitHub\barroc-intense\resources\views/dashboard.blade.php ENDPATH**/ ?>