<?php
include 'koneksi.php';

$keyword = $_POST['keyword'] ?? '';
$search = "%" . $keyword . "%";

$sql = "SELECT * FROM gallery 
        WHERE judul LIKE ? 
           OR tanggal LIKE ? 
           OR username LIKE ?
        ORDER BY tanggal DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $search, $search, $search);
$stmt->execute();

$result = $stmt->get_result();
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
        <a href="#" class="badge rounded-pill text-bg-success" data-bs-toggle="modal" data-bs-target="#modalEdit<?= $row['id'] ?>">
            <i class="bi bi-pencil"></i>
        </a>
        <a href="#" class="badge rounded-pill text-bg-danger" data-bs-toggle="modal" data-bs-target="#modalHapus<?= $row['id'] ?>">
            <i class="bi bi-x-circle"></i>
        </a>
    </td>
</tr>
<?php
    endwhile;
else:
?>
<tr>
    <td colspan="5" class="text-center text-muted">Data tidak ditemukan</td>
</tr>
<?php
endif;
?>
