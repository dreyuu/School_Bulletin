<?php
require '../../connection.php';

try {
    $stmt = $connect->prepare("
        SELECT 
            a.*, 
            u.name AS postedByName
        FROM announcement a
        LEFT JOIN users u ON a.posted_by = u.user_id
        WHERE a.status = 'approved'
        ORDER BY a.date DESC
    ");
    $stmt->execute();
    $announcements = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([
        'success' => true,
        'data' => $announcements
    ]);
} catch (PDOException $e) {
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
?>
