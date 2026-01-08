<?php
include 'koneksi.php';
include "upload_foto.php";
?>

<div class="container">
		<div class="row mb-2">
        <div class="col-md-6">
           <!--button add-->
        </div>
        <div class="col-md-6">
            						<div class="input-group">
                <input type="text" id="search" class="form-control" placeholder="Cari Artikel...">
                <span class="input-group-text">
                    <i class="bi bi-search"></i>
                </span>
            </div>
        </div>
    </div>
    <!-- TOMBOL TAMBAH -->
    <button type="button" class="btn btn-secondary mb-3" data-bs-toggle="modal" data-bs-target="#modalTambah">
    Tambah Article
    </button>

    <!-- TABEL ARTICLE -->
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead class="table-dark">
                <tr>
                    <th width="5%">No</th>
                    <th width="20%">Judul</th>
                    <th width="35%">Isi</th>
                    <th width="20%">Gambar</th>
                    <th width="10%">Aksi</th>
                </tr>
            </thead>
            <tbody id="result">

            <?php
            $sql = "SELECT * FROM article ORDER BY tanggal DESC";
            $result = $conn->query($sql);
            $no = 1;

            if ($result && $result->num_rows > 0):
                while ($row = $result->fetch_assoc()):
            ?>
                <tr>
                    <td><?= $no++; ?></td>

                    <td>
                        <strong><?= $row['judul']; ?></strong><br>
                        <small><?= $row['tanggal']; ?> | <?= $row['username']; ?></small>
                    </td>

                    <td><?= nl2br($row['isi']); ?></td>

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
        <h5 class="modal-title">Edit Article</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <form method="post" enctype="multipart/form-data">
        <div class="modal-body">

          <input type="hidden" name="id" value="<?= $row['id'] ?>">
          <input type="hidden" name="gambar_lama" value="<?= $row['gambar'] ?>">

          <div class="mb-3">
            <label class="form-label">Judul</label>
            <input type="text" name="judul" class="form-control" value="<?= $row['judul'] ?>" required>
          </div>

          <div class="mb-3">
            <label class="form-label">Isi</label>
            <textarea name="isi" class="form-control" required><?= $row['isi'] ?></textarea>
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
        <h5 class="modal-title">Hapus Article</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <form method="post">
        <div class="modal-body">
          Yakin hapus artikel <strong><?= $row['judul']; ?></strong> ?
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

            <?php
                endwhile;
            else:
            ?>
                <tr>
                    <td colspan="5" class="text-center">Belum ada artikel</td>
                </tr>
            <?php endif; ?>

            </tbody>
 <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    function loadData(keyword = '') {
        $.ajax({
            url: "article_search.php",
            type: "POST",
            data: { keyword: keyword },
            success: function(data) {
                $("#result").html(data);
            }
        });
    }

    // event pencarian
    $("#search").on("keyup", function() {
        let keyword = $(this).val();
        loadData(keyword);
    });
</script>

        </table>
    </div>
</div>

<!-- ================= MODAL TAMBAH ================= -->
<div class="modal fade" id="modalTambah" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title">Tambah Article</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <form method="post" enctype="multipart/form-data">
        <div class="modal-body">

          <div class="mb-3">
            <label class="form-label">Judul</label>
            <input type="text" name="judul" class="form-control" required>
          </div>

          <div class="mb-3">
            <label class="form-label">Isi</label>
            <textarea name="isi" class="form-control" required></textarea>
          </div>

          <div class="mb-3">
            <label class="form-label">Gambar</label>
            <input type="file" name="gambar" class="form-control">
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
    $isi = $_POST['isi'];
    $tanggal = date("Y-m-d H:i:s");
    $username = $_SESSION['username'];

    $gambar = '';
    $nama_gambar = $_FILES['gambar']['name'];

    if ($nama_gambar != '') {
        $cek_upload = upload_foto($_FILES['gambar']);
        if ($cek_upload['status']) {
            $gambar = $cek_upload['message'];
        } else {
            echo "<script>alert('".$cek_upload['message']."');location='admin.php?page=article';</script>";
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

        $stmt = $conn->prepare("UPDATE article SET judul=?, isi=?, gambar=?, tanggal=?, username=? WHERE id=?");
        $stmt->bind_param("sssssi", $judul, $isi, $gambar, $tanggal, $username, $id);

    } else {
        // INSERT
        $stmt = $conn->prepare("INSERT INTO article (judul, isi, gambar, tanggal, username) VALUES (?,?,?,?,?)");
        $stmt->bind_param("sssss", $judul, $isi, $gambar, $tanggal, $username);
    }

    $stmt->execute();
    $stmt->close();

    echo "<script>alert('Data berhasil disimpan');location='admin.php?page=article';</script>";
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

    $stmt = $conn->prepare("DELETE FROM article WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();

    echo "<script>alert('Data berhasil dihapus');location='admin.php?page=article';</script>";
}
?>
