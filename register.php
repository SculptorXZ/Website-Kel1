<?php
include 'koneksi.php';

$username = $_POST['username'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
$role = 'user';

$query = "INSERT INTO users (username, password, role) VALUES (?, ?, ?)";
$stmt = $conn->prepare($query);
$stmt->bind_param("sss", $username, $password, $role);

if ($stmt->execute()) {
    echo "success";
} else {
    echo "error";
}
?>