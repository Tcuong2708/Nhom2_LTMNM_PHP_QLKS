<?php $__env->startPush('styles'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('admin/reviews-assets/css/index.css')); ?>">
    <style>
        .bg-navy { background-color: #0F2942 !important; }
        .text-navy { color: #0F2942 !important; }
        .text-gold { color: #C5A017 !important; }
    </style>
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

        <div class="card shadow-sm border-0 admin-card">
            <div class="admin-header d-flex justify-content-between align-items-center" style="background-color: var(--navy-color);">
                <h3 class="fw-bold text-uppercase mb-0 text-white">
                    <i class="bi bi-chat-square-heart-fill me-2 text-gold"></i>Kiểm duyệt Đánh giá phản hồi
                </h3>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-header-navy" style="background-color: #0F2942; color: white;">
                        <tr>
                            <th class="py-3 text-center text-uppercase small text-white">Mã đơn</th>
                            <th class="text-center text-uppercase small text-white">Phòng</th>
                            <th class="text-center text-uppercase small text-white">Người đánh giá</th>
                            <th class="text-center text-uppercase small text-white">Số sao</th>
                            <th class="text-center text-uppercase small text-white" style="max-width: 350px;">Nội dung</th>
                            <th class="text-center text-uppercase small text-white" style="width: 180px;">Thao tác</th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $reviews; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td class="text-center fw-bold text-muted">#<?php echo e($r->id); ?></td>
                                    <td class="text-center fw-bold text-navy"><?php echo e($r->TenPhong); ?></td>
                                    <td class="text-center fw-bold"><?php echo e($r->NguoiDanhGia); ?></td>
                                    <td class="text-center">
                                        <?php for($i = 0; $i < $r->SoSao; $i++): ?>
                                            <span class="text-warning"><i class="bi bi-star-fill"></i></span>
                                        <?php endfor; ?>
                                    </td>
                                    <td class="text-center text-truncate" style="max-width: 350px;" title="<?php echo e($r->NoiDung); ?>"><?php echo e($r->NoiDung); ?></td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-1">
                                            <form action="<?php echo e(route('admin.reviews.destroy', $r->id)); ?>" method="POST" onsubmit="return confirm('Xóa bỏ vĩnh viễn bình luận này?');">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>
                                                <button type="submit" class="btn btn-sm btn-danger shadow-sm">
                                                    <i class="bi bi-trash"></i> Xóa
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="6" class="text-center py-4 text-muted">Hệ thống hiện tại chưa nhận được phản hồi đánh giá nào từ khách hàng.</td>
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

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laragon\www\quanlykhachsan\resources\views/admin/reviews/index.blade.php ENDPATH**/ ?>