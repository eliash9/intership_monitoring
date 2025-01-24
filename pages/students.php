<?php
include '../config.php';
include '../includes/header.php';

// Tambah atau Update Siswa
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? null;
    $name = $_POST['name'];
    $student_id = $_POST['student_id'];
    $contact_info = $_POST['contact_info'];

    if ($id) {
        // Update
        $stmt = $pdo->prepare("UPDATE students SET name = ?, student_id = ?, contact_info = ? WHERE id = ?");
        $stmt->execute([$name, $student_id, $contact_info, $id]);
        echo "<p>Siswa berhasil diperbarui.</p>";
    } else {
        // Insert
        $stmt = $pdo->prepare("INSERT INTO students (name, student_id, contact_info) VALUES (?, ?, ?)");
        $stmt->execute([$name, $student_id, $contact_info]);
        echo "<p>Siswa berhasil ditambahkan.</p>";
    }
}

// Hapus Siswa
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $pdo->prepare("DELETE FROM students WHERE id = ?");
    $stmt->execute([$id]);
    echo "<p>Siswa berhasil dihapus.</p>";
}

// Ambil Data Siswa
$students = $pdo->query("SELECT * FROM students")->fetchAll(PDO::FETCH_ASSOC);
?>

<h1>Data Siswa</h1>
<table class="table table-bordered table-striped">
    <thead class="table-light">
        <tr>
            <th>ID</th>
            <th>Nama</th>
            <th>ID Siswa</th>
            <th>Kontak</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($students as $student): ?>
        <tr>
            <td><?= $student['id']; ?></td>
            <td><?= $student['name']; ?></td>
            <td><?= $student['student_id']; ?></td>
            <td><?= $student['contact_info']; ?></td>
            <td>
                <a href="?edit=<?= $student['id']; ?>" class="btn btn-primary btn-sm">Edit</a>
                <a href="?delete=<?= $student['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Hapus siswa ini?')">Delete</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>


<h2><?= isset($_GET['edit']) ? 'Edit Siswa' : 'Tambah Siswa Baru' ?></h2>
<?php
$editData = isset($_GET['edit']) ? $pdo->prepare("SELECT * FROM students WHERE id = ?") : null;
if ($editData) {
    $editData->execute([$_GET['edit']]);
    $editData = $editData->fetch(PDO::FETCH_ASSOC);
}
?>
<form method="POST" class="mb-3">
    <input type="hidden" name="id" value="<?= $editData['id'] ?? ''; ?>">
    <div class="mb-3">
        <label for="name" class="form-label">Nama</label>
        <input type="text" id="name" name="name" class="form-control" value="<?= $editData['name'] ?? ''; ?>" required>
    </div>
    <div class="mb-3">
        <label for="student_id" class="form-label">ID Siswa</label>
        <input type="text" id="student_id" name="student_id" class="form-control" value="<?= $editData['student_id'] ?? ''; ?>" required>
    </div>
    <div class="mb-3">
        <label for="contact_info" class="form-label">Kontak</label>
        <input type="text" id="contact_info" name="contact_info" class="form-control" value="<?= $editData['contact_info'] ?? ''; ?>">
    </div>
    <button type="submit" class="btn btn-success"><?= isset($editData) ? 'Update' : 'Tambah' ?></button>
</form>


<?php include '../includes/footer.php'; ?>
