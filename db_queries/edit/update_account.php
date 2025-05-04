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

//     // Optional: Admin check
//     if ($decoded->user_type !== "admin") {
//         http_response_code(403);
//         echo json_encode(["error" => "Forbidden - Admins only"]);
//         exit;
//     }

    // Get POST data
    $userId   = $_POST['userId'] ?? null;
    $name     = $_POST['name'] ?? null;
    $username = $_POST['username'] ?? null;
    $password = $_POST['password'] ?? null;
    $email    = $_POST['email'] ?? null;
    $user_type = $_POST['user_type'] ?? null;

    // Validate
    if (!$userId || !$name || !$username || !$email || !$user_type) {
        http_response_code(400);
        echo json_encode(["success" => false, "message" => "Missing required fields"]);
        exit;
    }

    // Check if the username is used by another account
    $checkQuery = "SELECT user_id FROM users WHERE username = :username AND user_id != :userId LIMIT 1";
    $checkStmt = $connect->prepare($checkQuery);
    $checkStmt->execute([':username' => $username, ':userId' => $userId]);

    if ($checkStmt->rowCount() > 0) {
        http_response_code(409);
        echo json_encode(["success" => false, "message" => "Username already taken by another user"]);
        exit;
    }

    // Prepare update query
    $updateQuery = "UPDATE users SET name = :name, username = :username, email = :email, user_type = :user_type";

    // Optional password update
    if (!empty($password)) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $updateQuery .= ", password = :password";
    }

    $updateQuery .= " WHERE user_id = :userId";

    // Bind values
    $stmt = $connect->prepare($updateQuery);
    $params = [
        ':name' => $name,
        ':username' => $username,
        ':email' => $email,
        ':user_type' => $user_type,
        ':userId' => $userId
    ];

    if (!empty($password)) {
        $params[':password'] = $hashedPassword;
    }

    $stmt->execute($params);

    echo json_encode(["success" => true, "message" => "Account updated successfully"]);

// } catch (ExpiredException $e) {
//     http_response_code(401);
//     echo json_encode(["error" => "Token expired"]);
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
