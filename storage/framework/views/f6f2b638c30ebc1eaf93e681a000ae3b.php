<!DOCTYPE html>
<html lang="id">
<head>
  <link rel="icon" type="image/png" href="<?php echo e(asset('images/favicon.png')); ?>">
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register Mahasiswa — Sistem Pelaporan</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="<?php echo e(asset('css/style.css')); ?>">
  <style>
    .radio-group {
      display: flex;
      justify-content: center;
      gap: 20px;
      margin-bottom: 18px;
      font-size: 14px;
      color: #555;
    }
    .radio-group label { cursor: pointer; display: flex; align-items: center; gap: 6px; }
  </style>
</head>
<body>

<div class="container">

  <!-- LEFT -->
  <div class="left"></div>

  <!-- RIGHT -->
  <div class="right">

    <img class="logo" src="<?php echo e(asset('images/logo.png')); ?>" alt="logo">

    <div class="login-box">

      <div class="title">
        <h1>Buat Akun<br>Mahasiswa</h1>
      </div>

      <?php if($errors->any()): ?>
        <div style="background:#f8d7da;color:#721c24;padding:10px 15px;border-radius:8px;margin-bottom:14px;font-size:13px;">
          <?php echo e($errors->first()); ?>

        </div>
      <?php endif; ?>

      <form action="<?php echo e(route('register.mhs.post')); ?>" method="POST">
        <?php echo csrf_field(); ?>

        <div class="input-group">
          <input type="text"
                 name="nama_mhs"
                 placeholder="Nama Mahasiswa"
                 value="<?php echo e(old('nama_mhs')); ?>"
                 required>
        </div>

        <div class="input-group">
          <input type="number"
                 name="nim"
                 placeholder="NIM"
                 value="<?php echo e(old('nim')); ?>"
                 required>
        </div>

        <div class="input-group">
          <select name="prodi" required>
            <option disabled <?php echo e(old('prodi') ? '' : 'selected'); ?> value="">Program Studi</option>
            <?php $__currentLoopData = ['Ilmu Komputer', 'Sistem Informasi', 'Matematika', 'Sains Data']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <option value="<?php echo e($p); ?>" <?php echo e(old('prodi') == $p ? 'selected' : ''); ?>><?php echo e($p); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </select>
        </div>

        <div class="input-group">
          <input type="number"
                 name="kontak"
                 placeholder="Nomor Kontak"
                 value="<?php echo e(old('kontak')); ?>"
                 required>
        </div>

        <div class="input-group">
          <input type="password"
                 name="sandi"
                 placeholder="Password"
                 required>
        </div>

        <div class="radio-group">
          <label>
            <input type="radio" name="jenis_kelamin" value="L" <?php echo e(old('jenis_kelamin') == 'L' ? 'checked' : ''); ?> required>
            Laki-laki
          </label>
          <label>
            <input type="radio" name="jenis_kelamin" value="P" <?php echo e(old('jenis_kelamin') == 'P' ? 'checked' : ''); ?>>
            Perempuan
          </label>
        </div>

        <button type="submit" class="btn">REGISTER</button>

      </form>

      <div class="forgot">
        <a href="<?php echo e(route('login')); ?>">Sudah punya akun? Login</a>
      </div>

    </div>
  </div>
</div>

</body>
</html>

<?php /**PATH C:\xampp\htdocs\aqas\resources\views/auth/register-mhs.blade.php ENDPATH**/ ?>