<?php
include '../config.php';
include '../includes/header.php';

// Tambah atau Update Guru
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? null;
    $name = $_POST['name'];
    $contact_info = $_POST['contact_info'];

    if ($id) {
        // Update
        $stmt = $pdo->prepare("UPDATE teachers SET name = ?,  contact_info = ? WHERE id = ?");
        $stmt->execute([$name,  $contact_info, $id]);
        echo "<p>Guru berhasil diperbarui.</p>";
    } else {
        // Insert
        $stmt = $pdo->prepare("INSERT INTO teachers (name,  contact_info) VALUES (?,  ?)");
        $stmt->execute([$name, $contact_info]);
        echo "<p>Guru berhasil ditambahkan.</p>";
    }
}

// Hapus Guru
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $pdo->prepare("DELETE FROM teachers WHERE id = ?");
    $stmt->execute([$id]);
    echo "<p>Guru berhasil dihapus.</p>";
}

// Ambil Data Guru
$teachers = $pdo->query("SELECT * FROM teachers")->fetchAll(PDO::FETCH_ASSOC);
?>

<h1>Data Guru</h1>
<table class="table table-bordered table-striped">
    <thead class="table-light">
        <tr>
            <th>ID</th>
            <th>Nama</th>
            <th>Kontak</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($teachers as $teacher): ?>
        <tr>
            <td><?= $teacher['id']; ?></td>
            <td><?= $teacher['name']; ?></td>
            <td><?= $teacher['contact_info']; ?></td>
            <td>
                <a href="?edit=<?= $teacher['id']; ?>" class="btn btn-primary btn-sm">Edit</a>
                <a href="?delete=<?= $teacher['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Hapus Guru ini?')">Delete</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>


<h2><?= isset($_GET['edit']) ? 'Edit Guru' : 'Tambah Guru Baru' ?></h2>
<?php
$editData = isset($_GET['edit']) ? $pdo->prepare("SELECT * FROM teachers WHERE id = ?") : null;
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
        <label for="contact_info" class="form-label">Kontak</label>
        <input type="text" id="contact_info" name="contact_info" class="form-control" value="<?= $editData['contact_info'] ?? ''; ?>">
    </div>
    <button type="submit" class="btn btn-success"><?= isset($editData) ? 'Update' : 'Tambah' ?></button>
</form>


<?php include '../includes/footer.php'; ?>
