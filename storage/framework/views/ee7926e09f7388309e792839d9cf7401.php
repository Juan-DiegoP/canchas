

<?php $__env->startSection('title', 'Ocupación semanal'); ?>

<?php $__env->startSection('content'); ?>
    <h1 class="mb-4">Ocupación semanal</h1>

    <form method="GET" action="<?php echo e(route('admin.occupancy')); ?>" class="row g-2 mb-4 align-items-end">
        <div class="col-md-4">
            <label for="field_id" class="form-label">Cancha</label>
            <select id="field_id" name="field_id" class="form-select" onchange="this.form.submit()">
                <?php $__currentLoopData = $fields; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $f): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($f->id); ?>" <?php if(optional($field)->id == $f->id): echo 'selected'; endif; ?>>
                        <?php echo e($f->name); ?> — <?php echo e($f->venue->name); ?>

                    </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        <input type="hidden" name="week" value="<?php echo e($weekStart->toDateString()); ?>">
        <div class="col-md-6">
            <div class="btn-group">
                <a href="<?php echo e(route('admin.occupancy', ['field_id' => optional($field)->id, 'week' => $weekStart->copy()->subWeek()->toDateString()])); ?>" class="btn btn-outline-secondary">&laquo; Semana anterior</a>
                <a href="<?php echo e(route('admin.occupancy', ['field_id' => optional($field)->id, 'week' => now()->startOfWeek()->toDateString()])); ?>" class="btn btn-outline-secondary">Hoy</a>
                <a href="<?php echo e(route('admin.occupancy', ['field_id' => optional($field)->id, 'week' => $weekStart->copy()->addWeek()->toDateString()])); ?>" class="btn btn-outline-secondary">Semana siguiente &raquo;</a>
            </div>
        </div>
    </form>

    <?php if(! $field): ?>
        <div class="alert alert-info">No hay canchas registradas todavía.</div>
    <?php else: ?>
        <p class="text-muted">Semana del <?php echo e($weekStart->format('d/m/Y')); ?> al <?php echo e($weekStart->copy()->addDays(6)->format('d/m/Y')); ?> — <?php echo e($field->name); ?> (<?php echo e($field->venue->name); ?>)</p>

        <div class="table-responsive">
            <table class="table table-bordered text-center align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>Hora</th>
                        <?php $__currentLoopData = $days; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $day): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <th class="<?php echo e($day->isToday() ? 'table-warning text-dark' : ''); ?>">
                                <?php echo e(ucfirst($day->locale('es')->translatedFormat('D d/m'))); ?>

                            </th>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $hours; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $hour): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td class="fw-bold"><?php echo e(sprintf('%02d:00', $hour)); ?></td>
                            <?php $__currentLoopData = $days; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $day): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    $dateKey = $day->format('Y-m-d');
                                    $reservation = $occupancyMap[$dateKey][$hour] ?? null;
                                ?>
                                <?php if($reservation): ?>
                                    <td class="bg-<?php echo e($reservation->status === 'confirmed' ? 'success' : 'warning'); ?> bg-opacity-50" title="<?php echo e($reservation->user->name); ?>">
                                        <small><?php echo e($reservation->status === 'confirmed' ? 'Confirmada' : 'Pendiente'); ?></small>
                                    </td>
                                <?php else: ?>
                                    <td class="bg-light text-muted"><small>Libre</small></td>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\wamp64\www\canchasya\resources\views/admin/reservations/occupancy.blade.php ENDPATH**/ ?>