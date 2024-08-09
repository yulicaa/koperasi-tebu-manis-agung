<div class="card shadow col-xl-12 col-md-12 mb-4">
    <div class="card-header bg-white py-3 d-flex align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">Bukti Transfer</h6>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <?php if($upload && $upload->count() > 0): ?>
                    <div class="d-flex justify-content-center align-items-center" style="height: 100%;">
                        <div class="image-card-mycars">
                            <img class="border" style="width: 200px; height: 150px; object-fit: cover; cursor: pointer;"
                                data-bs-toggle="modal" data-bs-target="#imageModal"
                                src="<?php echo e(asset('storage/uploads/' . $upload->file_name . '.' . $upload->file_type)); ?>"
                                alt="<?php echo e($upload->file_name . '.' . $upload->file_type); ?>">
                        </div>
                    </div>
                    <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="imageModalLabel">Image Preview</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <img src="<?php echo e(asset('storage/uploads/' . $upload->file_name . '.' . $upload->file_type)); ?>"
                                        alt="<?php echo e($upload->file_name); ?>" style="width: 100%;">
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <?php if(Auth::user()->role === 'ADMIN' && $tagihan->status === 'ON PROCESS'): ?>
            <form method="POST" action="<?php echo e(route('tagihan.update', ['tagihanId' => $tagihan->id])); ?>">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PATCH'); ?>
                <input type="hidden" name="tagihanId" value="<?php echo e($tagihan->id); ?>">
                <div class="col-md-12 d-flex justify-content-center mt-5">
                    <button type="submit" name="action" value="PAID"
                        class="btn btn-success w-100 mx-2">Approve</button>
                    <button type="submit" name="action" value="REJECTED"
                        class="btn btn-danger w-100 mx-2">Reject</button>
                </div>
            </form>
        <?php endif; ?>
    </div>
</div>
<?php /**PATH C:\xampp\htdocs\koperasi-tebu-manis-agung\resources\views/components/bukti.blade.php ENDPATH**/ ?>