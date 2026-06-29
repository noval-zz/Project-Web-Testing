<?php $__env->startSection('title', 'Dashboard Mahasiswa — Sistem Pelaporan Fasilitas'); ?>

<?php $__env->startPush('styles'); ?>
  <link rel="stylesheet" href="<?php echo e(asset('css/mahasiswa-dashboard.css')); ?>">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<?php $__env->stopPush(); ?>


<?php $__env->startSection('sidebar-menu'); ?>
  <a href="<?php echo e(route('mahasiswa.dashboard')); ?>">
    <button class="active-menu">🏠 Dashboard</button>
  </a>
  <a href="<?php echo e(route('laporan.create')); ?>">
    <button>📋 Buat Laporan</button>
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
<?php $__env->startSection('profile-role'); ?> NIM: <?php echo e($mhs->Nim ?? ''); ?> <?php $__env->stopSection(); ?>
<?php $__env->startSection('profile-buttons'); ?>
  <a href="<?php echo e(route('mahasiswa.biodata', $mhs->id_mahasiswa ?? 0)); ?>">
    <button>👤 Edit Profil</button>
  </a>
  <a href="<?php echo e(route('mahasiswa.ganti.password')); ?>">
    <button>🔑 Ganti Password</button>
  </a>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>

<?php
  $nama    = $mhs->Nama_mahasiswa ?? $user->username;
  $nim     = $mhs->Nim ?? '-';
  $prodi   = $mhs->prodi ?? 'Mahasiswa';
  $now     = \Carbon\Carbon::now('Asia/Makassar');

  // Determine greeting based on time
  $hour = (int)$now->format('H');
  if ($hour >= 5 && $hour < 12)       $greeting = 'Selamat Pagi';
  elseif ($hour >= 12 && $hour < 15)  $greeting = 'Selamat Siang';
  elseif ($hour >= 15 && $hour < 18)  $greeting = 'Selamat Sore';
  else                                 $greeting = 'Selamat Malam';

  // Status badge helper (closure to avoid redeclaration)
  $statusBadge = function(string $status): string {
    if (str_contains($status, 'Selesai'))     return '<span class="status-badge badge-selesai">Selesai</span>';
    if (str_contains($status, 'Diperbaiki'))  return '<span class="status-badge badge-proses">Dalam Pengerjaan</span>';
    if (str_contains($status, 'Verifikasi')) return '<span class="status-badge badge-menunggu">Menunggu Verifikasi</span>';
    return '<span class="status-badge badge-default">' . e($status) . '</span>';
  };

  $severityBadge = function(string $severity): string {
    return match($severity) {
      'Rendah' => '<span class="severity-badge sev-rendah">Rendah</span>',
      'Sedang' => '<span class="severity-badge sev-sedang">Sedang</span>',
      'Parah'  => '<span class="severity-badge sev-parah">Parah</span>',
      default  => '<span class="severity-badge sev-rendah">' . e($severity) . '</span>',
    };
  };

  // Progress tracker steps
  $steps = [
    ['icon' => '📩', 'label' => 'Laporan Dibuat',        'timestamp' => 'Diterima sistem'],
    ['icon' => '🔍', 'label' => 'Menunggu Verifikasi',   'timestamp' => 'Menunggu admin'],
    ['icon' => '🔧', 'label' => 'Dalam Pengerjaan',      'timestamp' => 'Teknisi ditugaskan'],
    ['icon' => '✅', 'label' => 'Selesai',               'timestamp' => 'Perbaikan selesai'],
  ];

  // Determine active step based on laporanAktif status
  $activeStep = 0;
  if ($laporanAktif) {
    $s = $laporanAktif->Status_terkini ?? '';
    if (str_contains($s, 'Verifikasi'))  $activeStep = 1;
    elseif (str_contains($s, 'Diperbaiki')) $activeStep = 2;
    elseif (str_contains($s, 'Selesai'))    $activeStep = 3;
    else $activeStep = 1;
  }

  $stepCount   = count($steps);
  $fillPercent = $stepCount > 1 ? ($activeStep / ($stepCount - 1)) * 100 : 0;
?>

