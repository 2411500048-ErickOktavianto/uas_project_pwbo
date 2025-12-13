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
              <div class="card-body table-responsive">
                <?php if($this->session->flashdata('message')) : ?>
                  <?= $this->session->flashdata('message') ?>
                <?php endif; ?>
                <a class="btn btn-outline-primary" href="<?php echo base_url('daftar_pesan/tambah'); ?>" role="button">Tambah Pesanan</a>
                <!-- tombol tetap <a> -->
                <a class="btn btn-outline-danger" id="btnHapusPilih" role="button">Hapus Pesanan (Pilih)</a>

                <!-- hapus semua pakai link ke controller -->
                <a class="btn btn-outline-danger"
                  href="<?= base_url('daftar_pesan/hapus_semua'); ?>"
                  onclick="return confirm('Yakin ingin menghapus SEMUA pesanan?')"
                  role="button">
                  Hapus Semua Pesanan
                </a>
                <form id="formHapusPilih" method="post" action="<?= base_url('daftar_pesan/hapus_banyak'); ?>">
                  <table class="table mt-3">
                    <thead>
                        <tr>
                        <th>Pilih</th>
                        <th scope="col">ID_Pesanan</th>
                        <th scope="col">Team</th>
                        <th scope="col">Waktu</th>
                        <th scope="col">Nama</th>
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
                                     <th><input type="checkbox" name="id_pesan[]" value="<?= $pesan['id_pesan']; ?>"></th>
                                    <th scope="row">
                                        <?= 'LP-' . str_pad($pesan['id_pesan'], 2, '0', STR_PAD_LEFT); ?>
                                    </th>
                                    <td><?= $pesan['nama_team'] ?? '-'; ?></td>
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
                </form>
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


  <script>
document.getElementById('btnHapusPilih').addEventListener('click', function () {
  const checked = document.querySelectorAll('input[name="id_pesan[]"]:checked');
  if (checked.length === 0) {
    alert('Pilih minimal 1 pesanan dulu.');
    return;
  }
  if (confirm('Yakin ingin menghapus pesanan yang dipilih?')) {
    document.getElementById('formHapusPilih').submit();
  }
});
</script>