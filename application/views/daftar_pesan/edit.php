<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">

        <div class="col-sm-6">
          <h1 class="m-0">Edit Data Pesanan</h1>
        </div>

        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?= base_url(); ?>">Home</a></li>
            <li class="breadcrumb-item"><a href="<?= base_url('daftar_pesan'); ?>">Daftar Pesan</a></li>
            <li class="breadcrumb-item active">Edit Data Pesanan</li>
          </ol>
        </div>

      </div>
    </div>
  </div>

  <div class="content">
    <div class="container-fluid">

      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Edit Pesanan</h5>

              <p class="card-text">
                <form method="post" action="">
                  <div class="mb-3">
                    <label for="waktu" class="form-label">Waktu</label>
                    <input type="text"
                           class="form-control"
                           name="waktu"
                           id="waktu"
                           value="<?= set_value('waktu', $pesan['waktu']); ?>">
                    <?= form_error('waktu', '<small class="text-danger">', '</small>'); ?>
                  </div>
                  <!-- team -->
                  <div class="mb-3">
                    <label for="team" class="form-label">Team</label>
                      <select name="team" class="form-control">
                        <option value="">-- Tanpa Team --</option>
                        <?php foreach ($teams as $t): ?>
                          <option value="<?= $t['id_team']; ?>"
                            <?= ($pesan['team'] == $t['id_team']) ? 'selected' : ''; ?>>
                            <?= $t['nama_team']; ?>
                          </option>
                        <?php endforeach; ?>
                      </select>
                    <?= form_error('team', '<small class="text-danger">', '</small>'); ?>
                  </div>
                  <!-- End of team  -->
                  <div class="mb-3">
                    <label for="nama_pembeli" class="form-label">Nama Pembeli</label>
                    <input type="text"
                           class="form-control"
                           name="nama_pembeli"
                           id="nama_pembeli"
                           value="<?= set_value('nama_pembeli', $pesan['nama_pembeli']); ?>">
                    <?= form_error('nama_pembeli', '<small class="text-danger">', '</small>'); ?>
                  </div>

                  <!-- Server -->
                  <div class="mb-3">
                    <label for="server" class="form-label">Server</label>
                    <select name="server" id="server" class="form-control">
                      <?php foreach ($servers as $srv): ?>
                        <option value="<?= $srv['id_server']; ?>"
                          <?= set_select('server', $srv['id_server'], $srv['id_server'] == $pesan['server']); ?>>
                          <?= $srv['ip_address']; ?>
                        </option>
                      <?php endforeach; ?>
                    </select>
                    <?= form_error('server', '<small class="text-danger">', '</small>'); ?>
                  </div>

                  <!-- Status Pesan boleh diubah Run/Done -->
                  <div class="mb-3">
                    <label for="status_pesan" class="form-label">Status Pesanan</label>
                    <?php $st = set_value('status_pesan', $pesan['status_pesan']); ?>
                    <select class="form-control" name="status_pesan" id="status_pesan">
                      <option value="Run"  <?= $st == 'Run'  ? 'selected' : ''; ?>>Run</option>
                      <option value="Done" <?= $st == 'Done' ? 'selected' : ''; ?>>Done</option>
                    </select>
                  </div>

                  <!-- Harga + satuan -->
                  <?php
                    $display_harga = $pesan['harga'];
                    if ($pesan['satuan'] == 'IDR') {
                      $display_harga = number_format($pesan['harga'], 0, ',', '.');
                    }
                  ?>
                  <div class="mb-3">
                    <label for="harga_display" class="form-label">Harga</label>
                    <div class="input-group">
                      <input type="text"
                             class="form-control"
                             id="harga_display"
                             name="harga_display"
                             value="<?= set_value('harga_display', $display_harga); ?>">

                      <?php $sat = set_value('satuan', $pesan['satuan']); ?>
                      <select class="form-control"
                              style="max-width: 120px;"
                              name="satuan"
                              id="satuan">
                        <option value="DL"  <?= $sat == 'DL'  ? 'selected' : ''; ?>>DL</option>
                        <option value="IDR" <?= $sat == 'IDR' ? 'selected' : ''; ?>>Rupiah</option>
                      </select>
                    </div>

                    <input type="hidden"
                           name="harga"
                           id="harga_hidden"
                           value="<?= set_value('harga', $pesan['harga']); ?>">

                    <?= form_error('harga', '<small class="text-danger">', '</small>'); ?>
                  </div>

                  <a href="<?= base_url('daftar_pesan'); ?>" class="btn btn-danger">Kembali</a>
                  <button type="submit" class="btn btn-primary">Simpan Perubahan</button>

                </form>
              </p>

            </div>
          </div>

        </div>
      </div>

    </div>
  </div>

</div>

<!-- JS sama seperti di tambah.php -->
<script>
  (function() {
    const inputDisplay = document.getElementById('harga_display');
    const inputHidden  = document.getElementById('harga_hidden');
    const satuanSelect = document.getElementById('satuan');

    if (!inputDisplay || !inputHidden || !satuanSelect) return;

    function onlyNumber(str) {
      return (str || '').replace(/[^0-9]/g, '');
    }

    function formatRupiah(numStr) {
      if (!numStr) return '';
      return numStr.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    }

    function syncHarga() {
      const satuan = satuanSelect.value;
      let raw = onlyNumber(inputDisplay.value);

      if (satuan === 'IDR') {
        inputDisplay.value = formatRupiah(raw);
      } else {
        inputDisplay.value = raw;
      }
      inputHidden.value = raw;
    }

    inputDisplay.addEventListener('keyup', syncHarga);
    inputDisplay.addEventListener('change', syncHarga);
    satuanSelect.addEventListener('change', syncHarga);

    syncHarga();
  })();
</script>
