<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Biodata — <?php echo e($mhs->Nama_mahasiswa); ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  
  <style>
    body {
      background-color: #f0f4fd;
      font-family: 'Plus Jakarta Sans', 'Segoe UI', sans-serif;
    }
    
    /* Card dengan sudut melengkung halus & shadow modern */
    .card-custom {
      border: none;
      border-radius: 20px;
      overflow: hidden;
      box-shadow: 0 10px 30px rgba(13, 110, 253, 0.05);
    }
    
    /* Header Futuristik dengan Gradasi Cyber Blue & Pola Halus */
    .card-header-futuristic {
      background: linear-gradient(135deg, #0052d4 0%, #4364f7 50%, #6fb1fc 100%);
      border-bottom: none;
      position: relative;
    }
    
    .form-label {
      font-weight: 600;
      color: #2d3748;
      font-size: 0.875rem;
      letter-spacing: 0.3px;
    }
    
    /* Input Form dengan Efek Transisi Halus */
    .form-control, .form-select {
      border-radius: 10px;
      padding: 0.65rem 1rem;
      border: 1px solid #e2e8f0;
      background-color: #f8fafc;
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .form-control:focus, .form-select:focus {
      background-color: #fff;
      border-color: #4364f7;
      box-shadow: 0 0 0 4px rgba(67, 100, 247, 0.15);
      transform: translateY(-1px); /* Efek sedikit naik saat aktif */
    }

    /* Container Box untuk Radio & Checkbox */
    .custom-selection-box {
      background: #f8fafc;
      border: 1px solid #e2e8f0;
      border-radius: 10px;
      padding: 0.75rem;
    }

    /* ==========================================
       ANIMASI & GAYA TOMBOL (FUTURISTIK)
       ========================================== */
    
    /* Tombol Utama (Simpan) dengan Efek Glow & Scale */
    .btn-futuristic-primary {
      background: linear-gradient(135deg, #0052d4 0%, #4364f7 100%);
      color: white;
      border: none;
      padding: 0.75rem 1.75rem;
      border-radius: 10px;
      font-weight: 600;
      letter-spacing: 0.5px;
      transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
      box-shadow: 0 4px 15px rgba(67, 100, 247, 0.3);
    }
    
    .btn-futuristic-primary:hover {
      transform: translateY(-3px) scale(1.02);
      box-shadow: 0 8px 25px rgba(67, 100, 247, 0.5);
      color: white;
    }
    
    .btn-futuristic-primary:active {
      transform: translateY(-1px) scale(0.98);
    }

    /* Tombol Reset dengan Efek Fade & Slide Border */
    .btn-futuristic-secondary {
      background-color: #fff;
      color: #4a5568;
      border: 1px solid #e2e8f0;
      padding: 0.75rem 1.75rem;
      border-radius: 10px;
      font-weight: 600;
      transition: all 0.3s ease;
    }
    
    .btn-futuristic-secondary:hover {
      background-color: #f8fafc;
      color: #e53e3e;
      border-color: #fecaca;
      transform: translateY(-2px);
    }

    /* Tombol Kembali (Glassmorphism Ringan) */
    .btn-glass {
      background: rgba(255, 255, 255, 0.15);
      backdrop-filter: blur(5px);
      -webkit-backdrop-filter: blur(5px);
      border: 1px solid rgba(255, 255, 255, 0.25);
      color: white;
      border-radius: 8px;
      padding: 0.5rem 1rem;
      transition: all 0.3s ease;
    }

    .btn-glass:hover {
      background: rgba(255, 255, 255, 0.3);
      color: white;
      transform: translateX(-3px); /* Efek bergeser ke kiri menunjuk panah */
    }

    /* Avatar Preview Glow */
    .avatar-container {
      background: #f8fafc;
      border: 1px dashed #cbd5e1;
      border-radius: 12px;
      padding: 1rem;
      transition: all 0.3s ease;
    }
    
    .avatar-container:hover {
      border-color: #4364f7;
    }

    .avatar-preview {
      width: 65px;
      height: 65px;
      border-radius: 50%;
      object-fit: cover;
      border: 3px solid #fff;
      box-shadow: 0 4px 10px rgba(0, 82, 212, 0.2);
    }
  </style>
</head>
<body>

<div class="container mt-5 mb-5">
  <div class="row justify-content-center">
    <div class="col-lg-9">
      
      <div class="card card-custom bg-white">
        
        <div class="card-header card-header-futuristic py-4 px-4 d-flex justify-content-between align-items-center">
          <div>
            <h4 class="mb-1 fw-bold text-white" style="letter-spacing: -0.5px;">Edit Data Mahasiswa</h4>
            <p class="mb-0 text-white-50 small">Pusat pembaruan enkripsi data dan profil mahasiwa.</p>
          </div>
          <a href="<?php echo e(route('mahasiswa.dashboard')); ?>" class="btn btn-glass btn-sm fw-medium">
            <i class="bi bi-arrow-left me-1"></i> Kembali
          </a>
        </div>

        <div class="card-body p-4 p-md-5">

          <?php if($errors->any()): ?>
            <div class="alert alert-danger d-flex align-items-center alert-dismissible fade show mb-4" role="alert" style="border-radius: 12px;">
              <i class="bi bi-exclamation-triangle-fill me-2 fs-5"></i>
              <ul class="mb-0 ps-3">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $err): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <li><?php echo e($err); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </ul>
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
          <?php endif; ?>

          <form action="<?php echo e(route('mahasiswa.biodata.update', $mhs->id_mahasiswa)); ?>"
                method="POST"
                enctype="multipart/form-data">
            <?php echo csrf_field(); ?>

            <div class="row">
              
              <div class="col-md-6 mb-4">
                <label class="form-label">Nama Mahasiswa</label>
                <input type="text"
                       class="form-control"
                       name="Nama_mahasiswa"
                       required
                       placeholder="Nama lengkap tanpa gelar"
                       value="<?php echo e(old('Nama_mahasiswa', $mhs->Nama_mahasiswa)); ?>">
              </div>

              <div class="col-md-6 mb-4">
                <label class="form-label">NIM (Nomor Induk Mahasiswa)</label>
                <input type="number"
                       class="form-control"
                       name="Nim"
                       required
                       placeholder="Contoh: 210101xxx"
                       value="<?php echo e(old('Nim', $mhs->Nim)); ?>">
              </div>

              <div class="col-md-6 mb-4">
                <label class="form-label d-block mb-2">Jenis Kelamin</label>
                <div class="custom-selection-box d-flex align-items-center" style="height: calc(2.25rem + 14px);">
                  <div class="form-check form-check-inline me-4 ms-2">
                    <input class="form-check-input" type="radio" name="jenis_Kelamin" id="genderL" value="L"
                      <?php echo e(old('jenis_Kelamin', $mhs->jenis_kelamin) == 'L' ? 'checked' : ''); ?>>
                    <label class="form-check-label" for="genderL">Laki-laki</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="jenis_Kelamin" id="genderP" value="P"
                      <?php echo e(old('jenis_Kelamin', $mhs->jenis_kelamin) == 'P' ? 'checked' : ''); ?>>
                    <label class="form-check-label" for="genderP">Perempuan</label>
                  </div>
                </div>
              </div>

              <div class="col-md-6 mb-4">
                <label class="form-label">Tanggal Lahir</label>
                <input type="date"
                       class="form-control"
                       name="tanggal_lahir"
                       value="<?php echo e(old('tanggal_lahir', $mhs->tanggal_lahir)); ?>">
              </div>

              <div class="col-md-6 mb-4">
                <label class="form-label">Agama</label>
                <select class="form-select" name="agama">
                  <?php $__currentLoopData = ['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($ag); ?>"
                      <?php echo e(old('agama', $mhs->agama) == $ag ? 'selected' : ''); ?>>
                      <?php echo e($ag); ?>

                    </option>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
              </div>

              <div class="col-md-6 mb-4">
                <label class="form-label">Program Studi</label>
                <select class="form-select" name="prodi">
                  <?php $__currentLoopData = ['Ilmu Komputer', 'Sistem Informasi', 'Matematika', 'Sains Data']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($p); ?>"
                      <?php echo e(old('prodi', $mhs->prodi) == $p ? 'selected' : ''); ?>>
                      <?php echo e($p); ?>

                    </option>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
              </div>

              <div class="col-md-6 mb-4">
                <label class="form-label">Nomor Kontak / WhatsApp</label>
                <input type="number"
                       class="form-control"
                       name="Kontak"
                       placeholder="08xxxxxxxxxx"
                       value="<?php echo e(old('Kontak', $mhs->Kontak)); ?>">
              </div>

              <div class="col-md-6 mb-4">
                <label class="form-label d-block mb-2">Unit Kegiatan Mahasiswa (UKM)</label>
                <div class="custom-selection-box d-flex flex-wrap gap-3 align-items-center" style="min-height: calc(2.25rem + 14px);">
                  <?php $__currentLoopData = ['Seni', 'olahraga', 'Robotika']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $u): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="form-check m-0 ms-2">
                      <input class="form-check-input" type="checkbox" name="ukm[]" id="ukm_<?php echo e($u); ?>" value="<?php echo e($u); ?>"
                        <?php echo e(in_array($u, $ukm_array) ? 'checked' : ''); ?>>
                      <label class="form-check-label" for="ukm_<?php echo e($u); ?>"><?php echo e(ucfirst($u)); ?></label>
                    </div>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
              </div>

              <div class="col-12 mb-4">
                <label class="form-label">Foto Profil</label>
                <div class="d-flex align-items-center gap-3 avatar-container">
                  <?php if($mhs->foto_profil): ?>
                    <img src="<?php echo e(asset('storage/' . $mhs->foto_profil)); ?>" class="avatar-preview" alt="Foto profil">
                  <?php else: ?>
                    <div class="bg-primary-subtle d-flex align-items-center justify-content-center text-primary rounded-circle shadow-sm" style="width:65px; height:65px;">
                      <i class="bi bi-person-fill fs-3"></i>
                    </div>
                  <?php endif; ?>
                  <div class="flex-grow-1">
                    <input type="file" class="form-control" name="foto_profil" accept="image/*">
                    <div class="form-text mt-1" style="font-size: 0.75rem;">Ekstensi yang diizinkan: PNG, JPG, JPEG. Maks 2MB.</div>
                  </div>
                </div>
              </div>

            </div>

            <hr class="text-muted opacity-25 my-4">

            <div class="d-flex justify-content-end gap-3">
              <button type="reset" class="btn btn-futuristic-secondary">
                <i class="bi bi-arrow-counterclockwise me-1"></i> Reset
              </button>
              <button type="submit" class="btn btn-futuristic-primary">
                <i class="bi bi-cloud-arrow-up me-1"></i> Simpan Perubahan
              </button>
            </div>

          </form>

        </div>
      </div>

    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html><?php /**PATH C:\xampp\htdocs\laravel - Copy (2)\resources\views/mahasiswa/biodata.blade.php ENDPATH**/ ?>