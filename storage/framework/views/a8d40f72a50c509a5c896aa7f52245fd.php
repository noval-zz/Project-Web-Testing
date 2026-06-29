<?php $__env->startSection('title', 'Tambah Pengumuman Sarpras'); ?>

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
  .form-wrap {
    font-family: 'Inter', sans-serif;
    background: #F1F5F9;
    min-height: calc(100vh - 70px);
    padding: 28px 32px 48px;
  }
  .form-card {
    background: #fff;
    border: 1px solid #E2E8F0;
    border-radius: 16px;
    padding: 32px;
    max-width: 720px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.06);
  }
  .form-card h2 {
    font-size: 18px;
    font-weight: 800;
    color: #0F172A;
    margin: 0 0 24px;
    display: flex;
    align-items: center;
    gap: 10px;
  }
  .form-card h2 i { color: #2563EB; }
  .form-group { margin-bottom: 18px; }
  .form-group label {
    display: block;
    font-size: 13px;
    font-weight: 600;
    color: #374151;
    margin-bottom: 6px;
  }
  .form-group input,
  .form-group textarea,
  .form-group select {
    width: 100%;
    border: 1.5px solid #E2E8F0;
    border-radius: 10px;
    padding: 10px 14px;
    font-size: 13px;
    font-family: 'Inter', sans-serif;
    color: #0F172A;
    background: #fff;
    transition: border-color .2s, box-shadow .2s;
    outline: none;
  }
  .form-group input:focus,
  .form-group textarea:focus,
  .form-group select:focus {
    border-color: #2563EB;
    box-shadow: 0 0 0 3px rgba(37,99,235,0.10);
  }
  .form-group textarea { resize: vertical; min-height: 120px; }
  .error-msg { font-size: 11.5px; color: #DC2626; margin-top: 4px; }
  .form-actions { display: flex; gap: 12px; margin-top: 24px; }
  .btn-submit {
    background: #2563EB;
    color: #fff;
    border: none;
    border-radius: 10px;
    padding: 11px 28px;
    font-size: 13px;
    font-weight: 700;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    transition: background .2s, transform .15s;
  }
  .btn-submit:hover { background: #1D4ED8; transform: translateY(-1px); }
  .btn-cancel {
    background: #F1F5F9;
    color: #64748B;
    border: 1px solid #E2E8F0;
    border-radius: 10px;
    padding: 11px 20px;
    font-size: 13px;
    font-weight: 600;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    transition: background .15s;
  }
  .btn-cancel:hover { background: #E2E8F0; }
  .breadcrumb {
    font-size: 12px;
    color: #94A3B8;
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    gap: 6px;
  }
  .breadcrumb a { color: #2563EB; text-decoration: none; }
  .breadcrumb a:hover { text-decoration: underline; }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="form-wrap">

  
  <div class="breadcrumb">
    <a href="<?php echo e(route('admin.dashboard')); ?>">Dashboard</a>
    <i class="fa-solid fa-chevron-right" style="font-size:9px"></i>
    <a href="<?php echo e(route('admin.pengumuman.index')); ?>">Pengumuman</a>
    <i class="fa-solid fa-chevron-right" style="font-size:9px"></i>
    <span>Tambah Baru</span>
  </div>

  <div class="form-card">
    <h2><i class="fa-solid fa-bullhorn"></i> Tambah Pengumuman Sarpras</h2>

    <form action="<?php echo e(route('admin.pengumuman.store')); ?>" method="POST">
      <?php echo csrf_field(); ?>

      
      <div class="form-group">
        <label for="judul">Judul Pengumuman <span style="color:#DC2626">*</span></label>
        <input type="text" id="judul" name="judul" placeholder="Contoh: Perbaikan Jaringan Internet Kampus"
               value="<?php echo e(old('judul')); ?>" maxlength="200">
        <?php $__errorArgs = ['judul'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="error-msg"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
      </div>

      
      <div class="form-group">
        <label for="isi">Isi Pengumuman <span style="color:#DC2626">*</span></label>
        <textarea id="isi" name="isi" placeholder="Tulis isi pengumuman secara detail..."><?php echo e(old('isi')); ?></textarea>
        <?php $__errorArgs = ['isi'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="error-msg"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
      </div>

      
      <div class="form-group">
        <label for="tanggal_publish">Tanggal Publish <span style="color:#DC2626">*</span></label>
        <input type="date" id="tanggal_publish" name="tanggal_publish"
               value="<?php echo e(old('tanggal_publish', date('Y-m-d'))); ?>">
        <?php $__errorArgs = ['tanggal_publish'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="error-msg"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
      </div>

      
      <div class="form-group">
        <label for="status">Status <span style="color:#DC2626">*</span></label>
        <select id="status" name="status">
          <option value="aktif"    <?php echo e(old('status', 'aktif') === 'aktif' ? 'selected' : ''); ?>>✅ Aktif — Tampil di dashboard mahasiswa</option>
          <option value="nonaktif" <?php echo e(old('status') === 'nonaktif' ? 'selected' : ''); ?>>⛔ Nonaktif — Disembunyikan dari mahasiswa</option>
        </select>
        <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="error-msg"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
      </div>

      <div class="form-actions">
        <button type="submit" class="btn-submit" id="btn-simpan-pengumuman">
          <i class="fa-solid fa-floppy-disk"></i> Simpan Pengumuman
        </button>
        <a href="<?php echo e(route('admin.pengumuman.index')); ?>" class="btn-cancel">
          <i class="fa-solid fa-xmark"></i> Batal
        </a>
      </div>
    </form>
  </div>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\laravel - Copy (2)\resources\views/admin/pengumuman/create.blade.php ENDPATH**/ ?>