<div class="mhs-dashboard">

  
  <?php if(session('success')): ?>
    <div class="alert-success" role="alert">
      ✅ <span><?php echo e(session('success')); ?></span>
    </div>
  <?php endif; ?>

  
  <div class="welcome-banner">
    <div class="welcome-text">
      <div class="greeting"><?php echo e($greeting); ?>, 👋</div>
      <h2><?php echo e($nama); ?></h2>
      <div class="sub-info">
        <span class="info-item">🎓 <?php echo e($prodi); ?></span>
        <span class="info-item">🪪 NIM: <?php echo e($nim); ?></span>
        <span class="info-item">📅 <?php echo e($now->isoFormat('dddd, D MMMM Y')); ?></span>
      </div>
    </div>
    <div class="welcome-actions">
      <a href="<?php echo e(route('laporan.create')); ?>" class="btn-primary-white">
        ➕ Buat Laporan Baru
      </a>
    </div>
  </div>

  
  <div class="stats-grid">
    
    <div class="stat-card total">
      <div class="stat-icon">📋</div>
      <div class="stat-info">
        <div class="stat-number"><?php echo e($totalLaporan); ?></div>
        <div class="stat-label">Total Laporan</div>
        <div class="stat-sub">Semua laporan Anda</div>
      </div>
    </div>

    
    <div class="stat-card menunggu">
      <div class="stat-icon">⏳</div>
      <div class="stat-info">
        <div class="stat-number"><?php echo e($menunggu); ?></div>
        <div class="stat-label">Sedang Diproses</div>
        <div class="stat-sub">Menunggu tindak lanjut</div>
      </div>
    </div>

    
    <div class="stat-card proses">
      <div class="stat-icon">🔧</div>
      <div class="stat-info">
        <div class="stat-number"><?php echo e($dalamProses); ?></div>
        <div class="stat-label">Dalam Pengerjaan</div>
        <div class="stat-sub">Teknisi aktif bekerja</div>
      </div>
    </div>

    
    <div class="stat-card selesai">
      <div class="stat-icon">✅</div>
      <div class="stat-info">
        <div class="stat-number"><?php echo e($selesai); ?></div>
        <div class="stat-label">Selesai</div>
        <div class="stat-sub">Perbaikan terselesaikan</div>
      </div>
    </div>
  </div>

  
  <div class="progress-section">
    <div class="section-header">
      <h3><span class="icon">📊</span> Progress Laporan Aktif</h3>
      <?php if($laporanAktif): ?>
        <a href="<?php echo e(route('laporan.pantau')); ?>">Lihat Detail →</a>
      <?php endif; ?>
    </div>

    <?php if($laporanAktif): ?>
      
      <div style="background:#EFF6FF;border-radius:10px;padding:12px 16px;margin-bottom:20px;font-size:13px;color:#1E3A5F;display:flex;align-items:center;gap:10px;">
        <span style="font-size:18px;">🔧</span>
        <div>
          <strong><?php echo e($laporanAktif->kategori->nama_kategori ?? 'Fasilitas'); ?></strong>
          <?php if($laporanAktif->lokasi): ?>
            — <?php echo e($laporanAktif->lokasi->nama_ruangan); ?>, <?php echo e($laporanAktif->lokasi->nama_gedung); ?>

          <?php endif; ?>
          <div style="font-size:11px;color:#64748B;margin-top:2px;">
            Dilaporkan <?php echo e($laporanAktif->created_at->diffForHumans()); ?>

          </div>
        </div>
        <?php echo $statusBadge($laporanAktif->Status_terkini ?? 'Sedang Diperbaiki'); ?>

      </div>

      
      <div class="progress-tracker">
        <div class="progress-connector">
          <div class="progress-connector-fill" style="width:<?php echo e($fillPercent); ?>%"></div>
        </div>

        <?php $__currentLoopData = $steps; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $step): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <?php
            if ($i < $activeStep)      $stepClass = 'done';
            elseif ($i === $activeStep) $stepClass = 'active';
            else                        $stepClass = 'pending';
          ?>
          <div class="progress-step <?php echo e($stepClass); ?>">
            <div class="step-circle"><?php echo e($step['icon']); ?></div>
            <div class="step-label"><?php echo e($step['label']); ?></div>
            <div class="step-timestamp"><?php echo e($step['timestamp']); ?></div>
          </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </div>
    <?php elseif($totalLaporan === 0): ?>
      <div class="no-active-label">
        📭 Belum ada laporan aktif. Buat laporan pertama Anda!
      </div>
    <?php else: ?>
      <div class="no-active-label">
        🎉 Semua laporan Anda telah diselesaikan. Tidak ada laporan aktif saat ini.
      </div>
    <?php endif; ?>
  </div>

  
  <div class="two-col-grid">

    
    <div class="panel">
      <div class="section-header" style="margin-bottom:12px;">
        <h3>📁 Laporan Terbaru Saya</h3>
        <a href="<?php echo e(route('laporan.status')); ?>">Semua Laporan →</a>
      </div>

      <?php if($laporanTerbaru->isEmpty()): ?>
        <div class="empty-state">
          <div class="empty-icon-wrap">📋</div>
          <h4>Belum Ada Laporan</h4>
          <p>Belum ada laporan yang dibuat. Klik tombol di bawah untuk melaporkan kerusakan fasilitas kampus.</p>
          <a href="<?php echo e(route('laporan.create')); ?>" class="btn-create">
            ➕ Buat Laporan Pertama
          </a>
        </div>
      <?php else: ?>
        <table class="laporan-table">
          <thead>
            <tr>
              <th>Tiket</th>
              <th>Kerusakan</th>
              <th>Status</th>
              <th>Tingkat</th>
              <th>Tanggal</th>
            </tr>
          </thead>
          <tbody>
            <?php $__currentLoopData = $laporanTerbaru; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lap): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
              <td>
                <span class="ticket-badge">
                  RPT-<?php echo e(str_pad($lap->id_laporan, 5, '0', STR_PAD_LEFT)); ?>

                </span>
              </td>
              <td>
                <div class="laporan-title">
                  <?php echo e(ucfirst($lap->kategori->nama_kategori ?? 'Fasilitas')); ?>

                </div>
                <div class="laporan-lokasi">
                  📍
                  <?php if($lap->lokasi): ?>
                    <?php echo e($lap->lokasi->nama_ruangan); ?>, <?php echo e($lap->lokasi->nama_gedung); ?>

                  <?php else: ?>
                    Lokasi tidak diketahui
                  <?php endif; ?>
                </div>
              </td>
              <td><?php echo $statusBadge($lap->Status_terkini ?? '-'); ?></td>
              <td><?php echo $severityBadge($lap->Tingkat_Kerusakan ?? '-'); ?></td>
              <td style="font-size:11.5px;color:#64748B;white-space:nowrap;">
                <?php echo e($lap->created_at->format('d M Y')); ?>

              </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </tbody>
        </table>
      <?php endif; ?>
    </div>

    
    <div class="panel">
      <div class="section-header" style="margin-bottom:12px;">
        <h3>🕐 Aktivitas Terbaru</h3>
      </div>

      <?php if($laporanTerbaru->isEmpty()): ?>
        <div style="padding:24px;text-align:center;color:#94A3B8;font-size:13px;font-style:italic;">
          Belum ada aktivitas yang tercatat.
        </div>
      <?php else: ?>
        <div class="timeline">
          <?php $__currentLoopData = $laporanTerbaru->take(4); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lap): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
              $status = $lap->Status_terkini ?? 'Sedang Diperbaiki';
              $isSelesai = str_contains($status, 'Selesai');
              $dotClass  = $isSelesai ? 'dot-green' : 'dot-blue';
              $icon      = $isSelesai ? '✅' : '🔧';
              $kategori  = ucfirst($lap->kategori->nama_kategori ?? 'Fasilitas');
              $lokasi    = $lap->lokasi ? $lap->lokasi->nama_ruangan : 'Lokasi tidak diketahui';
            ?>
            <div class="timeline-item">
              <div class="timeline-dot <?php echo e($dotClass); ?>"><?php echo e($icon); ?></div>
              <div class="timeline-content">
                <div class="t-title"><?php echo e($kategori); ?> — <?php echo e($lokasi); ?></div>
                <div class="t-desc">
                  Tingkat kerusakan: <strong><?php echo e($lap->Tingkat_Kerusakan ?? '-'); ?></strong>
                </div>
                <div class="t-time"><?php echo e($lap->created_at->diffForHumans()); ?> · <?php echo e($lap->created_at->format('d M Y, H:i')); ?> WITA</div>
              </div>
            </div>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

          
          <div class="timeline-item">
            <div class="timeline-dot dot-purple">🎓</div>
            <div class="timeline-content">
              <div class="t-title">Akun Mahasiswa Aktif</div>
              <div class="t-desc">Sistem siap menerima laporan kerusakan fasilitas.</div>
              <div class="t-time">Selamat datang, <?php echo e($nama); ?>!</div>
            </div>
          </div>
        </div>
      <?php endif; ?>
    </div>
  </div>

  
  <div class="announce-section">
    <div class="announce-header">
      <span class="icon">📣</span>
      <h3>Pengumuman Sarpras</h3>
      <span style="font-size:11px;color:#94A3B8;margin-left:auto;">Dikelola oleh Admin</span>
    </div>
    <div class="announce-list">

      <?php if($pengumuman->isEmpty()): ?>
        <div style="padding:28px;text-align:center;color:#94A3B8;">
          <div style="font-size:32px;margin-bottom:8px;">📭</div>
          <div style="font-size:13px;">Belum ada pengumuman dari Admin Sarpras.</div>
        </div>
      <?php else: ?>
        <?php $__currentLoopData = $pengumuman; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <div class="announce-item">
            <div class="announce-date-badge">
              <div class="day"><?php echo e($item->tanggal_publish->format('d')); ?></div>
              <div class="month"><?php echo e($item->tanggal_publish->translatedFormat('M')); ?></div>
            </div>
            <div class="announce-text">
              <div class="a-title"><?php echo e($item->judul); ?></div>
              <div class="a-desc"><?php echo e(Str::limit($item->isi, 130)); ?></div>
              <?php if($item->pembuat): ?>
                <div style="font-size:10.5px;color:#94A3B8;margin-top:4px;">
                  👤 Diterbitkan oleh Admin Sarpras
                </div>
              <?php endif; ?>
            </div>
          </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      <?php endif; ?>

    </div>
  </div>

  
  <div class="quick-actions-section">
    <div class="section-header" style="margin-bottom:16px;">
      <h3 style="font-size:16px;font-weight:700;color:#0F172A;display:flex;align-items:center;gap:8px;">
        ⚡ Aksi Cepat
      </h3>
    </div>
    <div class="quick-actions">
      
      <a href="<?php echo e(route('laporan.create')); ?>" class="action-card ac-blue" id="btn-buat-laporan">
        <div class="action-icon">➕</div>
        <div class="action-label">Buat Laporan</div>
        <div class="action-sub">Laporkan kerusakan fasilitas kampus</div>
      </a>

      
      <a href="<?php echo e(route('laporan.pantau')); ?>" class="action-card ac-purple" id="btn-pantau-laporan">
        <div class="action-icon">🔍</div>
        <div class="action-label">Pantau Laporan</div>
        <div class="action-sub">Monitor detail status laporan Anda</div>
      </a>

      
      <a href="<?php echo e(route('laporan.status')); ?>" class="action-card ac-green" id="btn-riwayat-laporan">
        <div class="action-icon">📂</div>
        <div class="action-label">Riwayat Laporan</div>
        <div class="action-sub">Lihat semua laporan yang pernah dibuat</div>
      </a>

      
      <a href="<?php echo e(route('mahasiswa.biodata', $mhs->id_mahasiswa ?? 0)); ?>" class="action-card ac-gray" id="btn-profil-saya">
        <div class="action-icon">👤</div>
        <div class="action-label">Profil Saya</div>
        <div class="action-sub">Kelola data diri & foto profil</div>
      </a>
    </div>
  </div>

</div>

<?php $__env->startPush('scripts'); ?>
<script>
  // Animate stat numbers counting up
  document.addEventListener('DOMContentLoaded', function () {
    const nums = document.querySelectorAll('.stat-number');
    nums.forEach(el => {
      const target = parseInt(el.textContent, 10);
      if (isNaN(target) || target === 0) return;
      let current = 0;
      const step = Math.max(1, Math.floor(target / 30));
      const timer = setInterval(() => {
        current = Math.min(current + step, target);
        el.textContent = current;
        if (current >= target) clearInterval(timer);
      }, 30);
    });
  });
</script>
<?php $__env->stopPush(); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\laravel - Copy (2)\resources\views/mahasiswa/dashboard.blade.php ENDPATH**/ ?>