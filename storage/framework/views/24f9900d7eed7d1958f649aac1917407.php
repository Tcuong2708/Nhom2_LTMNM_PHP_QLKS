<?php $__env->startPush('styles'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('admin/category-assets/css/index.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
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
        <div class="admin-header d-flex justify-content-between align-items-center">
            <h3 class="fw-bold text-uppercase mb-0">
                <i class="bi bi-bookmark-star-fill me-2"></i>Quản Lý Loại Phòng
            </h3>
            <a href="<?php echo e(route('admin.category.create')); ?>" class="btn btn-gold px-4 shadow-sm text-white" style="background: #C5A017;">
                <i class="bi bi-plus-lg me-1"></i> Thêm Mới
            </a>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                <thead class="table-header-navy" style="background-color: #0F2942; color: white;">
                    <tr>
                        <th class="py-3 text-center text-uppercase small text-white">Mã số</th>
                        <th class="text-center text-uppercase small text-white">Tên loại phòng</th>
                        <th class="text-center text-uppercase small text-white">Sức chứa tối đa (Người)</th>
                        <th class="text-center text-uppercase small text-white">Số lượng phòng</th>
                        <th class="text-center text-uppercase small text-white" style="width: 150px;">Thao tác</th>
                    </tr>
                </thead>
                    <tbody id="category-table-body">
                        <?php $__empty_1 = true; $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td class="text-center fw-bold text-muted">#<?php echo e($cat->MaLoai); ?></td>
                            <td class="text-center fw-bold text-navy" style="color: #0F2942;"><?php echo e($cat->Name); ?></td>
                            <td class="text-center"><span class="badge bg-info text-dark"><i class="bi bi-people-fill me-1"></i> <?php echo e($cat->SoNguoi); ?></span></td>
                            <td class="text-center"><span class="badge bg-secondary"><?php echo e($cat->so_luong_phong ?? 0); ?> phòng</span></td>
                            <td class="text-center">
                                <a href="<?php echo e(route('admin.category.edit', $cat->MaLoai)); ?>" class="btn btn-sm btn-warning text-white shadow-sm" title="Sửa"><i class="bi bi-pencil"></i></a>
                                <form action="<?php echo e(route('admin.category.destroy', $cat->MaLoai)); ?>" method="POST" class="d-inline-block" onsubmit="return confirm('Bạn có chắc chắn muốn xóa loại phòng này? Thao tác này không thể phục hồi!');">
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
                            <td colspan="5" class="text-center py-4 text-muted">
                                <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                Không có dữ liệu loại phòng.
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

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laragon\www\quanlykhachsan\resources\views/admin/category/index.blade.php ENDPATH**/ ?>