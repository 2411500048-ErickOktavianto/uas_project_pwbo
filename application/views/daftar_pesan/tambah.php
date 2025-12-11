<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">

        <div class="col-sm-6">
          <h1 class="m-0">Tambah Data Pesanan</h1>
        </div>

        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Tambah Data Pesanan</li>
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
              <h5 class="card-title">Tambah Daftar Pesanan</h5>

              <p class="card-text">
                <form method="post" action="">
                  <div class="mb-3">
                    <label for="waktu" class="form-label">Waktu</label>
                    <input type="text"
                           class="form-control"
                           name="waktu"
                           id="waktu"
                           value="<?= set_value('waktu'); ?>"
                           placeholder="Misal: 13.00 - 16.00">
                    <?= form_error('waktu', '<small class="text-danger">', '</small>'); ?>
                  </div>

                  <div class="mb-3">
                    <label for="nama_pembeli" class="form-label">Nama Pembeli</label>
                    <input type="text"
                           class="form-control"
                           name="nama_pembeli"
                           id="nama_pembeli"
                           value="<?= set_value('nama_pembeli'); ?>"
                           placeholder="Masukkan Nama Pembeli">
                    <?= form_error('nama_pembeli', '<small class="text-danger">', '</small>'); ?>
                  </div>
                    <!-- bagian server untuk drop down pilih server yang jelas sudah terhubung pada tabel server -->
                    <div class="mb-3">
                        <label for="server" class="form-label">Server</label>
                        <select name="server" id="server" class="form-control">
                            <option disabled selected>-- Pilih Server --</option>
                            <?php foreach ($servers as $srv): ?>
                                <option value="<?= $srv['id_server']; ?>">
                                    <?= $srv['ip_address']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                  <!-- Status Pesan: default Run, user tidak bisa ubah -->
                  <div class="mb-3">
                    <label class="form-label">Status Pesanan</label>
                    <select class="form-control" disabled>
                      <option selected>Run</option>
                      <option>Done</option>
                    </select>
                    <!-- value yang dikirim ke server -->
                    <input type="hidden" name="status_pesan" value="Run">
                  </div>

                  <!-- Harga + satuan -->

                  <!-- Harga + satuan -->
                  <div class="mb-3">
                    <label for="harga_display" class="form-label">Harga</label>
                    <div class="input-group">
                      <!-- input yang kelihatan -->
                      <input type="text"
                             class="form-control"
                             id="harga_display"
                             name="harga_display"
                             value="<?= set_value('harga_display'); ?>"
                             placeholder="Masukkan harga">

                      <select class="form-control"
                              style="max-width: 120px;"
                              name="satuan"
                              id="satuan">
                        <option value="DL"  <?= set_select('satuan', 'DL');  ?>>DL</option>
                        <option value="IDR" <?= set_select('satuan', 'IDR'); ?>>Rupiah</option>
                      </select>
                    </div>

                    <!-- angka mentah yang dikirim ke server -->
                    <input type="hidden"
                           name="harga"
                           id="harga_hidden"
                           value="<?= set_value('harga'); ?>">

                    <?= form_error('harga', '<small class="text-danger">', '</small>'); ?>
                    <small class="form-text text-muted">
                      Jika satuan Rupiah dipilih, angka otomatis diformat (contoh: 30000 → 30.000).
                    </small>
                  </div>
                  
                  <a href="<?= base_url('daftar_pesan'); ?>" class="btn btn-danger">Kembali</a>
                  <button type="submit" class="btn btn-primary">Tambah</button>

                </form>
              </p>

            </div>
          </div>

        </div>
      </div>

    </div>
  </div>
  <!-- /.content -->

</div>
<!-- /.content-wrapper -->

<!-- Script format harga -->
<script>
    (function() {
    const inputDisplay = document.getElementById('harga_display');
    const inputHidden  = document.getElementById('harga_hidden');
    const satuanSelect = document.getElementById('satuan');

    if (!inputDisplay || !inputHidden || !satuanSelect) return;

    // hapus semua non-digit
    function onlyNumber(str) {
      return (str || '').replace(/[^0-9]/g, '');
    }

    // format rupiah: 30000 -> 30.000
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

      // simpan angka mentah ke hidden
      inputHidden.value = raw;
    }

    inputDisplay.addEventListener('keyup', syncHarga);
    inputDisplay.addEventListener('change', syncHarga);
    satuanSelect.addEventListener('change', syncHarga);

    // inisialisasi pertama kali
    syncHarga();
  })();
</script>
