<?php
include('connect.php');

$case = $_GET['xCase'];
$id = $_GET['id'];

switch ($case) {
    case 1:
        try {
            $docdey = date("m");
            $dicyear = date("Y");
            $fdoc = substr($dicyear, 2, 2) . $docdey; // ตัดเอาปี 2 หลัก+เดือน 2 หลัก
            $no = 1; // กำหนดค่าเริ่มต้นเป็น 0
            $newCode = 1;
            // หาเลขที่เอกสารที่มี ปีและเดือน ที่ขึ้นต้นตรงกับ ตัวแปร fdoc
            $sql = "SELECT MAX(doc_no) AS MAX_ID FROM projcost_hd ";
            $sql = $sql . "WHERE doc_no like '$fdoc%'";
            $objQuery = mysqli_query($conn, $sql);
            // หากมีข้อมูล
            while ($objResult = mysqli_fetch_array($objQuery)) {
                if ($objResult["MAX_ID"] != "") {
                    $no = $objResult["MAX_ID"] + 1; // เอาค่าล่าสุดไป+1 จะได้เลขที่ใหม่
                }
            }
            $docno = "0000" . (string)$no; // เอาเลข 0 เติมให้ครบ 4 หลัก
            $docno = substr($docno, -4); // ตัดเอาเฉพาะ 4 ตัวหลัง
            $docno = $fdoc . $docno; // เลขที่เอกสารใหม่ คือ YYMMตามด้วยเลขที่คำนวณใหม่

            $date_close = $_POST['date_close'];
            $project_id = $_POST['project_id'];
            $cost = $_POST['cost'];
            $expenses = $_POST['expenses'];
            $emp_code = $_POST['emp_code'];
            $comments = $_POST['comments'];

            $sql = mysqli_query($conn, "INSERT INTO project_close VALUES('$docno','$date_close','$project_id', '$cost', '$expenses', '$emp_code', '$comments', '1')");
            $close_prj = mysqli_query($conn, "UPDATE project SET void = 2 WHERE project_id = $project_id");
            if ($sql && $close_prj != null) {
                echo json_encode(array("status" => "success", "title" => "เพิ่มข้อมูล!", "msg" => "บันทึกข้อมูลการปิดโครง " . $project_id . " การเรียบร้อยแล้ว"));
            } else {
                echo json_encode(array("sattus" => "error", "title" => "เกิดข้อผิดพลาด!", "msg" => mysqli_error($conn)));
            }
        } catch (Exception $error) {
            echo json_encode(array("sattus" => "error", "title" => "เกิดข้อผิดพลาด!", "msg" => $error->getMessage()));
        }
        break;
}
