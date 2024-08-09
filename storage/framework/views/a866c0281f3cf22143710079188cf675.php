<?php $__env->startSection('heading'); ?>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800 hide-print">Laporan</h1>
    <a onclick="printLaporan()" class="btn btn-primary btn hide-print">Print <i class="fas fa-print"></i></a>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<!-- Content Row -->
<div id="main-container" class="row px-2">
    <div class="card shadow col-xl-12 col-md-12 mb-4">
        <div class="card-header bg-white py-3 d-flex align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Laporan</h6>
            <form method="GET" action="<?php echo e(route('laporan.index')); ?>" class="d-flex align-items-center">
                <!-- Month Filter -->
                <select name="month" class="form-control mr-2" onchange="this.form.submit()">
                    <option value="">Month</option>
                    <?php $__currentLoopData = range(1, 12); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $month): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($month); ?>" <?php echo e(request('month') == $month ? 'selected' : ''); ?>>
                        <?php echo e(\Carbon\Carbon::createFromFormat('m', $month)->format('F')); ?>

                    </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>

                <!-- Year Filter -->
                <select name="year" class="form-control mr-2" onchange="this.form.submit()">
                    <option value="">Year</option>
                    <?php $__currentLoopData = range(date('Y'), date('Y') - 10); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $year): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($year); ?>" <?php echo e(request('year') == $year ? 'selected' : ''); ?>>
                        <?php echo e($year); ?>

                    </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>

                <!-- Status Filter -->
                

                <!-- Submit Button -->
                
            </form>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No.</th>
                            
                            <th>Nama</th>
                            <th>Angsuran</th>
                            <th>Jumlah Tagihan</th>
                            <th>Tanggal Bayar</th>
                            
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if($dataTagihans->isNotEmpty()): ?>
                        <?php $__currentLoopData = $dataTagihans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tagihan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($loop->iteration); ?></td>
                            
                            <td class="align-middle"><?php echo e($tagihan->user->name); ?></td>
                            <td class="align-middle"><?php echo e($tagihan->angsuran); ?> dari <?php echo e($tagihan->pinjaman->tenor); ?></td>
                            <td class="align-middle"><?php echo e($tagihan->total_tagihan); ?></td>
                            <td class="align-middle"><?php echo e($tagihan->updated_at->format('d-m-Y H:i:s')); ?></td>
                            
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
    // function printLaporan() {
    //     window.location.href = '<?php echo e(route('laporan.print')); ?>';
    // }

    function printLaporan() {
        const month = document.querySelector('select[name="month"]').value;
        const year = document.querySelector('select[name="year"]').value;
        // const status = document.querySelector('select[name="status"]').value;

        const url = new URL("<?php echo e(route('laporan.print')); ?>", window.location.origin);
        if (month) url.searchParams.append('month', month);
        if (year) url.searchParams.append('year', year);
        // if (status) url.searchParams.append('status', status);

        window.location.href = url.toString();
    }
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
                form.action = "<?php echo e(route('admin.user.delete', ['userId' => ':userId'])); ?>"
                    .replace(':userId', userId);
            });
        });
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('components.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\koperasi-tebu-manis-agung\resources\views/laporan/index.blade.php ENDPATH**/ ?>