<?php
require '../../connection.php';
require '../../vendor/autoload.php';

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Firebase\JWT\ExpiredException;

// $secretKey = "chiascornersercretkey";

// // Get token from header
// $headers = apache_request_headers();
// if (!isset($headers['Authorization'])) {
//     http_response_code(401);
//     echo json_encode(["error" => "Unauthorized - No token provided"]);
//     exit;
// }
// $token = str_replace("Bearer ", "", $headers['Authorization']);

try {
//     $decoded = JWT::decode($token, new Key($secretKey, 'HS256'));

//     // Optional: Only allow admins
//     if ($decoded->user_type !== "admin") {
//         http_response_code(403);
//         echo json_encode(["error" => "Forbidden - Admins only"]);
//         exit;
//     }

    // Get the raw JSON body
    $input = json_decode(file_get_contents('php://input'), true);

    $userId = $input['userId'] ?? null;

    if (!$userId) {
        http_response_code(400);
        echo json_encode(["success" => false, "message" => "Missing user ID"]);
        exit;
    }

    // Optional: You can also check if user exists before deleting

    $query = "DELETE FROM users WHERE user_id = :userId";
    $stmt = $connect->prepare($query);
    $stmt->execute([':userId' => $userId]);

    if ($stmt->rowCount() > 0) {
        echo json_encode(["success" => true, "message" => "Account deleted successfully"]);
    } else {
        echo json_encode(["success" => false, "message" => "Account not found or already deleted"]);
    }

// } catch (ExpiredException $e) {
//     http_response_code(401);
//     echo json_encode(["error" => "Token has expired"]);
// } catch (Exception $e) {
//     http_response_code(401);
//     echo json_encode(["error" => "Invalid token"]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(["error" => "Database error: " . $e->getMessage()]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(["error" => "Unexpected error: " . $e->getMessage()]);
}
