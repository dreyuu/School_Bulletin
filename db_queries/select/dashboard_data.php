<?php
include '../../connection.php'; // Make sure this sets up your $connect as a PDO instance

try {
    // Fetch total users
    $stmtUsers = $connect->prepare("SELECT COUNT(*) AS total FROM users");
    $stmtUsers->execute();
    $totalUsers = $stmtUsers->fetch(PDO::FETCH_ASSOC)['total'];

    // Fetch announcement counts
    $stmtAnnouncements = $connect->prepare("
        SELECT 
            COUNT(*) AS total,
            SUM(CASE WHEN status = 'approved' THEN 1 ELSE 0 END) AS approved,
            SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) AS pending,
            SUM(CASE WHEN status = 'dismissed' THEN 1 ELSE 0 END) AS dismissed,
            SUM(CASE WHEN status = 'deleted' THEN 1 ELSE 0 END) AS deleted
        FROM announcement
    ");
    $stmtAnnouncements->execute();
    $announcementCounts = $stmtAnnouncements->fetch(PDO::FETCH_ASSOC);

    // Prepare response
    $response = [
        'total_users' => $totalUsers,
        'total_announcements' => $announcementCounts['total'],
        'approved' => $announcementCounts['approved'],
        'pending' => $announcementCounts['pending'],
        'dismissed' => $announcementCounts['dismissed'],
        'deleted' => $announcementCounts['deleted']
    ];

    header('Content-Type: application/json');
    echo json_encode($response);

} catch (PDOException $e) {
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
}
?>
