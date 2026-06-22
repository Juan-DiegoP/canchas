

<?php $__env->startSection('title', 'Reservas'); ?>

<?php $__env->startSection('content'); ?>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Reservas</h1>
        <a href="<?php echo e(route('admin.occupancy')); ?>" class="btn btn-outline-primary">Ver ocupación semanal</a>
    </div>

    <form method="GET" action="<?php echo e(route('admin.reservations.index')); ?>" class="row g-2 mb-4">
        <div class="col-md-3">
            <select name="status" class="form-select" onchange="this.form.submit()">
                <option value="">Todos los estados</option>
                <option value="pending" <?php if(request('status') == 'pending'): echo 'selected'; endif; ?>>Pendiente</option>
                <option value="confirmed" <?php if(request('status') == 'confirmed'): echo 'selected'; endif; ?>>Confirmada</option>
                <option value="cancelled" <?php if(request('status') == 'cancelled'): echo 'selected'; endif; ?>>Cancelada</option>
            </select>
        </div>
    </form>

    <div class="table-responsive">
        <table class="table table-bordered align-middle">
            <thead class="table-dark">
                <tr>
                    <th>Cliente</th>
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
                <?php $__empty_1 = true; $__currentLoopData = $reservations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reservation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td><?php echo e($reservation->user->name); ?></td>
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
                        <td class="text-end">
                            <?php if($reservation->status === 'pending'): ?>
                                <form method="POST" action="<?php echo e(route('admin.reservations.confirm', $reservation)); ?>" class="d-inline">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('PATCH'); ?>
                                    <button type="submit" class="btn btn-sm btn-success">Confirmar</button>
                                </form>
                            <?php endif; ?>
                            <?php if($reservation->status !== 'cancelled'): ?>
                                <form method="POST" action="<?php echo e(route('admin.reservations.cancel', $reservation)); ?>" class="d-inline" data-confirm="¿Cancelar esta reserva?">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('PATCH'); ?>
                                    <button type="submit" class="btn btn-sm btn-outline-danger">Cancelar</button>
                                </form>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="8" class="text-center text-muted">No hay reservas.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <?php echo e($reservations->links()); ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\wamp64\www\canchasya\resources\views/admin/reservations/index.blade.php ENDPATH**/ ?>