<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Sistem Pelaporan</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="<?php echo e(asset('css/style.css')); ?>">
</head>
<body>

  <div class="container">

    <!-- LEFT SIDE -->
    <div class="left"></div>

    <!-- RIGHT SIDE -->
    <div class="right">

      <img class="logo" src="<?php echo e(asset('images/logo.png')); ?>" alt="logo">

      <div class="login-box">
        <div class="title">
          <h1>Masuk Kesistem<br>Pelaporan Fasilitas</h1>
        </div>

        
        <?php if(session('success')): ?>
          <div style="background:#d4edda;color:#155724;padding:10px 15px;border-radius:8px;margin-bottom:14px;font-size:13px;">
            <?php echo e(session('success')); ?>

          </div>
        <?php endif; ?>

        
        <?php if($errors->any()): ?>
          <div style="background:#f8d7da;color:#721c24;padding:10px 15px;border-radius:8px;margin-bottom:14px;font-size:13px;">
            <?php echo e($errors->first()); ?>

          </div>
        <?php endif; ?>

        <form action="<?php echo e(route('login.post')); ?>" method="POST">
          <?php echo csrf_field(); ?>

          <div class="input-group">
            <input type="text"
                   name="username"
                   placeholder="Username"
                   value="<?php echo e(old('username')); ?>"
                   required>
          </div>

          <div class="input-group">
            <input type="password"
                   name="password"
                   placeholder="Password"
                   required>
          </div>

          <div class="remember">
            <input type="checkbox" id="remember" name="remember">
            <label for="remember">Remember Me</label>
          </div>

          <div class="forgot">
            <a href="<?php echo e(route('register.mhs')); ?>">Daftar Akun Mahasiswa</a>
            &nbsp;|&nbsp;
            <a href="<?php echo e(route('reset.password')); ?>" style="color:#f59e0b;">🔑 Lupa Password?</a>
          </div>

          <button type="submit" class="btn">SIGN IN</button>
        </form>

      </div>
    </div>
  </div>

</body>
</html>
<?php /**PATH C:\xampp\htdocs\laravel - Copy (2)\resources\views/auth/login.blade.php ENDPATH**/ ?>