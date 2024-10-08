<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <style>
        /* General styling */
        body {
            margin: 0;
            font-family: Arial, sans-serif;
        }

        /* Table styling */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px; /* Space between table and footer */
        }

        table,
        th,
        td {
            border: 1px solid black;
            padding: 8px;
        }

        /* Styling for footer */
        .footer {
            position: fixed;
            bottom: 20px; /* Adjust as needed */
            width: 100%;
            text-align: center;
            padding: 10px 0;
            border-top: 1px solid black;
        }
    </style>
</head>

<body>
    <h2>Laporan Tagihan Terbayar</h2>
    <table>
        <thead>
            <tr>
                <th>No.</th>
                <th>Nama</th>
                <th>Angsuran</th>
                <th>Jumlah Tagihan</th>
                <th>Tanggal Bayar</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $dataTagihans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tagihan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($loop->iteration); ?></td>
                    <td><?php echo e($tagihan->user->name); ?></td>
                    <td><?php echo e($tagihan->angsuran); ?> dari <?php echo e($tagihan->pinjaman->tenor); ?></td>
                    <td><?php echo e($tagihan->total_tagihan); ?></td>
                    <td><?php echo e($tagihan->updated_at->format('d-m-Y H:i:s')); ?></td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>

    <!-- Footer -->
    <div class="footer">
        <p>Copyright &copy; Koperasi Tebu Manis Agung <?php echo e(date('Y')); ?></p>
    </div>
</body>

</html>
<?php /**PATH C:\xampp\htdocs\koperasi-tebu-manis-agung\resources\views/laporan/pdf.blade.php ENDPATH**/ ?>