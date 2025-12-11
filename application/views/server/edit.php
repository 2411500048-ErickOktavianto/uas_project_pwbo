<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">

        <div class="col-sm-6">
          <h1 class="m-0">Edit Data Server</h1>
        </div><!-- /.col -->

        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?= base_url(); ?>">Home</a></li>
            <li class="breadcrumb-item"><a href="<?= base_url('server'); ?>">Server</a></li>
            <li class="breadcrumb-item active">Edit Data Server</li>
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
              <h5 class="card-title">Edit Server</h5>

              <p class="card-text">
                <form method="post" action="">
                  <div class="mb-3">
                    <label for="ip_address" class="form-label">IP Address</label>
                    <input type="text"
                           class="form-control"
                           name="ip_address"
                           id="ip_address"
                           value="<?= set_value('ip_address', $server['ip_address']); ?>"
                           aria-describedby="IP Address">
                    <?= form_error('ip_address', '<small class="text-danger">', '</small>'); ?>
                  </div>

                  <div class="mb-3">
                    <label for="expired" class="form-label">Expired</label>
                    <input type="date"
                           class="form-control"
                           name="expired"
                           id="expired"
                           value="<?= set_value('expired', $server['expired']); ?>"
                           aria-describedby="Expired">
                    <?= form_error('expired', '<small class="text-danger">', '</small>'); ?>
                  </div>

                  <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select name="status" id="status" class="form-control">
                      <?php
                        $status = set_value('status', $server['status']);
                      ?>
                      <option value="Available" <?= $status == 'Available' ? 'selected' : '' ?>>Available</option>
                      <option value="USED" <?= $status == 'USED' ? 'selected' : '' ?>>USED</option>
                    </select>
                    <?= form_error('status', '<small class="text-danger">', '</small>'); ?>
                  </div>

                  <a href="<?= base_url('server'); ?>" class="btn btn-danger">Kembali</a>
                  <button type="submit" class="btn btn-primary">Simpan Perubahan</button>

                </form>
              </p>

            </div><!-- /.card-body -->
          </div><!-- /.card -->

        </div><!-- /.col-lg-12 -->
      </div><!-- /.row -->

    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content -->

</div>
<!-- /.content-wrapper -->
