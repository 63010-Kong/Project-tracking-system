<?php
include('connect.php');

$case = $_GET['xCase'];
$emp_code = $_GET['emp_code'];

switch ($case) {
    case 1:
        $no = 1; // กำหนดค่าเริ่มต้นเป็น 0
        $objQuery = mysqli_query($conn, "SELECT MAX(emp_code) AS MAX_ID FROM employee");
        $max_id = mysqli_fetch_assoc($objQuery);
        if ($max_id["MAX_ID"] != "") {
            $no = $max_id["MAX_ID"] + 1; // เอาค่าล่าสุดไป+1 จะได้เลขที่ใหม่
        }
        $docno = "000" . (string)$no; // เอาเลข 0 เติมให้ครบ 4 หลัก
        $emp_code = substr($docno, -3); // ตัดเอาเฉพาะ 4 ตัวหลัง

        $emp_name = $_POST['txt_name'];
        $surname = $_POST['txt_surname'];
        $address = $_POST['txt_address'];
        $subdistrict_code = $_POST['ddl_subdistrict'];
        $district_code = $_POST['ddl_district'];
        $province_code = $_POST['ddl_province'];
        $zip_code = $_POST['txt_zip_code'];
        $phone = $_POST['txt_phone'];
        $job_position = $_POST['txt_job_position'];
        $email = $_POST['txt_email'];
        $password = $_POST['txt_password'];
        $cpassword = $_POST['txt_confirm_password'];
        $work_start_date = $_POST['work_start_date'];
        if ($password === $cpassword) {
            $sql = mysqli_query($conn, "INSERT INTO employee VALUES($emp_code,'$emp_name','$surname', '$address', '$subdistrict_code', '$district_code', '$province_code', '$zip_code', '$phone', '$job_position', '$email','" . md5($password) . "', '$work_start_date', '')");
            if ($sql) {
                echo json_encode(array("status" => "success", "title" => "เพิ่มข้อมูล!", "msg" => "เพิ่มข้อมูลพนักงาน " . $emp_name . ' ' . $surname . " เรียบร้อยแล้ว"));
            } else {
                echo json_encode(array("sattus" => "error", "title" => "เกิดข้อผิดพลาด!", "msg" => mysqli_error($conn)));
            }
        } else {
            echo json_encode(array("sattus" => "warning", "title" => "รหัสผ่านไม่เหมือนกัน!", "msg" => "กรุณาป้อนรหัสผ่านให้เหมือนกันด้วย"));
        }
        break;
    case 2:
        $emp_name = $_POST['txt_name'];
        $surname = $_POST['txt_surname'];
        $address = $_POST['txt_address'];
        $subdistrict_code = $_POST['ddl_subdistrict'];
        $district_code = $_POST['ddl_district'];
        $province_code = $_POST['ddl_province'];
        $zip_code = $_POST['txt_zip_code'];
        $phone = $_POST['txt_phone'];
        $job_position = $_POST['txt_job_position'];
        $email = $_POST['txt_email'];
        $work_start_date = $_POST['work_start_date'];

        $sql = mysqli_query($conn, "UPDATE employee SET emp_name='$emp_name', surname='$surname', address = '$address', subdistrict_code = '$subdistrict_code', district_code = '$district_code', province_code = '$province_code', zip_code = '$zip_code', phone = '$phone', job_position = '$job_position', email = '$email', work_start_date = '$work_start_date' WHERE emp_code = '$emp_code'");
        if (isset($sql)) {
            echo json_encode(array("status" => "success", "title" => "แก้ไขข้อมูล!", "msg" => "แก้ไขข้อมูลพนักงาน " . $emp_name . ' ' . $surname . " เรียบร้อยแล้ว"));
        } else {
            echo json_encode(array("status" => "error", "title" => "เกิดข้อผิดพลาด!", "msg" => mysqli_error($conn)));
        }
        break;
    case '3':
        $data = mysqli_query($conn, "SELECT emp_name,surname FROM employee WHERE emp_code = $emp_code");
        $resule = mysqli_fetch_assoc($data);
        $sql = mysqli_query($conn, "UPDATE employee SET void = '1' WHERE emp_code = '$emp_code'");
        if (isset($sql)) {
            echo json_encode(array("status" => "success", "title" => "ลบข้อมูล!", "msg" => "ลบข้อมูลพนักงาน " . $resule['emp_name'] . ' ' . $resule['surname'] . " เรียบร้อยแล้ว"));
        } else {
            echo json_encode(array("status" => "error", "title" => "เกิดข้อผิดพลาด!", "msg" => mysqli_error($conn)));
        };
        break;
}
