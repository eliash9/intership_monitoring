<?php
include '../config.php'; // Hubungkan ke database

include '../includes/header.php';
// Ambil data filter dari request (jika ada)
$teacherId = isset($_GET['teacher_id']) ? $_GET['teacher_id'] : '';
$studentId = isset($_GET['student_id']) ? $_GET['student_id'] : '';
$companyId = isset($_GET['company_id']) ? $_GET['company_id'] : '';
$periodId = isset($_GET['period_id']) ? $_GET['period_id'] : '';

// Query untuk menampilkan data monitoring
$query = "
    SELECT 
        m.monitoring_date,
        t.name AS teacher_name,
        s.name AS student_name,
        c.name AS company_name,
        ip.start_date,
        ip.end_date
    FROM monitoring m
    JOIN teachers t ON m.teacher_id = t.id
    JOIN students s ON m.student_id = s.id
    JOIN companies c ON m.company_id = c.id
    JOIN internships i ON m.student_id = i.student_id AND m.teacher_id = i.teacher_id AND m.company_id = i.company_id
    JOIN internship_periods ip ON i.period_id = ip.id
    WHERE 1=1
";

// Tambahkan filter jika ada
if (!empty($teacherId)) {
    $query .= " AND m.teacher_id = :teacher_id";
}
if (!empty($studentId)) {
    $query .= " AND m.student_id = :student_id";
}
if (!empty($companyId)) {
    $query .= " AND m.company_id = :company_id";
}
if (!empty($periodId)) {
    $query .= " AND ip.id = :period_id";
}

// Siapkan dan eksekusi query
$stmt = $pdo->prepare($query);
if (!empty($teacherId)) $stmt->bindParam(':teacher_id', $teacherId);
if (!empty($studentId)) $stmt->bindParam(':student_id', $studentId);
if (!empty($companyId)) $stmt->bindParam(':company_id', $companyId);
if (!empty($periodId)) $stmt->bindParam(':period_id', $periodId);

$stmt->execute();
$monitoringData = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Ambil data untuk dropdown filter
$teachers = $pdo->query("SELECT id, name FROM teachers")->fetchAll(PDO::FETCH_ASSOC);
$students = $pdo->query("SELECT id, name FROM students")->fetchAll(PDO::FETCH_ASSOC);
$companies = $pdo->query("SELECT id, name FROM companies")->fetchAll(PDO::FETCH_ASSOC);
$periods = $pdo->query("SELECT id, start_date, end_date FROM internship_periods")->fetchAll(PDO::FETCH_ASSOC);
?>

    <h1 class="mb-4">Monitoring</h1>
    
    <!-- Filter Form -->
    <form method="GET" class="row g-3 mb-4">
        <div class="col-md-3">
            <label for="teacher_id" class="form-label">Guru</label>
            <select id="teacher_id" name="teacher_id" class="form-select">
                <option value="">Semua Guru</option>
                <?php foreach ($teachers as $teacher): ?>
                    <option value="<?= $teacher['id'] ?>" <?= $teacherId == $teacher['id'] ? 'selected' : '' ?>>
                        <?= $teacher['name'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-3">
            <label for="student_id" class="form-label">Siswa</label>
            <select id="student_id" name="student_id" class="form-select">
                <option value="">Semua Siswa</option>
                <?php foreach ($students as $student): ?>
                    <option value="<?= $student['id'] ?>" <?= $studentId == $student['id'] ? 'selected' : '' ?>>
                        <?= $student['name'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-3">
            <label for="company_id" class="form-label">Perusahaan</label>
            <select id="company_id" name="company_id" class="form-select">
                <option value="">Semua Perusahaan</option>
                <?php foreach ($companies as $company): ?>
                    <option value="<?= $company['id'] ?>" <?= $companyId == $company['id'] ? 'selected' : '' ?>>
                        <?= $company['name'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-3">
            <label for="period_id" class="form-label">Periode</label>
            <select id="period_id" name="period_id" class="form-select">
                <option value="">Semua Periode</option>
                <?php foreach ($periods as $period): ?>
                    <option value="<?= $period['id'] ?>" <?= $periodId == $period['id'] ? 'selected' : '' ?>>
                        <?= $period['start_date'] ?> - <?= $period['end_date'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-12 text-end">
            <button type="submit" class="btn btn-primary">Filter</button>
            <a href="monitoring.php" class="btn btn-secondary">Reset</a>
        </div>
    </form>

    <!-- Tabel Monitoring -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Tanggal Monitoring</th>
                <th>Guru</th>
                <th>Siswa</th>
                <th>Perusahaan</th>
                <th>Periode</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($monitoringData)): ?>
                <?php foreach ($monitoringData as $data): ?>
                    <tr>
                        <td><?= $data['monitoring_date'] ?></td>
                        <td><?= $data['teacher_name'] ?></td>
                        <td><?= $data['student_name'] ?></td>
                        <td><?= $data['company_name'] ?></td>
                        <td><?= $data['start_date'] ?> - <?= $data['end_date'] ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" class="text-center">Tidak ada data monitoring</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>


<?php include '../includes/footer.php'; ?>

