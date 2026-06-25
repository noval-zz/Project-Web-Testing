@extends('layouts.dashboard')

@section('title', 'Tambah Pengumuman Sarpras')

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
  .form-wrap {
    font-family: 'Inter', sans-serif;
    background: #F1F5F9;
    min-height: calc(100vh - 70px);
    padding: 28px 32px 48px;
  }
  .form-card {
    background: #fff;
    border: 1px solid #E2E8F0;
    border-radius: 16px;
    padding: 32px;
    max-width: 720px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.06);
  }
  .form-card h2 {
    font-size: 18px;
    font-weight: 800;
    color: #0F172A;
    margin: 0 0 24px;
    display: flex;
    align-items: center;
    gap: 10px;
  }
  .form-card h2 i { color: #2563EB; }
  .form-group { margin-bottom: 18px; }
  .form-group label {
    display: block;
    font-size: 13px;
    font-weight: 600;
    color: #374151;
    margin-bottom: 6px;
  }
  .form-group input,
  .form-group textarea,
  .form-group select {
    width: 100%;
    border: 1.5px solid #E2E8F0;
    border-radius: 10px;
    padding: 10px 14px;
    font-size: 13px;
    font-family: 'Inter', sans-serif;
    color: #0F172A;
    background: #fff;
    transition: border-color .2s, box-shadow .2s;
    outline: none;
  }
  .form-group input:focus,
  .form-group textarea:focus,
  .form-group select:focus {
    border-color: #2563EB;
    box-shadow: 0 0 0 3px rgba(37,99,235,0.10);
  }
  .form-group textarea { resize: vertical; min-height: 120px; }
  .error-msg { font-size: 11.5px; color: #DC2626; margin-top: 4px; }
  .form-actions { display: flex; gap: 12px; margin-top: 24px; }
  .btn-submit {
    background: #2563EB;
    color: #fff;
    border: none;
    border-radius: 10px;
    padding: 11px 28px;
    font-size: 13px;
    font-weight: 700;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    transition: background .2s, transform .15s;
  }
  .btn-submit:hover { background: #1D4ED8; transform: translateY(-1px); }
  .btn-cancel {
    background: #F1F5F9;
    color: #64748B;
    border: 1px solid #E2E8F0;
    border-radius: 10px;
    padding: 11px 20px;
    font-size: 13px;
    font-weight: 600;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    transition: background .15s;
  }
  .btn-cancel:hover { background: #E2E8F0; }
  .breadcrumb {
    font-size: 12px;
    color: #94A3B8;
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    gap: 6px;
  }
  .breadcrumb a { color: #2563EB; text-decoration: none; }
  .breadcrumb a:hover { text-decoration: underline; }
</style>
@endpush

@section('content')
<div class="form-wrap">

  {{-- Breadcrumb --}}
  <div class="breadcrumb">
    <a href="{{ route('admin.dashboard') }}">Dashboard</a>
    <i class="fa-solid fa-chevron-right" style="font-size:9px"></i>
    <a href="{{ route('admin.pengumuman.index') }}">Pengumuman</a>
    <i class="fa-solid fa-chevron-right" style="font-size:9px"></i>
    <span>Tambah Baru</span>
  </div>

  <div class="form-card">
    <h2><i class="fa-solid fa-bullhorn"></i> Tambah Pengumuman Sarpras</h2>

    <form action="{{ route('admin.pengumuman.store') }}" method="POST">
      @csrf

      {{-- Judul --}}
      <div class="form-group">
        <label for="judul">Judul Pengumuman <span style="color:#DC2626">*</span></label>
        <input type="text" id="judul" name="judul" placeholder="Contoh: Perbaikan Jaringan Internet Kampus"
               value="{{ old('judul') }}" maxlength="200">
        @error('judul')<div class="error-msg">{{ $message }}</div>@enderror
      </div>

      {{-- Isi --}}
      <div class="form-group">
        <label for="isi">Isi Pengumuman <span style="color:#DC2626">*</span></label>
        <textarea id="isi" name="isi" placeholder="Tulis isi pengumuman secara detail...">{{ old('isi') }}</textarea>
        @error('isi')<div class="error-msg">{{ $message }}</div>@enderror
      </div>

      {{-- Tanggal Publish --}}
      <div class="form-group">
        <label for="tanggal_publish">Tanggal Publish <span style="color:#DC2626">*</span></label>
        <input type="date" id="tanggal_publish" name="tanggal_publish"
               value="{{ old('tanggal_publish', date('Y-m-d')) }}">
        @error('tanggal_publish')<div class="error-msg">{{ $message }}</div>@enderror
      </div>

      {{-- Status --}}
      <div class="form-group">
        <label for="status">Status <span style="color:#DC2626">*</span></label>
        <select id="status" name="status">
          <option value="aktif"    {{ old('status', 'aktif') === 'aktif' ? 'selected' : '' }}>✅ Aktif — Tampil di dashboard mahasiswa</option>
          <option value="nonaktif" {{ old('status') === 'nonaktif' ? 'selected' : '' }}>⛔ Nonaktif — Disembunyikan dari mahasiswa</option>
        </select>
        @error('status')<div class="error-msg">{{ $message }}</div>@enderror
      </div>

      <div class="form-actions">
        <button type="submit" class="btn-submit" id="btn-simpan-pengumuman">
          <i class="fa-solid fa-floppy-disk"></i> Simpan Pengumuman
        </button>
        <a href="{{ route('admin.pengumuman.index') }}" class="btn-cancel">
          <i class="fa-solid fa-xmark"></i> Batal
        </a>
      </div>
    </form>
  </div>

</div>
@endsection
