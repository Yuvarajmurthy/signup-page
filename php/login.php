<?php
require_once "connection.php";

if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "GET") {
    $email = $_GET["email"];
    $password = $_GET["password"];

    if (!empty($email) && !empty($password)) {
        $stmt = $conn->prepare("SELECT * FROM signup WHERE `E-mail`=? AND `password`=?");
        $stmt->bind_param("ss", $email, $password);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows == 1) {
            echo "Login successful!";
            echo "<script>window.location.href='../Home/home.html';</script>";
            exit();
        } else {
            echo "Invalid email or password!";
        }
    }
}

$conn->close();
?>

