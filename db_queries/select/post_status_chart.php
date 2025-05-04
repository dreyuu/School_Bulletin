<?php
include '../../connection.php';

try {
    $stmt = $connect->query("
        SELECT 
            SUM(CASE WHEN status = 'approved' THEN 1 ELSE 0 END) AS approved,
            SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) AS pending,
            SUM(CASE WHEN status = 'dismissed' THEN 1 ELSE 0 END) AS dismissed,
            SUM(CASE WHEN status = 'deleted' THEN 1 ELSE 0 END) AS deleted
        FROM announcement
    ");

    $counts = $stmt->fetch(PDO::FETCH_ASSOC);

    // Ensure all values are returned as numbers (0 if null)
    foreach ($counts as $key => $value) {
        $counts[$key] = (int)$value;
    }

    echo json_encode($counts);
} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
