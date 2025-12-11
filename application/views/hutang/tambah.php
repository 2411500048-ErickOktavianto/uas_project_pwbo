    <!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">

        <div class="col-sm-6">
          <h1 class="m-0">Tambah Data Hutang</h1>
        </div><!-- /.col -->

        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Tambah Data Hutang</li>
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
              <h5 class="card-title">Tambah Hutang</h5>

              <p class="card-text">
                <form method="post" action="">
                  <div class="mb-3">
                    <label for="nama_orang" class="form-label">Nama Orang</label>
                    <input type="text" class="form-control" name="nama_orang" id="nama_orang"
                           aria-describedby="nama orang">
                  </div>

                 <div class="mb-3">
                    <label for="total_hutang" class="form-label">Total Hutang</label>
                    <div class="input-group">
                      <!-- input yang kelihatan -->
                      <input type="text"
                             class="form-control"
                             id="total_hutang"
                             name="total_hutang"
                             placeholder="Masukkan Total Hutang">

                      <select class="form-control"
                              style="max-width: 120px;"
                              name="satuan"
                              id="satuan">
                        <option value="DL"  <?= set_select('satuan', 'DL');  ?>>DL</option>
                        <option value="IDR" <?= set_select('satuan', 'IDR'); ?>>Rupiah</option>
                      </select>
                    </div>
                    <input type="hidden"
                           name="harga"
                           id="harga_hidden"
                           value="<?= set_value('harga'); ?>">
                    </div>
                  <div class="mb-3">
                    <label for="status_hutang" class="form-label">Status Hutang</label>
                    <select name="status_hutang" id="status_hutang" class="form-control">
                      <option value="Lunas">Lunas</option>
                      <option value="Belum Lunas">Belum Lunas</option>
                    </select>
                  </div>

                  <a href="<?= base_url('hutang'); ?>" class="btn btn-danger">Kembali</a>
                  <button type="submit" class="btn btn-primary">Tambah</button>

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
 <script>
(function() {
  const inputDisplay = document.getElementById('total_hutang');
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
    return numStr.replace(/\B(?=(\d{3})+(?!\d))/g, ".");
  }

  function syncHarga() {
    const satuan = satuanSelect.value;
    let raw = onlyNumber(inputDisplay.value); // simpan angka asli tanpa simbol

    if (satuan === 'IDR') {
      inputDisplay.value = "Rp. " + formatRupiah(raw);
    } 
    else if (satuan === 'DL') {
      inputDisplay.value = raw + " DL";
    }

    // simpan angka murni
    inputHidden.value = raw;
  }

  // hapus simbol saat user fokus mengetik lagi
  inputDisplay.addEventListener("focus", function () {
    inputDisplay.value = onlyNumber(inputDisplay.value);
  });

  inputDisplay.addEventListener('keyup', syncHarga);
  inputDisplay.addEventListener('change', syncHarga);
  satuanSelect.addEventListener('change', syncHarga);

})();
</script>
