<?php $__env->startSection('title', 'Tambah Pengguna'); ?>
<?php $__env->startSection('page-title', 'Tambah Pengguna'); ?>
<?php $__env->startSection('page-subtitle', 'Buat akun pengguna baru'); ?>

<?php $__env->startSection('content'); ?>
<div style="max-width:640px">
    <div class="card">
        <div class="card-header">
            <div class="card-title">Form Tambah Pengguna</div>
            <a href="<?php echo e(route('superadmin.akun.index')); ?>" class="btn btn-secondary btn-sm">
                <i class="fa-solid fa-arrow-left"></i> Kembali
            </a>
        </div>

        <form method="POST" action="<?php echo e(route('superadmin.akun.store')); ?>">
            <?php echo csrf_field(); ?>

            <div class="form-group">
                <label class="form-label">Username <span style="color:var(--danger)">*</span></label>
                <input type="text" name="username" class="form-control" value="<?php echo e(old('username')); ?>" required>
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
                <input type="text" name="nama" class="form-control" value="<?php echo e(old('nama')); ?>" required>
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
                <input type="email" name="email" class="form-control" value="<?php echo e(old('email')); ?>">
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
                        <option value="">-- Pilih Role --</option>
                        <?php $__currentLoopData = ['super_admin','admin','teknisi','mahasiswa','dosen']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($r); ?>" <?php echo e(old('role') === $r ? 'selected' : ''); ?>>
                                <?php echo e(ucfirst(str_replace('_',' ',$r))); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <?php $__errorArgs = ['role'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="form-error"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div class="form-group">
                    <label class="form-label">Status <span style="color:var(--danger)">*</span></label>
                    <select name="status" class="form-control" required>
                        <option value="aktif"    <?php echo e(old('status','aktif') === 'aktif'    ? 'selected' : ''); ?>>Aktif</option>
                        <option value="nonaktif" <?php echo e(old('status') === 'nonaktif' ? 'selected' : ''); ?>>Nonaktif</option>
                    </select>
                    <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="form-error"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
            </div>

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px">
                <div class="form-group">
                    <label class="form-label">Password <span style="color:var(--danger)">*</span></label>
                    <input type="password" name="password" class="form-control" required>
                    <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="form-error"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div class="form-group">
                    <label class="form-label">Konfirmasi Password <span style="color:var(--danger)">*</span></label>
                    <input type="password" name="password_confirmation" class="form-control" required>
                </div>
            </div>

            <div style="display:flex;gap:12px;justify-content:flex-end;margin-top:8px">
                <a href="<?php echo e(route('superadmin.akun.index')); ?>" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-primary">
                    <i class="fa-solid fa-user-plus"></i> Simpan Pengguna
                </button>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('superadmin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\aqas\resources\views/superadmin/akun/create.blade.php ENDPATH**/ ?>