

<?php $__env->startSection('title', 'Mis reservas'); ?>

<?php $__env->startSection('content'); ?>
    <h1 class="mb-4">Mis reservas</h1>

    <?php if($reservations->isEmpty()): ?>
        <div class="alert alert-info">Todavía no tienes reservas. <a href="<?php echo e(route('fields.index')); ?>">Busca una cancha</a> para reservar.</div>
    <?php else: ?>
        <div class="table-responsive">
            <table class="table table-bordered align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>Cancha</th>
                        <th>Complejo</th>
                        <th>Fecha</th>
                        <th>Horario</th>
                        <th>Precio</th>
                        <th>Estado</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $reservations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reservation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($reservation->field->name); ?></td>
                            <td><?php echo e($reservation->field->venue->name); ?></td>
                            <td><?php echo e($reservation->date->format('d/m/Y')); ?></td>
                            <td><?php echo e(\Carbon\Carbon::parse($reservation->start_time)->format('H:i')); ?> - <?php echo e(\Carbon\Carbon::parse($reservation->end_time)->format('H:i')); ?></td>
                            <td>$<?php echo e(number_format($reservation->total_price, 0, ',', '.')); ?></td>
                            <td>
                                <?php
                                    $badge = match ($reservation->status) {
                                        'pending' => 'warning',
                                        'confirmed' => 'success',
                                        'cancelled' => 'danger',
                                    };
                                ?>
                                <span class="badge bg-<?php echo e($badge); ?>"><?php echo e($reservation->statusLabel()); ?></span> 
                            </td>
                            <td>
                                <?php if($reservation->status === 'pending'): ?>
                                    <form method="POST" action="<?php echo e(route('reservations.cancel', $reservation)); ?>" onsubmit="return confirm('¿Cancelar esta reserva?');">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('PATCH'); ?>
                                        <button type="submit" class="btn btn-sm btn-outline-danger">Cancelar</button>
                                    </form>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            <?php echo e($reservations->links()); ?>

        </div>
    <?php endif; ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\wamp64\www\canchasya\resources\views/reservations/index.blade.php ENDPATH**/ ?>