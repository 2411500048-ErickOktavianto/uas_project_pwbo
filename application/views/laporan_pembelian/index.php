<div class="content-wrapper">

  <!-- ===== HEADER ===== -->
  <div class="content-header">
    <div class="container-fluid">
      <h1 class="m-0">Laporan Pembelian</h1>
    </div>
  </div>

  <!-- ===== CONTENT ===== -->
  <div class="content">
    <div class="container-fluid">

      <?php if ($this->session->flashdata('message')): ?>
        <?= $this->session->flashdata('message'); ?>
      <?php endif; ?>

      <!-- ===== TOMBOL ===== -->
      <div class="mb-3 d-flex align-items-center">
        <a href="#"
           class="btn btn-danger"
           id="btnHapusToggle">
           Hapus Laporan (Pilih)
        </a>

        <a href="<?= site_url('laporan_pembelian/export_pdf') ?>"
           target="_blank"
           class="btn btn-success  ml-2">
           Export PDF
           
        </a>
        
      </div>

      <!-- ===== FORM HAPUS ===== -->
      <form id="formHapusLaporan"
      method="post"
      action="<?= base_url('laporan_pembelian_controller/hapus_pilih'); ?>">


        <?php if (!empty($laporan_per_bulan)): ?>
          <?php foreach ($laporan_per_bulan as $bulan => $data): ?>

          <!-- ===== CARD PER BULAN ===== -->
          <div class="card mb-4">
            <div class="card-header d-flex align-items-center bg-light">
    <strong>
        <?= date('F Y', strtotime($bulan . '-01')); ?>
    </strong>

    <strong class="ml-auto text-right">
        Total:
        <?php if ($data['total_idr'] > 0): ?>
            Rp <?= number_format($data['total_idr'], 0, ',', '.'); ?>
        <?php endif; ?>

        <?php if ($data['total_idr'] > 0 && $data['total_dl'] > 0): ?>
            •
        <?php endif; ?>

        <?php if ($data['total_dl'] > 0): ?>
            <?= number_format($data['total_dl']); ?> DL
        <?php endif; ?>
    </strong>
</div>

            <div class="card-body table-responsive">

              <table class="table table-bordered table-hover">
                <thead>
                  <tr>
                    <th class="col-pilih d-none">Pilih</th>
                    <th>ID Pesanan</th>
                    <th>Nama Pembeli</th>
                    <th>Team</th>
                    <th>Tanggal</th>
                    <th>Durasi</th>
                    <th>Harga</th>
                    <th>Status</th>
                  </tr>
                </thead>

                <tbody>
                  <?php foreach ($data['items'] as $row): ?>
                  <tr>
                    <td class="col-pilih d-none">
                      <input type="checkbox"
                             name="id_laporan[]"
                             value="<?= $row['id']; ?>"
                             class="cb-laporan">
                    </td>

                    <td>LP-<?= str_pad($row['id_pesan'], 2, '0', STR_PAD_LEFT); ?></td>
                    <td><?= $row['nama']; ?></td>
                    <td><?= $row['team']; ?></td>
                    <td><?= date('d F Y H:i', strtotime($row['created_at'])); ?> WIB</td>
                    <td><?= $row['tanggal_pesan']; ?></td>
                    <td>
                      <?= ($row['satuan'] === 'DL')
                        ? number_format($row['harga']).' DL'
                        : 'Rp '.number_format($row['harga'], 0, ',', '.'); ?>
                    </td>
                    <td>
                      <span class="badge bg-success"><?= $row['status']; ?></span>
                    </td>
                  </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>

            </div>
          </div>

          <?php endforeach; ?>
        <?php else: ?>
          <div class="alert alert-warning text-center">
            Belum ada data laporan
          </div>
        <?php endif; ?>

      </form>

    </div>
  </div>
</div>

<!-- ===== STYLE ===== -->
<style>
.col-pilih {
  width: 60px;
  text-align: center;
}
tr.row-selected {
  background-color: #fff3cd !important;
}
</style>

<!-- ===== SCRIPT HAPUS ===== -->
<script>
let modeHapus = false;

const btnHapus = document.getElementById('btnHapusToggle');
const formHapus = document.getElementById('formHapusLaporan');

function getCheckboxes() {
    return document.querySelectorAll('.cb-laporan');
}

function getChecked() {
    return document.querySelectorAll('.cb-laporan:checked');
}

btnHapus.addEventListener('click', function (e) {
    e.preventDefault();

    const colPilih = document.querySelectorAll('.col-pilih');

    // ===== MASUK MODE HAPUS =====
    if (!modeHapus) {
        colPilih.forEach(col => col.classList.remove('d-none'));

        btnHapus.textContent = 'Batal';
        btnHapus.classList.remove('btn-outline-danger');
        btnHapus.classList.add('btn-secondary');

        modeHapus = true;
        return;
    }

    // ===== JIKA ADA YANG DICENTANG → HAPUS =====
    if (getChecked().length > 0) {
        if (!confirm('Yakin ingin menghapus laporan terpilih?')) return;
        formHapus.submit();
        return;
    }

    // ===== BATAL MODE HAPUS =====
    colPilih.forEach(col => col.classList.add('d-none'));

    getCheckboxes().forEach(cb => {
        cb.checked = false;
        cb.closest('tr').classList.remove('row-selected');
    });

    btnHapus.textContent = 'Hapus Laporan (Pilih)';
    btnHapus.classList.remove('btn-secondary');
    btnHapus.classList.add('btn-outline-danger');

    modeHapus = false;
});

// ===== LISTENER CHECKBOX (DINAMIS) =====
document.addEventListener('change', function (e) {
    if (!e.target.classList.contains('cb-laporan')) return;

    const row = e.target.closest('tr');
    row.classList.toggle('row-selected', e.target.checked);

    if (!modeHapus) return;

    const checkedCount = getChecked().length;

    if (checkedCount > 0) {
        btnHapus.textContent = 'Hapus Terpilih';
        btnHapus.classList.remove('btn-secondary');
        btnHapus.classList.add('btn-danger');
    } else {
        btnHapus.textContent = 'Batal';
        btnHapus.classList.remove('btn-danger');
        btnHapus.classList.add('btn-secondary');
    }
});
</script>

