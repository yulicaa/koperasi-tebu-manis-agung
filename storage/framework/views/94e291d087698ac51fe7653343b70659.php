<?php $__env->startSection('heading'); ?>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Detail Tagihan</h1>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="row px-2">
    <div class="card shadow col-xl-12 col-md-12 mb-4">
        <div class="card-header bg-white py-3 d-flex align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Detail Tagihan</h6>
            <h6 class="m-0 font-weight-bold text-info"><?php echo e($tagihan->status); ?></h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="idPinjaman" class="form-label">ID Pinjaman</label>
                        <input type="text" class="form-control" name="idPinjaman" id="idPinjaman" value="<?php echo e($tagihan->pinjaman_id); ?>" onclick="detailPinjaman()" style="cursor: pointer" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="angsuran" class="form-label">Angsuran</label>
                        <input type="text" class="form-control" name="angsuran" id="angsuran" value="<?php echo e($tagihan->angsuran); ?> dari <?php echo e($tagihan->pinjaman->tenor); ?> Bulan " disabled>
                    </div>
                    <div class="mb-3">
                        <label for="tagihanPokok" class="form-label">Tagihan Pokok</label>
                        <input type="text" class="form-control" name="tagihanPokok" id="tagihanPokok" value="<?php echo e($tagihan->tagihan_pokok); ?>" disabled>
                    </div>
                    

            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="idTagihan" class="form-label">ID Tagihan</label>
                    <input type="text" class="form-control" name="idTagihan" id="idTagihan" value="<?php echo e($tagihan->id); ?>" disabled>
                </div>
                <div class="mb-3">
                    <label for="jatuhTempo" class="form-label">Jatuh Tempo</label>
                    <input type="text" class="form-control" name="jatuhTempo" id="jatuhTempo" value="<?php echo e($tagihan->jatuh_tempo ? \Carbon\Carbon::parse($tagihan->jatuh_tempo)->format('d-m-Y') : '-'); ?>" disabled>
                </div>
                <div class="mb-3">
                    <label for="tunggakan" class="form-label">Tunggakan</label>
                    <input type="text" class="form-control" name="tunggakan" id="tunggakan" value="<?php echo e($tagihan->tunggakan); ?>" disabled>
                </div>

            </div>
            <div class="col-md-12">
                <div class="mb-3">
                    <label for="totalTagihan" class="form-label">Total Tagihan</label>
                    <input type="text" class="form-control" name="totalTagihan" id="totalTagihan" value="<?php echo e($tagihan->total_tagihan); ?>" disabled>
                </div>
            </div>
            
</div>
</div>
</div>


<?php if($tagihan->status === 'WAITING FOR PAYMENT' && Auth::user()->role === 'USER'): ?>

<?php echo $__env->make('components.pembayaran', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>


<?php elseif($tagihan->status === 'REJECTED' || $tagihan->status === 'PAID'): ?>


<?php echo $__env->make('components.bukti', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php elseif($tagihan->status === 'ON PROCESS'): ?>

<?php if(Auth::user()->role === 'USER'): ?>

<?php echo $__env->make('components.pembayaran', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php else: ?>
<?php echo $__env->make('components.bukti', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php endif; ?>
<?php endif; ?>


</div>
<?php if($upload && $upload->count() > 0): ?>
<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="imageModalLabel">Image Preview</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <img src="<?php echo e(asset('storage/uploads/' . $upload->file_name . '.' . $upload->file_type)); ?>" alt="<?php echo e($upload->file_name); ?>" style="width: 100%;">
            </div>
        </div>
    </div>
</div>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const fileInput = document.getElementById('fileInput');
        const fileError = document.getElementById('file-error');

        if (fileInput) {
            fileInput.addEventListener('change', function(event) {
                const files = event.target.files;
                let allFilesValid = true;

                if (files.length > 0) {
                    const uploadedFiles = new FormData();

                    for (const file of files) {
                        const fileType = file.type.toLowerCase();

                        if (fileType === "image/jpeg" || fileType === "image/png") {
                            uploadedFiles.append('files[]', file);
                            const reader = new FileReader();
                            reader.onload = function(e) {
                                const fileLabel = document.getElementById('fileName');
                                fileLabel.innerText = file.name;
                                fileError.style.display = 'none';
                            };
                            reader.readAsDataURL(file);
                        } else {
                            allFilesValid = false;
                            break;
                        }
                    }

                    if (!allFilesValid) {
                        fileError.innerText = 'Only JPG and PNG files are allowed.';
                        fileError.style.display = 'block';
                        fileInput.value = '';
                    }
                }
            });
        }
    });

    function detailPinjaman() {
        const pinjamanId = document.getElementById('idPinjaman').value;
        const url = "<?php echo e(route('pinjaman.detail',['pinjamanId' => ':pinjamanId '])); ?>".replace(':pinjamanId', pinjamanId);
        window.location.href = url;
    }


    function deleteImage(imageId) {
        if (confirm('Hapus Bukti Tagihan?')) {
            const formData = new FormData();
            formData.append('_method', 'DELETE'); // This is for Laravel method spoofing
            formData.append('_token', '<?php echo e(csrf_token()); ?>');
            formData.append('uploadId', imageId);
            formData.append('tagihanId', document.getElementById('idTagihan').value);

            fetch(`/tagihan/upload/${imageId}`, {
                    method: 'POST', // Use POST method to support FormData
                    headers: {
                        'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>',
                    },
                    body: formData
                })
                .then(response => {
                    if (response.ok) {
                        location.reload(); // Reload the page after successful deletion
                    } else {
                        console.error('Failed to delete the image.');
                    }
                })
                .catch(error => console.error('Error deleting image:', error));
        }
    }
</script>
<?php echo $__env->make('components.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\koperasi-tebu-manis-agung\resources\views/tagihan/detail.blade.php ENDPATH**/ ?>