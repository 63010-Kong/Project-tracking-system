<?php

$conn = mysqli_connect("localhost", "root", "") or die("ไม่สามารถเชื่อมต่อฐานเข้ามูลได้");
mysqli_select_db($conn, "db_project") or die("ไม่พบฐานข้อมูล");
mysqli_query($conn, "SET NAMES UTF8");



// if (isset($_POST['btn_pdf'])) {
$prj_id = $_POST['project'];
$prj_pay = 0;
$void = '';
$project = mysqli_query($conn, "SELECT p.*,ph.status, pd.*, s.*,s.name AS product_name ,CONCAT(c.cus_name,' ',c.surname) AS cus_name ,CONCAT(e.emp_name,' ',e.surname) AS emp_name FROM project p JOIN projcost_hd ph ON p.project_id = ph.project_id JOIN customer c ON p.cus_code = c.cus_code JOIN employee e ON p.emp_code = e.emp_code JOIN projcost_desc pd ON ph.doc_no = pd.doc_no JOIN stock s ON pd.product_id = s.id WHERE p.project_id = '$prj_id'");
$prj_hd = mysqli_fetch_assoc($project);
if ($prj_hd['void'] == 0) {
    $void = 'ยกเลิก';
} else if ($prj_hd['void'] == 1) {
    $void = 'อยู่ระหว่างดำเนินการ';
} else {
    $void = 'ปิดโครงการ';
}

require('fpdf.php');
class PDF extends FPDF
{
    // Page header
    function Header()
    {
        // Logo
        // $this->Image('logo.png',10,6,30);
        // THSarabunB bold 24
        $this->AddFont('THSarabunB', 'B', 'THSarabunB.php');
        $this->SetFont('THSarabunB', 'B', 24);
        // Move to the right
        $this->Cell(110);
        // Title
        $this->Cell(50, 10, iconv('utf-8', 'cp874', 'รายงานโครงการ'), 'C');
        // Line break
        $this->Ln(15);
    }

    // Page footer
    function Footer()
    {
        // Position at 1.5 cm from bottom
        $this->SetY(-15);
        // THSarabunB italic 12
        $this->AddFont('THSarabunI', 'I', 'THSarabunI.php');
        $this->SetFont('THSarabunI', 'I', 12);
        // Page number
        $this->Cell(0, 10, iconv('utf-8', 'cp874', 'หน้า ' . $this->PageNo() . '/{nb}'), 0, 0, 'C');
    }
}

// Instanciation of inherited class
$pdf = new PDF('L', 'mm', 'A4');
$pdf->AddFont('THSarabunB', 'B', 'THSarabunB.php');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('THSarabunB', 'B', 18);
$pdf->Cell(275, 10, iconv('utf-8', 'cp874', 'โครงการ ' . $prj_hd['project_name']), 0, 1, 'L',);
$pdf->Cell(275, 2, '', 0, 1);
$pdf->AddFont('THSarabun', '', 'THSarabun.php');
$pdf->SetFont('THSarabun', '', 16);
$pdf->Cell(90, 7, iconv('utf-8', 'cp874', 'วันที่เริ่มโครงการ : ' . $prj_hd['start_date']), 0, 0, 'L',);
$pdf->Cell(90, 7, iconv('utf-8', 'cp874', 'วันที่สิ้นสุดโครงการ : ' . $prj_hd['end_date']), 0, 0, 'L',);
$pdf->Cell(90, 7, iconv('utf-8', 'cp874', 'มูลค่าโครงการ : ') . number_format($prj_hd['project_price']) . iconv('utf-8', 'cp874', ' บาท'), 0, 1, 'L',);
$pdf->Cell(275, 2, '', 0, 1, 'C',);
$pdf->Cell(90, 7, iconv('utf-8', 'cp874', 'เจ้าของโครงการ : ' . $prj_hd['cus_name']), 0, 0, 'L',);
$pdf->Cell(90, 7, iconv('utf-8', 'cp874', 'ผู้ดูแลโครงการ : ' . $prj_hd['emp_name']), 0, 0, 'L',);
$pdf->Cell(90, 7, iconv('utf-8', 'cp874', 'สถานะโครงการ : ' . $void), 0, 1, 'L',);
$pdf->Cell(275, 5, '', 0, 1, 'C',);
$pdf->AddFont('THSarabunB', 'B', 'THSarabunB.php');
$pdf->SetFont('THSarabunB', 'B', 16);
$pdf->Cell(25, 10, iconv('utf-8', 'cp874', 'รหัสสินค้า'), 1, 0, 'C',);
$pdf->Cell(110, 10, iconv('utf-8', 'cp874', 'รายการสินค้า'), 1, 0, 'C');
$pdf->Cell(35, 10, iconv('utf-8', 'cp874', 'ราคา/หน่วย'), 1, 0, 'C');
$pdf->Cell(35, 10, iconv('utf-8', 'cp874', 'จำนวน'), 1, 0, 'C');
$pdf->Cell(35, 10, iconv('utf-8', 'cp874', 'หน่อยนับ'), 1, 0, 'C');
$pdf->Cell(35, 10, iconv('utf-8', 'cp874', 'จำนวนเงิน'), 1, 1, 'C');
$pdf->AddFont('THSarabun', '', 'THSarabun.php');
$pdf->SetFont('THSarabun', '', 16);
$amount = 0;
if ($project != null) {
    while ($row = mysqli_fetch_array($project)) {
        if ($row['status'] != 0) {
            $amount += $row['total_price'];
        }
        $pdf->Cell(25, 10, $row['product_id'], 1, 0, 'C');
        $pdf->Cell(110, 10, iconv('utf-8', 'cp874', $row['product_name']), 1, 0, 'L');
        $pdf->Cell(35, 10, number_format($row['unit_price']) . iconv('utf-8', 'cp874', ' บาท'), 1, 0, 'R');
        $pdf->Cell(35, 10, number_format($row['qty']), 1, 0, 'C');
        $pdf->Cell(35, 10, iconv('utf-8', 'cp874', $row['unit']), 1, 0, 'C');
        $pdf->Cell(35, 10, number_format($row['total_price']) . iconv('utf-8', 'cp874', ' บาท'), 1, 1, 'C');
    }
}
$pdf->AddFont('THSarabunB', 'B', 'THSarabunB.php');
$pdf->SetFont('THSarabunB', 'B', 16);
$pdf->Cell(240, 10, iconv('utf-8', 'cp874', 'มูลค่ารวม'), 1, 0, 'L');
$pdf->Cell(35, 10, number_format($amount) . iconv('utf-8', 'cp874', ' บาท'), 1, 1, 'C');
$pdf->Output();
// }
