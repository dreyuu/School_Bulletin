<?php
require_once '../../connection.php'; // PDO connection

$response = ['success' => false, 'message' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $title = $_POST['title'];
        $category = $_POST['category'];
        $description = $_POST['description'];
        // $expiredDate = $_POST['expired_date'];
        $postedBy = $_POST['user_id'];

        $stmt = $connect->prepare("INSERT INTO announcement (title, category, description,  posted_by) VALUES (:title, :category, :description,  :postedBy)");
        $stmt->execute([
            ':title' => $title,
            ':category' => $category,
            ':description' => $description,
            // ':expiredDate' => $expiredDate,
            ':postedBy' => $postedBy
        ]);

        $response['success'] = true;
        $response['message'] = 'Announcement posted successfully.';
    } catch (PDOException $e) {
        $response['message'] = 'Error: ' . $e->getMessage();
    }
}

echo json_encode($response);
?>
