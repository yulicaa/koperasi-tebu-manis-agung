<?php if($paginator->hasPages()): ?>
    <nav class="d-flex flex-column justify-content-center">
        <div class="mb-3">
            <p class="small text-muted">
                <?php echo __('Showing'); ?>

                <span class="fw-semibold"><?php echo e($paginator->firstItem()); ?></span>
                <?php echo __('to'); ?>

                <span class="fw-semibold"><?php echo e($paginator->lastItem()); ?></span>
                <?php echo __('of'); ?>

                <span class="fw-semibold"><?php echo e($paginator->total()); ?></span>
                <?php echo __('results'); ?>

            </p>
        </div>

        <div class="pagination-wrapper">
            <ul class="pagination justify-content-center">
                
                <?php if($paginator->onFirstPage()): ?>
                    <li class="page-item disabled" aria-disabled="true" aria-label="<?php echo app('translator')->get('pagination.previous'); ?>">
                        <span class="page-link" aria-hidden="true">&lsaquo;</span>
                    </li>
                <?php else: ?>
                    <li class="page-item">
                        <a class="page-link" href="<?php echo e($paginator->previousPageUrl()); ?>" rel="prev"
                            aria-label="<?php echo app('translator')->get('pagination.previous'); ?>">&lsaquo;</a>
                    </li>
                <?php endif; ?>

                
                <?php
                    $start = max($paginator->currentPage() - 1, 1);
                    $end = min(max($paginator->currentPage() + 1, 3), $paginator->lastPage());
                    if ($paginator->currentPage() > $paginator->lastPage() - 2) {
                        $start = max($paginator->lastPage() - 2, 1);
                    }
                ?>

                <?php for($i = $start; $i <= $end; $i++): ?>
                    <?php if($i == $paginator->currentPage()): ?>
                        <li class="page-item active" aria-current="page"><span class="page-link"><?php echo e($i); ?></span></li>
                    <?php else: ?>
                        <li class="page-item"><a class="page-link" href="<?php echo e($paginator->url($i)); ?>"><?php echo e($i); ?></a></li>
                    <?php endif; ?>
                <?php endfor; ?>

                
                <?php if($paginator->hasMorePages()): ?>
                    <li class="page-item">
                        <a class="page-link" href="<?php echo e($paginator->nextPageUrl()); ?>" rel="next"
                            aria-label="<?php echo app('translator')->get('pagination.next'); ?>">&rsaquo;</a>
                    </li>
                <?php else: ?>
                    <li class="page-item disabled" aria-disabled="true" aria-label="<?php echo app('translator')->get('pagination.next'); ?>">
                        <span class="page-link" aria-hidden="true">&rsaquo;</span>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>
<?php endif; ?>
<?php /**PATH C:\xampp\htdocs\koperasi-tebu-manis-agung\resources\views/vendor/pagination/bootstrap-5.blade.php ENDPATH**/ ?>