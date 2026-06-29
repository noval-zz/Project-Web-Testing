<?php $__env->startSection('title','Konfigurasi Ruangan'); ?>
<?php $__env->startSection('page-title','Ruangan'); ?>
<?php $__env->startSection('page-subtitle','Manajemen ruangan per lantai'); ?>

<?php $__env->startSection('content'); ?>
<div class="card">
    <div class="card-header">
        <div>
            <div class="card-title">Daftar Ruangan</div>
            <div class="card-subtitle"><?php echo e($ruangans->count()); ?> ruangan terdaftar</div>
        </div>
        <a href="<?php echo e(route('superadmin.ruangan.create')); ?>" class="btn btn-primary">
            <i class="fa-solid fa-plus"></i> Tambah Ruangan
        </a>
    </div>
    <div class="table-wrapper">
        <table>
            <thead>
                <tr><th>#</th><th>Gedung</th><th>Lantai</th><th>Nama Ruangan</th><th>Kode</th><th>Aksi</th></tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $ruangans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td style="color:var(--text-muted)"><?php echo e($r->id); ?></td>
                    <td><span class="badge badge-purple"><?php echo e($r->lantai?->gedung?->nama_gedung ?? '-'); ?></span></td>
                    <td><span class="badge badge-info"><?php echo e($r->lantai?->nama_lantai ?? '-'); ?></span></td>
                    <td style="font-weight:600"><?php echo e($r->nama_ruangan); ?></td>
                    <td style="color:var(--text-muted)"><?php echo e($r->kode_ruangan ?? '-'); ?></td>
                    <td>
                        <div style="display:flex;gap:6px">
                            <a href="<?php echo e(route('superadmin.ruangan.edit', $r->id)); ?>" class="btn btn-sm btn-secondary"><i class="fa-solid fa-pen"></i></a>
                            <form method="POST" action="<?php echo e(route('superadmin.ruangan.destroy', $r->id)); ?>" style="display:inline">
                                <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                <button class="btn btn-sm btn-danger" onclick="return confirm('Hapus ruangan <?php echo e($r->nama_ruangan); ?>?')">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr><td colspan="6" style="text-align:center;color:var(--text-muted);padding:40px">Belum ada data ruangan.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('superadmin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\aqas\resources\views/superadmin/ruangan/index.blade.php ENDPATH**/ ?>