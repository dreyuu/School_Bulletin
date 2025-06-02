<?php
require '../../connection.php';

try {
    $stmt = $connect->prepare("
        SELECT 
            a.*, 
            u.name AS postedByName,
            u2.name AS approvedByName
        FROM announcement a
        LEFT JOIN users u ON a.posted_by = u.user_id
        LEFT JOIN users u2 ON a.approved_by = u2.user_id
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
