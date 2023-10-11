<?php
include('connect.php');

$case = $_GET['xCase'];
$id = $_GET['id'];

switch ($case) {
    case 1:
        $name = $_POST['txt_name'];
        $unit = $_POST['txt_unit'];
        $price = $_POST['txt_price'];

        $sql = mysqli_query($conn, "INSERT INTO stock VALUES(null,'$name', '$price', '$unit')");
        if ($sql) {
            echo json_encode(array("status" => "success", "title" => "เพิ่มข้อมูล!", "msg" => "เพิ่มข้อมูลสินค้า " . $name . " เรียบร้อยแล้ว"));
        } else {
            echo json_encode(array("sattus" => "error", "title" => "เกิดข้อผิดพลาด!", "msg" => mysqli_error($conn)));
        }
        break;
    case 2:
        $name = $_POST['txt_name'];
        $unit = $_POST['txt_unit'];
        $price = $_POST['txt_price'];

        $sql = mysqli_query($conn, "UPDATE stock SET name='$name', price = '$price', unit='$unit' WHERE id = $id");
        if (isset($sql)) {
            echo json_encode(array("status" => "success", "title" => "แก้ไขข้อมูล!", "msg" => "แก้ไขข้อมูลสินค้า " . $name . " เรียบร้อยแล้ว"));
        } else {
            echo json_encode(array("status" => "error", "title" => "เกิดข้อผิดพลาด!", "msg" => mysqli_error($conn)));
        }
        break;
    case '3':
        $data = mysqli_query($conn, "SELECT * FROM stock WHERE id = $id");
        $resule = mysqli_fetch_assoc($data);
        $sql = mysqli_query($conn, "DELETE FROM stock WHERE id = '$id'");
        if (isset($sql)) {
            echo json_encode(array("status" => "success", "title" => "ลบข้อมูล!", "msg" => "ลบข้อมูลสินค้า " . $resule['name'] . " เรียบร้อยแล้ว"));
        } else {
            echo json_encode(array("status" => "error", "title" => "เกิดข้อผิดพลาด!", "msg" => mysqli_error($conn)));
        };
        break;

    case '4':
        $data = mysqli_query($conn, "SELECT * FROM stock WHERE id = $id");
        $resule = mysqli_fetch_assoc($data);
        echo json_encode($resule);
        break;
}
