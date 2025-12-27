<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">

        <div class="col-sm-6">
          <h1 class="m-0">Edit Data Hutang</h1>
        </div>

        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Edit Hutang</li>
          </ol>
        </div>

      </div>
    </div>
  </div>

  <!-- Main content -->
  <div class="content">
    <div class="container-fluid">

      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Edit Hutang</h5>
              <br> <br>

              <form method="post" action="">

                <!-- Nama Orang -->
                <div class="mb-3">
                  <label for="nama_orang" class="form-label">Nama Orang</label>
                  <input type="text" class="form-control" 
                         name="nama_orang" id="nama_orang"
                         value="<?= $hutang['nama_orang'] ?>">
                </div>

                <!-- Total Hutang + Satuan -->
                <div class="mb-3">
                  <label for="total_hutang" class="form-label">Total Hutang</label>
                  <div class="input-group">

                    <input type="text"
                           class="form-control"
                           id="total_hutang"
                           name="total_hutang"
                           value="<?= $hutang['satuan'] == 'IDR' 
                                    ? 'Rp. ' . number_format($hutang['total_hutang'], 0, ',', '.') 
                                    : $hutang['total_hutang'] . ' DL' ?>">

                    <select class="form-control"
                            style="max-width: 120px;"
                            name="satuan"
                            id="satuan">
                      <option value="DL"  <?= $hutang['satuan'] == 'DL'  ? 'selected' : '' ?>>DL</option>
                      <option value="IDR" <?= $hutang['satuan'] == 'IDR' ? 'selected' : '' ?>>Rupiah</option>
                    </select>
                  </div>

                  <input type="hidden"
                         name="harga"
                         id="harga_hidden"
                         value="<?= $hutang['total_hutang'] ?>">
                </div>

                <!-- Status Hutang -->
                <div class="mb-3">
                  <label class="form-label">Status Hutang</label>
                  <select name="status_hutang" id="status_hutang" class="form-control">
                    <option value="Lunas" 
                      <?= $hutang['status_hutang'] == 'Lunas' ? 'selected' : '' ?>>
                      Lunas
                    </option>

                    <option value="Belum Lunas" 
                      <?= $hutang['status_hutang'] == 'Belum Lunas' ? 'selected' : '' ?>>
                      Belum Lunas
                    </option>
                  </select>
                </div>

                <a href="<?= base_url('hutang'); ?>" class="btn btn-danger">Kembali</a>
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>

              </form>

            </div>
          </div>

        </div>
      </div>

    </div>
  </div>

</div>

<!-- Script Format Angka -->
<script>
(function() {
  const inputDisplay = document.getElementById('total_hutang');
  const inputHidden  = document.getElementById('harga_hidden');
  const satuanSelect = document.getElementById('satuan');

  if (!inputDisplay || !inputHidden || !satuanSelect) return;

  // Hapus semua selain angka
  function onlyNumber(str) {
    return (str || '').replace(/[^0-9]/g, '');
  }

  // Format angka 30000 -> 30.000
  function formatRupiah(numStr) {
    if (!numStr) return '';
    return numStr.replace(/\B(?=(\d{3})+(?!\d))/g, ".");
  }

  function syncHarga() {
    const satuan = satuanSelect.value;
    let raw = onlyNumber(inputDisplay.value);

    if (satuan === 'IDR') {
      inputDisplay.value = "Rp. " + formatRupiah(raw);
    } else {
      inputDisplay.value = raw + " DL";
    }

    inputHidden.value = raw;
  }

  // Ketika user klik input → hapus simbol
  inputDisplay.addEventListener("focus", function () {
    inputDisplay.value = onlyNumber(inputDisplay.value);
  });

  inputDisplay.addEventListener('keyup', syncHarga);
  satuanSelect.addEventListener('change', syncHarga);

})();
</script>
