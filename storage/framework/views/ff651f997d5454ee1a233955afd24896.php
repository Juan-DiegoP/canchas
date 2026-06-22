

<?php $__env->startSection('title', 'Canchas disponibles'); ?>

<?php $__env->startSection('content'); ?>
    <h1 class="mb-4">Canchas disponibles</h1>

    <form method="GET" action="<?php echo e(route('fields.index')); ?>" class="row g-2 mb-4">
        <div class="col-md-4">
            <select name="sport_type_id" class="form-select">
                <option value="">Todos los deportes</option>
                <?php $__currentLoopData = $sportTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sportType): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($sportType->id); ?>" <?php if(request('sport_type_id') == $sportType->id): echo 'selected'; endif; ?>>
                        <?php echo e($sportType->name); ?>

                    </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        <div class="col-md-4">
            <select name="city" class="form-select">
                <option value="">Todas las ciudades</option>
                <?php $__currentLoopData = $cities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $city): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($city); ?>" <?php if(request('city') == $city): echo 'selected'; endif; ?>><?php echo e($city); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-primary w-100">Filtrar</button>
        </div>
        <div class="col-md-2">
            <a href="<?php echo e(route('fields.index')); ?>" class="btn btn-outline-secondary w-100">Limpiar</a>
        </div>
    </form>

    <div class="row g-4">
        <?php $__empty_1 = true; $__currentLoopData = $fields; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $field): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="col-md-4">
                <div class="card h-100 shadow-sm">
                    <?php if($field->venue->image): ?>
                        <img src="<?php echo e(asset('storage/' . $field->venue->image)); ?>" class="card-img-top" alt="<?php echo e($field->venue->name); ?>" style="height: 180px; object-fit: cover;">
                    <?php else: ?>
                        <div class="bg-secondary bg-opacity-10 d-flex align-items-center justify-content-center" style="height: 180px;">
                            <i class="bi bi-image text-secondary fs-1"></i>
                        </div>
                    <?php endif; ?>
                    <div class="card-body">
                        <span class="badge bg-secondary mb-2"><?php echo e($field->sportType->name); ?></span>
                        <h5 class="card-title"><?php echo e($field->name); ?></h5>
                        <p class="card-subtitle text-muted mb-2"><?php echo e($field->venue->name); ?> — <?php echo e($field->venue->city); ?></p>
                        <p class="card-text"><?php echo e(Str::limit($field->description, 80)); ?></p>
                        <p class="fw-bold text-success">$<?php echo e(number_format($field->price_per_hour, 0, ',', '.')); ?> / hora</p>
                    </div>
                    <div class="card-footer bg-white border-0">
                        <a href="<?php echo e(route('fields.show', $field)); ?>" class="btn btn-outline-primary w-100">Ver disponibilidad</a>
                    </div>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="col-12">
                <div class="alert alert-info">No hay canchas disponibles con esos filtros.</div>
            </div>
        <?php endif; ?>
    </div>

    <div class="mt-4">
        <?php echo e($fields->links()); ?>

    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\wamp64\www\canchasya\resources\views/fields/index.blade.php ENDPATH**/ ?>