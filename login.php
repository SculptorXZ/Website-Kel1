<?php
header('Content-Type: application/json');
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method Not Allowed']);
    exit;
}
include 'koneksi.php';

$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

$stmt = $conn->prepare("SELECT password, role FROM users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    $stmt->bind_result($hashed_password, $role);
    $stmt->fetch();
    if (password_verify($password, $hashed_password)) {
        echo json_encode(['success' => true, 'role' => $role]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Password salah']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Username tidak ditemukan']);
}
?>