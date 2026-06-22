

<?php $__env->startSection('title', $field->name); ?>

<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-md-7">
            <?php if($field->venue->image): ?>
                <img src="<?php echo e(asset('storage/' . $field->venue->image)); ?>" class="img-fluid rounded mb-3" alt="<?php echo e($field->venue->name); ?>">
            <?php endif; ?>
            <h1><?php echo e($field->name); ?></h1>
            <p class="text-muted"><?php echo e($field->venue->name); ?> — <?php echo e($field->venue->address); ?>, <?php echo e($field->venue->city); ?></p>

            <span class="badge bg-light text-dark border"><?php echo e($field->surfaceLabel()); ?></span>
            <span class="badge bg-light text-dark border"><?php echo e(ucfirst($field->surface)); ?></span>
            <?php if($field->capacity): ?>
                <span class="badge bg-light text-dark border">Capacidad: <?php echo e($field->capacity); ?></span>
            <?php endif; ?>

            <p class="mt-3"><?php echo e($field->description); ?></p>

            <h4 class="text-success">$<?php echo e(number_format($field->price_per_hour, 0, ',', '.')); ?> / hora</h4>

            <h5 class="mt-4">Próximas reservas (no disponibles)</h5>
            <?php if($reservations->isEmpty()): ?>
                <p class="text-muted">No hay reservas próximas para esta cancha.</p>
            <?php else: ?>
                <ul class="list-group mb-4">
                    <?php $__currentLoopData = $reservations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reservation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li class="list-group-item d-flex justify-content-between">
                            <span><?php echo e($reservation->date->format('d/m/Y')); ?> — <?php echo e(\Carbon\Carbon::parse($reservation->start_time)->format('H:i')); ?> a <?php echo e(\Carbon\Carbon::parse($reservation->end_time)->format('H:i')); ?></span>
                            <span class="badge bg-<?php echo e($reservation->status === 'confirmed' ? 'success' : 'warning'); ?>"><?php echo e($reservation->statusLabel()); ?></span>
                        </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            <?php endif; ?>
        </div>

        <div class="col-md-5">
            <?php if(auth()->guard()->check()): ?>
                <?php if(auth()->user()->isCustomer()): ?>
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">Reservar esta cancha</h5>

                            <form method="POST" action="<?php echo e(route('reservations.store', $field)); ?>">
                                <?php echo csrf_field(); ?>
                                <input type="hidden" name="field_id" value="<?php echo e($field->id); ?>">

                                <div class="mb-3">
                                    <label for="date" class="form-label">Fecha</label>
                                    <input type="date" id="date" name="date" class="form-control <?php $__errorArgs = ['date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e(old('date')); ?>" min="<?php echo e(now()->toDateString()); ?>" required>
                                    <?php $__errorArgs = ['date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>

                                <div class="row">
                                    <div class="col-6 mb-3">
                                        <label for="start_time" class="form-label">Hora inicio</label>
                                        <input type="time" id="start_time" name="start_time" class="form-control <?php $__errorArgs = ['start_time'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e(old('start_time')); ?>" required>
                                        <?php $__errorArgs = ['start_time'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                    <div class="col-6 mb-3">
                                        <label for="end_time" class="form-label">Hora fin</label>
                                        <input type="time" id="end_time" name="end_time" class="form-control <?php $__errorArgs = ['end_time'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e(old('end_time')); ?>" required>
                                        <?php $__errorArgs = ['end_time'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="notes" class="form-label">Notas (opcional)</label>
                                    <textarea id="notes" name="notes" class="form-control" rows="2"><?php echo e(old('notes')); ?></textarea>
                                </div>

                                <div class="d-grid">
                                    <button type="submit" class="btn btn-success">Reservar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="alert alert-info">Inicia sesión como cliente para reservar esta cancha.</div>
                <?php endif; ?>
            <?php else: ?>
                <div class="alert alert-info">
                    <a href="<?php echo e(route('login')); ?>">Inicia sesión</a> o <a href="<?php echo e(route('register')); ?>">regístrate</a> para reservar esta cancha.
                </div>
            <?php endif; ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\wamp64\www\canchasya\resources\views/fields/show.blade.php ENDPATH**/ ?>