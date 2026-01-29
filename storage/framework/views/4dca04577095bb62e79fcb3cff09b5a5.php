<?php $__env->startSection('content'); ?>
    <div class="bg-yellow-50 min-h-screen py-10">
        <div class="max-w-5xl mx-auto">

            <h1 class="text-4xl font-bold text-yellow-700 text-center mb-10">
                Rollen Toewijzen aan Gebruikers
            </h1>

            <!-- Notificatie Container -->
            <div id="notification-container" class="mb-6"></div>

            <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <form
                    action="<?php echo e(route('roles.assign.save', $user->id)); ?>"
                    method="POST"
                    class="mb-8 bg-white shadow-md border-l-4 border-yellow-500 rounded-lg p-6 hover:shadow-xl transition-shadow duration-200"
                    data-user-form="<?php echo e($user->id); ?>"
                    data-user-name="<?php echo e($user->name); ?>"
                >
                    <?php echo csrf_field(); ?>

                    <!-- Gebruikers Info -->
                    <h3 class="text-2xl font-semibold text-gray-800 mb-4 flex items-center">
                        <span class="mr-2 text-yellow-600">👤</span>
                        <?php echo e($user->name); ?> <span class="text-gray-500 text-lg ml-2">(<?php echo e($user->email); ?>)</span>
                    </h3>

                    <!-- Checkboxes -->
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-2 mb-6">
                        <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <label class="flex items-center space-x-2 text-gray-700">
                                <input
                                    type="checkbox"
                                    name="roles[]"
                                    value="<?php echo e($role->id); ?>"
                                    class="rounded border-yellow-400 text-yellow-600 focus:ring-yellow-500"
                                    data-original="<?php echo e($user->roles->contains($role->id) ? '1' : '0'); ?>"
                                    data-role-name="<?php echo e($role->name); ?>"
                                    <?php echo e($user->roles->contains($role->id) ? 'checked' : ''); ?>

                                >
                                <span><?php echo e(ucfirst($role->name)); ?></span>
                            </label>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>

                    <!-- Submit Button -->
                    <button
                        type="submit"
                        class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-5 rounded-lg shadow-md transition-transform hover:scale-105"
                    >
                        💾 Opslaan
                    </button>
                </form>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        </div>
    </div>

    <script>
        function showNotification(message, type = 'success') {
            const container = document.getElementById('notification-container');

            // Verwijder bestaande notificaties
            container.innerHTML = '';

            const notification = document.createElement('div');

            const bgColor = type === 'success' ? 'bg-green-100 border-green-500 text-green-700' :
                type === 'warning' ? 'bg-yellow-100 border-yellow-500 text-yellow-700' :
                    'bg-red-100 border-red-500 text-red-700';

            const icon = type === 'success' ? '✅' :
                type === 'warning' ? '⚠️' : '❌';

            notification.className = `${bgColor} border-l-4 p-4 rounded-lg shadow-md mb-4`;
            notification.innerHTML = `
                    <div class="flex items-start">
                        <span class="text-2xl mr-3">${icon}</span>
                        <div class="flex-1">
                            ${message}
                        </div>
                    </div>
                `;

            container.appendChild(notification);

            // Scroll naar boven
            window.scrollTo({ top: 0, behavior: 'smooth' });

            // Verwijder na 5 seconden
            setTimeout(() => {
                notification.style.transition = 'opacity 0.3s ease-out';
                notification.style.opacity = '0';
                setTimeout(() => {
                    notification.remove();
                }, 300);
            }, 5000);
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Voeg event listener toe aan alle formulieren
            document.querySelectorAll('form[data-user-form]').forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();

                    const userName = this.dataset.userName;
                    const checkboxes = this.querySelectorAll('input[type="checkbox"]');

                    let addedRoles = [];
                    let removedRoles = [];

                    checkboxes.forEach(checkbox => {
                        const originalState = checkbox.dataset.original === '1';
                        const currentState = checkbox.checked;
                        const roleName = checkbox.dataset.roleName;

                        if (!originalState && currentState) {
                            // Rol toegevoegd
                            addedRoles.push(ucfirst(roleName));
                        } else if (originalState && !currentState) {
                            // Rol verwijderd
                            removedRoles.push(ucfirst(roleName));
                        }
                    });

                    // Controleer of er wijzigingen zijn
                    if (addedRoles.length === 0 && removedRoles.length === 0) {
                        showNotification(
                            `<strong>Geen wijzigingen</strong><br><span class="text-sm">Voor gebruiker: ${userName}</span>`,
                            'warning'
                        );
                        return false;
                    }

                    // Bouw de notificatie boodschap
                    let message = `<strong>Rollen gewijzigd voor ${userName}</strong><br>`;

                    if (addedRoles.length > 0) {
                        message += `<span class="text-sm">➕ <strong>Toegevoegd:</strong> ${addedRoles.join(', ')}</span><br>`;
                    }

                    if (removedRoles.length > 0) {
                        message += `<span class="text-sm">➖ <strong>Verwijderd:</strong> ${removedRoles.join(', ')}</span>`;
                    }

                    // Toon notificatie
                    showNotification(message, 'success');

                    // Verzend het formulier NA het tonen van de notificatie
                    // Dit gebeurt pas na 500ms zodat de gebruiker de notificatie ziet
                    setTimeout(() => {
                        this.submit();
                    }, 5000);
                });
            });
        });

        function ucfirst(string) {
            return string.charAt(0).toUpperCase() + string.slice(1);
        }
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\merta\Documents\GitHub\barroc-intense\resources\views/roles/assign.blade.php ENDPATH**/ ?>