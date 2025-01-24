<?php
include '../config.php';
include '../includes/header.php';

// Tambah atau Update Periode
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? null;
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];

    if ($id) {
        // Update Periode
        $stmt = $pdo->prepare("UPDATE internship_periods SET start_date = ?, end_date = ? WHERE id = ?");
        $stmt->execute([$start_date, $end_date, $id]);
        echo "<div class='alert alert-success'>Jadwal internship_periods berhasil diperbarui.</div>";
    } else {
        // Insert Periode
        $stmt = $pdo->prepare("INSERT INTO internship_periods (start_date, end_date) VALUES (?, ?)");
        $stmt->execute([$start_date, $end_date]);
        echo "<div class='alert alert-success'>Jadwal internship_periods baru berhasil ditambahkan.</div>";
    }
}

// Hapus Periode
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $pdo->prepare("DELETE FROM internship_periods WHERE id = ?");
    $stmt->execute([$id]);
    echo "<div class='alert alert-success'>Jadwal internship_periods berhasil dihapus.</div>";
}

// Ambil Data Periode
$internship_periods = $pdo->query("
    SELECT *
    FROM internship_periods 
")->fetchAll(PDO::FETCH_ASSOC);

?>

<h1>Jadwal Periode</h1>

<!-- Tabel Periode -->
<table class="table table-bordered table-striped">
    <thead class="table-light">
        <tr>
            <th>ID</th>
            <th>Start Date</th>
            <th>End Date</th>
            
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($internship_periods as $row): ?>
        <tr>
            <td><?= $row['id']; ?></td>
            <td><?= $row['start_date']; ?></td>
            <td><?= $row['end_date']; ?></td>
           
            <td>
                <a href="?edit=<?= $row['id']; ?>" class="btn btn-primary btn-sm">Edit</a>
                <a href="?delete=<?= $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Hapus jadwal internship_periods ini?')">Delete</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<!-- Form Tambah/Edit Periode -->
<h2><?= isset($_GET['edit']) ? 'Edit Jadwal Periode' : 'Tambah Jadwal Periode' ?></h2>
<?php
$editData = isset($_GET['edit']) ? $pdo->prepare("SELECT * FROM internship_periods WHERE id = ?") : null;
if ($editData) {
    $editData->execute([$_GET['edit']]);
    $editData = $editData->fetch(PDO::FETCH_ASSOC);
}
?>
<form method="POST" class="mb-3">
    <input type="hidden" name="id" value="<?= $editData['id'] ?? ''; ?>">
    <div class="mb-3">
        <label for="start_date" class="form-label">Guru</label>
        <input type="date" id="start_date" name="start_date" class="form-control" value="<?= $editData['start_date'] ?? ''; ?>" required>
    </div>
    <div class="mb-3">
        <label for="end_date" class="form-label">Siswa</label>
        <input type="date" id="end_date" name="end_date" class="form-control" value="<?= $editData['end_date'] ?? ''; ?>" required>
  
    </div>
    
    <button type="submit" class="btn btn-success"><?= isset($editData) ? 'Update' : 'Tambah' ?></button>
</form>

<?php include '../includes/footer.php'; ?>
