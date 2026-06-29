<!DOCTYPE html>
<html lang="id">
<head>
  <link rel="icon" type="image/png" href="<?php echo e(asset('images/favicon.png')); ?>">
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Profil — <?php echo e($user->nama ?? $user->username); ?></title>
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
      transform: translateY(-1px);
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

    /* Tombol Warning (Ganti Password) */
    .btn-futuristic-warning {
      background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
      color: white;
      border: none;
      padding: 0.75rem 1.75rem;
      border-radius: 10px;
      font-weight: 600;
      letter-spacing: 0.5px;
      transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
      box-shadow: 0 4px 15px rgba(245, 158, 11, 0.3);
    }
    
    .btn-futuristic-warning:hover {
      transform: translateY(-3px) scale(1.02);
      box-shadow: 0 8px 25px rgba(245, 158, 11, 0.5);
      color: white;
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
      transform: translateX(-3px);
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

    .section-title {
      font-size: 1.1rem;
      font-weight: 700;
      color: #1e293b;
      margin-bottom: 1rem;
      border-bottom: 2px solid #e2e8f0;
      padding-bottom: 0.5rem;
      display: inline-block;
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
            <h4 class="mb-1 fw-bold text-white" style="letter-spacing: -0.5px;">Pengaturan Profil Teknisi</h4>
            <p class="mb-0 text-white-50 small">Pusat pembaruan informasi dan keamanan akun teknisi.</p>
          </div>
          <a href="<?php echo e(route('teknisi.dashboard')); ?>" class="btn btn-glass btn-sm fw-medium">
            <i class="bi bi-arrow-left me-1"></i> Kembali
          </a>
        </div>

        <div class="card-body p-4 p-md-5">

          <?php if(session('success')): ?>
            <div class="alert alert-success d-flex align-items-center alert-dismissible fade show mb-4" role="alert" style="border-radius: 12px;">
              <i class="bi bi-check-circle-fill me-2 fs-5"></i>
              <div><?php echo e(session('success')); ?></div>
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
          <?php endif; ?>

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

          <!-- FORM: FOTO PROFIL -->
          <div class="mb-5">
            <div class="section-title"><i class="bi bi-image me-2 text-primary"></i>Foto Profil</div>
            <form action="<?php echo e(route('teknisi.profil.foto')); ?>" method="POST" enctype="multipart/form-data">
              <?php echo csrf_field(); ?>
              <div class="d-flex align-items-center gap-3 avatar-container">
                <?php if($user->foto_profil): ?>
                  <img src="<?php echo e(asset('storage/' . $user->foto_profil)); ?>" class="avatar-preview" alt="Foto profil">
                <?php else: ?>
                  <div class="bg-primary-subtle d-flex align-items-center justify-content-center text-primary rounded-circle shadow-sm" style="width:65px; height:65px;">
                    <i class="bi bi-person-fill fs-3"></i>
                  </div>
                <?php endif; ?>
                <div class="flex-grow-1 row align-items-center">
                  <div class="col-md-8">
                    <input type="file" class="form-control" name="foto_profil" accept="image/*" required>
                    <div class="form-text mt-1" style="font-size: 0.75rem;">Ekstensi: PNG, JPG, JPEG. Maks 2MB.</div>
                  </div>
                  <div class="col-md-4 text-end mt-3 mt-md-0">
                    <button type="submit" class="btn btn-futuristic-primary btn-sm w-100 py-2">
                      <i class="bi bi-cloud-arrow-up me-1"></i> Upload
                    </button>
                  </div>
                </div>
              </div>
            </form>
          </div>

          <!-- FORM: DATA PROFIL -->
          <div class="mb-5">
            <div class="section-title"><i class="bi bi-person-lines-fill me-2 text-primary"></i>Informasi Dasar</div>
            <form action="<?php echo e(route('teknisi.profil.update')); ?>" method="POST">
              <?php echo csrf_field(); ?>
              <?php echo method_field('PUT'); ?>
              
              <div class="row">
                <div class="col-md-6 mb-4">
                  <label class="form-label">Username Login</label>
                  <input type="text" class="form-control text-muted" value="<?php echo e($user->username); ?>" disabled style="background-color: #e2e8f0; opacity: 0.7;">
                  <div class="form-text mt-1" style="font-size: 0.75rem;"><i class="bi bi-info-circle me-1"></i>Username bawaan tidak bisa diubah</div>
                </div>

                <div class="col-md-6 mb-4">
                  <label class="form-label">Nama Lengkap</label>
                  <input type="text" class="form-control" name="nama" value="<?php echo e(old('nama', $user->nama)); ?>" required placeholder="Nama lengkap Anda">
                </div>

                <div class="col-md-12 mb-4">
                  <label class="form-label">Alamat Email</label>
                  <input type="email" class="form-control" name="email" value="<?php echo e(old('email', $user->email)); ?>" placeholder="email@contoh.com">
                </div>
              </div>

              <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-futuristic-primary">
                  <i class="bi bi-save2 me-1"></i> Simpan Profil
                </button>
              </div>
            </form>
          </div>

          <hr class="text-muted opacity-25 my-5">

          <!-- FORM: GANTI PASSWORD -->
          <div>
            <div class="section-title" style="color: #d97706; border-color: #fde68a;"><i class="bi bi-shield-lock-fill me-2 text-warning"></i>Keamanan (Ganti Password)</div>
            <form action="<?php echo e(route('teknisi.profil.password')); ?>" method="POST">
              <?php echo csrf_field(); ?>
              
              <div class="row">
                <div class="col-md-12 mb-4">
                  <label class="form-label">Password Lama</label>
                  <input type="password" class="form-control" name="password_lama" required placeholder="Masukkan password saat ini">
                </div>

                <div class="col-md-6 mb-4">
                  <label class="form-label">Password Baru</label>
                  <input type="password" class="form-control" name="password_baru" required placeholder="Minimal 6 karakter">
                </div>

                <div class="col-md-6 mb-4">
                  <label class="form-label">Konfirmasi Password Baru</label>
                  <input type="password" class="form-control" name="password_baru_confirmation" required placeholder="Ketik ulang password baru">
                </div>
              </div>

              <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-futuristic-warning">
                  <i class="bi bi-key-fill me-1"></i> Update Password
                </button>
              </div>
            </form>
          </div>

        </div>
      </div>

    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php /**PATH C:\xampp\htdocs\aqas\resources\views/Teknisi/profil.blade.php ENDPATH**/ ?>