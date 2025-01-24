<?php
include '../config.php';
include '../includes/header.php';

// Tambah atau Update Internships
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? null;
    $teacher_id = $_POST['teacher_id'];
    $student_id = $_POST['student_id'];
    $company_id = $_POST['company_id'];
    $period_id = $_POST['period_id'];

    if ($id) {
        // Update Internships
        $stmt = $pdo->prepare("UPDATE internships SET teacher_id = ?, student_id = ?, company_id = ?, period_id = ? WHERE id = ?");
        $stmt->execute([$teacher_id, $student_id, $company_id, $period_id, $id]);
        echo "<div class='alert alert-success'>Jadwal internships berhasil diperbarui.</div>";
    } else {
        // Insert Internships
        $stmt = $pdo->prepare("INSERT INTO internships (teacher_id, student_id, company_id, period_id) VALUES (?, ?, ?, ?)");
        $stmt->execute([$teacher_id, $student_id, $company_id, $period_id]);
        echo "<div class='alert alert-success'>Jadwal internships baru berhasil ditambahkan.</div>";
    }
}

// Hapus Internships
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $pdo->prepare("DELETE FROM internships WHERE id = ?");
    $stmt->execute([$id]);
    echo "<div class='alert alert-success'>Jadwal internships berhasil dihapus.</div>";
}

// Ambil Data Internships
$internships = $pdo->query("
    SELECT m.id, t.name AS teacher_name, s.name AS student_name, c.name AS company_name, m.period_id,i.start_date,i.end_date  
    FROM internships m
    JOIN teachers t ON m.teacher_id = t.id
    JOIN students s ON m.student_id = s.id
    JOIN companies c ON m.company_id = c.id
    JOIN internship_periods i on m.period_id=i.id 
")->fetchAll(PDO::FETCH_ASSOC);

// Ambil Data Guru, Siswa, dan Perusahaan untuk dropdown
$teachers = $pdo->query("SELECT id, name FROM teachers")->fetchAll(PDO::FETCH_ASSOC);
$students = $pdo->query("SELECT id, name FROM students")->fetchAll(PDO::FETCH_ASSOC);
$companies = $pdo->query("SELECT id, name FROM companies")->fetchAll(PDO::FETCH_ASSOC);
$internship_periods = $pdo->query("SELECT id, description FROM internship_periods")->fetchAll(PDO::FETCH_ASSOC);
?>

<h1>Jadwal Internships</h1>

<!-- Tabel Internships -->
<table class="table table-bordered table-striped">
    <thead class="table-light">
        <tr>
            <th>ID</th>
            <th>Nama Guru</th>
            <th>Nama Siswa</th>
            <th>Perusahaan</th>
            <th>Internships periode</th>
            <th>Start</th>
            <th>End</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($internships as $row): ?>
        <tr>
            <td><?= $row['id']; ?></td>
            <td><?= $row['teacher_name']; ?></td>
            <td><?= $row['student_name']; ?></td>
            <td><?= $row['company_name']; ?></td>
            <td><?= $row['period_id']; ?></td>
            <td><?= $row['start_date']; ?></td>
            <td><?= $row['end_date']; ?></td>
            <td>
                <a href="?edit=<?= $row['id']; ?>" class="btn btn-primary btn-sm">Edit</a>
                <a href="?delete=<?= $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Hapus jadwal internships ini?')">Delete</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<!-- Form Tambah/Edit Internships -->
<h2><?= isset($_GET['edit']) ? 'Edit Jadwal Internships' : 'Tambah Jadwal Internships' ?></h2>
<?php
$editData = isset($_GET['edit']) ? $pdo->prepare("SELECT * FROM internships WHERE id = ?") : null;
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
        <label for="period_id" class="form-label">Periode</label>
        <select id="period_id" name="period_id" class="form-control" required>
            <option value="">Pilih Periode</option>
            <?php foreach ($internship_periods as $period): ?>
            <option value="<?= $period['id']; ?>" <?= isset($editData['period_id']) && $editData['period_id'] == $period['id'] ? 'selected' : ''; ?>>
                <?= $period['description']; ?>
            </option>
            <?php endforeach; ?>
        </select>
    </div>
   
    <button type="submit" class="btn btn-success"><?= isset($editData) ? 'Update' : 'Tambah' ?></button>
</form>

<?php include '../includes/footer.php'; ?>
