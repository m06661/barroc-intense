<nav class="bg-yellow-500 p-4">
    <div class="max-w-7xl mx-auto flex justify-between items-center">
        <!-- Logo -->
        <a href="/index" class="flex items-center">
            <img src="<?php echo e(asset('images/logo5_klein.png')); ?>" alt="Barroc Intens Logo" class="h-8 mr-2"> <!-- Voeg het logo toe -->
            <span class="text-white text-2xl font-semibold">Barroc<span class="text-black">Intens.</span></span>
        </a>


                <div>
                    <input type="text" name="search" value="<?php echo e(request('search')); ?>"
                           class="w-full border-gray-300 rounded p-2"
                           placeholder="Search...">
                </div>



        <!-- Navigation Links -->
        <div class="space-x-4">
            <?php if(auth()->guard()->guest()): ?>
                <!-- Link voor niet-ingelogde gebruikers -->
                <a href="<?php echo e(route('login')); ?>" class="text-white">Login</a>
                <?php if(Route::has('register')): ?>
                    <a href="<?php echo e(route('register')); ?>" class="text-white">Register</a>
                <?php endif; ?>
            <?php else: ?>
                <!-- Links voor ingelogde gebruikers -->
                <a href="<?php echo e(route('index')); ?>" class="text-white">Home</a>

                <a href="<?php echo e(url('/customers')); ?>" class="text-white">Customers</a>

                <a href="<?php echo e(route('issues.index')); ?>" class="text-white">Issues</a>

                <a href="<?php echo e(route('orders.index')); ?>" class="text-white">Orders</a>

                <a href="<?php echo e(route('roles.assign')); ?>" class="text-white">assign roles</a>

                <!-- Dit moet later specifiek voor de juiste users worden -->
                <a href="<?php echo e(route('dashboard')); ?>" class="text-white">Dashboard</a>

                <a href="<?php echo e(route('machines.index')); ?>" class="text-white">Machines</a>
                <!-- Feedback Link -->
                <a href="<?php echo e(route('feedback.index')); ?>" class="text-white hover:text-gray-200 transition">Feedback</a>

                <a href="<?php echo e(route('leases.index')); ?>" class="text-white">Leases</a>

                <a href="<?php echo e(route('contact')); ?>" class="text-white">Contact</a>

                <a href="<?php echo e(route('audit.index')); ?>" class="text-white">auditpage</a>

                <a href="<?php echo e(route('sales-funnel.index')); ?>" class="text-white">
                    Sales Funnel
                </a>

                <!-- Logout Form -->
                <form method="POST" action="<?php echo e(route('logout')); ?>" class="inline">
                    <?php echo csrf_field(); ?>
                    <button type="submit" class="text-white">Logout</button>
                </form>
            <?php endif; ?>
        </div>
    </div>
</nav>
<?php /**PATH C:\Users\merta\Documents\GitHub\barroc-intense\resources\views/layouts/navigation.blade.php ENDPATH**/ ?>