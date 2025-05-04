<?php
require '../../connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? null;
    $status = $_POST['status'] ?? null;
    $approvedBy = $_POST['approvedBy'] ?? null;

    if (!$id || !$status) {
        echo json_encode(['success' => false, 'message' => 'Missing required fields.']);
        exit;
    }

    try {
        $query = "UPDATE announcement SET status = :status";
        if ($status === 'approved' && $approvedBy) {
            $query .= ", approved_by = :approvedBy";
        }
        $query .= " WHERE announcement_id = :id";

        $stmt = $connect->prepare($query);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':id', $id);
        if ($status === 'approved' && $approvedBy) {
            $stmt->bindParam(':approvedBy', $approvedBy);
        }
        $stmt->execute();

        echo json_encode(['success' => true]);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
}
?>
