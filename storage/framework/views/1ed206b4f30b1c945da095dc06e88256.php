<?php $__env->startSection('heading'); ?>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Pinjaman</h1>
    <?php if(Auth::user()->role === 'USER'): ?>
    <a href="<?php echo e(route('pinjaman.create.page')); ?>" class="btn btn-primary btn" style="white-space: nowrap;">Ajukan
        Pinjaman</a>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<!-- Content Row -->
<div class="row px-2">
    <div class="card shadow col-xl-12 col-md-12 mb-4">
        <div class="card-header bg-white py-3 d-flex align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Pinjaman</h6>
            <form method="GET" action="<?php echo e(route('pinjaman.index')); ?>" class="d-flex align-items-center">
                <!-- Status Filter -->
                <select name="status" class="form-control mr-2" onchange="this.form.submit()">
                    <option value="">All</option>
                    <option value="PENDING" <?php echo e(request('status') == 'PENDING' ? 'selected' : ''); ?>>Pending</option>
                    <option value="ON GOING" <?php echo e(request('status') == 'ON GOING' ? 'selected' : ''); ?>>On Going</option>
                    <option value="PAID" <?php echo e(request('status') == 'PAID' ? 'selected' : ''); ?>>Paid</option>
                    <option value="REJECTED" <?php echo e(request('status') == 'REJECTED' ? 'selected' : ''); ?>>Rejected</option>
                </select>
            </form>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No. </th>
                            <th>ID Pinjaman</th>
                            <th>Nama Peminjam</th>
                            <th>Total Pinjaman</th>
                            <th>Tenor</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if($dataPinjamans->isNotEmpty()): ?>
                        <?php $__currentLoopData = $dataPinjamans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pinjaman): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($loop->iteration); ?></td>
                            <td class="align-middle"><?php echo e($pinjaman->id); ?></td>
                            <td class="align-middle"><?php echo e($pinjaman->user->name); ?></td>
                            <td class="align-middle"><?php echo e($pinjaman->total_pinjaman); ?></td>
                            <td class="align-middle"><?php echo e($pinjaman->tenor); ?> Bulan</td>
                            <td class="align-middle"><?php echo e($pinjaman->status); ?></td>
                            <td class="text-center">
                                <a href="<?php echo e(route('pinjaman.detail', ['pinjamanId' => $pinjaman->id])); ?>">
                                    <i class="fas fa-eye"></i>
                                </a>
                                
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center">No data available</td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
                <div class="d-flex justify-content-center">
                    <?php echo e($dataPinjamans->links('pagination::bootstrap-5')); ?>

                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete User Modal -->
<div class="modal fade" id="deleteUserModal" tabindex="-1" aria-labelledby="deleteUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteUserModalLabel">Delete User?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="deleteUserForm" method="POST" action="">
                <?php echo csrf_field(); ?>
                <?php echo method_field('DELETE'); ?>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">Nama</label>
                        <input type="text" class="form-control" id="name" name="name" disabled>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" disabled>
                    </div>
                    <div class="form-group">
                        <label for="nik">NIK</label>
                        <input type="text" class="form-control" id="nik" name="nik" disabled>
                    </div>
                    <div class="form-group">
                        <label for="no_telp">No. Telp</label>
                        <input type="text" class="form-control" id="noTelp" name="noTelp" disabled>
                    </div>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>


<?php $__env->stopSection(); ?>
<?php echo $__env->make('components.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\koperasi-tebu-manis-agung\resources\views/pinjaman/index.blade.php ENDPATH**/ ?>