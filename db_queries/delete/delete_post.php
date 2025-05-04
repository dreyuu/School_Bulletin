<?php
require_once '../../connection.php'; // Include your database connection file
header('Content-Type: application/json');

$response = ['success' => false, 'message' => ''];

try {
    $input = json_decode(file_get_contents("php://input"), true);
    $announcementId = $input['announcement_id'] ?? null;

    if (!$announcementId) {
        throw new Exception("Invalid announcement ID.");
    }

    // Optional: Check if the announcement exists first
    $checkStmt = $connect->prepare("SELECT * FROM announcement WHERE announcement_id = :id");
    $checkStmt->execute([':id' => $announcementId]);

    if ($checkStmt->rowCount() === 0) {
        throw new Exception("Announcement not found.");
    }

    // Delete the announcement
    $stmt = $connect->prepare("DELETE FROM announcement WHERE announcement_id = :id");
    $stmt->execute([':id' => $announcementId]);

    $response['success'] = true;
    $response['message'] = 'Post deleted successfully.';
} catch (PDOException $e) {
    $response['message'] = 'Database error: ' . $e->getMessage();
} catch (Exception $e) {
    $response['message'] = $e->getMessage();
}

echo json_encode($response);
?>
