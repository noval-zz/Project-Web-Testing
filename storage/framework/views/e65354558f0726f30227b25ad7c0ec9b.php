<?php $__env->startSection('title', 'Dashboard Teknisi — Sistem Pelaporan Fasilitas Kampus'); ?>

<?php $__env->startPush('styles'); ?>
  <link rel="stylesheet" href="<?php echo e(asset('css/teknisi-dashboard.css')); ?>">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
<?php $__env->stopPush(); ?>


<?php $__env->startSection('sidebar-menu'); ?>
  <a href="<?php echo e(route('teknisi.dashboard')); ?>">
    <button class="active-menu">🏠 Dashboard</button>
  </a>
  <a href="<?php echo e(route('teknisi.tugas')); ?>">
    <button>🔧 Tugas Saya</button>
  </a>
  <a href="<?php echo e(route('teknisi.tugas', ['status' => 'Dalam Pengerjaan'])); ?>">
    <button>⚙️ Dalam Pengerjaan</button>
  </a>
  <a href="<?php echo e(route('teknisi.tugas', ['status' => 'Selesai'])); ?>">
    <button>✅ Riwayat Selesai</button>
  </a>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('profile-name'); ?> <?php echo e($user->nama ?? $user->username); ?> <?php $__env->stopSection(); ?>
<?php $__env->startSection('profile-role'); ?> Teknisi Fasilitas <?php $__env->stopSection(); ?>
<?php $__env->startSection('profile-buttons'); ?>
  <a href="<?php echo e(route('teknisi.tugas')); ?>"><button>🔧 Tugas Saya</button></a>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>

<?php
  $now  = \Carbon\Carbon::now('Asia/Makassar');
  $hour = (int)$now->format('H');
  if      ($hour >= 5  && $hour < 12) $greeting = 'Selamat Pagi';
  elseif  ($hour >= 12 && $hour < 15) $greeting = 'Selamat Siang';
  elseif  ($hour >= 15 && $hour < 18) $greeting = 'Selamat Sore';
  else                                 $greeting = 'Selamat Malam';
?>

