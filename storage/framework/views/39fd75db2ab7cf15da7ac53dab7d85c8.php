<?php $__env->startSection('title', 'Detail Tugas #<?php echo e(str_pad($laporan->id_laporan, 5, "0", STR_PAD_LEFT)); ?> — Teknisi'); ?>

<?php $__env->startPush('styles'); ?>
  <link rel="stylesheet" href="<?php echo e(asset('css/teknisi-dashboard.css')); ?>">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('sidebar-menu'); ?>
  <a href="<?php echo e(route('teknisi.dashboard')); ?>"><button>🏠 Dashboard</button></a>
  <a href="<?php echo e(route('teknisi.tugas')); ?>"><button class="active-menu">🔧 Tugas Saya</button></a>
  <a href="<?php echo e(route('teknisi.profil.edit')); ?>"><button>👤 Profil</button></a>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('profile-name'); ?> <?php echo e($user->nama ?? $user->username); ?> <?php $__env->stopSection(); ?>
<?php $__env->startSection('profile-role'); ?> Teknisi Fasilitas <?php $__env->stopSection(); ?>
<?php $__env->startSection('profile-buttons'); ?>
  <a href="<?php echo e(route('teknisi.dashboard')); ?>"><button>🏠 Dashboard</button></a>
  <a href="<?php echo e(route('teknisi.profil.edit')); ?>"><button>👤 Edit Profil</button></a>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<?php
  $pr = $laporan->Tingkat_Kerusakan ?? 'Rendah';
  $prioClass = match($pr) {
    'Rendah' => 'prio-rendah',
    'Sedang' => 'prio-sedang',
    'Parah'  => 'prio-tinggi',
    default  => 'prio-rendah'
  };
  $st = $laporan->Status_terkini ?? '';
  $isSelesai = ($st === 'Selesai');
  $isProses  = ($st === 'Dalam Pengerjaan');
  $isBaru    = ($st === 'Sedang Diperbaiki');

  $stClass = match(true) {
    $isSelesai => 'st-selesai',
    $isProses  => 'st-proses',
    $isBaru    => 'st-menunggu',
    default    => 'st-baru'
  };
  $stLabel = match(true) {
    $isSelesai => 'Selesai',
    $isProses  => 'Dalam Pengerjaan',
    $isBaru    => 'Menunggu Penanganan',
    default    => $st
  };

  // Timeline step
  $step0 = 'tl-done';   // Laporan Masuk (selalu done)
  $step1 = 'tl-done';   // Disposisi Admin (sudah done karena laporan ada)
  $step2 = match(true) {
    $isSelesai => 'tl-done',
    $isProses  => 'tl-active',
    default    => 'tl-pending'
  };
  $step3 = $isSelesai ? 'tl-done' : 'tl-pending';
  $step4 = $isSelesai ? 'tl-selesai' : 'tl-pending';

  $tiket = 'RPT-' . str_pad($laporan->id_laporan, 5, '0', STR_PAD_LEFT);
?>

