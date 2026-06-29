<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo $__env->yieldContent('title', 'Sistem Pelaporan Fasilitas'); ?></title>
  <link rel="stylesheet" href="<?php echo e(asset('css/dashboard.css')); ?>">
  <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body>

  <div class="container">

    <!-- SIDEBAR -->
    <aside class="sidebar" id="sidebar">

      <div class="sidebar-header">
        <h2>MENU</h2>
      </div>

      <div class="sidebar-menu">
        <?php echo $__env->yieldContent('sidebar-menu'); ?>
      </div>

      <div class="logout">
        <form action="<?php echo e(route('logout')); ?>" method="POST" style="display:inline">
          <?php echo csrf_field(); ?>
          <button type="submit" style="background:none;border:none;cursor:pointer;font-weight:bold;font-size:14px;">⤺ LOG OUT</button>
        </form>
      </div>

    </aside>

    <!-- MAIN -->
    <main class="main-content">

      <?php
          $layoutFotoUrl = '';
          $layoutUser = auth()->user();
          if ($layoutUser) {
              if (in_array($layoutUser->role, ['mahasiswa', 'dosen'])) {
                  $layoutMhs = \App\Models\Mahasiswa::where('Nim', $layoutUser->username)->first();
                  if ($layoutMhs && $layoutMhs->foto_profil) {
                      $layoutFotoUrl = asset('storage/' . $layoutMhs->foto_profil);
                  }
              } elseif (in_array($layoutUser->role, ['super_admin', 'admin', 'teknisi'])) {
                  if ($layoutUser->foto_profil) {
                      $layoutFotoUrl = asset('storage/' . $layoutUser->foto_profil);
                  }
              }
          }
      ?>

      <!-- HEADER -->
      <div class="header">

        <div class="menu-btn" onclick="toggleSidebar()">☰</div>

        <div class="title">
          <img src="<?php echo e(asset('images/logo.png')); ?>" alt="Logo">
          <h1>SISTEM PELAPORAN FASILITAS</h1>
        </div>

        <div class="profile-icon" onclick="toggleProfile()" <?php echo $layoutFotoUrl ? 'style="background-image: url(\''.$layoutFotoUrl.'\'); background-size: cover; background-position: center;"' : ''; ?>></div>

      </div>

      <?php echo $__env->yieldContent('content'); ?>

    </main>

  </div>

  <!-- PROFILE POPUP (global) -->
  <div class="profile-popup" id="profilePopup">
    <span class="close" onclick="toggleProfile()">×</span>
    <div class="profile-picture" <?php echo $layoutFotoUrl ? 'style="background-image: url(\''.$layoutFotoUrl.'\'); background-size: cover; background-position: center;"' : ''; ?>></div>
    <h3><?php echo $__env->yieldContent('profile-name'); ?></h3>
    <p><?php echo $__env->yieldContent('profile-role'); ?></p>
    <div class="profile-buttons">
      <?php echo $__env->yieldContent('profile-buttons'); ?>
      <form action="<?php echo e(route('logout')); ?>" method="POST">
        <?php echo csrf_field(); ?>
        <button type="submit">Log Out</button>
      </form>
    </div>
  </div>

  <script>
    function toggleSidebar() {
      document.getElementById('sidebar').classList.toggle('active');
    }
    function toggleProfile() {
      document.getElementById('profilePopup').classList.toggle('show');
    }
  </script>

  <?php echo $__env->yieldPushContent('scripts'); ?>

</body>
</html>
<?php /**PATH C:\xampp\htdocs\aqas\resources\views/layouts/dashboard.blade.php ENDPATH**/ ?>