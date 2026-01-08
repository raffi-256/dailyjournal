<?php
include "koneksi.php";

$keyword = $_POST['keyword'] ?? '';

$sql = "SELECT * FROM article 
        WHERE judul LIKE ? 
           OR isi LIKE ? 
           OR tanggal LIKE ? 
           OR username LIKE ?
        ORDER BY tanggal DESC";

$stmt = $conn->prepare($sql);
$search = "%" . $keyword . "%";
$stmt->bind_param("ssss", $search, $search, $search, $search);
$stmt->execute();

$hasil = $stmt->get_result();
$no = 1;

if ($hasil && $hasil->num_rows > 0):
    while ($row = $hasil->fetch_assoc()):
?>
<tr>
    <td><?= $no++; ?></td>

    <td>
        <strong><?= htmlspecialchars($row['judul']); ?></strong><br>
        <small>
            <?= $row['tanggal']; ?> |
            <?= htmlspecialchars($row['username']); ?>
        </small>
    </td>

    <td><?= nl2br(htmlspecialchars($row['isi'])); ?></td>

    <td>
        <?php if (!empty($row['gambar']) && file_exists('img/'.$row['gambar'])): ?>
            <img src="img/<?= $row['gambar']; ?>" class="img-fluid rounded" width="120">
        <?php else: ?>
            <span class="text-muted">Tidak ada</span>
        <?php endif; ?>
    </td>

    <td>
        <a href="#" class="badge rounded-pill text-bg-success">
            <i class="bi bi-pencil"></i>
        </a>
        <a href="#" class="badge rounded-pill text-bg-danger">
            <i class="bi bi-x-circle"></i>
        </a>
    </td>
</tr>
<?php
    endwhile;
else:
?>
<tr>
    <td colspan="5" class="text-center text-muted">
        Article tidak ditemukan
    </td>
</tr>
<?php
endif;
?>
