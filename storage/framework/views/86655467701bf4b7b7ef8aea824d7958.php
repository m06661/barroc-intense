<?php $__env->startSection('title', 'Klantdossier – ' . $customer->name); ?>

<?php $__env->startSection('content'); ?>
<div class="min-h-screen flex flex-col items-center justify-start pt-20 pb-12 px-6 lg:px-8" style="background-color: #FFFBEA;">

    <!-- Titel -->
    <div class="text-center mb-10">
        <h1 class="text-4xl font-extrabold text-gray-900">Klantdossier</h1>
        <p class="mt-2 text-gray-700 text-lg">
            Dossier van <span class="font-semibold"><?php echo e($customer->name); ?></span>.  
            Upload documenten, bekijk bestanden en controleer ontbrekende gegevens.
        </p>
    </div>

    <!-- Container -->
    <div class="bg-white rounded-xl shadow-lg w-full max-w-6xl border border-gray-100 p-8 space-y-10">

        
        <?php if(session('success')): ?>
            <div class="bg-green-100 border border-green-300 text-green-800 px-6 py-4 rounded-lg shadow-sm">
                <?php echo e(session('success')); ?>

            </div>
        <?php endif; ?>

        <!-- Ontbrekende gegevens -->
        <?php if(count($missing) > 0): ?>
            <div class="bg-red-100 border border-red-300 text-red-800 px-6 py-5 rounded-lg shadow-sm">
                <h2 class="text-2xl font-semibold mb-3">Ontbrekende gegevens</h2>
                <p class="mb-2 text-gray-800">De volgende velden ontbreken in het klantdossier:</p>
                <ul class="list-disc pl-6 text-gray-800">
                    <?php $__currentLoopData = $missing; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $field): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e(ucfirst(str_replace('_', ' ', $field))); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        <?php endif; ?>

        <!-- Document upload -->
        <div>
            <h2 class="text-2xl font-semibold text-gray-900 mb-4">Document uploaden</h2>

            <form method="POST" action="<?php echo e(route('documents.store', $customer->id)); ?>" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>

                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2">Bestand</label>
                    <input type="file"
                           name="document"
                           class="block w-full border-gray-300 rounded-md shadow-sm bg-white
                                  focus:ring-yellow-500 focus:border-yellow-500"
                           required>
                </div>

                <button type="submit"
                        class="bg-yellow-500 hover:bg-yellow-600 text-white font-semibold py-2 px-5 rounded-lg shadow-sm focus:ring-2 focus:ring-yellow-400 transition">
                    Uploaden
                </button>
            </form>
        </div>

        <!-- Documentenlijst -->
        <div>
            <h2 class="text-2xl font-semibold text-gray-900 mb-4">Documenten</h2>

            <?php if($files->count() === 0): ?>
                <p class="text-gray-700">Er zijn nog geen documenten voor deze klant.</p>
            <?php else: ?>

            <div class="overflow-hidden rounded-xl border border-gray-200 shadow">
                <table class="min-w-full text-left">
                    <thead class="bg-gray-100 text-gray-700 text-sm uppercase tracking-wide">
                        <tr>
                            <th class="px-6 py-4">Bestand</th>
                            <th class="px-6 py-4">Geüpload op</th>
                            <th class="px-6 py-4 text-center">Acties</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-200 bg-white">
                        <?php $__currentLoopData = $files; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $file): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr class="hover:bg-yellow-50 transition">
                            <td class="px-6 py-4 font-medium text-gray-800">
                                <?php echo e($file->filename); ?>

                            </td>

                            <td class="px-6 py-4 text-gray-700">
                                <?php echo e($file->created_at->format('d-m-Y H:i')); ?>

                            </td>

                            <td class="px-6 py-4 text-center">
                                <div class="flex justify-center gap-3">

                                    <!-- Download -->
                                    <a href="<?php echo e(Storage::url($file->path)); ?>"
                                       download
                                       class="bg-green-500 hover:bg-green-600 text-white font-semibold py-2 px-4 rounded-lg shadow-sm transition text-sm">
                                        Download
                                    </a>

                                    <!-- Verwijderen -->
                                    <form method="POST" action="<?php echo e(route('documents.destroy', [$customer->id, $file->id])); ?>">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button
                                            class="bg-red-500 hover:bg-red-600 text-white font-semibold py-2 px-4 rounded-lg shadow-sm transition text-sm">
                                            Verwijderen
                                        </button>
                                    </form>

                                </div>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>

                </table>
            </div>

            <?php endif; ?>
        </div>

    </div>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\merta\Documents\GitHub\barroc-intense\resources\views/customers/documents/index.blade.php ENDPATH**/ ?>