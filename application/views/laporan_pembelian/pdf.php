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
            margin-bottom: 20px;
        }

        .card {
            border: 1px solid #000;
            margin-bottom: 20px;
            padding: 8px;
        }

        .card-header {
            width: 100%;
            margin-bottom: 8px;
        }

        .card-header table {
            width: 100%;
            border: none;
        }

        .card-header td {
            border: none;
            font-weight: bold;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #000;
            padding: 4px;
            text-align: left;
        }

        th {
            background: #eee;
        }
    </style>
</head>
<body>

<h2>LAPORAN PEMBELIAN</h2>

<?php foreach ($laporan_per_bulan as $bulan => $data): ?>

<div class="card">

    <!-- ===== HEADER BULAN + TOTAL ===== -->
    <div class="card-header">
        <table>
            <tr>
                <td>
                    <?= date('F Y', strtotime($bulan . '-01')); ?>
                </td>
                <td style="text-align:right;">
                    Total:
                    <?php if ($data['total_idr'] > 0): ?>
                        Rp <?= number_format($data['total_idr'], 0, ',', '.'); ?>
                    <?php endif; ?>

                    <?php if ($data['total_idr'] > 0 && $data['total_dl'] > 0): ?>
                        •
                    <?php endif; ?>

                    <?php if ($data['total_dl'] > 0): ?>
                        <?= number_format($data['total_dl']); ?> DL
                    <?php endif; ?>
                </td>
            </tr>
        </table>
    </div>

    <!-- ===== TABLE DATA ===== -->
    <table>
        <thead>
            <tr>
                <th>ID Pesanan</th>
                <th>Nama</th>
                <th>Team</th>
                <th>Tanggal</th>
                <th>Durasi</th>
                <th>Harga</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data['items'] as $row): ?>
            <tr>
                <td>LP-<?= $row['id_pesan']; ?></td>
                <td><?= $row['nama']; ?></td>
                <td><?= $row['team']; ?></td>
                <td><?= date('d F Y H:i', strtotime($row['created_at'])); ?> WIB</td>
                <td><?= $row['tanggal_pesan']; ?></td>
                <td>
                    <?= ($row['satuan'] === 'DL')
                        ? number_format($row['harga']).' DL'
                        : 'Rp '.number_format($row['harga'], 0, ',', '.'); ?>
                </td>
                <td><?= $row['status']; ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</div>

<?php endforeach; ?>

</body>
</html>