<div class="tek-wrap">

  
  <?php if(session('success')): ?>
    <div class="tek-alert alert-success" role="alert">
      <span><?php echo e(session('success')); ?></span>
    </div>
  <?php endif; ?>

  
  <div class="tek-welcome">
    <div class="tek-welcome-text">
      <div class="greeting"><?php echo e($greeting); ?>, 👷</div>
      <h2><?php echo e($user->nama ?? $user->username); ?></h2>
      <div class="sub-info">
        <span class="info-chip">🪪 Teknisi Fasilitas</span>
        <span class="info-chip">📅 <?php echo e($now->isoFormat('dddd, D MMMM Y')); ?></span>
        <span class="info-chip">🕐 <?php echo e($now->format('H:i')); ?> WITA</span>
      </div>
    </div>
    <div class="tek-welcome-actions">
      <a href="<?php echo e(route('teknisi.tugas')); ?>" class="btn-white">
        🔧 Lihat Tugas Saya
      </a>
      <a href="<?php echo e(route('teknisi.tugas', ['tingkat' => 'Parah'])); ?>" class="btn-ghost-white">
        🚨 Darurat (<?php echo e($darurat); ?>)
      </a>
    </div>
  </div>

  
  <div class="tek-stats-grid">

    <div class="tek-stat-card sc-total">
      <div class="tek-stat-icon">📋</div>
      <div class="tek-stat-info">
        <div class="tek-stat-number stat-animate"><?php echo e($totalTugas); ?></div>
        <div class="tek-stat-label">Total Tugas</div>
        <div class="tek-stat-sub">Semua laporan</div>
      </div>
    </div>

    <div class="tek-stat-card sc-proses">
      <div class="tek-stat-icon">⏳</div>
      <div class="tek-stat-info">
        <div class="tek-stat-number stat-animate"><?php echo e($tugasBaru); ?></div>
        <div class="tek-stat-label">Menunggu</div>
        <div class="tek-stat-sub">Perlu ditangani</div>
      </div>
    </div>

    <div class="tek-stat-card sc-done">
      <div class="tek-stat-icon">⚙️</div>
      <div class="tek-stat-info">
        <div class="tek-stat-number stat-animate"><?php echo e($dalamPengerjaan); ?></div>
        <div class="tek-stat-label">Dalam Pengerjaan</div>
        <div class="tek-stat-sub">Sedang dikerjakan</div>
      </div>
    </div>

    <div class="tek-stat-card sc-darurat">
      <div class="tek-stat-icon">🚨</div>
      <div class="tek-stat-info">
        <div class="tek-stat-number stat-animate"><?php echo e($darurat); ?></div>
        <div class="tek-stat-label">Prioritas Darurat</div>
        <div class="tek-stat-sub">Perlu segera</div>
      </div>
    </div>

  </div>

  
  <div class="tek-panel" style="margin-bottom:24px;">
    <div class="tek-panel-header">
      <h3>📊 Alur Penanganan Laporan</h3>
      <span style="font-size:12px;color:var(--gray-400);">Status progress per laporan</span>
    </div>
    <div class="tek-panel-body">
      <div class="tek-timeline" id="flow-timeline">

        
        <div class="tek-timeline-step tl-done">
          <div class="tl-circle">📩</div>
          <div>
            <div class="tl-label">Laporan Masuk</div>
            <div class="tl-sub">✓ Diterima sistem</div>
          </div>
        </div>

        
        <div class="tek-timeline-step tl-done">
          <div class="tl-circle">📋</div>
          <div>
            <div class="tl-label">Disposisi Admin</div>
            <div class="tl-sub">✓ Ditugaskan ke teknisi</div>
          </div>
        </div>

        
        <div class="tek-timeline-step tl-active">
          <div class="tl-circle">🔧</div>
          <div>
            <div class="tl-label">Dalam Pengerjaan</div>
            <div class="tl-sub">⚙️ Proses perbaikan</div>
          </div>
        </div>

        
        <div class="tek-timeline-step tl-pending">
          <div class="tl-circle">📸</div>
          <div>
            <div class="tl-label">Upload Bukti</div>
            <div class="tl-sub">Foto hasil perbaikan</div>
          </div>
        </div>

        
        <div class="tek-timeline-step tl-pending">
          <div class="tl-circle">✅</div>
          <div>
            <div class="tl-label">Selesai</div>
            <div class="tl-sub">Notifikasi terkirim</div>
          </div>
        </div>

      </div>
    </div>
  </div>

  
  <div class="tek-two-col">

    
    <div class="tek-panel">
      <div class="tek-panel-header">
        <h3>🔧 Tugas Aktif Terbaru</h3>
        <a href="<?php echo e(route('teknisi.tugas')); ?>" class="panel-link">Lihat Semua →</a>
      </div>
      <div class="tek-table-wrap">
        <?php if($tugasTerbaru->isEmpty()): ?>
          <div class="tek-empty">
            <div class="tek-empty-icon">🎉</div>
            <h4>Tidak Ada Tugas Aktif</h4>
            <p>Semua laporan sudah diselesaikan. Kerja bagus!</p>
          </div>
        <?php else: ?>
          <table class="tek-table">
            <thead>
              <tr>
                <th>Tiket</th>
                <th>Fasilitas & Lokasi</th>
                <th>Prioritas</th>
                <th>Status</th>
                <th>Tanggal</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php $__currentLoopData = $tugasTerbaru; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lap): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <?php
                $pr = $lap->Tingkat_Kerusakan ?? 'Rendah';
                $prioClass = match($pr) {
                  'Rendah' => 'prio-rendah',
                  'Sedang' => 'prio-sedang',
                  'Parah'  => 'prio-tinggi',
                  default  => 'prio-rendah'
                };
                $st = $lap->Status_terkini ?? '';
                $stClass = match(true) {
                  str_contains($st,'Selesai')      => 'st-selesai',
                  str_contains($st,'Pengerjaan')   => 'st-proses',
                  str_contains($st,'Verifikasi')   => 'st-menunggu',
                  default                          => 'st-baru'
                };
              ?>
              <tr>
                <td>
                  <span class="ticket-badge">RPT-<?php echo e(str_pad($lap->id_laporan, 5, '0', STR_PAD_LEFT)); ?></span>
                </td>
                <td>
                  <div style="font-weight:600;font-size:13px;color:var(--gray-800);">
                    <?php echo e(ucfirst($lap->kategori->nama_kategori ?? 'Fasilitas')); ?>

                  </div>
                  <div style="font-size:11.5px;color:var(--gray-400);">
                    📍 <?php if($lap->lokasi): ?> <?php echo e($lap->lokasi->nama_ruangan); ?>, <?php echo e($lap->lokasi->nama_gedung); ?> <?php else: ?> Lokasi tidak tersedia <?php endif; ?>
                  </div>
                </td>
                <td><span class="priority-badge <?php echo e($prioClass); ?>"><?php echo e($pr); ?></span></td>
                <td><span class="status-badge <?php echo e($stClass); ?>"><?php echo e($st); ?></span></td>
                <td style="font-size:11.5px;color:var(--gray-400);white-space:nowrap;">
                  <?php echo e($lap->created_at->format('d M Y')); ?>

                </td>
                <td>
                  <a href="<?php echo e(route('teknisi.detail', $lap->id_laporan)); ?>" class="btn-icon view" title="Lihat Detail">👁</a>
                </td>
              </tr>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
          </table>
        <?php endif; ?>
      </div>
    </div>

    
    <div style="display:flex;flex-direction:column;gap:16px;">

      
      <div class="tek-panel">
        <div class="tek-panel-header">
          <h3>⚡ Aksi Cepat</h3>
        </div>
        <div class="tek-panel-body">
          <div class="tek-quick-actions">
            <a href="<?php echo e(route('teknisi.tugas')); ?>" class="tek-action-item qa-blue">
              <div class="tek-action-icon">🔧</div>
              <div>
                <div class="ai-label">Semua Tugas</div>
                <div class="ai-sub">Kelola semua laporan</div>
              </div>
            </a>
            <a href="<?php echo e(route('teknisi.tugas', ['status' => 'Dalam Pengerjaan'])); ?>" class="tek-action-item qa-orange">
              <div class="tek-action-icon">⚙️</div>
              <div>
                <div class="ai-label">Sedang Dikerjakan</div>
                <div class="ai-sub"><?php echo e($dalamPengerjaan); ?> laporan aktif</div>
              </div>
            </a>
            <a href="<?php echo e(route('teknisi.tugas', ['tingkat' => 'Parah'])); ?>" class="tek-action-item qa-purple" style="background:var(--tek-danger-soft);">
              <div class="tek-action-icon">🚨</div>
              <div>
                <div class="ai-label">Prioritas Darurat</div>
                <div class="ai-sub"><?php echo e($darurat); ?> laporan kritis</div>
              </div>
            </a>
            <a href="<?php echo e(route('teknisi.tugas', ['status' => 'Selesai'])); ?>" class="tek-action-item qa-green">
              <div class="tek-action-icon">✅</div>
              <div>
                <div class="ai-label">Riwayat Selesai</div>
                <div class="ai-sub"><?php echo e($selesai); ?> diselesaikan</div>
              </div>
            </a>
          </div>
        </div>
      </div>

      
      <div class="tek-panel">
        <div class="tek-panel-header">
          <h3>🕐 Aktivitas Terbaru</h3>
        </div>
        <div class="tek-panel-body" style="padding:0 22px 16px;">
          <?php if($aktivitasTerbaru->isEmpty()): ?>
            <div style="padding:24px;text-align:center;color:var(--gray-400);font-size:13px;">
              Belum ada aktivitas tercatat.
            </div>
          <?php else: ?>
            <div class="tek-activity-timeline">
              <?php $__currentLoopData = $aktivitasTerbaru->take(5); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lap): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <?php
                $st = $lap->Status_terkini ?? '';
                $isSelesai = str_contains($st, 'Selesai');
                $isProses  = str_contains($st, 'Pengerjaan');
                $dotClass  = $isSelesai ? 'd-green' : ($isProses ? 'd-orange' : 'd-blue');
                $icon      = $isSelesai ? '✅' : ($isProses ? '⚙️' : '📋');
              ?>
              <div class="tak-item">
                <div class="tak-dot <?php echo e($dotClass); ?>"><?php echo e($icon); ?></div>
                <div class="tak-content">
                  <div class="tak-title"><?php echo e(ucfirst($lap->kategori->nama_kategori ?? 'Fasilitas')); ?></div>
                  <div class="tak-sub">
                    📍 <?php if($lap->lokasi): ?> <?php echo e($lap->lokasi->nama_ruangan); ?> <?php else: ?> Lokasi N/A <?php endif; ?>
                  </div>
                  <div class="tak-time">🕐 <?php echo e($lap->updated_at->diffForHumans()); ?></div>
                </div>
              </div>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
          <?php endif; ?>
        </div>
      </div>

    </div>
  </div>

</div>

<?php $__env->startPush('scripts'); ?>
<script>
  // Animate stat counters
  document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.stat-animate').forEach(el => {
      const target = parseInt(el.textContent, 10);
      if (isNaN(target) || target === 0) return;
      let cur = 0;
      const step = Math.max(1, Math.floor(target / 30));
      const t = setInterval(() => {
        cur = Math.min(cur + step, target);
        el.textContent = cur;
        if (cur >= target) clearInterval(t);
      }, 30);
    });
  });
</script>
<?php $__env->stopPush(); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\laravel - Copy (2)\resources\views/Teknisi/dashboard.blade.php ENDPATH**/ ?>