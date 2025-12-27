  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Data Server</h1><br>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>">Home</a></li>
              <li class="breadcrumb-item active">Server</li>
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
                <a class="btn btn-outline-primary" href="<?php echo base_url('server/tambah'); ?>" role="button">Tambah Data</a>
                    <table class="table">
                    <thead>
                        <tr>
                        <th scope="col">ID_Server</th>
                        <th scope="col">IP Address</th>
                        <th scope="col">Expired</th>
                        <th scope="col">Status</th>
                        <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no= 1;
                        foreach ($list_server as $server) : ?>
                                <tr>
                                    <th scope="row"><?= $no ?></th>
                                    <td><?= $server['ip_address'] ?></td>
                                    <td><?= tgl_indo($server['expired']) ?></td>
                                    <td>
                                            <?php if ($server['status'] == 'Available'): ?>
                                            <span class="badge bg-success">Available</span>
                                            <?php elseif ($server['status'] == 'USED'): ?>
                                                <span class="badge bg-danger">USED</span>
                                            <?php else: ?>
                                                <span class="badge bg-secondary"><?= $server['status']; ?></span>
                                            <?php endif; ?>

                                    </td>
                                    <td>
                                        <!-- Bagian Edit -->
                                        <a href="<?= base_url('server/edit/'.$server['id_server']); ?>"
                                        class="badge bg-success">Edit</a> 

                                        <!-- Bagian Hapus -->
                                        <a href="<?= base_url('server/hapus/'.$server['id_server']); ?>" 
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
