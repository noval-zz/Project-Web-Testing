<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Daftar Mahasiswa — Sistem Pelaporan Fasilitas</title>
  <link rel="stylesheet" href="<?php echo e(asset('css/hiasan.css')); ?>">
</head>
<body>

<div class="container">

  <div class="card">

    <div class="card-header">
      <h2>Data Mahasiswa</h2>
      <a href="<?php echo e(route('admin.dashboard')); ?>" class="btn-tambah">← Kembali</a>
    </div>

    <?php if(session('success')): ?>
      <div style="background:#d4edda;color:#155724;padding:12px 20px;font-size:14px;">
        <?php echo e(session('success')); ?>

      </div>
    <?php endif; ?>

    <div class="table-wrapper">
      <table class="table">
        <thead>
          <tr>
            <th>Nama</th>
            <th>NIM</th>
            <th>Gender</th>
            <th>Prodi</th>
            <th>Jumlah Laporan</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php $__empty_1 = true; $__currentLoopData = $mahasiswas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mhs): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr>
              <td><?php echo e($mhs->Nama_mahasiswa); ?></td>
              <td><?php echo e($mhs->Nim); ?></td>
              <td><?php echo e($mhs->jenis_kelamin == 'L' ? 'Laki-laki' : ($mhs->jenis_kelamin == 'P' ? 'Perempuan' : '-')); ?></td>
              <td><?php echo e($mhs->prodi ?? '-'); ?></td>
              <td>0</td>
              <td>
                <a href="<?php echo e(route('mahasiswa.biodata', $mhs->id_mahasiswa)); ?>"
                   class="btn btn-edit">Edit</a>

                <form action="<?php echo e(route('admin.mahasiswa.hapus', $mhs->id_mahasiswa)); ?>"
                      method="POST"
                      style="display:inline"
                      onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                  <?php echo csrf_field(); ?>
                  <?php echo method_field('DELETE'); ?>
                  <button type="submit" class="btn btn-hapus">Hapus</button>
                </form>
              </td>
            </tr>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr>
              <td colspan="6">Tidak ada data mahasiswa</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>

  </div>

</div>

</body>
</html>
<?php /**PATH C:\xampp\htdocs\aqas\resources\views/admin/mahasiswa.blade.php ENDPATH**/ ?>