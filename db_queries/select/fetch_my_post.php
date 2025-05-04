<?php
require_once '../../connection.php'; // Include your database connection file
header('Content-Type: application/json');

$response = ['success' => false, 'message' => '', 'data' => null];

try {
    $input = json_decode(file_get_contents("php://input"), true);
    $announcementId = $input['announcement_id'];

    $stmt = $connect->prepare("SELECT * FROM announcement WHERE announcement_id = :id");
    $stmt->execute([':id' => $announcementId]);
    $post = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($post) {
        $response['success'] = true;
        $response['data'] = $post;
    } else {
        $response['message'] = 'Post not found.';
    }
} catch (PDOException $e) {
    $response['message'] = 'Database error: ' . $e->getMessage();
}

echo json_encode($response);
?>
