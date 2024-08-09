<?php $__env->startSection('heading'); ?>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Tagihan</h1>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<!-- Content Row -->
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
                            <th>No.</th>
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
                            <td class="align-middle"><?php echo e($tagihan->angsuran); ?> Dari <?php echo e($tagihan->pinjaman->tenor); ?></td>
                            <td class="align-middle"><?php echo e(\Carbon\Carbon::parse($tagihan->jatuh_tempo)->format('d-m-Y')); ?></td>
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
                            <td colspan="7" class="text-center">No data available</td>
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

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const deleteButtons = document.querySelectorAll('.delete-user-btn');
        deleteButtons.forEach(button => {
            button.addEventListener('click', function() {
                // Get user data from data attributes
                const name = this.getAttribute('data-name');
                const email = this.getAttribute('data-email');
                const nik = this.getAttribute('data-nik');
                const noTelp = this.getAttribute('data-no-telp');

                // Populate modal form fields
                document.getElementById('name').value = name;
                document.getElementById('email').value = email;
                document.getElementById('nik').value = nik;
                document.getElementById('noTelp').value = noTelp;

                // Set the form action dynamically based on user ID
                const userId = this.dataset.userId; // Ensure you have this dataset in your HTML
                const form = document.getElementById('deleteUserForm');
                form.action = "<?php echo e(route('admin.user.delete', ['userId' => ':userId'])); ?>".replace(':userId', userId);
            });
        });
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('components.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\koperasi-tebu-manis-agung\resources\views/tagihan/index.blade.php ENDPATH**/ ?>