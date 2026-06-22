

<?php $__env->startSection('title', 'Complejos'); ?>

<?php $__env->startSection('content'); ?>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Complejos deportivos</h1>
        <a href="<?php echo e(route('admin.venues.create')); ?>" class="btn btn-primary">Nuevo complejo</a>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered align-middle">
            <thead class="table-dark">
                <tr>
                    <th>Nombre</th>
                    <th>Ciudad</th>
                    <th>Teléfono</th>
                    <th># Canchas</th>
                    <th>Activo</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $venues; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $venue): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td><?php echo e($venue->name); ?></td>
                        <td><?php echo e($venue->city); ?></td>
                        <td><?php echo e($venue->phone); ?></td>
                        <td><?php echo e($venue->fields_count); ?></td>
                        <td>
                            <span class="badge bg-<?php echo e($venue->active ? 'success' : 'secondary'); ?>">
                                <?php echo e($venue->active ? 'Sí' : 'No'); ?>

                            </span>
                        </td>
                        <td class="text-end">
                            <a href="<?php echo e(route('admin.venues.edit', $venue)); ?>" class="btn btn-sm btn-outline-secondary">Editar</a>
                            <form method="POST" action="<?php echo e(route('admin.venues.destroy', $venue)); ?>" class="d-inline" data-confirm="¿Eliminar este complejo?">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="btn btn-sm btn-outline-danger">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="6" class="text-center text-muted">No hay complejos registrados.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <?php echo e($venues->links()); ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\wamp64\www\canchasya\resources\views/admin/venues/index.blade.php ENDPATH**/ ?>