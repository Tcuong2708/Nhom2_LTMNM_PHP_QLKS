<?php $__env->startPush('styles'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('account/css/login.css')); ?>" />
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div class="login-wrapper fade-in-box">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-5">
                    <div class="card card-login shadow-lg border-0">

                        <div class="card-header-login text-center py-4 bg-navy text-white">
                            <h2 class="fw-bold">Đăng nhập</h2>
                            <p class="mb-0 small opacity-75">Chào mừng bạn trở lại với MAY HOTEL</p>
                        </div>

                        <div class="card-body p-4 p-md-5">

                            <?php if(session('error')): ?>
                                <div class="alert alert-danger text-center mb-4" role="alert">
                                    <i class="bi bi-exclamation-circle-fill me-2"></i>
                                    <span><?php echo e(session('error')); ?></span>
                                </div>
                            <?php endif; ?>

                            <form action="<?php echo e(url('/login')); ?>" method="POST">
                                <?php echo csrf_field(); ?>

                                <div class="mb-4">
                                    <label class="form-label fw-bold text-navy">Tên đăng nhập</label>
                                    <input type="text" name="username" class="form-control form-control-lg"
                                           placeholder="Nhập tên đăng nhập của bạn" required value="<?php echo e(old('username')); ?>" />
                                    <?php $__errorArgs = ['username'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <small class="text-danger"><?php echo e($message); ?></small>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label fw-bold text-navy">Mật khẩu</label>
                                    <input type="password" name="password" class="form-control form-control-lg"
                                           placeholder="Nhập mật khẩu" required />
                                    <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <small class="text-danger"><?php echo e($message); ?></small>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>

                                <div class="form-check m-0">
                                    <input type="checkbox" name="remember" class="form-check-input" id="rememberMe">
                                    <label class="form-check-label small text-navy fw-bold" for="rememberMe" style="cursor: pointer;">
                                        Ghi nhớ đăng nhập
                                    </label>
                                </div>

                                <div class="d-flex justify-content-end mb-3">
                                    <a href="#" class="small fw-bold text-decoration-none"
                                       style="color: #d4af37;">
                                        Quên mật khẩu?
                                    </a>
                                </div>

                                <button type="submit" class="btn btn-login w-100 py-3 fw-bold shadow-sm">
                                    <i class="bi bi-box-arrow-in-right me-2"></i> ĐĂNG NHẬP
                                </button>
                            </form>

                            <div class="login-footer text-center mt-4">
                                <p class="mb-1">Chưa có tài khoản? <a href="#" class="fw-bold">Đăng ký ngay</a></p>
                                <p class="mt-2">
                                    <a href="<?php echo e(url('/')); ?>" class="small text-muted text-decoration-none">
                                        <i class="bi bi-arrow-left me-1"></i> Quay về trang chủ
                                    </a>
                                </p>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laragon\www\quanlykhachsan\resources\views/auth/login.blade.php ENDPATH**/ ?>