@extends('layouts.dashboard')

@section('title', 'Kelola Pengumuman Sarpras')

@section('sidebar-menu')
  <a href="{{ route('admin.dashboard') }}">
    <button>🏠 Dashboard</button>
  </a>
  <a href="{{ route('admin.verifikasi.index') }}">
    <button>✅ Verifikasi Laporan</button>
  </a>
  <a href="{{ route('admin.laporan.semua') }}">
    <button>📋 Semua Laporan</button>
  </a>
  <a href="#">
    <button>👷 Teknisi Tersedia</button>
  </a>
  <a href="{{ route('admin.mahasiswa') }}">
    <button>🎓 Daftar Mahasiswa</button>
  </a>
  <a href="{{ route('admin.riwayat') }}">
    <button>📂 Riwayat Laporan</button>
  </a>
  <a href="{{ route('admin.pengumuman.index') }}">
    <button class="active-menu" style="background:rgba(255,243,205,.1);color:#FCD34D;">📣 Pengumuman</button>
  </a>
@endsection

@section('profile-name') {{ $user->nama ?? $user->username }} @endsection
@section('profile-role') Administrator Sarpras @endsection

@push('styles')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
  * { box-sizing: border-box; }
  .peng-wrap {
    font-family: 'Inter', sans-serif;
    background: #F1F5F9;
    min-height: calc(100vh - 70px);
    padding: 28px 32px 48px;
  }
  .peng-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 24px;
    flex-wrap: wrap;
    gap: 12px;
  }
  .peng-header h1 {
    font-size: 22px;
    font-weight: 800;
    color: #0F172A;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 10px;
  }
  .peng-header h1 i { color: #2563EB; font-size: 20px; }
  .btn-tambah {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: #2563EB;
    color: #fff;
    border: none;
    border-radius: 10px;
    padding: 10px 20px;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    text-decoration: none;
    transition: background .2s, transform .15s;
  }
  .btn-tambah:hover { background: #1D4ED8; transform: translateY(-1px); }

  /* Flash */
  .flash-ok {
    background: #DCFCE7;
    border: 1px solid #86EFAC;
    color: #166534;
    padding: 12px 18px;
    border-radius: 10px;
    font-size: 13px;
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    gap: 10px;
  }

  /* Table card */
  .table-card {
    background: #fff;
    border: 1px solid #E2E8F0;
    border-radius: 14px;
    box-shadow: 0 1px 4px rgba(0,0,0,0.05);
    overflow: hidden;
  }
  .peng-table { width: 100%; border-collapse: collapse; font-size: 13px; }
  .peng-table thead th {
    padding: 12px 16px;
    text-align: left;
    font-size: 11px;
    font-weight: 700;
    color: #64748B;
    text-transform: uppercase;
    letter-spacing: .5px;
    background: #F8FAFC;
    border-bottom: 1px solid #E2E8F0;
  }
  .peng-table tbody td {
    padding: 14px 16px;
    border-bottom: 1px solid #F1F5F9;
    color: #334155;
    vertical-align: top;
  }
  .peng-table tbody tr:last-child td { border-bottom: none; }
  .peng-table tbody tr:hover { background: #F8FAFC; }

  /* Badge status */
  .badge-status {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    padding: 3px 10px;
    border-radius: 999px;
    font-size: 11px;
    font-weight: 600;
    white-space: nowrap;
  }
  .badge-aktif    { background: #DCFCE7; color: #166534; }
  .badge-nonaktif { background: #F1F5F9; color: #64748B; }

  /* Action buttons */
  .act-btns { display: flex; gap: 8px; flex-wrap: wrap; }
  .btn-edit, .btn-hapus, .btn-toggle {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 5px 12px;
    border-radius: 7px;
    font-size: 12px;
    font-weight: 600;
    cursor: pointer;
    text-decoration: none;
    border: none;
    transition: opacity .15s, transform .15s;
  }
  .btn-edit:hover, .btn-hapus:hover, .btn-toggle:hover {
    opacity: .85;
    transform: translateY(-1px);
  }
  .btn-edit   { background: #EFF6FF; color: #2563EB; }
  .btn-hapus  { background: #FEF2F2; color: #DC2626; }
  .btn-toggle { background: #F0FDF4; color: #16A34A; }

  /* Judul truncate */
  .judul-cell { font-weight: 600; color: #0F172A; max-width: 220px; }
  .isi-cell   { font-size: 12px; color: #64748B; max-width: 320px; white-space: pre-line; }

  /* Pagination */
  .peng-pagination {
    display: flex;
    justify-content: center;
    padding: 20px 0 0;
    gap: 6px;
  }
  .peng-pagination a, .peng-pagination span {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 34px; height: 34px;
    border-radius: 8px;
    font-size: 13px;
    font-weight: 600;
    text-decoration: none;
    border: 1px solid #E2E8F0;
    color: #334155;
    background: #fff;
    transition: all .15s;
  }
  .peng-pagination a:hover { background: #EFF6FF; border-color: #BFDBFE; color: #2563EB; }
  .peng-pagination span.active { background: #2563EB; border-color: #2563EB; color: #fff; }

  /* Empty */
  .empty-state {
    text-align: center;
    padding: 52px 24px;
    color: #94A3B8;
  }
  .empty-state i { font-size: 40px; margin-bottom: 12px; display: block; color: #CBD5E1; }
  .empty-state h4 { font-size: 15px; font-weight: 600; margin: 0 0 6px; color: #64748B; }
</style>
@endpush

@section('content')
<div class="peng-wrap">

  {{-- Header --}}
  <div class="peng-header">
    <h1><i class="fa-solid fa-bullhorn"></i> Kelola Pengumuman Sarpras</h1>
    <a href="{{ route('admin.pengumuman.create') }}" class="btn-tambah">
      <i class="fa-solid fa-plus"></i> Tambah Pengumuman
    </a>
  </div>

  {{-- Flash --}}
  @if(session('success'))
    <div class="flash-ok">
      <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
    </div>
  @endif

  {{-- Tabel --}}
  <div class="table-card">
    @if($pengumumanList->isEmpty())
      <div class="empty-state">
        <i class="fa-solid fa-bullhorn"></i>
        <h4>Belum Ada Pengumuman</h4>
        <p>Klik tombol <strong>Tambah Pengumuman</strong> untuk membuat pengumuman pertama.</p>
      </div>
    @else
      <table class="peng-table">
        <thead>
          <tr>
            <th>#</th>
            <th>Judul</th>
            <th>Isi</th>
            <th>Tanggal</th>
            <th>Status</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          @foreach($pengumumanList as $i => $p)
          <tr>
            <td style="color:#94A3B8;font-size:12px;">
              {{ $pengumumanList->firstItem() + $i }}
            </td>
            <td>
              <div class="judul-cell">{{ $p->judul }}</div>
            </td>
            <td>
              <div class="isi-cell">{{ Str::limit($p->isi, 100) }}</div>
            </td>
            <td style="white-space:nowrap;font-size:12px;color:#64748B;">
              <i class="fa-regular fa-calendar" style="color:#2563EB"></i>
              {{ $p->tanggal_publish->translatedFormat('d M Y') }}
            </td>
            <td>
              @if($p->status === 'aktif')
                <span class="badge-status badge-aktif"><i class="fa-solid fa-circle" style="font-size:6px"></i> Aktif</span>
              @else
                <span class="badge-status badge-nonaktif"><i class="fa-regular fa-circle" style="font-size:6px"></i> Nonaktif</span>
              @endif
            </td>
            <td>
              <div class="act-btns">
                {{-- Edit --}}
                <a href="{{ route('admin.pengumuman.edit', $p->id_pengumuman) }}" class="btn-edit">
                  <i class="fa-solid fa-pen"></i> Edit
                </a>

                {{-- Toggle status --}}
                <form action="{{ route('admin.pengumuman.toggle', $p->id_pengumuman) }}" method="POST" style="display:inline;">
                  @csrf @method('PATCH')
                  <button type="submit" class="btn-toggle" title="Ubah Status">
                    <i class="fa-solid fa-toggle-{{ $p->status === 'aktif' ? 'on' : 'off' }}"></i>
                    {{ $p->status === 'aktif' ? 'Nonaktifkan' : 'Aktifkan' }}
                  </button>
                </form>

                {{-- Hapus --}}
                <form action="{{ route('admin.pengumuman.destroy', $p->id_pengumuman) }}" method="POST"
                      style="display:inline;"
                      onsubmit="return confirm('Yakin ingin menghapus pengumuman ini?')">
                  @csrf @method('DELETE')
                  <button type="submit" class="btn-hapus">
                    <i class="fa-solid fa-trash"></i> Hapus
                  </button>
                </form>
              </div>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>

      {{-- Pagination --}}
      @if($pengumumanList->hasPages())
        <div class="peng-pagination">
          {{$pengumumanList->links('pagination::simple-default')}}
        </div>
      @endif

    @endif
  </div>

</div>
@endsection
