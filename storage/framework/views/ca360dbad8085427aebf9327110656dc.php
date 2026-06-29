<?php $__env->startSection('title','Kategori Fasilitas'); ?>
<?php $__env->startSection('page-title','Kategori Fasilitas'); ?>
<?php $__env->startSection('page-subtitle','Master data kategori fasilitas kampus'); ?>

<?php $__env->startSection('content'); ?>
<div style="display:grid;grid-template-columns:1fr 380px;gap:20px">

    <!-- TABLE -->
    <div class="card">
        <div class="card-header">
            <div>
                <div class="card-title">Daftar Kategori</div>
                <div class="card-subtitle"><?php echo e($kategoris->count()); ?> kategori terdaftar</div>
            </div>
            <a href="<?php echo e(route('superadmin.kategori.create')); ?>" class="btn btn-primary">
                <i class="fa-solid fa-plus"></i> Tambah
            </a>
        </div>
        <div class="table-wrapper">
            <table>
                <thead>
                    <tr><th>#</th><th>Nama Kategori</th><th>Deskripsi</th><th>Aksi</th></tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $kategoris; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td style="color:var(--text-muted)"><?php echo e($k->id_kategori); ?></td>
                        <td>
                            <div style="display:flex;align-items:center;gap:10px">
                                <div style="width:32px;height:32px;border-radius:8px;background:linear-gradient(135deg,rgba(108,99,255,0.2),rgba(255,101,132,0.2));display:flex;align-items:center;justify-content:center;font-size:14px">
                                    <?php
                                        $icons = ['Listrik'=>'bolt','Air'=>'droplet','AC'=>'wind','Meja'=>'table','Kursi'=>'chair','Proyektor'=>'video','Jaringan Internet'=>'wifi'];
                                        $icon = $icons[$k->nama_kategori] ?? 'tag';
                                    ?>
                                    <i class="fa-solid fa-<?php echo e($icon); ?>" style="color:var(--primary-light)"></i>
                                </div>
                                <span style="font-weight:600"><?php echo e($k->nama_kategori); ?></span>
                            </div>
                        </td>
                        <td style="color:var(--text-muted);font-size:13px"><?php echo e(Str::limit($k->deskripsi ?? '-', 60)); ?></td>
                        <td>
                            <div style="display:flex;gap:6px">
                                <a href="<?php echo e(route('superadmin.kategori.edit', $k->id_kategori)); ?>" class="btn btn-sm btn-secondary"><i class="fa-solid fa-pen"></i></a>
                                <form method="POST" action="<?php echo e(route('superadmin.kategori.destroy', $k->id_kategori)); ?>" style="display:inline">
                                    <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                    <button class="btn btn-sm btn-danger" onclick="return confirm('Hapus kategori <?php echo e($k->nama_kategori); ?>?')">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr><td colspan="4" style="text-align:center;color:var(--text-muted);padding:40px">Belum ada kategori.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- QUICK INFO -->
    <div>
        <div class="card">
            <div class="card-title" style="margin-bottom:12px">Contoh Kategori</div>
            <div style="display:flex;flex-direction:column;gap:8px">
                <?php $__currentLoopData = ['Listrik','Air','AC','Meja','Kursi','Proyektor','Jaringan Internet']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $contoh): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div style="padding:8px 12px;border-radius:8px;background:rgba(255,255,255,0.03);font-size:13px;color:var(--text-muted)">
                    <i class="fa-solid fa-circle-dot" style="color:var(--primary-light);margin-right:8px;font-size:8px"></i> <?php echo e($contoh); ?>

                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('superadmin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\aqas\resources\views/superadmin/kategori/index.blade.php ENDPATH**/ ?>