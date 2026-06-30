<?php $__env->startSection('title', 'Tugas Saya — Teknisi Sistem Pelaporan Fasilitas'); ?>

<?php $__env->startPush('styles'); ?>
  <link rel="stylesheet" href="<?php echo e(asset('css/teknisi-dashboard.css')); ?>">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
<?php $__env->stopPush(); ?>


<?php $__env->startSection('sidebar-menu'); ?>
  <a href="<?php echo e(route('teknisi.dashboard')); ?>">
    <button>🏠 Dashboard</button>
  </a>
  <a href="<?php echo e(route('teknisi.tugas')); ?>">
    <button class="active-menu">🔧 Tugas Saya</button>
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
  <a href="<?php echo e(route('teknisi.dashboard')); ?>"><button>🏠 Dashboard</button></a>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<div class="tek-wrap">

  
  <?php if(session('success')): ?>
    <div class="tek-alert alert-success">✅ <?php echo e(session('success')); ?></div>
  <?php endif; ?>
  <?php if(session('error')): ?>
    <div class="tek-alert alert-danger">❌ <?php echo e(session('error')); ?></div>
  <?php endif; ?>

  
  <nav class="tek-breadcrumb" aria-label="breadcrumb">
    <a href="<?php echo e(route('teknisi.dashboard')); ?>">🏠 Dashboard</a>
    <span class="sep">›</span>
    <span class="current">🔧 Tugas Saya</span>
  </nav>

  <div class="tek-page-title">
    <div>
      <h1>🔧 Tugas Saya</h1>
      <div class="page-subtitle">Daftar semua laporan kerusakan yang perlu ditangani</div>
    </div>
    <div class="page-actions">
      <a href="<?php echo e(route('teknisi.tugas', ['tingkat' => 'Parah'])); ?>" class="btn-danger btn-sm">
        🚨 Darurat
      </a>
      <a href="<?php echo e(route('teknisi.dashboard')); ?>" class="btn-outline btn-sm">
        ← Dashboard
      </a>
    </div>
  </div>

  
  <div style="display:flex;gap:10px;flex-wrap:wrap;margin-bottom:20px;">
    <a href="<?php echo e(route('teknisi.tugas')); ?>"
       style="display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:9999px;font-size:12px;font-weight:700;text-decoration:none;transition:all .2s;
              <?php echo e(!request()->filled('status') && !request()->filled('tingkat') ? 'background:var(--tek-primary);color:#fff;box-shadow:0 2px 8px rgba(15,76,129,.25)' : 'background:var(--gray-100);color:var(--gray-600)'); ?>">
      📋 Semua <span style="background:rgba(255,255,255,.3);padding:1px 7px;border-radius:9999px;font-size:11px;"><?php echo e($statTotal); ?></span>
    </a>
    <a href="<?php echo e(route('teknisi.tugas', ['status' => 'Sedang Diperbaiki'])); ?>"
       style="display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:9999px;font-size:12px;font-weight:700;text-decoration:none;transition:all .2s;
              <?php echo e(request('status') === 'Sedang Diperbaiki' ? 'background:var(--tek-warning);color:#fff;box-shadow:0 2px 8px rgba(245,158,11,.25)' : 'background:var(--gray-100);color:var(--gray-600)'); ?>">
      ⏳ Menunggu <span style="padding:1px 7px;border-radius:9999px;font-size:11px;background:rgba(0,0,0,.1);"><?php echo e($statBaru); ?></span>
    </a>
    <a href="<?php echo e(route('teknisi.tugas', ['status' => 'Dalam Pengerjaan'])); ?>"
       style="display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:9999px;font-size:12px;font-weight:700;text-decoration:none;transition:all .2s;
              <?php echo e(request('status') === 'Dalam Pengerjaan' ? 'background:var(--tek-accent);color:#fff;box-shadow:0 2px 8px rgba(255,107,53,.25)' : 'background:var(--gray-100);color:var(--gray-600)'); ?>">
      ⚙️ Dikerjakan <span style="padding:1px 7px;border-radius:9999px;font-size:11px;background:rgba(0,0,0,.1);"><?php echo e($statProses); ?></span>
    </a>
    <a href="<?php echo e(route('teknisi.tugas', ['status' => 'Selesai'])); ?>"
       style="display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:9999px;font-size:12px;font-weight:700;text-decoration:none;transition:all .2s;
              <?php echo e(request('status') === 'Selesai' ? 'background:var(--tek-success);color:#fff;box-shadow:0 2px 8px rgba(16,185,129,.25)' : 'background:var(--gray-100);color:var(--gray-600)'); ?>">
      ✅ Selesai <span style="padding:1px 7px;border-radius:9999px;font-size:11px;background:rgba(0,0,0,.1);"><?php echo e($statSelesai); ?></span>
    </a>
  </div>

  
  <div class="tek-panel">

    
    <div class="tek-filter-bar">
      <form method="GET" action="<?php echo e(route('teknisi.tugas')); ?>" style="display:contents;">
        <div class="tek-search-box">
          <span class="search-icon">🔍</span>
          <input type="text" name="search" placeholder="Cari laporan, lokasi, pelapor…"
                 value="<?php echo e(request('search')); ?>">
        </div>
        <select name="tingkat" class="tek-filter-select" onchange="this.form.submit()">
          <option value="">🎯 Semua Prioritas</option>
          <option value="Rendah" <?php echo e(request('tingkat') === 'Rendah' ? 'selected' : ''); ?>>🟢 Rendah</option>
          <option value="Sedang" <?php echo e(request('tingkat') === 'Sedang' ? 'selected' : ''); ?>>🟡 Sedang</option>
          <option value="Parah"  <?php echo e(request('tingkat') === 'Parah'  ? 'selected' : ''); ?>>🔴 Tinggi / Darurat</option>
        </select>
        <button type="submit" class="btn-primary btn-sm">🔍 Cari</button>
        <?php if(request()->hasAny(['search', 'status', 'tingkat'])): ?>
          <a href="<?php echo e(route('teknisi.tugas')); ?>" class="btn-outline btn-sm">✕ Reset</a>
        <?php endif; ?>
      </form>
    </div>

    
    <div class="tek-table-wrap">
      <?php if($laporanList->isEmpty()): ?>
        <div class="tek-empty">
          <div class="tek-empty-icon">📭</div>
          <h4>Tidak Ada Laporan Ditemukan</h4>
          <p>Coba ubah filter pencarian atau cek kembali nanti.</p>
        </div>
      <?php else: ?>
        <table class="tek-table">
          <thead>
            <tr>
              <th>#</th>
              <th>Tiket</th>
              <th>Fasilitas</th>
              <th>Lokasi</th>
              <th>Pelapor</th>
              <th>Prioritas</th>
              <th>Status</th>
              <th>Tanggal</th>
              <th style="text-align:center;">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php $__currentLoopData = $laporanList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $lap): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
              $pr = $lap->Tingkat_Kerusakan ?? 'Rendah';
              $prioClass = match($pr) {
                'Rendah' => 'prio-rendah',
                'Sedang' => 'prio-sedang',
                'Parah'  => 'prio-tinggi',
                default  => 'prio-rendah'
              };
              $prioIcon = match($pr) {
                'Rendah' => '🟢',
                'Sedang' => '🟡',
                'Parah'  => '🔴',
                default  => '⚪'
              };
              $st = $lap->Status_terkini ?? '';
              $stClass = match(true) {
                str_contains($st,'Selesai')         => 'st-selesai',
                str_contains($st,'Pengerjaan')      => 'st-proses',
                $st === 'Sedang Diperbaiki'         => 'st-menunggu',
                default                             => 'st-baru'
              };
              $stLabel = match(true) {
                str_contains($st,'Selesai')         => 'Selesai',
                str_contains($st,'Pengerjaan')      => 'Dalam Pengerjaan',
                $st === 'Sedang Diperbaiki'         => 'Menunggu Penanganan',
                default                             => $st
              };
            ?>
            <tr>
              <td style="color:var(--gray-400);font-size:12px;">
                <?php echo e($laporanList->firstItem() + $i); ?>

              </td>
              <td>
                <span class="ticket-badge">RPT-<?php echo e(str_pad($lap->id_laporan, 5, '0', STR_PAD_LEFT)); ?></span>
              </td>
              <td>
                <div style="font-weight:600;font-size:13px;color:var(--gray-800);max-width:160px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">
                  <?php echo e(ucfirst($lap->kategori->nama_kategori ?? 'Fasilitas')); ?>

                </div>
                <div style="font-size:11px;color:var(--gray-400);margin-top:2px;max-width:160px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">
                  <?php echo e(Str::limit($lap->deskripsi ?? '-', 40)); ?>

                </div>
              </td>
              <td style="font-size:12.5px;color:var(--gray-600);">
                <?php if($lap->lokasi): ?>
                  <div><?php echo e($lap->lokasi->nama_ruangan); ?></div>
                  <div style="font-size:11px;color:var(--gray-400);"><?php echo e($lap->lokasi->nama_gedung); ?></div>
                <?php else: ?>
                  <span style="color:var(--gray-300);">—</span>
                <?php endif; ?>
              </td>
              <td style="font-size:12.5px;color:var(--gray-600);">
                <?php echo e($lap->mahasiswa->Nama_mahasiswa ?? 'Anonim'); ?>

                <?php if($lap->mahasiswa?->Nim): ?>
                  <div style="font-size:11px;color:var(--gray-400);"><?php echo e($lap->mahasiswa->Nim); ?></div>
                <?php endif; ?>
              </td>
              <td>
                <span class="priority-badge <?php echo e($prioClass); ?>"><?php echo e($prioIcon); ?> <?php echo e($pr); ?></span>
              </td>
              <td>
                <span class="status-badge <?php echo e($stClass); ?>"><?php echo e($stLabel); ?></span>
              </td>
              <td style="font-size:11.5px;color:var(--gray-400);white-space:nowrap;">
                <?php echo e($lap->created_at->format('d M Y')); ?>

                <div><?php echo e($lap->created_at->format('H:i')); ?> WITA</div>
              </td>
              <td style="text-align:center;">
                <a href="<?php echo e(route('teknisi.detail', $lap->id_laporan)); ?>"
                   class="btn-primary btn-sm" title="Lihat & Kelola Tugas">
                  👁 Detail
                </a>
              </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </tbody>
        </table>

        
        <?php if($laporanList->hasPages()): ?>
        <div style="padding:16px 20px;border-top:1px solid var(--gray-100);display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:10px;">
          <div style="font-size:12.5px;color:var(--gray-500);">
            Menampilkan <?php echo e($laporanList->firstItem()); ?>–<?php echo e($laporanList->lastItem()); ?> dari <?php echo e($laporanList->total()); ?> laporan
          </div>
          <div style="display:flex;gap:4px;">
            
            <?php if($laporanList->onFirstPage()): ?>
              <span style="padding:6px 12px;border-radius:var(--radius-sm);background:var(--gray-100);color:var(--gray-300);font-size:12px;cursor:not-allowed;">‹</span>
            <?php else: ?>
              <a href="<?php echo e($laporanList->previousPageUrl()); ?>"
                 style="padding:6px 12px;border-radius:var(--radius-sm);background:var(--gray-100);color:var(--gray-600);font-size:12px;text-decoration:none;transition:all .2s;"
                 onmouseover="this.style.background='var(--tek-primary-soft)'"
                 onmouseout="this.style.background='var(--gray-100)'">‹</a>
            <?php endif; ?>

            
            <?php $__currentLoopData = $laporanList->getUrlRange(max(1,$laporanList->currentPage()-2), min($laporanList->lastPage(),$laporanList->currentPage()+2)); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page => $url): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <?php if($page === $laporanList->currentPage()): ?>
                <span style="padding:6px 12px;border-radius:var(--radius-sm);background:var(--tek-primary);color:#fff;font-size:12px;font-weight:700;"><?php echo e($page); ?></span>
              <?php else: ?>
                <a href="<?php echo e($url); ?>"
                   style="padding:6px 12px;border-radius:var(--radius-sm);background:var(--gray-100);color:var(--gray-600);font-size:12px;text-decoration:none;transition:all .2s;"
                   onmouseover="this.style.background='var(--tek-primary-soft)'"
                   onmouseout="this.style.background='var(--gray-100)'"><?php echo e($page); ?></a>
              <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            
            <?php if($laporanList->hasMorePages()): ?>
              <a href="<?php echo e($laporanList->nextPageUrl()); ?>"
                 style="padding:6px 12px;border-radius:var(--radius-sm);background:var(--gray-100);color:var(--gray-600);font-size:12px;text-decoration:none;transition:all .2s;"
                 onmouseover="this.style.background='var(--tek-primary-soft)'"
                 onmouseout="this.style.background='var(--gray-100)'">›</a>
            <?php else: ?>
              <span style="padding:6px 12px;border-radius:var(--radius-sm);background:var(--gray-100);color:var(--gray-300);font-size:12px;cursor:not-allowed;">›</span>
            <?php endif; ?>
          </div>
        </div>
        <?php endif; ?>

      <?php endif; ?>
    </div>
  </div>

</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\laravel - Copy (2)\resources\views/Teknisi/tugas.blade.php ENDPATH**/ ?>