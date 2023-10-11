<?php
include('connect.php');

$case = $_GET['xCase'];
$id = $_GET['id'];

switch ($case) {
    case 1:
        $no = 1; // กำหนดค่าเริ่มต้นเป็น 0
        $objQuery = mysqli_query($conn, "SELECT MAX(project_id) AS MAX_ID FROM project");
        $max_id = mysqli_fetch_assoc($objQuery);
        if ($max_id["MAX_ID"] != "") {
            $no = $max_id["MAX_ID"] + 1; // เอาค่าล่าสุดไป+1 จะได้เลขที่ใหม่
        }
        $docno = "00000" . (string)$no; // เอาเลข 0 เติมให้ครบ 4 หลัก
        $project_id = substr($docno, -5); // ตัดเอาเฉพาะ 4 ตัวหลัง

        $project_name = $_POST['prj_name'];
        $cus_code = $_POST['cus_code'];
        $status_date = $_POST['s_date'];
        $end_date = $_POST['e_date'];
        $project_price = $_POST['prj_price'];
        $emp_code = $_POST['emp_code'];

        $sql = mysqli_query($conn, "INSERT INTO project VALUES('$project_id','$project_name','$cus_code', '$status_date', '$end_date', '$project_price', '$emp_code','1')");
        if ($sql) {
            echo json_encode(array("status" => "success", "title" => "เพิ่มสำเร็จ!", "msg" => "เพิ่มโครงการ " . $project_name . " เรียบร้อยแล้ว"));
        } else {
            echo json_encode(array("sattus" => "error", "title" => "เกิดข้อผิดพลาด!", "msg" => mysqli_error($conn)));
        }
        break;
    case 2:
        $project_name = $_POST['prj_name'];
        $cus_code = $_POST['cus_code'];
        $start_date = $_POST['s_date'];
        $end_date = $_POST['e_date'];
        $project_price = $_POST['prj_price'];
        $emp_code = $_POST['emp_code'];
        $void = $_POST['prj_void'];

        $sql = mysqli_query($conn, "UPDATE project SET project_name='$project_name', cus_code='$cus_code', start_date = '$start_date', end_date = '$end_date', project_price = '$project_price', emp_code = '$emp_code', void = '$void' WHERE project_id = $id");
        if (isset($sql)) {
            echo json_encode(array("status" => "success", "title" => "แก้ไขข้อมูล!", "msg" => "แก้ไขข้อมูลโครงการ " . $project_name . " เรียบร้อยแล้ว"));
        } else {
            echo json_encode(array("status" => "error", "title" => "เกิดข้อผิดพลาด!", "msg" => mysqli_error($conn)));
        }
        break;
    case '3':
        try {
            $prj = mysqli_query($conn, "SELECT * FROM project WHERE project_id = $id");
            $prj_data = mysqli_fetch_assoc($prj);
            $sql = mysqli_query($conn, "UPDATE project SET void = '0' WHERE project_id = '$id'");
            if (isset($sql)) {
                echo json_encode(array("status" => "success", "title" => "ยกเลิกสำเร็จ!", "msg" => "ยกเลิกการดำเนินการโครงการ " . $prj_data['project_name'] . " เรียบร้อยแล้ว"));
            }
        } catch (Exception $error) {
            echo json_encode(array("status" => "error", "title" => "เกิดข้อผิดพลาด!", "msg" => $error->getMessage()));
        };
        break;
}
