<?php
include '../config.php';
include '../includes/header.php';

// Tambah atau Update Perusahaan
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? null;
    $name = $_POST['name'];
    $contact_person = $_POST['contact_person'];
    $contact_info = $_POST['contact_info'];
    $address = $_POST['address'];

    if ($id) {
        // Update
        $stmt = $pdo->prepare("UPDATE companies SET name = ?, contact_person = ?, contact_info = ?, address = ? WHERE id = ?");
        $stmt->execute([$name, $contact_person, $contact_info, $address, $id]);
        echo "<div class='alert alert-success'>Data perusahaan berhasil diperbarui.</div>";
    } else {
        // Insert
        $stmt = $pdo->prepare("INSERT INTO companies (name, contact_person, contact_info, address) VALUES (?, ?, ?, ?)");
        $stmt->execute([$name, $contact_person, $contact_info, $address]);
        echo "<div class='alert alert-success'>Perusahaan baru berhasil ditambahkan.</div>";
    }
}

// Hapus Perusahaan
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $pdo->prepare("DELETE FROM companies WHERE id = ?");
    $stmt->execute([$id]);
    echo "<div class='alert alert-success'>Data perusahaan berhasil dihapus.</div>";
}

// Ambil Data Perusahaan
$companies = $pdo->query("SELECT * FROM companies")->fetchAll(PDO::FETCH_ASSOC);
?>

<h1>Data Perusahaan</h1>

<!-- Tabel Perusahaan -->
<table class="table table-bordered table-striped">
    <thead class="table-light">
        <tr>
            <th>ID</th>
            <th>Nama Perusahaan</th>
            <th>Kontak Person</th>
            <th>Kontak Info</th>
            <th>Alamat</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($companies as $company): ?>
        <tr>
            <td><?= $company['id']; ?></td>
            <td><?= $company['name']; ?></td>
            <td><?= $company['contact_person']; ?></td>
            <td><?= $company['contact_info']; ?></td>
            <td><?= $company['address']; ?></td>
            <td>
                <a href="?edit=<?= $company['id']; ?>" class="btn btn-primary btn-sm">Edit</a>
                <a href="?delete=<?= $company['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Hapus perusahaan ini?')">Delete</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<!-- Form Tambah/Edit Perusahaan -->
<h2><?= isset($_GET['edit']) ? 'Edit Perusahaan' : 'Tambah Perusahaan Baru' ?></h2>
<?php
$editData = isset($_GET['edit']) ? $pdo->prepare("SELECT * FROM companies WHERE id = ?") : null;
if ($editData) {
    $editData->execute([$_GET['edit']]);
    $editData = $editData->fetch(PDO::FETCH_ASSOC);
}
?>
<form method="POST" class="mb-3">
    <input type="hidden" name="id" value="<?= $editData['id'] ?? ''; ?>">
    <div class="mb-3">
        <label for="name" class="form-label">Nama Perusahaan</label>
        <input type="text" id="name" name="name" class="form-control" value="<?= $editData['name'] ?? ''; ?>" required>
    </div>
    <div class="mb-3">
        <label for="contact_person" class="form-label">Kontak Person</label>
        <input type="text" id="contact_person" name="contact_person" class="form-control" value="<?= $editData['contact_person'] ?? ''; ?>" required>
    </div>
    <div class="mb-3">
        <label for="contact_info" class="form-label">Kontak Info</label>
        <input type="text" id="contact_info" name="contact_info" class="form-control" value="<?= $editData['contact_info'] ?? ''; ?>">
    </div>
    <div class="mb-3">
        <label for="address" class="form-label">Alamat</label>
        <textarea id="address" name="address" class="form-control" rows="3"><?= $editData['address'] ?? ''; ?></textarea>
    </div>
    <button type="submit" class="btn btn-success"><?= isset($editData) ? 'Update' : 'Tambah' ?></button>
</form>

<?php include '../includes/footer.php'; ?>
