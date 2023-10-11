<?php
include('connect.php');
$no = 1; // กำหนดค่าเริ่มต้นเป็น 0
$objQuery = mysqli_query($conn, "SELECT MAX(project_id) AS MAX_ID FROM project");
$max_id = mysqli_fetch_assoc($objQuery);
if ($max_id["MAX_ID"] != "") {
    $no = $max_id["MAX_ID"] + 1; // เอาค่าล่าสุดไป+1 จะได้เลขที่ใหม่
}
$docno = "00000" . (string)$no; // เอาเลข 0 เติมให้ครบ 4 หลัก
$project_id = substr($docno, -5); // ตัดเอาเฉพาะ 4 ตัวหลัง
echo json_encode($project_id);
