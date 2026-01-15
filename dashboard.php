<?php
include 'koneksi.php';

// 1. Ambil data user yang sedang login dari database berdasarkan session
$username_session = $_SESSION['username'];
$sql_user = "SELECT * FROM user WHERE username = ?";
$stmt_user = $conn->prepare($sql_user);
$stmt_user->bind_param("s", $username_session);
$stmt_user->execute();
$result_user = $stmt_user->get_result();
$user_data = $result_user->fetch_assoc();

// 2. Query mengambil jumlah data article
$sql1 = "SELECT * FROM article";
$hasil1 = $conn->query($sql1);
$jumlah_article = $hasil1 ? $hasil1->num_rows : 0;

// 3. Query mengambil jumlah data gallery
$sql2 = "SELECT * FROM gallery";
$hasil2 = $conn->query($sql2);
$jumlah_gallery = $hasil2 ? $hasil2->num_rows : 0;
?>

<div class="container text-center mt-5">
    <p class="lead mb-0">Selamat Datang,</p>
    <h2 class="display-5 fw-bold text-danger mb-3"><?= htmlspecialchars($user_data['username']) ?></h2>
    
    <div class="mb-5">
        <img src="img/<?= !empty($user_data['foto']) ? $user_data['foto'] : 'default.png' ?>" 
             class="rounded-circle shadow" 
             style="width: 250px; height: 250px; object-fit: cover; border: 5px solid #fff;">
    </div>

    <div class="row justify-content-center g-4">
        
        <div class="col-md-3">
            <div class="card border-danger shadow-sm h-100">
                <div class="card-body d-flex justify-content-between align-items-center px-4">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-newspaper fs-4 me-2"></i>
                        <span class="fw-bold">Article</span>
                    </div>
                    <span class="badge rounded-circle bg-danger p-3 fs-5 d-flex align-items-center justify-content-center" 
                          style="width: 50px; height: 50px;">
                        <?= $jumlah_article ?>
                    </span>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-danger shadow-sm h-100">
                <div class="card-body d-flex justify-content-between align-items-center px-4">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-camera fs-4 me-2"></i>
                        <span class="fw-bold">Gallery</span>
                    </div>
                    <span class="badge rounded-circle bg-danger p-3 fs-5 d-flex align-items-center justify-content-center" 
                          style="width: 50px; height: 50px;">
                        <?= $jumlah_gallery ?>
                    </span>
                </div>
            </div>
        </div>

    </div>
</div>