<?php
include "koneksi.php";

// pastikan session sudah aktif dari admin.php
if (!isset($_SESSION['username'])) {
    header("location:login.php");
    exit;
}

$username = $_SESSION['username'];

/* =========================
   AMBIL DATA USER LOGIN
========================= */
$stmt = $conn->prepare("SELECT * FROM user WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();


/* =========================
   PROSES UPDATE PROFILE
========================= */
if (isset($_POST['update_profile'])) {

    $password_baru = $_POST['password_baru'];
    $foto_baru = $_FILES['foto']['name'];

    $password_final = $user['password'];
    $foto_final = $user['foto'];

    // === JIKA GANTI PASSWORD ===
    if (!empty($password_baru)) {
        $password_final = md5($password_baru); // 🔥 IKUT LOGIN.PHP (MD5)
    }

    // === JIKA GANTI FOTO ===
    if (!empty($foto_baru)) {
        $tmp = $_FILES['foto']['tmp_name'];
        $ext = pathinfo($foto_baru, PATHINFO_EXTENSION);
        $nama_baru = uniqid() . "." . $ext;

        move_uploaded_file($tmp, "img/" . $nama_baru);

        // hapus foto lama
        if (!empty($foto_final) && file_exists("img/" . $foto_final)) {
            unlink("img/" . $foto_final);
        }

        $foto_final = $nama_baru;
    }

    // === UPDATE KE DATABASE ===
    $stmt = $conn->prepare("UPDATE user SET password = ?, foto = ? WHERE username = ?");
    $stmt->bind_param("sss", $password_final, $foto_final, $username);
    $stmt->execute();
    $stmt->close();

    echo "<script>
            alert('Profile berhasil diperbarui');
            window.location='admin.php?page=profile';
          </script>";
    exit;
}
?>

<!-- =========================
     TAMPILAN PROFILE
========================= -->
<div class="container mt-4">
    <h3 class="mb-3">Profile Saya</h3>
    <hr>

    <form method="post" enctype="multipart/form-data">

        <!-- USERNAME -->
        <div class="mb-3">
            <label class="form-label">Username</label>
            <input type="text" class="form-control" value="<?= $user['username']; ?>" readonly>
        </div>

        <!-- PASSWORD -->
        <div class="mb-3">
            <label class="form-label">Ganti Password</label>
            <input type="password" name="password_baru" class="form-control" placeholder="Kosongkan jika tidak ingin ganti password">
        </div>

        <!-- FOTO -->
        <div class="mb-3">
            <label class="form-label">Ganti Foto Profil</label>
            <input type="file" name="foto" class="form-control">
        </div>

        <!-- FOTO SAAT INI -->
        <div class="mb-3">
            <label class="form-label">Foto Profil Saat Ini</label><br>
            <?php if (!empty($user['foto']) && file_exists("img/" . $user['foto'])): ?>
                <img src="img/<?= $user['foto']; ?>" width="120" class="rounded shadow">
            <?php else: ?>
                <span class="text-muted">Belum ada foto</span>
            <?php endif; ?>
        </div>

        <button type="submit" name="update_profile" class="btn btn-success">
            <i class="bi bi-save"></i> Simpan Perubahan
        </button>
    </form>
</div>
