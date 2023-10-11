<?php
include('connect.php');
session_start();
$email = $_POST['email'];
$password = $_POST['password'];
$sel = mysqli_query($conn, "SELECT * FROM employee WHERE email='" . $email . "' AND password='" . md5($password) . "' LIMIT 0,1");
$admin = mysqli_fetch_assoc($sel);
if ($admin) {
    $_SESSION["logged"] = true;
    $_SESSION["name"] = $admin["emp_name"] . " " . $admin["surname"];
    // $_SESSION["surname"] = $admin["surname"];
    $_SESSION["job_position"] = $admin["job_position"];
    $_SESSION["email"] = $admin["email"];

    echo json_encode(array("status" => "success", "title" => "Success!", "msg" => "ยินดีต้อนรับเข้าสู้ระบบติดตามโครงการ"));
} else {
    echo json_encode(array("status" => "warning", "title" => "Warning!", "msg" => 'อีเมลหรือรหัสผ่านไม่ถูกต้อง กรุณาลองใหม่อีกครั้ง', 'email' => $email, 'password' => $password));
}
