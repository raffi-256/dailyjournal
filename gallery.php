<?php
include 'koneksi.php';
include "upload_foto.php";
?>

<div class="container">
    <div class="row mb-2">
        <div class="col-md-6"></div>
        <div class="col-md-6">
            <div class="input-group">
                <input type="text" id="search" class="form-control" placeholder="Cari Gallery...">
                <span class="input-group-text">
                    <i class="bi bi-search"></i>
                </span>
            </div>
        </div>
    </div>

    <!-- TOMBOL TAMBAH -->
    <button type="button" class="btn btn-secondary mb-3" data-bs-toggle="modal" data-bs-target="#modalTambah">
        Tambah Gallery
    </button>

    <!-- TABEL -->
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead class="table-dark">
                <tr>
                    <th width="5%">No</th>
                    <th width="30%">Judul</th>
                    <th width="25%">Tanggal | User</th>
                    <th width="30%">Gambar</th>
                    <th width="10%">Aksi</th>
                </tr>
            </thead>
            <tbody id="result">

            <?php
            $sql = "SELECT * FROM gallery ORDER BY tanggal DESC";
            $result = $conn->query($sql);
            $no = 1;

            if ($result && $result->num_rows > 0):
                while ($row = $result->fetch_assoc()):
            ?>
                <tr>
                    <td><?= $no++; ?></td>

                    <td><strong><?= htmlspecialchars($row['judul']); ?></strong></td>

                    <td><small><?= $row['tanggal']; ?> | <?= htmlspecialchars($row['username']); ?></small></td>

                    <td>
                        <?php if (!empty($row['gambar']) && file_exists('img/'.$row['gambar'])): ?>
                            <img src="img/<?= $row['gambar']; ?>" class="img-fluid rounded" width="120">
                        <?php else: ?>
                            <span class="text-muted">Tidak ada</span>
                        <?php endif; ?>
                    </td>

                    <td>
                        <a href="#" class="badge rounded-pill text-bg-success" data-bs-toggle="modal" data-bs-target="#modalEdit<?= $row['id'] ?>"><i class="bi bi-pencil"></i></a>
                        <a href="#" class="badge rounded-pill text-bg-danger" data-bs-toggle="modal" data-bs-target="#modalHapus<?= $row['id'] ?>"><i class="bi bi-x-circle"></i></a>
                    </td>
                </tr>

<!-- ================= MODAL EDIT ================= -->
<div class="modal fade" id="modalEdit<?= $row['id'] ?>" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit Gallery</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <form method="post" enctype="multipart/form-data">
        <div class="modal-body">

          <input type="hidden" name="id" value="<?= $row['id'] ?>">
          <input type="hidden" name="gambar_lama" value="<?= $row['gambar'] ?>">

          <div class="mb-3">
            <label class="form-label">Judul</label>
            <input type="text" name="judul" class="form-control" value="<?= htmlspecialchars($row['judul']) ?>" required>
          </div>

          <div class="mb-3">
            <label class="form-label">Ganti Gambar</label>
            <input type="file" name="gambar" class="form-control">
          </div>

          <?php if (!empty($row['gambar']) && file_exists('img/'.$row['gambar'])): ?>
              <img src="img/<?= $row['gambar']; ?>" class="img-fluid rounded" width="120">
          <?php endif; ?>

        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" name="simpan" class="btn btn-primary">Simpan</button>
        </div>
      </form>

    </div>
  </div>
</div>

<!-- ================= MODAL HAPUS ================= -->
<div class="modal fade" id="modalHapus<?= $row['id'] ?>" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Hapus Gallery</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <form method="post">
        <div class="modal-body">
          Yakin hapus <strong><?= htmlspecialchars($row['judul']); ?></strong> ?
          <input type="hidden" name="id" value="<?= $row['id']; ?>">
          <input type="hidden" name="gambar" value="<?= $row['gambar']; ?>">
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" name="hapus" class="btn btn-danger">Hapus</button>
        </div>
      </form>

    </div>
  </div>
</div>

            <?php endwhile; else: ?>
                <tr>
                    <td colspan="5" class="text-center">Belum ada data</td>
                </tr>
            <?php endif; ?>

            </tbody>
        </table>
    </div>
</div>

<!-- ================= SCRIPT SEARCH ================= -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    function loadData(keyword = '') {
        $.ajax({
            url: "gallery_search.php",
            type: "POST",
            data: { keyword: keyword },
            success: function(data) {
                $("#result").html(data);
            }
        });
    }

    $("#search").on("keyup", function() {
        let keyword = $(this).val();
        loadData(keyword);
    });
</script>

<!-- ================= MODAL TAMBAH ================= -->
<div class="modal fade" id="modalTambah" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title">Tambah Gallery</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <form method="post" enctype="multipart/form-data">
        <div class="modal-body">

          <div class="mb-3">
            <label class="form-label">Judul</label>
            <input type="text" name="judul" class="form-control" required>
          </div>

          <div class="mb-3">
            <label class="form-label">Gambar</label>
            <input type="file" name="gambar" class="form-control" required>
          </div>

        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" name="simpan" class="btn btn-primary">Simpan</button>
        </div>
      </form>

    </div>
  </div>
</div>

<?php
/* =======================
   SIMPAN & UPDATE
======================= */
if (isset($_POST['simpan'])) {

    $judul = $_POST['judul'];
    $tanggal = date("Y-m-d H:i:s");
    $username = $_SESSION['username'];

    $gambar = '';
    $nama_gambar = $_FILES['gambar']['name'];

    if ($nama_gambar != '') {
        $cek_upload = upload_foto($_FILES['gambar']);
        if ($cek_upload['status']) {
            $gambar = $cek_upload['message'];
        } else {
            echo "<script>alert('".$cek_upload['message']."');location='admin.php?page=gallery';</script>";
            exit;
        }
    }

    if (isset($_POST['id'])) {
        // UPDATE
        $id = $_POST['id'];

        if ($nama_gambar == '') {
            $gambar = $_POST['gambar_lama'];
        } else {
            if (!empty($_POST['gambar_lama']) && file_exists('img/'.$_POST['gambar_lama'])) {
                unlink('img/'.$_POST['gambar_lama']);
            }
        }

        $stmt = $conn->prepare("UPDATE gallery SET judul=?, gambar=?, tanggal=?, username=? WHERE id=?");
        $stmt->bind_param("ssssi", $judul, $gambar, $tanggal, $username, $id);

    } else {
        // INSERT
        $stmt = $conn->prepare("INSERT INTO gallery (judul, gambar, tanggal, username) VALUES (?,?,?,?)");
        $stmt->bind_param("ssss", $judul, $gambar, $tanggal, $username);
    }

    $stmt->execute();
    $stmt->close();

    echo "<script>alert('Data berhasil disimpan');location='admin.php?page=gallery';</script>";
}

/* =======================
   HAPUS
======================= */
if (isset($_POST['hapus'])) {

    $id = $_POST['id'];
    $gambar = $_POST['gambar'];

    if (!empty($gambar) && file_exists('img/'.$gambar)) {
        unlink('img/'.$gambar);
    }

    $stmt = $conn->prepare("DELETE FROM gallery WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();

    echo "<script>alert('Data berhasil dihapus');location='admin.php?page=gallery';</script>";
}
?>
