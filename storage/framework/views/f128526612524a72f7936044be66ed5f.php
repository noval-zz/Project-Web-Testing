<?php $__env->startSection('title','Konfigurasi Gedung'); ?>
<?php $__env->startSection('page-title','Gedung'); ?>
<?php $__env->startSection('page-subtitle','Manajemen data gedung kampus'); ?>

<?php $__env->startSection('content'); ?>
<div class="card">
    <div class="card-header">
        <div>
            <div class="card-title">Daftar Gedung</div>
            <div class="card-subtitle"><?php echo e($gedungs->count()); ?> gedung terdaftar</div>
        </div>
        <a href="<?php echo e(route('superadmin.gedung.create')); ?>" class="btn btn-primary">
            <i class="fa-solid fa-plus"></i> Tambah Gedung
        </a>
    </div>
    <div class="table-wrapper">
        <table>
            <thead>
                <tr><th>#</th><th>Nama Gedung</th><th>Kode</th><th>Deskripsi</th><th>Jumlah Lantai</th><th>Aksi</th></tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $gedungs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $g): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td style="color:var(--text-muted)"><?php echo e($g->id); ?></td>
                    <td style="font-weight:600"><?php echo e($g->nama_gedung); ?></td>
                    <td><span class="badge badge-purple"><?php echo e($g->kode_gedung ?? '-'); ?></span></td>
                    <td style="color:var(--text-muted);font-size:13px;max-width:200px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis"><?php echo e($g->deskripsi ?? '-'); ?></td>
                    <td><span class="badge badge-info"><?php echo e($g->lantais_count); ?> lantai</span></td>
                    <td>
                        <div style="display:flex;gap:6px">
                            <a href="<?php echo e(route('superadmin.gedung.edit', $g->id)); ?>" class="btn btn-sm btn-secondary">
                                <i class="fa-solid fa-pen"></i>
                            </a>
                            <form method="POST" action="<?php echo e(route('superadmin.gedung.destroy', $g->id)); ?>" style="display:inline">
                                <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                <button class="btn btn-sm btn-danger" onclick="return confirm('Hapus gedung <?php echo e($g->nama_gedung); ?>? Semua lantai dan ruangan di dalamnya juga akan terhapus!')">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr><td colspan="6" style="text-align:center;color:var(--text-muted);padding:40px">Belum ada data gedung.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('superadmin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\laravel - Copy (2)\resources\views/superadmin/gedung/index.blade.php ENDPATH**/ ?>