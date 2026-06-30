<!DOCTYPE html>
<html lang="id">
<head>
  <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Profil Admin</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  
  <style>
    body {
      background-color: #f0f4fd;
      font-family: 'Inter', sans-serif;
    }
    
    .card-custom {
      border: none;
      border-radius: 20px;
      overflow: hidden;
      box-shadow: 0 10px 30px rgba(13, 110, 253, 0.05);
    }
    
    .card-header-futuristic {
      background: linear-gradient(135deg, #0d6efd 0%, #0b5ed7 100%);
      border-bottom: none;
      position: relative;
    }
    
    .form-label {
      font-weight: 600;
      color: #2d3748;
      font-size: 0.875rem;
    }
    
    .form-control {
      border-radius: 10px;
      padding: 0.65rem 1rem;
      border: 1px solid #e2e8f0;
      background-color: #f8fafc;
      transition: all 0.3s;
    }
    
    .form-control:focus {
      background-color: #fff;
      border-color: #0d6efd;
      box-shadow: 0 0 0 4px rgba(13, 110, 253, 0.15);
    }

    .btn-futuristic-primary {
      background: linear-gradient(135deg, #0d6efd 0%, #0b5ed7 100%);
      color: white;
      border: none;
      padding: 0.75rem 1.75rem;
      border-radius: 10px;
      font-weight: 600;
      transition: all 0.3s;
    }
    
    .btn-futuristic-primary:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 25px rgba(13, 110, 253, 0.4);
      color: white;
    }

    .btn-futuristic-secondary {
      background-color: #fff;
      color: #4a5568;
      border: 1px solid #e2e8f0;
      padding: 0.75rem 1.75rem;
      border-radius: 10px;
      font-weight: 600;
      transition: all 0.3s ease;
      text-decoration: none;
    }
    
    .btn-futuristic-secondary:hover {
      background-color: #f8fafc;
      color: #2d3748;
      border-color: #cbd5e1;
    }

    .photo-preview {
      width: 120px;
      height: 120px;
      border-radius: 50%;
      object-fit: cover;
      border: 4px solid #fff;
      box-shadow: 0 4px 15px rgba(0,0,0,0.1);
      margin-bottom: 15px;
    }
    
    .photo-placeholder {
      width: 120px;
      height: 120px;
      border-radius: 50%;
      background: linear-gradient(135deg, #0d6efd, #0b5ed7);
      color: white;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 48px;
      font-weight: bold;
      border: 4px solid #fff;
      box-shadow: 0 4px 15px rgba(0,0,0,0.1);
      margin-bottom: 15px;
    }
  </style>
</head>
<body>

<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-lg-8 col-xl-7">
      
      @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert" style="border-radius:15px;">
          <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      @endif
      
      @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm" role="alert" style="border-radius:15px;">
          <i class="fas fa-exclamation-circle me-2"></i> Terdapat kesalahan input.
          <ul class="mb-0 mt-2">
            @foreach($errors->all() as $err)
              <li>{{ $err }}</li>
            @endforeach
          </ul>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      @endif

      <div class="card card-custom">
        <div class="card-header card-header-futuristic text-white p-4">
          <h4 class="mb-1 fw-bold">Edit Profil Admin</h4>
          <p class="mb-0 text-white-50 small">Perbarui data diri dan foto profil Anda</p>
        </div>
        
        <div class="card-body p-4 p-md-5">
          <form action="{{ route('admin.profil.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Bagian Foto Profil -->
            <div class="text-center mb-5">
              <div class="position-relative d-inline-block">
                @if($user->foto_profil)
                  <img src="{{ asset('storage/' . $user->foto_profil) }}" alt="Foto Profil" class="photo-preview" id="preview-image">
                @else
                  <div class="photo-placeholder" id="preview-placeholder">
                    {{ strtoupper(substr($admin->nama_admin ?? $user->username, 0, 1)) }}
                  </div>
                  <img src="" alt="Preview" class="photo-preview d-none" id="preview-image">
                @endif
                
                <div class="mt-3">
                  <label for="foto_profil" class="btn btn-sm btn-outline-primary rounded-pill px-3 fw-bold" style="cursor: pointer;">
                    <i class="fas fa-camera me-1"></i> Ganti Foto
                  </label>
                  <input type="file" id="foto_profil" name="foto_profil" class="d-none" accept="image/*" onchange="previewFile()">
                  <div class="form-text mt-2 small text-muted">Format: JPG, PNG (Max 2MB).</div>
                </div>
              </div>
            </div>

            <div class="row g-4">
              <!-- Nama Lengkap -->
              <div class="col-md-6">
                <label class="form-label">Nama Lengkap</label>
                <div class="input-group">
                  <span class="input-group-text bg-light border-end-0"><i class="fas fa-user text-muted"></i></span>
                  <input type="text" class="form-control border-start-0 ps-0" name="nama_admin" value="{{ old('nama_admin', $admin->nama_admin ?? '') }}" required placeholder="Nama lengkap admin">
                </div>
              </div>

              <!-- Username (Readonly) -->
              <div class="col-md-6">
                <label class="form-label">Username</label>
                <div class="input-group">
                  <span class="input-group-text bg-light border-end-0"><i class="fas fa-id-badge text-muted"></i></span>
                  <input type="text" class="form-control border-start-0 ps-0 bg-light" value="{{ $user->username }}" readonly>
                </div>
              </div>

              <!-- NIP -->
              <div class="col-md-6">
                <label class="form-label">NIP</label>
                <div class="input-group">
                  <span class="input-group-text bg-light border-end-0"><i class="fas fa-hashtag text-muted"></i></span>
                  <input type="text" class="form-control border-start-0 ps-0" name="nip" value="{{ old('nip', $admin->nip ?? '') }}" placeholder="Nomor Induk Pegawai">
                </div>
              </div>

              <!-- Kontak -->
              <div class="col-md-6">
                <label class="form-label">No. Telepon / WhatsApp</label>
                <div class="input-group">
                  <span class="input-group-text bg-light border-end-0"><i class="fas fa-phone text-muted"></i></span>
                  <input type="text" class="form-control border-start-0 ps-0" name="kontak" value="{{ old('kontak', $admin->kontak ?? '') }}" placeholder="Contoh: 08123456789">
                </div>
              </div>
            </div>

            <hr class="my-5" style="border-color: #e2e8f0; opacity: 1;">

            <div class="d-flex justify-content-end gap-3">
              <a href="{{ route('admin.dashboard') }}" class="btn-futuristic-secondary">
                Batal
              </a>
              <button type="submit" class="btn-futuristic-primary">
                <i class="fas fa-save me-1"></i> Simpan Perubahan
              </button>
            </div>

          </form>

          <hr class="my-5" style="border-color: #e2e8f0; opacity: 1;">

          <!-- Form Ganti Password -->
          <form action="{{ route('admin.profil.password') }}" method="POST">
            @csrf
            <h5 class="mb-4 fw-bold text-danger"><i class="fas fa-lock me-2"></i>Keamanan Akun (Ganti Password)</h5>
            
            <div class="row g-4">
              <div class="col-md-12">
                <label class="form-label">Password Lama</label>
                <div class="input-group">
                  <span class="input-group-text bg-light border-end-0"><i class="fas fa-key text-muted"></i></span>
                  <input type="password" class="form-control border-start-0 ps-0" name="password_lama" required placeholder="Masukkan password saat ini">
                </div>
              </div>

              <div class="col-md-6">
                <label class="form-label">Password Baru</label>
                <div class="input-group">
                  <span class="input-group-text bg-light border-end-0"><i class="fas fa-shield-alt text-muted"></i></span>
                  <input type="password" class="form-control border-start-0 ps-0" name="password_baru" required placeholder="Minimal 6 karakter">
                </div>
              </div>

              <div class="col-md-6">
                <label class="form-label">Konfirmasi Password Baru</label>
                <div class="input-group">
                  <span class="input-group-text bg-light border-end-0"><i class="fas fa-check-circle text-muted"></i></span>
                  <input type="password" class="form-control border-start-0 ps-0" name="password_baru_confirmation" required placeholder="Ketik ulang password baru">
                </div>
              </div>
            </div>

            <div class="d-flex justify-content-end mt-4">
              <button type="submit" class="btn btn-danger" style="border-radius: 10px; font-weight: 600; padding: 0.75rem 1.75rem; background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); border: none;">
                <i class="fas fa-key me-1"></i> Update Password
              </button>
            </div>
          </form>
        </div>
      </div>
      
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
  function previewFile() {
    const preview = document.getElementById('preview-image');
    const placeholder = document.getElementById('preview-placeholder');
    const file = document.getElementById('foto_profil').files[0];
    const reader = new FileReader();

    reader.addEventListener("load", function () {
      preview.src = reader.result;
      preview.classList.remove('d-none');
      if(placeholder) placeholder.classList.add('d-none');
    }, false);

    if (file) {
      reader.readAsDataURL(file);
    }
  }
</script>

</body>
</html>

