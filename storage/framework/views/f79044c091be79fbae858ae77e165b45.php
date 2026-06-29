<?php $__env->startSection('title', 'Buat Laporan — Sistem Pelaporan Fasilitas'); ?>

<?php $__env->startPush('styles'); ?>
  <link rel="stylesheet" href="<?php echo e(asset('css/buat-laporan.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('sidebar-menu'); ?>
  <a href="<?php echo e(route('mahasiswa.dashboard')); ?>">
    <button>🏠 Dashboard</button>
  </a>
  <a href="<?php echo e(route('laporan.create')); ?>">
    <button class="active-menu">📋 Buat Laporan</button>
  </a>
  <a href="<?php echo e(route('laporan.pantau')); ?>">
    <button>🔍 Pantau Laporan</button>
  </a>
  <a href="<?php echo e(route('laporan.status')); ?>">
    <button>📂 Riwayat Laporan</button>
  </a>
  <a href="<?php echo e(route('mahasiswa.ganti.password')); ?>">
    <button style="background:rgba(255,243,205,.1);color:#FCD34D;">🔑 Ganti Password</button>
  </a>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('profile-name'); ?> <?php echo e($mhs->Nama_mahasiswa ?? $user->username); ?> <?php $__env->stopSection(); ?>
<?php $__env->startSection('profile-role'); ?> <?php echo e($mhs->Nim ?? ''); ?> <?php $__env->stopSection(); ?>
<?php $__env->startSection('profile-buttons'); ?>
  <a href="<?php echo e(route('mahasiswa.biodata', $mhs->id_mahasiswa ?? 0)); ?>"><button>Edit Profile</button></a>
  <a href="<?php echo e(route('mahasiswa.ganti.password')); ?>"><button>🔑 Ganti Password</button></a>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<div class="laporan-wrapper">

  <div class="laporan-title">
    <h2>📋 BUAT LAPORAN KERUSAKAN</h2>
  </div>

  
  <?php if(session('success')): ?>
    <div class="alert-success">
      ✅ <?php echo e(session('success')); ?>

    </div>
  <?php endif; ?>

  <?php if($errors->any()): ?>
    <div class="alert-error">
      <strong>⚠️ Terdapat kesalahan pada form:</strong>
      <ul>
        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $err): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <li><?php echo e($err); ?></li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </ul>
    </div>
  <?php endif; ?>

  <div class="laporan-card">

    <div class="info-badge">
      ℹ️ Laporan Anda akan segera diproses oleh tim teknis kampus.
    </div>

    <form action="<?php echo e(route('laporan.store')); ?>" method="POST" enctype="multipart/form-data" id="form-laporan">
      <?php echo csrf_field(); ?>

      
      <div class="form-row">

        <div class="form-group">
          <label for="id_kategori">Kategori Fasilitas <span class="required">*</span></label>
          <select name="id_kategori" id="id_kategori" class="form-control" required>
            <option value="" disabled selected>-- Pilih Kategori --</option>
            <?php $__currentLoopData = $kategori; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $kat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <option value="<?php echo e($kat->id_kategori); ?>" <?php echo e(old('id_kategori') == $kat->id_kategori ? 'selected' : ''); ?>>
                <?php echo e(ucfirst($kat->nama_kategori)); ?>

              </option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </select>
        </div>

        <div class="form-group">
          <label for="id_lokasi">Lokasi / Ruangan <span class="required">*</span></label>
          <select name="id_lokasi" id="id_lokasi" class="form-control" required>
            <option value="" disabled selected>-- Pilih Lokasi --</option>
            <?php $__currentLoopData = $lokasi; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lok): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <option value="<?php echo e($lok->id_lokasi); ?>" <?php echo e(old('id_lokasi') == $lok->id_lokasi ? 'selected' : ''); ?>>
                <?php echo e($lok->nama_gedung); ?> — <?php echo e($lok->nama_ruangan); ?>

              </option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </select>
        </div>

      </div>

      
      <div class="form-group">
        <label for="deskripsi">Deskripsi Kerusakan <span class="required">*</span></label>
        <textarea
          name="deskripsi"
          id="deskripsi"
          class="form-control"
          placeholder="Jelaskan kerusakan secara detail, misalnya: Kursi pada baris ketiga kaki depan kiri patah sehingga tidak bisa digunakan..."
          required
        ><?php echo e(old('deskripsi')); ?></textarea>
        <small style="color:#9ca3af;font-size:12px;margin-top:4px;display:block;">
          Minimal 10 karakter. Semakin detail, semakin cepat ditangani.
        </small>
      </div>

      
      <div class="form-group">
        <label>Tingkat Kerusakan <span class="required">*</span></label>
        <div class="kerusakan-group">

          <div class="kerusakan-pill rendah">
            <input type="radio" name="Tingkat_Kerusakan" id="tk-rendah" value="Rendah"
              <?php echo e(old('Tingkat_Kerusakan') == 'Rendah' ? 'checked' : ''); ?>>
            <label for="tk-rendah">Rendah</label>
          </div>

          <div class="kerusakan-pill sedang">
            <input type="radio" name="Tingkat_Kerusakan" id="tk-sedang" value="Sedang"
              <?php echo e(old('Tingkat_Kerusakan') == 'Sedang' ? 'checked' : ''); ?>>
            <label for="tk-sedang">Sedang</label>
          </div>

          <div class="kerusakan-pill parah">
            <input type="radio" name="Tingkat_Kerusakan" id="tk-parah" value="Parah"
              <?php echo e(old('Tingkat_Kerusakan') == 'Parah' ? 'checked' : ''); ?>>
            <label for="tk-parah">Parah</label>
          </div>

        </div>
      </div>

      
      <div class="form-group">
        <label>Foto Kerusakan <span style="color:#9ca3af;font-weight:400;">(Opsional)</span></label>

        <div class="upload-area" id="upload-area">
          <input type="file" name="foto" id="foto-input" accept="image/*">
          <div class="upload-icon">📷</div>
          <p><strong>Klik untuk upload</strong> atau drag & drop foto di sini</p>
          <small>Format: JPG, PNG, WEBP — Maks. 3 MB</small>
        </div>

        <div id="preview-container">
          <img id="preview-img" src="" alt="Preview foto">
          <button type="button" id="remove-photo" title="Hapus foto">✕</button>
        </div>
      </div>

      <div class="form-divider"></div>

      
      <button type="submit" class="btn-submit" id="btn-submit">
        <span class="btn-icon">📤</span> Kirim Laporan
      </button>

    </form>

    <a href="<?php echo e(route('mahasiswa.dashboard')); ?>" class="cancel-link">
      ← Kembali ke Dashboard
    </a>

  </div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
  // ── Preview & Upload Photo ──
  const fotoInput  = document.getElementById('foto-input');
  const previewCon = document.getElementById('preview-container');
  const previewImg = document.getElementById('preview-img');
  const removeBtn  = document.getElementById('remove-photo');
  const uploadArea = document.getElementById('upload-area');

  fotoInput.addEventListener('change', function () {
    const file = this.files[0];
    if (file) {
      previewImg.src = URL.createObjectURL(file);
      previewCon.style.display = 'block';
      uploadArea.style.display = 'none';
    }
  });

  removeBtn.addEventListener('click', function () {
    fotoInput.value = '';
    previewImg.src = '';
    previewCon.style.display = 'none';
    uploadArea.style.display = 'block';
  });

  // Drag & Drop
  uploadArea.addEventListener('dragover', (e) => {
    e.preventDefault();
    uploadArea.classList.add('drag-over');
  });

  uploadArea.addEventListener('dragleave', () => {
    uploadArea.classList.remove('drag-over');
  });

  uploadArea.addEventListener('drop', (e) => {
    e.preventDefault();
    uploadArea.classList.remove('drag-over');
    const file = e.dataTransfer.files[0];
    if (file && file.type.startsWith('image/')) {
      fotoInput.files = e.dataTransfer.files;
      previewImg.src = URL.createObjectURL(file);
      previewCon.style.display = 'block';
      uploadArea.style.display = 'none';
    }
  });

  // ── Submit loading state ──
  document.getElementById('form-laporan').addEventListener('submit', function () {
    const btn = document.getElementById('btn-submit');
    btn.disabled = true;
    btn.innerHTML = '<span class="btn-icon">⏳</span> Mengirim...';
  });
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\laravel - Copy (2)\resources\views/laporan/create.blade.php ENDPATH**/ ?>