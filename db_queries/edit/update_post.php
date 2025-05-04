<?php
require_once '../../connection.php';

$response = ['success' => false, 'message' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $announcementId = $_POST['announcement_id'];
        $title = $_POST['title'];
        $category = $_POST['category'];
        $description = $_POST['description'];
        // $expiredDate = $_POST['expired_date'];

        $stmt = $connect->prepare("UPDATE announcement SET title = :title, category = :category, description = :description WHERE announcement_id = :announcementId");
        $stmt->execute([
            ':title' => $title,
            ':category' => $category,
            ':description' => $description,
            // ':expiredDate' => $expiredDate,
            ':announcementId' => $announcementId
        ]);

        $response['success'] = true;
        $response['message'] = 'Announcement updated successfully.';
    } catch (PDOException $e) {
        $response['message'] = 'Error: ' . $e->getMessage();
    }
}

echo json_encode($response);
?>
