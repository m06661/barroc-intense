<?php $__env->startSection('title', 'Contact'); ?>

<?php $__env->startSection('content'); ?>
    <div class="min-h-screen flex flex-col items-center justify-center py-12 px-6 lg:px-8" style="background-color: #FFFBEA;">
        <!-- Success Message Display -->
        <?php if(session('success')): ?>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4 w-full max-w-3xl" role="alert">
                <span class="block sm:inline"><?php echo e(session('success')); ?></span>
            </div>
        <?php endif; ?>

        <!-- Validation Errors Display -->
        <?php if($errors->any()): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4 w-full max-w-3xl">
                <ul>
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        <?php endif; ?>

        <!-- Titel -->
        <div class="text-center mb-6">
            <h1 class="text-4xl font-extrabold text-gray-900">Neem Contact Op</h1>
            <p class="mt-2 text-gray-700">Heb je vragen? Neem gerust contact met ons op via onderstaand formulier of onze contactgegevens.</p>
        </div>

        <!-- Contact Gegevens -->
        <div class="bg-white rounded-lg shadow-md p-6 w-full max-w-3xl mb-8">
            <h2 class="text-2xl font-semibold text-gray-800 mb-4">Onze Contactgegevens</h2>
            <p class="text-gray-700">
                <strong>Telefoon:</strong> <span class="text-yellow-600">+31 6 1234 5678</span>
            </p>
            <p class="text-gray-700 mt-2">
                <strong>Email:</strong> <span class="text-yellow-600">support@barrocintens.fake</span>
            </p>
        </div>

        <!-- Contactformulier -->
        <div class="bg-white rounded-lg shadow-md p-8 w-full max-w-3xl">
            <!-- *** VERANDERD HIER: ACTION ATTRIBUTE *** -->
            <form method="POST" action="<?php echo e(route('contact.store')); ?>">
                <?php echo csrf_field(); ?>

                <!-- Naam -->
                <div class="mb-4">
                    <label for="name" class="block text-gray-700 font-semibold mb-2">Naam</label>
                    
                    <input type="text" id="name" name="name" value="<?php echo e(old('name')); ?>" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-yellow-500 focus:border-yellow-500" placeholder="Jouw naam" required>
                </div>

                <!-- Email -->
                <div class="mb-4">
                    <label for="email" class="block text-gray-700 font-semibold mb-2">Email</label>
                    
                    <input type="email" id="email" name="email" value="<?php echo e(old('email')); ?>" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-yellow-500 focus:border-yellow-500" placeholder="Jouw emailadres" required>
                </div>

                <!-- Bericht -->
                <div class="mb-6">
                    <label for="message" class="block text-gray-700 font-semibold mb-2">Bericht</label>
                    
                    <textarea id="message" name="message" rows="5" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-yellow-500 focus:border-yellow-500" placeholder="Typ hier je bericht" required><?php echo e(old('message')); ?></textarea>
                </div>

                <!-- Verzenden -->
                <div class="flex justify-between items-center">
                    <button type="submit" class="bg-yellow-500 text-white font-semibold py-2 px-4 rounded-lg hover:bg-yellow-600 focus:ring-2 focus:ring-yellow-400 focus:ring-offset-1">
                        Verstuur Bericht
                    </button>
                    <p class="text-gray-500 text-sm">We reageren binnen 2 werkdagen.</p>
                </div>
            </form>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\merta\Documents\GitHub\barroc-intense\resources\views/contact.blade.php ENDPATH**/ ?>