<div class="tek-wrap">

  
  <?php if(session('success')): ?>
    <div class="tek-alert alert-success">✅ <?php echo e(session('success')); ?></div>
  <?php endif; ?>

  
  <nav class="tek-breadcrumb">
    <a href="<?php echo e(route('teknisi.dashboard')); ?>">🏠 Dashboard</a>
    <span class="sep">›</span>
    <a href="<?php echo e(route('teknisi.tugas')); ?>">🔧 Tugas Saya</a>
    <span class="sep">›</span>
    <span class="current"><?php echo e($tiket); ?></span>
  </nav>

  
  <div class="tek-page-title">
    <div>
      <h1>🗂 Detail Laporan <span style="color:var(--tek-primary-light);font-size:18px;"><?php echo e($tiket); ?></span></h1>
      <div class="page-subtitle">
        Laporan diterima <?php echo e($laporan->created_at->diffForHumans()); ?> — <?php echo e($laporan->created_at->format('d M Y, H:i')); ?> WITA
      </div>
    </div>
    <div class="page-actions">
      <span class="priority-badge <?php echo e($prioClass); ?>" style="font-size:12px;"><?php echo e($pr); ?></span>
      <span class="status-badge <?php echo e($stClass); ?>" style="font-size:12px;"><?php echo e($stLabel); ?></span>
    </div>
  </div>

  
  <div class="tek-panel" style="margin-bottom:24px;">
    <div class="tek-panel-header">
      <h3>📊 Progress Status Laporan</h3>
    </div>
    <div class="tek-panel-body">
      <div class="tek-timeline">

        <div class="tek-timeline-step <?php echo e($step0); ?>">
          <div class="tl-circle">📩</div>
          <div>
            <div class="tl-label">Laporan Masuk</div>
            <div class="tl-sub"><?php echo e($step0 === 'tl-done' ? '✓ Diterima' : 'Menunggu'); ?></div>
          </div>
        </div>

        <div class="tek-timeline-step <?php echo e($step1); ?>">
          <div class="tl-circle">📋</div>
          <div>
            <div class="tl-label">Disposisi Admin</div>
            <div class="tl-sub"><?php echo e($step1 === 'tl-done' ? '✓ Ditugaskan' : 'Menunggu'); ?></div>
          </div>
        </div>

        <div class="tek-timeline-step <?php echo e($step2); ?>">
          <div class="tl-circle">🔧</div>
          <div>
            <div class="tl-label">Dalam Pengerjaan</div>
            <div class="tl-sub"><?php echo e($step2 === 'tl-done' ? '✓ Selesai dikerjakan' : ($step2 === 'tl-active' ? '⚙️ Sedang dikerjakan' : 'Belum dimulai')); ?></div>
          </div>
        </div>

        <div class="tek-timeline-step <?php echo e($step3); ?>">
          <div class="tl-circle">📸</div>
          <div>
            <div class="tl-label">Upload Bukti</div>
            <div class="tl-sub"><?php echo e($step3 === 'tl-done' ? '✓ Foto diunggah' : 'Menunggu'); ?></div>
          </div>
        </div>

        <div class="tek-timeline-step <?php echo e($step4); ?>">
          <div class="tl-circle">✅</div>
          <div>
            <div class="tl-label">Selesai</div>
            <div class="tl-sub"><?php echo e($step4 === 'tl-selesai' ? '🎉 Notifikasi terkirim' : 'Belum selesai'); ?></div>
          </div>
        </div>

      </div>
    </div>
  </div>

  
  <div class="tek-detail-grid">

    
    <div>
      
      <div class="tek-panel" style="margin-bottom:20px;">
        <div class="tek-panel-header">
          <h3>📋 Informasi Laporan</h3>
        </div>
        <div class="tek-panel-body">

          <div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;">

            <div class="info-group">
              <div class="info-label">ID Laporan</div>
              <div class="info-value"><span class="ticket-badge" style="font-size:13px;padding:5px 10px;"><?php echo e($tiket); ?></span></div>
            </div>

            <div class="info-group">
              <div class="info-label">Status Saat Ini</div>
              <div class="info-value"><span class="status-badge <?php echo e($stClass); ?>" style="font-size:12px;"><?php echo e($stLabel); ?></span></div>
            </div>

            <div class="info-group">
              <div class="info-label">Jenis Fasilitas</div>
              <div class="info-value"><?php echo e(ucfirst(($laporan->kategori->nama_kategori ?? 'Tidak diketahui') . ($laporan->subkategori ? ' — ' . $laporan->subkategori->nama_sub_kategori : ''))); ?></div>
            </div>

            <div class="info-group">
              <div class="info-label">Tingkat Prioritas</div>
              <div class="info-value">
                <span class="priority-badge <?php echo e($prioClass); ?>" style="font-size:12px;"><?php echo e($pr); ?></span>
              </div>
            </div>

          </div>

          <div class="info-divider"></div>

          <div class="info-group">
            <div class="info-label">📍 Lokasi Kerusakan</div>
            <div class="info-value" style="display:flex;align-items:center;gap:10px;flex-wrap:wrap;">
              <?php if($laporan->lokasi): ?>
                <span style="background:var(--tek-primary-soft);color:var(--tek-primary);padding:6px 12px;border-radius:var(--radius-md);font-size:13px;font-weight:600;">
                  🏢 <?php echo e($laporan->lokasi->nama_gedung); ?>

                </span>
                <span style="color:var(--gray-400);">›</span>
                <span style="background:var(--gray-100);padding:6px 12px;border-radius:var(--radius-md);font-size:13px;font-weight:600;color:var(--gray-700);">
                  🚪 <?php echo e($laporan->lokasi->nama_ruangan); ?>

                </span>
              <?php else: ?>
                <span style="color:var(--gray-400);">Lokasi tidak tersedia</span>
              <?php endif; ?>
            </div>
          </div>

          <div class="info-group">
            <div class="info-label">📝 Deskripsi Kerusakan</div>
            <div style="background:var(--gray-50);border-radius:var(--radius-md);padding:14px 16px;font-size:13.5px;color:var(--gray-700);line-height:1.7;border-left:3px solid var(--tek-primary);">
              <?php echo e($laporan->deskripsi ?? 'Tidak ada deskripsi.'); ?>

            </div>
          </div>

          <div class="info-divider"></div>

          <div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;">
            <div class="info-group">
              <div class="info-label">👤 Nama Pelapor</div>
              <div class="info-value" style="display:flex; align-items:center; gap:10px;">
                <?php if($laporan->mahasiswa?->foto_profil): ?>
                  <img src="<?php echo e(asset('storage/' . $laporan->mahasiswa->foto_profil)); ?>" style="width:28px; height:28px; border-radius:50%; object-fit:cover; border:1px solid #e2e8f0;" alt="Foto">
                <?php else: ?>
                  <div style="width:28px; height:28px; border-radius:50%; background:linear-gradient(135deg, #2563EB, #7C3AED); display:flex; align-items:center; justify-content:center; color:#fff; font-weight:bold; font-size:12px;">
                    <?php echo e(strtoupper(substr($laporan->mahasiswa?->Nama_mahasiswa ?? 'A', 0, 1))); ?>

                  </div>
                <?php endif; ?>
                <?php echo e($laporan->mahasiswa->Nama_mahasiswa ?? 'Anonim'); ?>

              </div>
            </div>
            <div class="info-group">
              <div class="info-label">🪪 NIM Pelapor</div>
              <div class="info-value"><?php echo e($laporan->mahasiswa->Nim ?? '—'); ?></div>
            </div>
            <div class="info-group">
              <div class="info-label">📅 Tanggal Laporan</div>
              <div class="info-value"><?php echo e($laporan->created_at->format('d M Y')); ?></div>
            </div>
            <div class="info-group">
              <div class="info-label">🕐 Jam Masuk</div>
              <div class="info-value"><?php echo e($laporan->created_at->format('H:i')); ?> WITA</div>
            </div>
          </div>

        </div>
      </div>

      
      <div class="tek-panel">
        <div class="tek-panel-header">
          <h3>📸 Foto Kerusakan</h3>
        </div>
        <div class="tek-panel-body">
          <?php if($laporan->foto): ?>
            <div class="img-preview-box">
              <?php
                $fotoUrl = str_starts_with($laporan->foto, 'http')
                    ? $laporan->foto
                    : asset('storage/' . $laporan->foto);
              ?>
              <img src="<?php echo e($fotoUrl); ?>" alt="Foto kerusakan <?php echo e($tiket); ?>">
              <div class="img-caption">📸 Foto kerusakan dilaporkan</div>
            </div>
            <div style="margin-top:10px;text-align:center;">
              <a href="<?php echo e($fotoUrl); ?>" target="_blank" class="btn-outline btn-sm">
                🔍 Buka Gambar Penuh
              </a>
            </div>
          <?php else: ?>
            <div class="img-preview-box">
              <div class="img-no-photo">
                <span style="font-size:40px;">📷</span>
                <span>Tidak ada foto yang dilampirkan</span>
              </div>
            </div>
          <?php endif; ?>
        </div>
      </div>

    </div>

    
    <div>

      
      <div class="tek-panel" style="margin-bottom:16px;">
        <div class="tek-panel-header">
          <h3>⚡ Aksi Teknisi</h3>
        </div>
        <div class="tek-panel-body">

          <?php if($isSelesai): ?>
            
            <div class="tek-alert alert-success" style="margin-bottom:12px;">
              🎉 Laporan ini sudah diselesaikan. Pekerjaan luar biasa!
            </div>
            <div style="background:var(--tek-success-soft);border-radius:var(--radius-md);padding:16px;text-align:center;">
              <div style="font-size:40px;margin-bottom:8px;">✅</div>
              <div style="font-size:14px;font-weight:700;color:#065F46;">Tugas Selesai</div>
              <div style="font-size:12px;color:#6EE7B7;margin-top:4px;">Notifikasi telah dikirim ke mahasiswa & admin</div>
            </div>

          <?php elseif($isProses): ?>
            
            <div class="tek-alert alert-warning" style="margin-bottom:16px;">
              ⚙️ Laporan ini sedang dalam pengerjaan. Upload foto bukti untuk menyelesaikan.
            </div>
            <a href="<?php echo e(route('teknisi.form-selesai', $laporan->id_laporan)); ?>"
               class="btn-success" id="btn-selesai-tugas"
               style="width:100%;justify-content:center;padding:14px;font-size:14px;">
              📸 Upload Bukti & Selesaikan Tugas
            </a>

          <?php else: ?>
            
            <div class="tek-alert alert-info" style="margin-bottom:16px;">
              📋 Laporan ini belum mulai dikerjakan. Tekan tombol di bawah untuk memulai.
            </div>
            <button type="button"
                    class="btn-primary" id="btn-mulai-perbaikan"
                    style="width:100%;justify-content:center;padding:14px;font-size:14px;"
                    onclick="openMulaiModal()">
              🔧 Mulai Perbaikan
            </button>
          <?php endif; ?>

          <div class="info-divider"></div>

          <a href="<?php echo e(route('teknisi.tugas')); ?>" class="btn-outline" style="width:100%;justify-content:center;">
            ← Kembali ke Daftar Tugas
          </a>

        </div>
      </div>

      
      <div class="tek-panel">
        <div class="tek-panel-header">
          <h3>📊 Ringkasan</h3>
        </div>
        <div class="tek-panel-body">
          <div style="display:flex;flex-direction:column;gap:12px;">
            <div style="display:flex;align-items:center;justify-content:space-between;padding:10px 12px;background:var(--gray-50);border-radius:var(--radius-md);">
              <span style="font-size:12px;color:var(--gray-500);font-weight:600;">ID Laporan</span>
              <span class="ticket-badge"><?php echo e($tiket); ?></span>
            </div>
            <div style="display:flex;align-items:center;justify-content:space-between;padding:10px 12px;background:var(--gray-50);border-radius:var(--radius-md);">
              <span style="font-size:12px;color:var(--gray-500);font-weight:600;">Prioritas</span>
              <span class="priority-badge <?php echo e($prioClass); ?>" style="font-size:11px;"><?php echo e($pr); ?></span>
            </div>
            <div style="display:flex;align-items:center;justify-content:space-between;padding:10px 12px;background:var(--gray-50);border-radius:var(--radius-md);">
              <span style="font-size:12px;color:var(--gray-500);font-weight:600;">Status</span>
              <span class="status-badge <?php echo e($stClass); ?>" style="font-size:11px;"><?php echo e($stLabel); ?></span>
            </div>
            <div style="display:flex;align-items:center;justify-content:space-between;padding:10px 12px;background:var(--gray-50);border-radius:var(--radius-md);">
              <span style="font-size:12px;color:var(--gray-500);font-weight:600;">Durasi</span>
              <span style="font-size:12px;font-weight:700;color:var(--gray-700);"><?php echo e($laporan->created_at->diffForHumans()); ?></span>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>

