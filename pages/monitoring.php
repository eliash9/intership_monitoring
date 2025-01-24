<?php
include '../config.php';
include '../includes/header.php';

// Tambah atau Update Monitoring
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? null;
    $teacher_id = $_POST['teacher_id'];
    $student_id = $_POST['student_id'];
    $company_id = $_POST['company_id'];
    $monitoring_date = $_POST['monitoring_date'];

    if ($id) {
        // Update Monitoring
        $stmt = $pdo->prepare("UPDATE monitoring SET teacher_id = ?, student_id = ?, company_id = ?, monitoring_date = ? WHERE id = ?");
        $stmt->execute([$teacher_id, $student_id, $company_id, $monitoring_date, $id]);
        echo "<div class='alert alert-success'>Jadwal monitoring berhasil diperbarui.</div>";
    } else {
        // Insert Monitoring
        $stmt = $pdo->prepare("INSERT INTO monitoring (teacher_id, student_id, company_id, monitoring_date) VALUES (?, ?, ?, ?)");
        $stmt->execute([$teacher_id, $student_id, $company_id, $monitoring_date]);
        echo "<div class='alert alert-success'>Jadwal monitoring baru berhasil ditambahkan.</div>";
    }
}

// Hapus Monitoring
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $pdo->prepare("DELETE FROM monitoring WHERE id = ?");
    $stmt->execute([$id]);
    echo "<div class='alert alert-success'>Jadwal monitoring berhasil dihapus.</div>";
}

// Ambil Data Monitoring
$monitoring = $pdo->query("
    SELECT m.id, t.name AS teacher_name, s.name AS student_name, c.name AS company_name, m.monitoring_date 
    FROM monitoring m
    JOIN teachers t ON m.teacher_id = t.id
    JOIN students s ON m.student_id = s.id
    JOIN companies c ON m.company_id = c.id
")->fetchAll(PDO::FETCH_ASSOC);

// Ambil Data Guru, Siswa, dan Perusahaan untuk dropdown
$teachers = $pdo->query("SELECT id, name FROM teachers")->fetchAll(PDO::FETCH_ASSOC);
$students = $pdo->query("SELECT id, name FROM students")->fetchAll(PDO::FETCH_ASSOC);
$companies = $pdo->query("SELECT id, name FROM companies")->fetchAll(PDO::FETCH_ASSOC);
?>

<h1>Jadwal Monitoring</h1>

<!-- Tabel Monitoring -->
<table class="table table-bordered table-striped">
    <thead class="table-light">
        <tr>
            <th>ID</th>
            <th>Nama Guru</th>
            <th>Nama Siswa</th>
            <th>Perusahaan</th>
            <th>Tanggal Monitoring</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($monitoring as $row): ?>
        <tr>
            <td><?= $row['id']; ?></td>
            <td><?= $row['teacher_name']; ?></td>
            <td><?= $row['student_name']; ?></td>
            <td><?= $row['company_name']; ?></td>
            <td><?= $row['monitoring_date']; ?></td>
            <td>
                <a href="?edit=<?= $row['id']; ?>" class="btn btn-primary btn-sm">Edit</a>
                <a href="?delete=<?= $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Hapus jadwal monitoring ini?')">Delete</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<!-- Form Tambah/Edit Monitoring -->
<h2><?= isset($_GET['edit']) ? 'Edit Jadwal Monitoring' : 'Tambah Jadwal Monitoring' ?></h2>
<?php
$editData = isset($_GET['edit']) ? $pdo->prepare("SELECT * FROM monitoring WHERE id = ?") : null;
if ($editData) {
    $editData->execute([$_GET['edit']]);
    $editData = $editData->fetch(PDO::FETCH_ASSOC);
}
?>
<form method="POST" class="mb-3">
    <input type="hidden" name="id" value="<?= $editData['id'] ?? ''; ?>">
    <div class="mb-3">
        <label for="teacher_id" class="form-label">Guru</label>
        <select id="teacher_id" name="teacher_id" class="form-control" required>
            <option value="">Pilih Guru</option>
            <?php foreach ($teachers as $teacher): ?>
            <option value="<?= $teacher['id']; ?>" <?= isset($editData['teacher_id']) && $editData['teacher_id'] == $teacher['id'] ? 'selected' : ''; ?>>
                <?= $teacher['name']; ?>
            </option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="mb-3">
        <label for="student_id" class="form-label">Siswa</label>
        <select id="student_id" name="student_id" class="form-control" required>
            <option value="">Pilih Siswa</option>
            <?php foreach ($students as $student): ?>
            <option value="<?= $student['id']; ?>" <?= isset($editData['student_id']) && $editData['student_id'] == $student['id'] ? 'selected' : ''; ?>>
                <?= $student['name']; ?>
            </option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="mb-3">
        <label for="company_id" class="form-label">Perusahaan</label>
        <select id="company_id" name="company_id" class="form-control" required>
            <option value="">Pilih Perusahaan</option>
            <?php foreach ($companies as $company): ?>
            <option value="<?= $company['id']; ?>" <?= isset($editData['company_id']) && $editData['company_id'] == $company['id'] ? 'selected' : ''; ?>>
                <?= $company['name']; ?>
            </option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="mb-3">
        <label for="monitoring_date" class="form-label">Tanggal Monitoring</label>
        <input type="date" id="monitoring_date" name="monitoring_date" class="form-control" value="<?= $editData['monitoring_date'] ?? ''; ?>" required>
    </div>
    <button type="submit" class="btn btn-success"><?= isset($editData) ? 'Update' : 'Tambah' ?></button>
</form>

<?php include '../includes/footer.php'; ?>
