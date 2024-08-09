<?php $__env->startSection('heading'); ?>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Detail Pinjaman</h1>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="row px-2">
    <div class="card shadow col-xl-12 col-md-12 mb-4">
        <div class="card-header bg-white py-3 d-flex align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Detail Pinjaman</h6>
            <h6 class="m-0 font-weight-bold text-info"><?php echo e($dataPinjaman->status); ?></h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <input type="text" class="form-control" id="idUser" value="<?php echo e($dataPinjaman->user->id); ?>" hidden>
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="name" value="<?php echo e($dataPinjaman->user->name); ?>" <?php if(Auth::user()->role === 'ADMIN'): ?> onclick="detailUser()" style="cursor: pointer"
                        <?php else: ?>
                        disabled <?php endif; ?>
                        readonly>
                    </div>
                    <div class="mb-3">
                        <label for="jumlahPinjaman" class="form-label">Total Pinjaman</label>
                        <input type="text" class="form-control" name="jumlahPinjaman" id="jumlahPinjaman" value="<?php echo e($dataPinjaman->total_pinjaman); ?>" disabled>
                    </div>
                    <div class="mb-3">
                        <label for="bank" class="form-label">Bank</label>
                        <input type="text" class="form-control" name="bank" id="bank" value="<?php echo e($dataPinjaman->bank); ?>" disabled>
                    </div>
                    <div class="mb-3">
                        <label for="tipePinjaman" class="form-label">Tipe Pinjaman</label>
                        <input type="text" class="form-control" name="tipePinjaman" id="tipePinjaman" value="<?php echo e($dataPinjaman->tipe_pinjaman); ?>" disabled>
                    </div>

                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="text" class="form-control" name="email" id="email" value="<?php echo e(Auth::user()->email); ?>" disabled>
                    </div>
                    <div class="mb-3">
                        <label for="namaPemilikRekening" class="form-label">Nama Pemilik Rekening</label>
                        <input type="text" class="form-control" name="namaPemilikRekening" id="namaPemilikRekening" value="<?php echo e($dataPinjaman->nama_pemilik_rekening); ?>" disabled>
                    </div>
                    <div class="mb-3">
                        <label for="noRekening" class="form-label">No. Rekening</label>
                        <input type="text" class="form-control" name="noRekening" id="noRekening" value="<?php echo e($dataPinjaman->no_rek); ?>" disabled>
                    </div>
                    <div class="mb-3">
                        <label for="tenor" class="form-label">Tenor</label>
                        <input type="text" class="form-control" name="tenor" id="tenor" value="<?php echo e($dataPinjaman->tenor); ?> Bulan" disabled>
                    </div>

                </div>
                <?php if(Auth::user()->role === 'ADMIN'): ?>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="status" class="form-label">Status Pinjaman</label>
                        <input type="text" class="form-control" name="status" id="status" value="<?php echo e($dataPinjaman->status); ?>" disabled>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="statusKelayakan" class="form-label">Status Kelayakan</label>
                        <input type="text" class="form-control" name="statusKelayakan" id="statusKelayakan" value="<?php echo e($dataPinjaman->status_kelayakan); ?>" disabled>
                    </div>
                </div>
                <?php else: ?>
                <div class="col-md-12">
                    <div class="mb-3">
                        <label for="status" class="form-label">Status Pinjaman</label>
                        <input type="text" class="form-control" name="status" id="status" value="<?php echo e($dataPinjaman->status); ?>" disabled>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
        <?php if(Auth::user()->role === 'ADMIN' && $dataPinjaman->status === 'PENDING'): ?>
        <form method="POST" action="<?php echo e(route('pinjaman.update', ['pinjamanId' => $dataPinjaman->id])); ?>">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PATCH'); ?>
            <input type="hidden" name="pinjamanId" value="<?php echo e($dataPinjaman->id); ?>">
            <div class="col-md-12 d-flex justify-content-center mt-2 mb-5">
                <button type="submit" name="action" value="APPROVED" class="btn btn-success w-100 mx-2">Approve</button>
                <button type="submit" name="action" value="REJECTED" class="btn btn-danger w-100 mx-2">Reject</button>
            </div>
        </form>
        <?php endif; ?>
    </div>
</div>
<?php if(!in_array($dataPinjaman->status, ['PENDING', 'REJECTED']) && $dataPinjaman->tipe_pinjaman != 'Potongan'): ?>
<div class="row px-2">
    <div class="card shadow col-xl-12 col-md-12 mb-4">
        <div class="card-header bg-white py-3 d-flex align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Tagihan</h6>
            
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>ID Tagihan</th>
                            <th>Jumlah Tagihan</th>
                            <th>Tenor</th>
                            <th>Jatuh Tempo</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if($dataTagihans->isNotEmpty()): ?>
                        <?php $__currentLoopData = $dataTagihans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tagihan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($loop->iteration); ?></td>
                            <td class="align-middle"><?php echo e($tagihan->id); ?></td>
                            <td class="align-middle"><?php echo e($tagihan->total_tagihan); ?></td>
                            <td class="align-middle"><?php echo e($tagihan->angsuran); ?> Dari
                                <?php echo e($tagihan->pinjaman->tenor); ?>

                            </td>
                            <td class="align-middle">
                                <?php echo e($tagihan->jatuh_tempo ? \Carbon\Carbon::parse($tagihan->jatuh_tempo)->format('d-m-Y') : '-'); ?>

                            </td>
                            <td class="align-middle"><?php echo e($tagihan->status); ?></td>
                            <td class="text-center">
                                <a href="<?php echo e(route('tagihan.detail', ['tagihanId' => $tagihan->id])); ?>">
                                    <i class="fas fa-eye"></i>
                                </a>
                                
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center">No data available</td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
                <div class="d-flex justify-content-center">
                    <?php echo e($dataTagihans->links('pagination::bootstrap-5')); ?>

                </div>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<script>
    function detailUser() {
        const userId = document.getElementById('idUser').value;
        const url = "{ route('admin.user.detail', ['userId' => ': userId']) }}".replace(':userId', userId);
        window.location.href = url;
    }
</script>
<?php echo $__env->make('components.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\koperasi-tebu-manis-agung\resources\views/pinjaman/detail.blade.php ENDPATH**/ ?>