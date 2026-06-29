<?php $__env->startSection('title','Profil Super Admin'); ?>
<?php $__env->startSection('page-title','Profil Saya'); ?>
<?php $__env->startSection('page-subtitle','Kelola informasi akun Super Admin'); ?>

<?php $__env->startSection('content'); ?>
<div style="display:grid;grid-template-columns:320px 1fr;gap:20px">

    <!-- FOTO PROFIL -->
    <div>
        <div class="card" style="text-align:center">
            <div style="margin-bottom:16px">
                <?php if($user->foto_profil): ?>
                    <img src="<?php echo e(asset('storage/profil/' . $user->foto_profil)); ?>"
                         style="width:120px;height:120px;border-radius:50%;object-fit:cover;border:3px solid var(--primary)" alt="Foto Profil">
                <?php else: ?>
                    <div style="width:120px;height:120px;border-radius:50%;background:linear-gradient(135deg,var(--primary),var(--accent));display:flex;align-items:center;justify-content:center;font-size:48px;font-weight:800;color:#fff;margin:0 auto;border:3px solid var(--border)">
                        <?php echo e(strtoupper(substr($user->nama ?? $user->username, 0, 1))); ?>

                    </div>
                <?php endif; ?>
            </div>
            <div style="font-size:18px;font-weight:700;margin-bottom:4px"><?php echo e($user->nama ?? $user->username); ?></div>
            <div style="font-size:13px;color:var(--primary-light);font-weight:500;margin-bottom:4px">Super Administrator</div>
            <div style="font-size:12px;color:var(--text-muted)"><?php echo e($user->email ?? 'Email belum diset'); ?></div>

            <div style="margin-top:20px;border-top:1px solid var(--border);padding-top:20px">
                <div style="font-size:13px;font-weight:600;margin-bottom:12px;color:var(--text-muted)">Upload Foto Profil</div>
                <form method="POST" action="<?php echo e(route('superadmin.profil.foto')); ?>" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <div class="form-group">
                        <input type="file" name="foto_profil" class="form-control" accept="image/*" required>
                        <?php $__errorArgs = ['foto_profil'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="form-error"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <button type="submit" class="btn btn-primary" style="width:100%">
                        <i class="fa-solid fa-upload"></i> Upload Foto
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- EDIT DATA -->
    <div style="display:flex;flex-direction:column;gap:20px">

        <!-- EDIT PROFIL -->
        <div class="card">
            <div class="card-title" style="margin-bottom:20px">
                <i class="fa-solid fa-user-pen" style="color:var(--primary-light);margin-right:8px"></i>Edit Profil
            </div>
            <form method="POST" action="<?php echo e(route('superadmin.profil.update')); ?>">
                <?php echo csrf_field(); ?>
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px">
                    <div class="form-group">
                        <label class="form-label">Username</label>
                        <input type="text" class="form-control" value="<?php echo e($user->username); ?>" disabled
                               style="opacity:0.6;cursor:not-allowed">
                        <div style="font-size:11px;color:var(--text-dark);margin-top:4px">Username tidak bisa diubah</div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Nama Lengkap <span style="color:var(--danger)">*</span></label>
                        <input type="text" name="nama" class="form-control" value="<?php echo e(old('nama', $user->nama)); ?>" required>
                        <?php $__errorArgs = ['nama'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="form-error"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" value="<?php echo e(old('email', $user->email)); ?>">
                    <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="form-error"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                <div style="display:flex;justify-content:flex-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa-solid fa-floppy-disk"></i> Simpan Profil
                    </button>
                </div>
            </form>
        </div>

        <!-- GANTI PASSWORD -->
        <div class="card">
            <div class="card-title" style="margin-bottom:20px">
                <i class="fa-solid fa-lock" style="color:var(--warning);margin-right:8px"></i>Ganti Password
            </div>
            <form method="POST" action="<?php echo e(route('superadmin.profil.password')); ?>">
                <?php echo csrf_field(); ?>
                <div class="form-group">
                    <label class="form-label">Password Lama <span style="color:var(--danger)">*</span></label>
                    <input type="password" name="password_lama" class="form-control" required>
                    <?php $__errorArgs = ['password_lama'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="form-error"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px">
                    <div class="form-group">
                        <label class="form-label">Password Baru <span style="color:var(--danger)">*</span></label>
                        <input type="password" name="password_baru" class="form-control" required>
                        <?php $__errorArgs = ['password_baru'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="form-error"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Konfirmasi Password Baru</label>
                        <input type="password" name="password_baru_confirmation" class="form-control" required>
                    </div>
                </div>
                <div style="display:flex;justify-content:flex-end">
                    <button type="submit" class="btn btn-warning">
                        <i class="fa-solid fa-key"></i> Ganti Password
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('superadmin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\aqas\resources\views/superadmin/profil/edit.blade.php ENDPATH**/ ?>