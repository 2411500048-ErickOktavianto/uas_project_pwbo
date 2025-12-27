    <!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">

        <div class="col-sm-6">
          <h1 class="m-0">Edit Data Team</h1>
        </div><!-- /.col -->

        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Edit Data Team</li>
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
              <h5 class="card-title">Edit Team</h5>

              <p class="card-text">
                <form method="post" action="">
                  <div class="mb-3">
                    <label for="nama_team" class="form-label">Nama Team</label>
                    <input  value="<?= set_value('nama_team', $team['nama_team']); ?>"
                     type="text" class="form-control" name="nama_team" id="nama_team"
                           aria-describedby="nama team">
                  </div>

                  <a href="<?= base_url('team'); ?>" class="btn btn-danger">Kembali</a>
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
