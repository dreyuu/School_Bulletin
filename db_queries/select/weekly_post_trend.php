<?php
include '../../connection.php';

try {
    $stmt = $connect->prepare("
        SELECT 
            DATE_FORMAT(date, '%W') AS day_name, 
            status, 
            COUNT(*) AS count 
        FROM announcement 
        WHERE YEARWEEK(date, 1) = YEARWEEK(CURDATE(), 1)
        GROUP BY day_name, status
    ");
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
    $statuses = ['pending', 'approved', 'dismissed', 'deleted'];
    $data = [];

    // Initialize all to 0
    foreach ($statuses as $status) {
        $data[$status] = array_fill_keys($days, 0);
    }

    // Fill in real values
    foreach ($rows as $row) {
        $day = $row['day_name'];
        $status = strtolower($row['status']);
        if (isset($data[$status][$day])) {
            $data[$status][$day] = (int)$row['count'];
        }
    }

    echo json_encode($data);
} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
