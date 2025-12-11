  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Daftar Pesan</h1><br>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>">Home</a></li>
              <li class="breadcrumb-item active">Daftar Pesan</li>
            </ol>   
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12">
            <div class="card">
              <div class="card-body">
                <?php if($this->session->flashdata('message')) : ?>
                  <?= $this->session->flashdata('message') ?>
                <?php endif; ?>
                <a class="btn btn-outline-primary" href="<?php echo base_url('daftar_pesan/tambah'); ?>" role="button">Tambah Pesanan</a>
                    <table class="table">
                    <thead>
                        <tr>
                        <th scope="col">ID_Pesanan</th>
                        <th scope="col">Waktu</th>
                        <th scope="col">Nama Pembeli</th>
                        <th scope="col">Server</th>
                        <th scope="col">Status Pesan</th>
                        <th scope="col">Harga</th>
                        <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no= 1;
                        foreach ($list_pesan as $pesan) : ?>
                                <tr>
                                    <!-- ID Pesanan dengan format LP-01 -->
                                    <th scope="row">
                                        <?= 'LP-' . str_pad($pesan['id_pesan'], 2, '0', STR_PAD_LEFT); ?>
                                    </th>

                                    <td><?= $pesan['waktu']; ?></td>
                                    <td><?= $pesan['nama_pembeli']; ?></td>

                                    <!-- Tampilkan IP Address dari id_server yang disimpan -->
                                    <td>
                                        <?php if ($pesan['status_pesan'] == 'Done'): ?>
                                            -
                                        <?php else: ?>
                                            <?= $pesan['ip_address'] ?: '-'; ?>
                                        <?php endif; ?>
                                    </td>
                                    <td> 
                                        <?php if ($pesan['status_pesan'] == 'Run'): ?>
                                            <span class="badge bg-success">Run</span>
                                            <?php elseif ($pesan['status_pesan'] == 'Done'): ?>
                                                <span class="badge bg-primary">Done</span>
                                            <?php else: ?>
                                                <span class="badge bg-secondary"><?= $pesan['status_pesan']; ?></span>
                                        <?php endif; ?>
                                    <td>
                                        <?php if ($pesan['satuan'] == 'DL'): ?>
                                                <?= $pesan['harga']; ?> DL
                                            <?php elseif ($pesan['satuan'] == 'IDR'): ?>
                                                Rp. <?= number_format($pesan['harga'], 0, ',', '.'); ?>
                                            <?php else: ?>
                                                <?= $pesan['harga']; ?>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <!-- Bagian Edit -->
                                        <a href="<?= base_url('daftar_pesan/edit/'.$pesan['id_pesan']); ?>"
                                        class="badge bg-warning">Edit</a> 

                                        <!-- Bagian Confirm Pesanan Selesai -->
                                        <a href="<?= base_url('daftar_pesan/selesai/'.$pesan['id_pesan']); ?>"
                                        class="badge bg-success">Selesai</a> 

                                        <!-- Bagian Hapus -->
                                        <a href="<?= base_url('daftar_pesan/hapus/'.$pesan['id_pesan']); ?>" 
                                        class="badge bg-danger"
                                        onclick="return confirm('Yakin ingin hapus data ini?')">
                                        Hapus
                                        </a>
                                    </td>
                                </tr>
                        <?php $no++; endforeach; ?>
                    </tbody>
                    </table>
              </div>
            </div>
          </div>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
