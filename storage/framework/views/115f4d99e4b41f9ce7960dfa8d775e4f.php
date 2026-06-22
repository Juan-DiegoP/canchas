<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title>CanchasYa — <?php echo $__env->yieldContent('title', 'Inicio'); ?></title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="icon" type="image/png" href="<?php echo e(asset('images/canchaya-logo.png')); ?>">

    <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body class="bg-light">

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="<?php echo e(route('home')); ?>">
                <img src="<?php echo e(asset('images/canchaya-logo.png')); ?>" alt="CanchaYa" height="40">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navMenu">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link <?php echo e(request()->routeIs('fields.*') || request()->routeIs('home') ? 'active' : ''); ?>" href="<?php echo e(route('fields.index')); ?>">Canchas</a>
                    </li>
                    <?php if(auth()->guard()->check()): ?>
                        <?php if(auth()->user()->isCustomer()): ?>
                            <li class="nav-item">
                                <a class="nav-link <?php echo e(request()->routeIs('reservations.*') ? 'active' : ''); ?>" href="<?php echo e(route('reservations.index')); ?>">Mis reservas</a>
                            </li>
                        <?php endif; ?>
                        <?php if(auth()->user()->isAdmin()): ?>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                    Administración
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="<?php echo e(route('admin.sport-types.index')); ?>">Deportes</a></li>
                                    <li><a class="dropdown-item" href="<?php echo e(route('admin.venues.index')); ?>">Complejos</a></li>
                                    <li><a class="dropdown-item" href="<?php echo e(route('admin.fields.index')); ?>">Canchas</a></li>
                                    <li><a class="dropdown-item" href="<?php echo e(route('admin.reservations.index')); ?>">Reservas</a></li>
                                    <li><a class="dropdown-item" href="<?php echo e(route('admin.occupancy')); ?>">Ocupación semanal</a></li>
                                </ul>
                            </li>
                        <?php endif; ?>
                    <?php endif; ?>
                </ul>

                <ul class="navbar-nav ms-auto">
                    <?php if(auth()->guard()->guest()): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo e(route('login')); ?>">Iniciar sesión</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo e(route('register')); ?>">Registrarse</a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                <?php echo e(auth()->user()->name); ?>

                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="<?php echo e(route('profile.edit')); ?>">Mi perfil</a></li>
                                <li>
                                    <form method="POST" action="<?php echo e(route('logout')); ?>">
                                        <?php echo csrf_field(); ?>
                                        <button type="submit" class="dropdown-item">Cerrar sesión</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container my-4">
        <?php if(session('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?php echo e(session('success')); ?>

                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?php if(session('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?php echo e(session('error')); ?>

                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?php echo $__env->yieldContent('content'); ?>
    </div>

    <footer class="bg-dark text-light text-center py-3 mt-5">
        <small>&copy; <?php echo e(date('Y')); ?> CanchasYa </small>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Modal de confirmación reutilizable -->
    <div class="modal fade" id="confirmModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Confirmar acción</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="confirmModalBody">
                    ¿Estás seguro?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-danger" id="confirmModalAccept">Confirmar</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        let formToSubmit = null;
        const confirmModalEl = document.getElementById('confirmModal');
        const confirmModal = new bootstrap.Modal(confirmModalEl);

        document.addEventListener('submit', function (e) {
            const form = e.target;
            if (form.matches('[data-confirm]')) {
                e.preventDefault();
                formToSubmit = form;
                document.getElementById('confirmModalBody').textContent = form.dataset.confirm;
                confirmModal.show();
            }
        });

        document.getElementById('confirmModalAccept').addEventListener('click', function () {
            if (formToSubmit) {
                confirmModal.hide();
                formToSubmit.submit();
            }
        });
    </script>

    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html><?php /**PATH C:\wamp64\www\canchasya\resources\views/layouts/app.blade.php ENDPATH**/ ?>