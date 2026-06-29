<!DOCTYPE html>
<html lang="id">
<head>
  <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Daftar Mahasiswa — Sistem Pelaporan Fasilitas</title>
  <link rel="stylesheet" href="{{ asset('css/hiasan.css') }}">
</head>
<body>

<div class="container">

  <div class="card">

    <div class="card-header">
      <h2>Data Mahasiswa</h2>
      <a href="{{ route('admin.dashboard') }}" class="btn-tambah">← Kembali</a>
    </div>

    @if (session('success'))
      <div style="background:#d4edda;color:#155724;padding:12px 20px;font-size:14px;">
        {{ session('success') }}
      </div>
    @endif

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
          @forelse ($mahasiswas as $mhs)
            <tr>
              <td>
                <div style="display:flex; align-items:center; gap:10px;">
                  @if($mhs->foto_profil)
                    <img src="{{ asset('storage/' . $mhs->foto_profil) }}" style="width:32px; height:32px; border-radius:50%; object-fit:cover; border:1px solid #ddd;" alt="Foto">
                  @else
                    <div style="width:32px; height:32px; border-radius:50%; background:#2563EB; display:flex; align-items:center; justify-content:center; color:#fff; font-weight:bold; font-size:12px;">
                      {{ strtoupper(substr($mhs->Nama_mahasiswa, 0, 1)) }}
                    </div>
                  @endif
                  {{ $mhs->Nama_mahasiswa }}
                </div>
              </td>
              <td>{{ $mhs->Nim }}</td>
              <td>{{ $mhs->jenis_kelamin == 'L' ? 'Laki-laki' : ($mhs->jenis_kelamin == 'P' ? 'Perempuan' : '-') }}</td>
              <td>{{ $mhs->prodi ?? '-' }}</td>
              <td>{{ $mhs->laporan_count ?? 0 }}</td>
              <td>
                <a href="{{ route('admin.mahasiswa.detail', $mhs->id_mahasiswa) }}" class="btn btn-primary" style="background-color: #0d6efd;">Lihat Detail</a>

                <form action="{{ route('admin.mahasiswa.hapus', $mhs->id_mahasiswa) }}"
                      method="POST"
                      style="display:inline"
                      onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-hapus">Hapus</button>
                </form>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="6">Tidak ada data mahasiswa</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

  </div>

</div>

</body>
</html>

