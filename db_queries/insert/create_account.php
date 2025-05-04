<?php
require '../../connection.php';
require '../../vendor/autoload.php';

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Firebase\JWT\ExpiredException;


// $secretKey = "chiascornersercretkey";

// Get token from header
// $headers = apache_request_headers();
// if (!isset($headers['Authorization'])) {
//     http_response_code(401);
//     echo json_encode(["error" => "Unauthorized - No token provided"]);
//     exit;
// }

// $token = str_replace("Bearer ", "", $headers['Authorization']);

try {
    // $decoded = JWT::decode($token, new Key($secretKey, 'HS256'));

    // Optional: check if user has admin rights
    // if ($decoded->user_type !== "admin") {
    //     http_response_code(403);
    //     echo json_encode(["error" => "Forbidden - Admins only"]);
    //     exit;
    // }

    // Get the raw POST data
    $name = $_POST['name'] ?? null;
    $username = $_POST['username'] ?? null;
    $password = isset($_POST['password']) ? password_hash($_POST['password'], PASSWORD_DEFAULT) : null;
    $email = $_POST['email'] ?? null;
    $user_type = $_POST['user_type'] ?? null;


    // Validate required fields
    if (!$name || !$username || !$password || !$email || !$user_type) {
        http_response_code(400);
        echo json_encode(["success" => false, "message" => "Missing required fields"]);
        exit;
    }

    // --- Check if username already exists ---
    $checkQuery = "SELECT user_id FROM users WHERE username = :username LIMIT 1";
    $checkStmt = $connect->prepare($checkQuery);
    $checkStmt->execute([':username' => $username]);

    if ($checkStmt->rowCount() > 0) {
        http_response_code(409); // Conflict
        echo json_encode(["success" => false, "message" => "Username already exists"]);
        exit;
    }

    // Generate a unique 5-character alphanumeric user code
    $userCode = strtoupper(substr(bin2hex(random_bytes(3)), 0, 5));

    // Insert into DB
    $query = "INSERT INTO users (name, username, password, email, user_type, user_code) 
                VALUES (:name, :username, :password, :email, :user_type, :user_code)";
    $stmt = $connect->prepare($query);
    $stmt->execute([
        ':name' => $name,
        ':username' => $username,
        ':password' => $password,
        ':email' => $email,
        ':user_type' => $user_type,
        ':user_code' => $userCode
    ]);

    echo json_encode(["success" => true, "message" => "User added successfully!"]);
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
    echo json_encode(["error" => "An unexpected error occurred: " . $e->getMessage()]);
}
