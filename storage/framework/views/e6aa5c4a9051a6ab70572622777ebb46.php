<?php $__env->startSection('title', 'Kelola Pengumuman Sarpras'); ?>

<?php $__env->startSection('sidebar-menu'); ?>
  <a href="<?php echo e(route('admin.dashboard')); ?>"><button>Dashboard</button></a>
  <a href="<?php echo e(route('admin.pengumuman.index')); ?>"><button class="active-menu">📣 Pengumuman</button></a>
  <a href="<?php echo e(route('admin.mahasiswa')); ?>"><button>Daftar Mahasiswa</button></a>
  <a href="<?php echo e(route('admin.riwayat')); ?>"><button>Riwayat Laporan</button></a>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('profile-name'); ?> <?php echo e($user->nama ?? $user->username); ?> <?php $__env->stopSection(); ?>
<?php $__env->startSection('profile-role'); ?> Administrator Sarpras <?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
  * { box-sizing: border-box; }
  .peng-wrap {
    font-family: 'Inter', sans-serif;
    background: #F1F5F9;
    min-height: calc(100vh - 70px);
    padding: 28px 32px 48px;
  }
  .peng-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 24px;
    flex-wrap: wrap;
    gap: 12px;
  }
  .peng-header h1 {
    font-size: 22px;
    font-weight: 800;
    color: #0F172A;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 10px;
  }
  .peng-header h1 i { color: #2563EB; font-size: 20px; }
  .btn-tambah {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: #2563EB;
    color: #fff;
    border: none;
    border-radius: 10px;
    padding: 10px 20px;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    text-decoration: none;
    transition: background .2s, transform .15s;
  }
  .btn-tambah:hover { background: #1D4ED8; transform: translateY(-1px); }

  /* Flash */
  .flash-ok {
    background: #DCFCE7;
    border: 1px solid #86EFAC;
    color: #166534;
    padding: 12px 18px;
    border-radius: 10px;
    font-size: 13px;
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    gap: 10px;
  }

  /* Table card */
  .table-card {
    background: #fff;
    border: 1px solid #E2E8F0;
    border-radius: 14px;
    box-shadow: 0 1px 4px rgba(0,0,0,0.05);
    overflow: hidden;
  }
  .peng-table { width: 100%; border-collapse: collapse; font-size: 13px; }
  .peng-table thead th {
    padding: 12px 16px;
    text-align: left;
    font-size: 11px;
    font-weight: 700;
    color: #64748B;
    text-transform: uppercase;
    letter-spacing: .5px;
    background: #F8FAFC;
    border-bottom: 1px solid #E2E8F0;
  }
  .peng-table tbody td {
    padding: 14px 16px;
    border-bottom: 1px solid #F1F5F9;
    color: #334155;
    vertical-align: top;
  }
  .peng-table tbody tr:last-child td { border-bottom: none; }
  .peng-table tbody tr:hover { background: #F8FAFC; }

  /* Badge status */
  .badge-status {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    padding: 3px 10px;
    border-radius: 999px;
    font-size: 11px;
    font-weight: 600;
    white-space: nowrap;
  }
  .badge-aktif    { background: #DCFCE7; color: #166534; }
  .badge-nonaktif { background: #F1F5F9; color: #64748B; }

  /* Action buttons */
  .act-btns { display: flex; gap: 8px; flex-wrap: wrap; }
  .btn-edit, .btn-hapus, .btn-toggle {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 5px 12px;
    border-radius: 7px;
    font-size: 12px;
    font-weight: 600;
    cursor: pointer;
    text-decoration: none;
    border: none;
    transition: opacity .15s, transform .15s;
  }
  .btn-edit:hover, .btn-hapus:hover, .btn-toggle:hover {
    opacity: .85;
    transform: translateY(-1px);
  }
  .btn-edit   { background: #EFF6FF; color: #2563EB; }
  .btn-hapus  { background: #FEF2F2; color: #DC2626; }
  .btn-toggle { background: #F0FDF4; color: #16A34A; }

  /* Judul truncate */
  .judul-cell { font-weight: 600; color: #0F172A; max-width: 220px; }
  .isi-cell   { font-size: 12px; color: #64748B; max-width: 320px; white-space: pre-line; }

  /* Pagination */
  .peng-pagination {
    display: flex;
    justify-content: center;
    padding: 20px 0 0;
    gap: 6px;
  }
  .peng-pagination a, .peng-pagination span {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 34px; height: 34px;
    border-radius: 8px;
    font-size: 13px;
    font-weight: 600;
    text-decoration: none;
    border: 1px solid #E2E8F0;
    color: #334155;
    background: #fff;
    transition: all .15s;
  }
  .peng-pagination a:hover { background: #EFF6FF; border-color: #BFDBFE; color: #2563EB; }
  .peng-pagination span.active { background: #2563EB; border-color: #2563EB; color: #fff; }

  /* Empty */
  .empty-state {
    text-align: center;
    padding: 52px 24px;
    color: #94A3B8;
  }
  .empty-state i { font-size: 40px; margin-bottom: 12px; display: block; color: #CBD5E1; }
  .empty-state h4 { font-size: 15px; font-weight: 600; margin: 0 0 6px; color: #64748B; }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="peng-wrap">

  
  <div class="peng-header">
    <h1><i class="fa-solid fa-bullhorn"></i> Kelola Pengumuman Sarpras</h1>
    <a href="<?php echo e(route('admin.pengumuman.create')); ?>" class="btn-tambah">
      <i class="fa-solid fa-plus"></i> Tambah Pengumuman
    </a>
  </div>

  
  <?php if(session('success')): ?>
    <div class="flash-ok">
      <i class="fa-solid fa-circle-check"></i> <?php echo e(session('success')); ?>

    </div>
  <?php endif; ?>

  
  <div class="table-card">
    <?php if($pengumumanList->isEmpty()): ?>
      <div class="empty-state">
        <i class="fa-solid fa-bullhorn"></i>
        <h4>Belum Ada Pengumuman</h4>
        <p>Klik tombol <strong>Tambah Pengumuman</strong> untuk membuat pengumuman pertama.</p>
      </div>
    <?php else: ?>
      <table class="peng-table">
        <thead>
          <tr>
            <th>#</th>
            <th>Judul</th>
            <th>Isi</th>
            <th>Tanggal</th>
            <th>Status</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php $__currentLoopData = $pengumumanList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <tr>
            <td style="color:#94A3B8;font-size:12px;">
              <?php echo e($pengumumanList->firstItem() + $i); ?>

            </td>
            <td>
              <div class="judul-cell"><?php echo e($p->judul); ?></div>
            </td>
            <td>
              <div class="isi-cell"><?php echo e(Str::limit($p->isi, 100)); ?></div>
            </td>
            <td style="white-space:nowrap;font-size:12px;color:#64748B;">
              <i class="fa-regular fa-calendar" style="color:#2563EB"></i>
              <?php echo e($p->tanggal_publish->translatedFormat('d M Y')); ?>

            </td>
            <td>
              <?php if($p->status === 'aktif'): ?>
                <span class="badge-status badge-aktif"><i class="fa-solid fa-circle" style="font-size:6px"></i> Aktif</span>
              <?php else: ?>
                <span class="badge-status badge-nonaktif"><i class="fa-regular fa-circle" style="font-size:6px"></i> Nonaktif</span>
              <?php endif; ?>
            </td>
            <td>
              <div class="act-btns">
                
                <a href="<?php echo e(route('admin.pengumuman.edit', $p->id_pengumuman)); ?>" class="btn-edit">
                  <i class="fa-solid fa-pen"></i> Edit
                </a>

                
                <form action="<?php echo e(route('admin.pengumuman.toggle', $p->id_pengumuman)); ?>" method="POST" style="display:inline;">
                  <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
                  <button type="submit" class="btn-toggle" title="Ubah Status">
                    <i class="fa-solid fa-toggle-<?php echo e($p->status === 'aktif' ? 'on' : 'off'); ?>"></i>
                    <?php echo e($p->status === 'aktif' ? 'Nonaktifkan' : 'Aktifkan'); ?>

                  </button>
                </form>

                
                <form action="<?php echo e(route('admin.pengumuman.destroy', $p->id_pengumuman)); ?>" method="POST"
                      style="display:inline;"
                      onsubmit="return confirm('Yakin ingin menghapus pengumuman ini?')">
                  <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                  <button type="submit" class="btn-hapus">
                    <i class="fa-solid fa-trash"></i> Hapus
                  </button>
                </form>
              </div>
            </td>
          </tr>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
      </table>

      
      <?php if($pengumumanList->hasPages()): ?>
        <div class="peng-pagination">
          <?php echo e($pengumumanList->links('pagination::simple-default')); ?>

        </div>
      <?php endif; ?>

    <?php endif; ?>
  </div>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\laravel - Copy (2)\resources\views/admin/pengumuman/index.blade.php ENDPATH**/ ?>