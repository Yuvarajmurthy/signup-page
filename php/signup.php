<?php
require_once "connection.php";

if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "POST") {
    $code = $_POST["code"];
    $name = $_POST["student"];
    $Registration = $_POST["Registration_No"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $confirmation = $_POST["confirmation"];
    $date = date('Y-m-d H:i:s');

    if (!empty($code) && !empty($name) && !empty($Registration) && !empty($email) && !empty($password) && !empty($confirmation) && ($password == $confirmation)) {
        $check_sql = "SELECT * FROM signup WHERE `E-mail` = ? AND `Registration` = ?";
        $check_stmt = $conn->prepare($check_sql);
        $check_stmt->bind_param("ss", $email, $Registration);
        $check_stmt->execute();
        $check_result = $check_stmt->get_result();
        
        if ($check_result->num_rows > 0) {
            echo "connection failed Email or Registration Number already exists.";
           // header("Location: ");
        } else {
            $insert_sql = "INSERT INTO signup (`code`, `student`, `Registration`, `E-mail`, `password`, `confirmation`, `date`) VALUES (?, ?, ?, ?, ?, ?, ?)";
            $insert_stmt = $conn->prepare($insert_sql);
            $insert_stmt->bind_param("sssssss", $code, $name, $Registration, $email, $password, $confirmation, $date);

            if ($insert_stmt->execute()) {
                echo "Records inserted successfully.";
                header("Location: ../login/Login.html");
            } else {
                echo "Error: " . $insert_sql . "<br>" . $conn->error;
            }
            $insert_stmt->close();
        }
        $check_stmt->close();
    }
}

$conn->close();
?>