</div>


<?php if(!$isSelesai && !$isProses): ?>
<div class="tek-modal-overlay" id="mulaiModal">
  <div class="tek-modal">
    <div class="tek-modal-icon">🔧</div>
    <h3>Mulai Perbaikan?</h3>
    <p>
      Anda akan mengubah status laporan <strong><?php echo e($tiket); ?></strong> menjadi
      <strong>"Dalam Pengerjaan"</strong>. Status ini akan terlihat oleh mahasiswa pelapor dan admin.
    </p>
    <div class="tek-modal-actions">
      <button type="button" class="btn-outline" onclick="closeMulaiModal()">Batal</button>
      <form action="<?php echo e(route('teknisi.mulai', $laporan->id_laporan)); ?>" method="POST" style="display:inline;">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PATCH'); ?>
        <button type="submit" class="btn-primary" id="btn-konfirmasi-mulai">
          ✅ Ya, Mulai Sekarang
        </button>
      </form>
    </div>
  </div>
</div>
<?php endif; ?>

<?php $__env->startPush('scripts'); ?>
<script>
  function openMulaiModal() {
    document.getElementById('mulaiModal')?.classList.add('open');
  }
  function closeMulaiModal() {
    document.getElementById('mulaiModal')?.classList.remove('open');
  }
  // Close on overlay click
  document.getElementById('mulaiModal')?.addEventListener('click', function(e) {
    if (e.target === this) closeMulaiModal();
  });
</script>
<?php $__env->stopPush(); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\aqas\resources\views/Teknisi/detail.blade.php ENDPATH**/ ?>