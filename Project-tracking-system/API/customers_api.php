<?php
include('connect.php');

$case = $_GET['xCase'];
$cus_code = $_GET['cus_code'];

switch ($case) {
    case 1:
        $no = 1; // กำหนดค่าเริ่มต้นเป็น 0
        $objQuery = mysqli_query($conn, "SELECT MAX(cus_code) AS MAX_ID FROM customer");
        $max_id = mysqli_fetch_assoc($objQuery);
        if ($max_id["MAX_ID"] != "") {
            $no = $max_id["MAX_ID"] + 1; // เอาค่าล่าสุดไป+1 จะได้เลขที่ใหม่
        }
        $docno = "00000" . (string)$no; // เอาเลข 0 เติมให้ครบ 4 หลัก
        $cus_code = substr($docno, -5); // ตัดเอาเฉพาะ 4 ตัวหลัง

        $cus_name = $_POST['txt_name'];
        $surname = $_POST['txt_surname'];
        $address = $_POST['txt_address'];
        $subdistrict_code = $_POST['ddl_subdistrict'];
        $district_code = $_POST['ddl_district'];
        $province_code = $_POST['ddl_province'];
        $zip_code = $_POST['txt_zip_code'];
        $email = $_POST['txt_email'];
        $phone = $_POST['txt_phone'];

        $sql = mysqli_query($conn, "INSERT INTO customer VALUES('$cus_code','$cus_name','$surname', '$address', '$subdistrict_code', '$district_code', '$province_code', '$zip_code', '$phone', '$email','')");
        if ($sql) {
            echo json_encode(array("status" => "success", "title" => "เพิ่มข้อมูล!", "msg" => "เพิ่มข้อมูลลูกค้า " . $cus_name . ' ' . $surname . " เรียบร้อยแล้ว"));
        } else {
            echo json_encode(array("sattus" => "error", "title" => "เกิดข้อผิดพลาด!", "msg" => mysqli_error($conn)));
        }
        break;
    case 2:
        $cus_name = $_POST['txt_name'];
        $surname = $_POST['txt_surname'];
        $address = $_POST['txt_address'];
        $subdistrict_code = $_POST['ddl_subdistrict'];
        $district_code = $_POST['ddl_district'];
        $province_code = $_POST['ddl_province'];
        $zip_code = $_POST['txt_zip_code'];
        $email = $_POST['txt_email'];
        $phone = $_POST['txt_phone'];

        $sql = mysqli_query($conn, "UPDATE customer SET cus_name='$cus_name', surname='$surname', address = '$address', subdistrict_code = '$subdistrict_code', district_code = '$district_code', province_code = '$province_code', zip_code = '$zip_code', phone = '$phone', email = '$email' WHERE cus_code = '$cus_code'");
        if (isset($sql)) {
            echo json_encode(array("status" => "success", "title" => "แก้ไขข้อมูล!", "msg" => "แก้ไขข้อมูลลูกค้า " . $cus_name . ' ' . $surname . " เรียบร้อยแล้ว"));
        } else {
            echo json_encode(array("status" => "error", "title" => "เกิดข้อผิดพลาด!", "msg" => mysqli_error($conn)));
        }
        break;
    case '3':
        $data = mysqli_query($conn, "SELECT cus_name,surname FROM customer WHERE cus_code = $cus_code");
        $resule = mysqli_fetch_assoc($data);
        $sql = mysqli_query($conn, "UPDATE customer SET void = '1' WHERE cus_code = '$cus_code'");
        if (isset($sql)) {
            echo json_encode(array("status" => "success", "title" => "ลบข้อมูล!", "msg" => "ลบข้อมูลลูกค้า " . $resule['cus_name'] . ' ' . $resule['surname'] . " เรียบร้อยแล้ว"));
        } else {
            echo json_encode(array("status" => "error", "title" => "เกิดข้อผิดพลาด!", "msg" => mysqli_error($conn)));
        };
        break;
}
