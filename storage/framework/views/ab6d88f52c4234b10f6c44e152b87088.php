<?php $__env->startPush('styles'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('admin/service-assets/css/index.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="container py-4">
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

    <div class="card border-0 shadow-sm admin-card">
        <div class="admin-header d-flex justify-content-between align-items-center">
            <h3 class="fw-bold text-uppercase mb-0">
                <i class="bi bi-briefcase-fill me-2"></i>Danh sách Dịch vụ
            </h3>
            <a href="<?php echo e(route('admin.service.create')); ?>" class="btn btn-gold px-4 shadow-sm text-white" style="background: #C5A017;">
                <i class="bi bi-plus-circle me-2"></i>Thêm dịch vụ mới
            </a>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-header-navy" style="background-color: #0F2942; color: white;">
                    <tr>
                        <th class="py-3 text-center text-uppercase small text-white">Tên Dịch vụ</th>
                        <th class="text-center text-uppercase small text-white">Đơn giá</th>
                        <th class="text-center text-uppercase small text-white">Đơn vị tính</th>
                        <th class="text-center text-uppercase small text-white" style="width: 150px;">Thao tác</th>
                    </tr>
                    </thead>
                    <tbody id="service-table-body">
                        <?php $__empty_1 = true; $__currentLoopData = $services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td class="text-center fw-bold" style="color: var(--navy-color);">
                                <i class="bi bi-star-fill me-2" style="color: var(--gold-color); opacity: 0.7;"></i>
                                <?php echo e($service->TenDV); ?>

                            </td>
                            <td class="text-center text-danger fw-bold">
                                <?php echo e(number_format($service->GiaTien, 0, ',', '.')); ?> đ
                            </td>
                            <td class="text-center">
                                <span class="badge bg-light text-dark border"><?php echo e($service->DonVi); ?></span>
                            </td>
                            <td class="text-center">
                                <a href="<?php echo e(route('admin.service.edit', $service->MaDV)); ?>" class="btn btn-sm btn-warning text-white shadow-sm mx-1" title="Chỉnh sửa">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="<?php echo e(route('admin.service.destroy', $service->MaDV)); ?>" method="POST" class="d-inline-block" onsubmit="return confirm('Bạn có chắc chắn muốn xóa dịch vụ này?');">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="btn btn-sm btn-danger shadow-sm ms-1" title="Xóa">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="4" class="text-center py-5 text-muted">
                                <i class="bi bi-inbox fs-1 d-block mb-2 opacity-25"></i>
                                <p>Chưa có dịch vụ nào trong hệ thống.</p>
                                <a href="<?php echo e(route('admin.service.create')); ?>" class="btn btn-sm btn-outline-secondary mt-2">Thêm ngay</a>
                            </td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laragon\www\quanlykhachsan\resources\views/admin/service/index.blade.php ENDPATH**/ ?>