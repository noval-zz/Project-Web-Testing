<?php $__env->startSection('title', 'Edit Pengguna'); ?>
<?php $__env->startSection('page-title', 'Edit Pengguna'); ?>
<?php $__env->startSection('page-subtitle', 'Ubah data pengguna: ' . $pengguna->username); ?>

<?php $__env->startSection('content'); ?>
<div style="max-width:640px">

    <!-- EDIT PROFIL -->
    <div class="card" style="margin-bottom:20px">
        <div class="card-header">
            <div class="card-title">Edit Data Pengguna</div>
            <a href="<?php echo e(route('superadmin.akun.index')); ?>" class="btn btn-secondary btn-sm">
                <i class="fa-solid fa-arrow-left"></i> Kembali
            </a>
        </div>

        <form method="POST" action="<?php echo e(route('superadmin.akun.update', $pengguna->id_user)); ?>">
            <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>

            <div class="form-group">
                <label class="form-label">Username <span style="color:var(--danger)">*</span></label>
                <input type="text" name="username" class="form-control" value="<?php echo e(old('username', $pengguna->username)); ?>" required>
                <?php $__errorArgs = ['username'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="form-error"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div class="form-group">
                <label class="form-label">Nama Lengkap <span style="color:var(--danger)">*</span></label>
                <input type="text" name="nama" class="form-control" value="<?php echo e(old('nama', $pengguna->nama)); ?>" required>
                <?php $__errorArgs = ['nama'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="form-error"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div class="form-group">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" value="<?php echo e(old('email', $pengguna->email)); ?>">
                <?php $__errorArgs = ['email'];
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
                    <label class="form-label">Role <span style="color:var(--danger)">*</span></label>
                    <select name="role" class="form-control" required>
                        <?php $__currentLoopData = ['super_admin','admin','teknisi','mahasiswa','dosen']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($r); ?>" <?php echo e((old('role',$pengguna->role) === $r) ? 'selected' : ''); ?>>
                                <?php echo e(ucfirst(str_replace('_',' ',$r))); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Status <span style="color:var(--danger)">*</span></label>
                    <select name="status" class="form-control" required>
                        <option value="aktif"    <?php echo e((old('status',$pengguna->status) === 'aktif')    ? 'selected' : ''); ?>>Aktif</option>
                        <option value="nonaktif" <?php echo e((old('status',$pengguna->status) === 'nonaktif') ? 'selected' : ''); ?>>Nonaktif</option>
                    </select>
                </div>
            </div>

            <div style="display:flex;gap:12px;justify-content:flex-end">
                <button type="submit" class="btn btn-primary">
                    <i class="fa-solid fa-floppy-disk"></i> Simpan Perubahan
                </button>
            </div>
        </form>
    </div>

    <!-- RESET PASSWORD -->
    <div class="card">
        <div class="card-title" style="margin-bottom:16px">
            <i class="fa-solid fa-key" style="color:var(--warning);margin-right:8px"></i>Reset Password
        </div>

        <form method="POST" action="<?php echo e(route('superadmin.akun.reset-password', $pengguna->id_user)); ?>">
            <?php echo csrf_field(); ?>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px">
                <div class="form-group">
                    <label class="form-label">Password Baru</label>
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
                    <label class="form-label">Konfirmasi Password</label>
                    <input type="password" name="password_baru_confirmation" class="form-control" required>
                </div>
            </div>
            <button type="submit" class="btn btn-warning" onclick="return confirm('Reset password pengguna <?php echo e($pengguna->username); ?>?')">
                <i class="fa-solid fa-rotate"></i> Reset Password
            </button>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('superadmin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\aqas\resources\views/superadmin/akun/edit.blade.php ENDPATH**/ ?>