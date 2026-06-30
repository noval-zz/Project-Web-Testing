<!DOCTYPE html>
<html lang="id">
<head>
  <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Detail Mahasiswa — Sistem Pelaporan Fasilitas</title>
  <link rel="stylesheet" href="{{ asset('css/hiasan.css') }}">
  <style>
    .detail-container {
        display: flex;
        gap: 20px;
        margin-top: 20px;
        flex-wrap: wrap;
    }
    .profile-card {
        background: white;
        border-radius: 15px;
        padding: 20px;
        box-shadow: 0 8px 20px rgba(0,0,0,0.1);
        flex: 1;
        min-width: 300px;
    }
    .reports-card {
        background: white;
        border-radius: 15px;
        box-shadow: 0 8px 20px rgba(0,0,0,0.1);
        flex: 2;
        min-width: 400px;
        overflow: hidden;
    }
    .profile-header {
        display: flex;
        align-items: center;
        gap: 15px;
        margin-bottom: 20px;
        border-bottom: 1px solid #eee;
        padding-bottom: 15px;
    }
    .profile-info {
        margin-bottom: 10px;
    }
    .profile-info strong {
        display: inline-block;
        width: 120px;
        color: #555;
    }
    .status-badge {
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 12px;
        font-weight: bold;
        color: white;
    }
  </style>
</head>
<body>

<div class="container">

  <div class="card-header" style="border-radius: 15px;">
    <h2>Detail Mahasiswa</h2>
    <a href="{{ route('admin.mahasiswa') }}" class="btn-tambah">← Kembali</a>
  </div>

  <div class="detail-container">
    
    <!-- Profil Mahasiswa -->
    <div class="profile-card">
      <div class="profile-header">
        @if($mhs->foto_profil)
          <img src="{{ asset('storage/' . $mhs->foto_profil) }}" style="width:80px; height:80px; border-radius:50%; object-fit:cover; border:3px solid #0d6efd;" alt="Foto">
        @else
          <div style="width:80px; height:80px; border-radius:50%; background:#2563EB; display:flex; align-items:center; justify-content:center; color:#fff; font-weight:bold; font-size:30px;">
            {{ strtoupper(substr($mhs->Nama_mahasiswa, 0, 1)) }}
          </div>
        @endif
        <div>
            <h3 style="margin:0 0 5px 0;">{{ $mhs->Nama_mahasiswa }}</h3>
            <span style="color:#666;">NIM: {{ $mhs->Nim }}</span>
        </div>
      </div>
      
      <div class="profile-info"><strong>Prodi:</strong> {{ $mhs->prodi ?? '-' }}</div>
      <div class="profile-info"><strong>Gender:</strong> {{ $mhs->jenis_kelamin == 'L' ? 'Laki-laki' : ($mhs->jenis_kelamin == 'P' ? 'Perempuan' : '-') }}</div>
      <div class="profile-info"><strong>Agama:</strong> {{ $mhs->agama ?? '-' }}</div>
      <div class="profile-info"><strong>Tgl Lahir:</strong> {{ $mhs->tanggal_lahir ? date('d M Y', strtotime($mhs->tanggal_lahir)) : '-' }}</div>
      <div class="profile-info"><strong>Kontak:</strong> {{ $mhs->Kontak ?? '-' }}</div>
      <div class="profile-info"><strong>UKM:</strong> {{ $mhs->ukm ?? '-' }}</div>
      <div class="profile-info"><strong>Total Laporan:</strong> <span style="font-size:16px; font-weight:bold; color:#0d6efd;">{{ $mhs->laporan_count }}</span></div>
    </div>

    <!-- Riwayat Laporan -->
    <div class="reports-card">
      <div style="padding: 15px 20px; background: #f8f9fa; border-bottom: 1px solid #eee;">
          <h3 style="margin: 0; color: #333;">Riwayat Laporan</h3>
      </div>
      <div class="table-wrapper">
        <table class="table">
          <thead>
            <tr>
              <th>ID</th>
              <th>Tanggal</th>
              <th>Kategori</th>
              <th>Tingkat</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($mhs->laporan as $lap)
              <tr>
                <td>#{{ $lap->id_laporan }}</td>
                <td>{{ $lap->created_at->format('d M Y') }}</td>
                <td>{{ ($lap->kategori->nama_kategori ?? '-') . ($lap->subkategori ? ' — ' . $lap->subkategori->nama_sub_kategori : '') }}</td>
                <td>{{ $lap->Tingkat_Kerusakan }}</td>
                <td>
                  @php
                    $bg = match($lap->Status_terkini) {
                        'Menunggu Verifikasi' => '#f59e0b',
                        'Sedang Diperbaiki', 'Dalam Pengerjaan' => '#3b82f6',
                        'Selesai' => '#10b981',
                        'Ditolak' => '#ef4444',
                        default => '#6b7280'
                    };
                  @endphp
                  <span class="status-badge" style="background-color: {{ $bg }}">{{ $lap->Status_terkini }}</span>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="5">Belum ada laporan dari mahasiswa ini.</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>

  </div>
</div>

</body>
</html>

