<?php $__env->startSection('heading'); ?>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Update User</h1>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="row px-2">
    <div class="card shadow col-xl-12 col-md-12 mb-4">
        <div class="card-header bg-white py-3">
            <h6 class="m-0 font-weight-bold text-primary">Update User</h6>
        </div>
        <div class="card-body">
            <form method="POST" action="<?php echo e(route('admin.user.update', ['userId' => $user->id])); ?>">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="_method" value="PATCH" />
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama</label>
                            <input type="text" class="form-control alphabet-format" name="name" id="name" value="<?php echo e($user->name); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="noTelp" class="form-label">No. Telp</label>
                            <input type="text" class="form-control number-format" name="noTelp" id="noTelp" value="<?php echo e($user->no_telp); ?>" disabled>
                        </div>
                        <div class="mb-3">
                            <label for="tempatLahir" class="form-label">Tempat Lahir</label>
                            <select class="form-control" name="tempatLahir" id="tempatLahir" required>
                                <option value="">--Tempat Lahir--</option>
                                <?php $__currentLoopData = json_decode(file_get_contents('https://www.emsifa.com/api-wilayah-indonesia/api/provinces.json')); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tempat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($tempat->name); ?>" <?php if($tempat->name == $user->tempat_lahir): ?> selected <?php endif; ?>><?php echo e($tempat->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="agama" class="form-label">Agama</label>
                            <select class="form-control" name="agama" id="agama" required>
                                <option value="">--Agama--</option>
                                <option value="Islam" <?php if($user->agama == 'Islam'): ?> selected <?php endif; ?>>Islam</option>
                                <option value="Kristen Protestan" <?php if($user->agama == 'Kristen Protestan'): ?> selected <?php endif; ?>>
                                    Kristen Protestan</option>
                                <option value="Kristen Katolik" <?php if($user->agama == 'Kristen Katolik'): ?> selected <?php endif; ?>>
                                    Kristen Katolik</option>
                                <option value="Hindu" <?php if($user->agama == 'Hindu'): ?> selected <?php endif; ?>>Hindu</option>
                                <option value="Buddha" <?php if($user->agama == 'Buddha'): ?> selected <?php endif; ?>>Buddha</option>
                                <option value="Konghucu" <?php if($user->agama == 'Konghucu'): ?> selected <?php endif; ?>>Konghucu
                                </option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="statusKeanggotaan" class="form-label">Status Keanggotaan</label>
                            <select class="form-control" name="statusKeanggotaan" id="statusKeanggotaan" required>
                                <option value="">--Status Keanggotaan--</option>
                                <option value="Pengurus" <?php if($user->status_keanggotaan == 'Pengurus'): ?> selected <?php endif; ?>>Pengurus
                                </option>
                                <option value="Pengawas" <?php if($user->status_keanggotaan == 'Pengawas'): ?> selected <?php endif; ?>>Pengawas
                                </option>
                                <option value="Anggota" <?php if($user->status_keanggotaan == 'Anggota'): ?> selected <?php endif; ?>>Anggota
                                </option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="penghasilanPerbulan" class="form-label">Penghasilan Perbulan</label>
                            <input type="text" class="form-control" name="penghasilanPerbulan" id="penghasilanPerbulan" value="<?php echo e($user->penghasilan_perbulan); ?>" disabled>
                        </div>
                        <div class="mb-3">
                            <label for="statusPinjaman" class="form-label">Status Pinjaman</label>
                            <input type="text" class="form-control" name="statusPinjaman" id="statusPinjaman" value="<?php echo e($user->status_pinjaman); ?>" disabled>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" id="email" name="email" class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e($user->email); ?>" disabled>
                        </div>
                        <div class="mb-3">
                            <label for="umur" class="form-label">Umur</label>
                            <input type="text" class="form-control" name="umur" id="umur" value="<?php echo e($user->umur); ?>" disabled>
                        </div>
                        <div class="mb-3">
                            <label for="tanggalLahir" class="form-label">Tanggal Lahir</label>
                            <input id="tanggalLahir" name="tanggalLahir" class="form-control" type="date" value="<?php echo e($user->tanggal_lahir); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="statusPerkawinan" class="form-label">Status Perkawinan</label>
                            <select class="form-control" name="statusPerkawinan" id="statusPerkawinan" required>
                                <option value="">--Status Perkawinan--</option>
                                <option value="Menikah" <?php if($user->status_perkawinan == 'Menikah'): ?> selected <?php endif; ?>>Menikah
                                </option>
                                <option value="Lajang" <?php if($user->status_perkawinan == 'Lajang'): ?> selected <?php endif; ?>>Lajang
                                </option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="luasLahan" class="form-label">Luas Lahan (ha)</label>
                            <input type="text" class="form-control" name="luasLahan" id="luasLahan" value="<?php echo e($user->luas_lahan); ?>" disabled>
                        </div>
                        <div class="mb-3">
                            <label for="penghasilanPanen" class="form-label">Penghasilan Panen</label>
                            <input type="text" class="form-control" name="penghasilanPanen" id="penghasilanPanen" value="<?php echo e($user->penghasilan_panen); ?>" disabled>
                        </div>
                        <div class="mb-3">
                            <label for="pinjamanSebelumnya" class="form-label">Pinjaman Sebelumnya</label>
                            <!-- <input type="text" class="form-control" name="pinjamanSebelumnya" id="pinjamanSebelumnya" value="<?php echo e($user->pinjaman_sebelumnya); ?>" disabled> -->
                            <select class="form-control" name="pinjamanSebelumnya" id="pinjamanSebelumnya" required>
                                <option value="">--Pinjaman Sebelumnya--</option>
                                <option value="Lancar" <?php if($user->pinjaman_sebelumnya == 'Lancar'): ?> selected <?php endif; ?>>Lancar
                                </option>
                                <option value="Macet" <?php if($user->pinjaman_sebelumnya == 'Macet'): ?> selected <?php endif; ?>>Macet
                                </option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-center mt-3">
                    <button type="submit" class="btn btn-success w-100">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('components.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\koperasi-tebu-manis-agung\resources\views/admin/users/detail.blade.php ENDPATH**/ ?>