<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">

        <div class="col-sm-6">
          <h1 class="m-0">Data Hutang</h1><br>
        </div>

        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>">Home</a></li>
            <li class="breadcrumb-item active">Hutang</li>
          </ol>
        </div>

      </div>
    </div>
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <div class="content">
    <div class="container-fluid">

      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">

              <!-- Flash message -->
              <?php if($this->session->flashdata('message')) : ?>
                <?= $this->session->flashdata('message') ?>
              <?php endif; ?>

              <!-- Tombol tambah -->
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> b13a2313cbc45e9c683548a68c5168349d2f3e80
              <a class="btn btn-outline-primary"
                 href="<?php echo base_url('hutang/tambah'); ?>"
                 role="button">Tambah Data</a>

              <br><br>
<<<<<<< HEAD
=======
              <div class="mb-3 d-flex">
    <a href="<?= base_url('hutang/tambah') ?>" class="btn btn-primary me-2">
        Tambah Data
    </a>

    <a href="<?= base_url('hutang/export_pdf') ?>" class="btn btn-danger  ml-2">
        Export PDF
    </a>
</div>

            <br></br>
>>>>>>> a56018f (Update laporan pembelian & hutang by framlie)
=======
>>>>>>> b13a2313cbc45e9c683548a68c5168349d2f3e80

              <!-- Tabel Data Hutang -->
              <table class="table">
                <thead>
                  <tr>
                    <th scope="col">ID_Hutang</th>
                    <th scope="col">Nama Orang</th>
                    <th scope="col">Total Hutang</th>
                    <th scope="col">Status Hutang</th>
                    <th scope="col">Aksi</th>
                  </tr>
                </thead>

                <tbody>
                  <?php $no = 1; foreach ($list_hutang as $hutang) : ?>
                    <tr>
                      <th scope="row"><?= $no ?></th>
                      <td><?= $hutang['nama_orang']; ?></td>

                      <!-- Formatting sesuai satuan -->
                      <td>
                        <?php
                          if ($hutang['satuan'] == 'IDR') {
                              echo "Rp. " . number_format($hutang['total_hutang'], 0, ',', '.');
                          } else {
                              echo $hutang['total_hutang'] . " DL";
                          }
                        ?>
                      </td>

                      <td>
                          <?php if ($hutang['status_hutang'] == 'Lunas'): ?>
                            <span class="badge bg-success">Lunas</span>
                            <?php elseif ($hutang['status_hutang'] == 'Belum Lunas'): ?>
                                <span class="badge bg-danger">Belum Lunas</span>
                             <?php else: ?>
                                <span class="badge bg-secondary"><?= $hutang['status_hutang']; ?></span>
                            <?php endif; ?>
                    </td>
                      <td>
                        <!-- Tombol Edit -->
                        <a href="<?= base_url('hutang/edit/'.$hutang['id_hutang']); ?>"
                           class="badge bg-success">Edit</a>

                        <!-- Tombol Hapus -->
                        <a href="<?= base_url('hutang/hapus/'.$hutang['id_hutang']); ?>"
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

    </div>
  </div>
  <!-- /.content -->

</div>
<!-- /.content-wrapper -->
