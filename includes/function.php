<?php
include '../config.php'; // Hubungkan ke database

function generateMonitoringSchedule($students, $teachers, $companies, $startDate, $endDate, $frequency = 7) {
    $schedules = []; // Array untuk menyimpan jadwal akhir
    $period = new DatePeriod(
        new DateTime($startDate),
        new DateInterval("P{$frequency}D"),
        new DateTime($endDate)
    );

    $teacherCount = count($teachers);
    $companyCount = count($companies);
    $i = 0; // Index guru

    foreach ($period as $currentDate) {
        foreach ($students as $student) {
            $teacher = $teachers[$i % $teacherCount]; // Distribusi guru
            $company = $companies[array_rand($companies)]; // Pilih perusahaan acak

            $schedules[] = [
                'date' => $currentDate->format('Y-m-d'),
                'teacher_id' => $teacher['id'],
                'student_id' => $student['id'],
                'company_id' => $company['id']
            ];

            $i++; // Perpindahan ke guru berikutnya
        }
    }

    return $schedules;
}

// Ambil data dari database
$students = $pdo->query("SELECT id, name FROM students")->fetchAll(PDO::FETCH_ASSOC);
$teachers = $pdo->query("SELECT id, name FROM teachers")->fetchAll(PDO::FETCH_ASSOC);
$companies = $pdo->query("SELECT id, name FROM companies")->fetchAll(PDO::FETCH_ASSOC);

// Input tanggal periode monitoring
$startDate = '2025-01-01';
$endDate = '2025-01-31';
$frequency = 7; // Monitoring setiap 7 hari

// Generate jadwal monitoring
$schedules = generateMonitoringSchedule($students, $teachers, $companies, $startDate, $endDate, $frequency);

// Simpan jadwal ke database
$stmt = $pdo->prepare("INSERT INTO monitoring (teacher_id, student_id, company_id, monitoring_date) VALUES (?, ?, ?, ?)");
foreach ($schedules as $schedule) {
    $stmt->execute([
        $schedule['teacher_id'],
        $schedule['student_id'],
        $schedule['company_id'],
        $schedule['date']
    ]);
}

// Tampilkan hasil jadwal yang di-generate
echo "<h1>Jadwal Monitoring Berhasil Digenerate</h1>";
echo "<table border='1' cellpadding='5'>";
echo "<tr><th>Tanggal</th><th>Guru</th><th>Siswa</th><th>Perusahaan</th></tr>";
foreach ($schedules as $schedule) {
    echo "<tr>";
    echo "<td>{$schedule['date']}</td>";
    echo "<td>{$teachers[array_search($schedule['teacher_id'], array_column($teachers, 'id'))]['name']}</td>";
    echo "<td>{$students[array_search($schedule['student_id'], array_column($students, 'id'))]['name']}</td>";
    echo "<td>{$companies[array_search($schedule['company_id'], array_column($companies, 'id'))]['name']}</td>";
    echo "</tr>";
}
echo "</table>";
?>
