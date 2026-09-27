<?php $__env->startPush('styles'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('admin/users-assets/css/index.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="main-content">
    <div class="container py-5">
        <?php if(session('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i><?php echo e(session('success')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php endif; ?>

        <?php if(session('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i><?php echo e(session('error')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php endif; ?>

        <div class="card shadow-sm border-0 admin-card">
            <div class="admin-header d-flex justify-content-between align-items-center" style="background-color: var(--navy-color);">
                <h3 class="fw-bold text-uppercase mb-0 text-white">
                    <i class="bi bi-people-fill me-2 text-gold"></i>Quản Lý Người Dùng
                </h3>
                <a href="<?php echo e(route('admin.users.create')); ?>" class="btn btn-gold px-4 shadow-sm text-white" style="background: #C5A017;">
                    <i class="bi bi-person-plus-fill me-1"></i> Thêm Người Dùng
                </a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-header-navy" style="background-color: #0F2942; color: white;">
                        <tr>
                            <th class="py-3 text-center text-uppercase small text-white">Tên đăng nhập</th>
                            <th class="text-center text-uppercase small text-white">Họ và Tên</th>
                            <th class="text-center text-uppercase small text-white">Số điện thoại</th>
                            <th class="text-center text-uppercase small text-white">Vai trò</th>
                            <th class="text-center text-uppercase small text-white">Trạng thái</th>
                            <th class="text-center text-uppercase small text-white" style="width: 220px;">Thao tác</th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $u): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td class="text-center fw-bold" style="color: var(--navy-color, #0F2942);">
                                        <i class="bi bi-person-badge me-2 text-warning opacity-75"></i>
                                        <span><?php echo e($u->TenDangNhap); ?></span>
                                    </td>
                                    <td class="text-center"><?php echo e($u->HoTen); ?></td>
                                    <td class="text-center"><span><?php echo e($u->SoDienThoai); ?></span></td>
                                    <td class="text-center">
                                        <?php if($u->RoleID == 1): ?>
                                            <span class="badge rounded-pill bg-danger px-3 py-2 small">ADMIN</span>
                                        <?php elseif($u->RoleID == 2): ?>
                                            <span class="badge rounded-pill bg-primary px-3 py-2 small">Nhân viên</span>
                                        <?php else: ?>
                                            <span class="badge rounded-pill bg-secondary px-3 py-2 small">Khách hàng</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center">
                                        <?php if($u->TrangThai == 1): ?>
                                            <span class="badge bg-success rounded-pill px-3 py-2 text-white small fw-bold">Hoạt động</span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary rounded-pill px-3 py-2 text-white small fw-bold">Bị khóa</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center">
                                        <a href="<?php echo e(route('admin.users.edit', $u->IDTaiKhoan)); ?>" class="btn btn-sm btn-warning text-white shadow-sm mx-1" title="Sửa thông tin">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="<?php echo e(route('admin.users.destroy', $u->IDTaiKhoan)); ?>" method="POST" class="d-inline-block" onsubmit="return confirm('Bạn có chắc chắn muốn xóa tài khoản này không?');">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="btn btn-sm btn-danger shadow-sm ms-1 delete-btn" title="Xóa">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="6" class="text-center py-5 text-muted">
                                        <i class="bi bi-inbox fs-1 d-block mb-2 opacity-25"></i>
                                        Chưa có dữ liệu người dùng.
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laragon\www\quanlykhachsan\resources\views/admin/users/index.blade.php ENDPATH**/ ?>