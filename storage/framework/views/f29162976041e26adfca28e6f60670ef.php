<?php $__env->startSection('title','Konfigurasi Lantai'); ?>
<?php $__env->startSection('page-title','Lantai'); ?>
<?php $__env->startSection('page-subtitle','Manajemen lantai per gedung'); ?>

<?php $__env->startSection('content'); ?>
<div class="card">
    <div class="card-header">
        <div>
            <div class="card-title">Daftar Lantai</div>
            <div class="card-subtitle"><?php echo e($lantais->count()); ?> lantai terdaftar</div>
        </div>
        <a href="<?php echo e(route('superadmin.lantai.create')); ?>" class="btn btn-primary">
            <i class="fa-solid fa-plus"></i> Tambah Lantai
        </a>
    </div>
    <div class="table-wrapper">
        <table>
            <thead>
                <tr><th>#</th><th>Gedung</th><th>Nama Lantai</th><th>Nomor Lantai</th><th>Aksi</th></tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $lantais; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $l): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td style="color:var(--text-muted)"><?php echo e($l->id); ?></td>
                    <td><span class="badge badge-purple"><?php echo e($l->gedung?->nama_gedung ?? '-'); ?></span></td>
                    <td style="font-weight:600"><?php echo e($l->nama_lantai); ?></td>
                    <td><span class="badge badge-info">Lantai <?php echo e($l->nomor_lantai); ?></span></td>
                    <td>
                        <div style="display:flex;gap:6px">
                            <a href="<?php echo e(route('superadmin.lantai.edit', $l->id)); ?>" class="btn btn-sm btn-secondary"><i class="fa-solid fa-pen"></i></a>
                            <form method="POST" action="<?php echo e(route('superadmin.lantai.destroy', $l->id)); ?>" style="display:inline">
                                <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                <button class="btn btn-sm btn-danger" onclick="return confirm('Hapus lantai ini? Semua ruangan di dalamnya juga terhapus!')">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr><td colspan="5" style="text-align:center;color:var(--text-muted);padding:40px">Belum ada data lantai.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('superadmin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\aqas\resources\views/superadmin/lantai/index.blade.php ENDPATH**/ ?>