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
            $sql = $sql . " WHERE doc_no like '$fdoc%'";
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

            $product_id = $_POST['product_id'];
            $qty = $_POST['qty'];
            $unit_price = $_POST['unit_price'];
            $total_price = $_POST['total_price'];

            foreach ($product_id as $key => $value) {
                $save = "INSERT INTO projcost_desc VALUES('" . $docno . "','" . $value . "','" . $qty[$key] . "','" . $unit_price[$key] . "','" . $total_price[$key] . "')";
                $resule = mysqli_query($conn, $save);
            }

            $amount = 0;
            foreach ($total_price as $key => $value) {
                $amount += $value;
            }

            $date_at = $_POST['date_at'];
            $order_no = $_POST['order_no'];
            $order_date = $_POST['order_date'];
            $project_id = $_POST['project_id'];
            $sql = mysqli_query($conn, "INSERT INTO projcost_hd VALUES('" . $docno . "','$date_at','$order_no', '$order_date', '$project_id', '$amount', '1', '1')");
            $datas = ['case' => 4, 'id' => $id];
            if ($sql) {
                echo json_encode(array("status" => "success", "title" => "บันทึกข้อมูล!", "msg" => "บันทึกข้อมูลค่าใช้จ่ายโครงการเรียบร้อยแล้ว", "data" => $datas));
            } else {
                echo json_encode(array("status" => "error", "title" => "เกิดข้อผิดพลาด!", "msg" => mysqli_error($conn)));
            }
        } catch (Exception $error) {
            echo json_encode(array("sattus" => "error", "title" => "เกิดข้อผิดพลาด!", "msg" => $error->getMessage()));
        }
        break;

    case 2:

        try {
            $doc_no = $_GET['doc_no'];
            $date_at = $_POST['date_at'];
            $order_no = $_POST['order_no'];
            $order_date = $_POST['order_date'];

            $sql = mysqli_query($conn, "UPDATE projcost_hd SET date_at = '$date_at', order_no = '$order_no', order_date = '$order_date' WHERE doc_no = $doc_no");
            $datas = ['case' => $case, 'id' => $id];

            if (isset($sql)) {
                echo json_encode(array("status" => "success", "title" => "แก้ไขข้อมูล!", "msg" => "แก้ไขข้อมูลค่าใช้จ่ายโครงการเรียบร้อยแล้ว", "data" => $datas));
            } else {
                echo json_encode(array("status" => "error", "title" => "เกิดข้อผิดพลาด!", "msg" => mysqli_error($conn)));
            }
        } catch (Exception $error) {
            echo json_encode(array("status" => "error", "title" => "เกิดข้อผิดพลาด!", "msg" => $error->getMessage()));
        }
        break;

    case 3:
        try {
            $doc_no = $_GET['doc_no'];
            $sql = mysqli_query($conn, "UPDATE projcost_hd SET status='0' WHERE doc_no = '$doc_no'");
            $datas = ['case' => 2, 'id' => $id];
            if (isset($sql)) {
                echo json_encode(array("status" => "success", "title" => "ยกเลิกเอกสาร!", "msg" => "ยกเลิกเอกสารค่าใช้จ่ายโครงการ " . $id . " เรียบร้อยแล้ว", "data" => $datas));
            } else {
                echo json_encode(array("status" => "error", "title" => "เกิดข้อผิดพลาด!", "msg" => mysqli_error($conn)));
            }
        } catch (Exception $error) {
            echo json_encode(array("status" => "error", "title" => "เกิดข้อผิดพลาด!", "msg" => $error->getMessage()));
        }
        break;
}
