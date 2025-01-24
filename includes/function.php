<?php
include '../config.php'; // Hubungkan ke database

function generateMonitoringSchedule($internships, $period, $frequency = 7) {
    $schedules = []; // Array untuk menyimpan jadwal akhir
    $periodStart = new DateTime($period['start_date']);
    $periodEnd = new DateTime($period['end_date']);
    
    // Hitung interval tanggal
    $datePeriod = new DatePeriod(
        $periodStart,
        new DateInterval("P{$frequency}D"),
        $periodEnd->modify('+1 day') // Termasuk tanggal akhir
    );

    foreach ($datePeriod as $date) {
        foreach ($internships as $internship) {
            $schedules[] = [
                'date' => $date->format('Y-m-d'),
                'teacher_id' => $internship['teacher_id'],
                'student_id' => $internship['student_id'],
                'company_id' => $internship['company_id']
            ];
        }
    }

    return $schedules;
}

// Ambil data dari database
$internships = $pdo->query("
    SELECT i.teacher_id, i.student_id, i.company_id, ip.start_date, ip.end_date
    FROM internships i
    JOIN internship_periods ip ON i.period_id = ip.id
")->fetchAll(PDO::FETCH_ASSOC);

// Kelompokkan berdasarkan periode
$groupedInternships = [];
foreach ($internships as $internship) {
    $periodKey = $internship['start_date'] . '_' . $internship['end_date'];
    if (!isset($groupedInternships[$periodKey])) {
        $groupedInternships[$periodKey] = [
            'start_date' => $internship['start_date'],
            'end_date' => $internship['end_date'],
            'internships' => []
        ];
    }
    $groupedInternships[$periodKey]['internships'][] = [
        'teacher_id' => $internship['teacher_id'],
        'student_id' => $internship['student_id'],
        'company_id' => $internship['company_id']
    ];
}

// Generate dan simpan jadwal untuk setiap periode
$stmt = $pdo->prepare("INSERT INTO monitoring (teacher_id, student_id, company_id, monitoring_date) VALUES (?, ?, ?, ?)");
foreach ($groupedInternships as $period) {
    $schedules = generateMonitoringSchedule($period['internships'], $period);

    foreach ($schedules as $schedule) {
        $stmt->execute([
            $schedule['teacher_id'],
            $schedule['student_id'],
            $schedule['company_id'],
            $schedule['date']
        ]);
    }
}

echo "<h1>Jadwal Monitoring Berhasil Digenerate</h1>";
?>
