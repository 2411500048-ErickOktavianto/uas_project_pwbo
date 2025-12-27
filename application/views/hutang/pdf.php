<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 11px;
        }

        h2 {
            text-align: center;
            margin-bottom: 15px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #000;
            padding: 6px;
            text-align: left;
        }

        th {
            background: #eee;
        }

        .total-table {
            width: 45%;
            margin-top: 15px;
            float: right;
        }
    </style>
</head>
<body>

<h2>DATA HUTANG</h2>

<?php
// ===== HITUNG TOTAL =====
$total_idr = 0;
$total_dl  = 0;

foreach ($hutang as $row) {
    if ($row['satuan'] === 'DL') {
        $total_dl += (int)$row['total_hutang'];
    } else {
        $total_idr += (int)$row['total_hutang'];
    }
}
?>

<table>
    <thead>
        <tr>
            <th>ID Hutang</th>
            <th>Nama Orang</th>
            <th>Total Hutang</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($hutang as $row): ?>
        <tr>
            <td><?= $row['id_hutang']; ?></td>
            <td><?= $row['nama_orang']; ?></td>
            <td>
                <?= ($row['satuan'] === 'DL')
                    ? number_format($row['total_hutang']).' DL'
                    : 'Rp '.number_format($row['total_hutang'], 0, ',', '.'); ?>
            </td>
            <td><?= $row['status_hutang']; ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<!-- ===== TOTAL HUTANG ===== -->
<table class="total-table">
    <tr>
        <th>Total Hutang Rupiah</th>
        <td>
            <?= $total_idr > 0 ? 'Rp '.number_format($total_idr, 0, ',', '.') : '-' ?>
        </td>
    </tr>
    <tr>
        <th>Total Hutang DL</th>
        <td>
            <?= $total_dl > 0 ? number_format($total_dl).' DL' : '-' ?>
        </td>
    </tr>
</table>

</body>
</html>
