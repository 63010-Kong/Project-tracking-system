<?php
include('connect.php');
include("../component/header.php");
$case = $_GET['xCase'];
if ($case == '1') {
    $header = 'เพิ่ม';
    $id = '';
    $date = date('Y-m-d');
    $statusInput = 'required';
    $statusSelect = 'required';
} else if ($case == '2') {
    $header = 'แก้ไขข้อมูล';
    $id = $_GET['id'];
    $prj_data = mysqli_query($conn, "SELECT * FROM project WHERE project_id='$id'");
    $project = mysqli_fetch_assoc($prj_data);
    $pay = mysqli_query($conn, "SELECT ph.* FROM projcost_hd ph JOIN project p ON ph.project_id = p.project_id WHERE ph.project_id = '$id'");
    $statusInput = 'required';
    $statusSelect = 'required';
} else if ($case == '3') {
    $header = 'ยกเลิก';
    $id = $_GET['id'];
    $prj_data = mysqli_query($conn, "SELECT * FROM project WHERE project_id='$id'");
    $project = mysqli_fetch_assoc($prj_data);
    $pay = mysqli_query($conn, "SELECT ph.* FROM projcost_hd ph JOIN project p ON ph.project_id = p.project_id WHERE ph.project_id = '$id'");
    $statusInput = 'readonly';
    $statusSelect = 'disabled';
} else if ($case == '4') {
    $header = 'ดูข้อมูล';
    $id = $_GET['id'];
    $prj_data = mysqli_query($conn, "SELECT * FROM project WHERE project_id='$id'");
    $project = mysqli_fetch_assoc($prj_data);
    $pay = mysqli_query($conn, "SELECT ph.* FROM projcost_hd ph JOIN project p ON ph.project_id = p.project_id WHERE ph.project_id = '$id'");
    $statusInput = 'readonly';
    $statusSelect = 'disabled';
}
?>

<!-- Layout wrapper -->
<div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">

        <!-- Menu -->
        <?php include("../component/sidebar.php"); ?>
        <!-- / Menu -->

        <!-- Layout container -->
        <div class="layout-page">
            <!-- Navbar -->
            <?php include("../component/topbar.php"); ?>
            <!-- / Navbar -->

            <!-- Content wrapper -->
            <div class="content-wrapper">
                <!-- Content -->
                <div class="container-xxl flex-grow-1 container-p-y">
                    <!-- Content Header (Page header) -->
                    <div class="content-header">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item active"><a href="projects-list.php" class="text-decolation">ข้อมูลโครงการ</a></li>
                            <li class="breadcrumb-item"><?= $header; ?>โครงการ</li>
                        </ol>
                    </div>
                    <!-- /.content-header -->
                    <div class="row">
                        <div class="col-12 order-2 order-md-3 order-lg-2 mb-4">
                            <div class="card">
                                <div class="card-header text-center">
                                    <h3><?= $header; ?>โครงการ</h3>
                                </div>
                                <div class="card-body">
                                    <form action="../../../API/projects_api.php?xCase=<?= $case ?>&id=<?= $id ?>" id="form_project" method="POST">
                                        <div class="row">
                                            <div class="mb-3 col-lg-6 col-md-12 col-sm-12">
                                                <label for="prj_name">ชื่อโครงการ</label>
                                                <input type="text" class="form-control" name="prj_name" id="prj_name" value="<?= ($case == 1) ? '' : $project['project_name']; ?>" placeholder="กรอกชื่อโครงการ" <?= $statusInput ?>>
                                            </div>
                                            <div class="mb-3 col-lg-3 col-md-6 col-sm-12">
                                                <label for="s_date">วันที่เริ่มโครงการ</label>
                                                <input type="date" class="form-control" name="s_date" id="s_date" value="<?= ($case == 1) ? $date : $project['start_date']; ?>" <?= $statusInput ?>>
                                            </div>
                                            <div class="mb-3 col-lg-3 col-md-6 col-sm-12">
                                                <label for="e_date">วันที่สิ้นสุดโครงการ</label>
                                                <input type="date" class="form-control" name="e_date" id="e_date" value="<?= ($case == 1) ? $date : $project['end_date']; ?>" <?= $statusInput ?>>
                                            </div>
                                            <div class="mb-3 col-lg-3 col-md-6 col-sm-12">
                                                <label for="prj_price">มูลค่าโครงการ</label>
                                                <input type="text" class="form-control" name="prj_price" id="prj_price" value="<?= ($case == 1) ? '' : $project['project_price']; ?>" placeholder="กรอกเบอร์โทรติดต่อ" <?= $statusInput ?>>
                                            </div>

                                            <div class="mb-3 col-lg-3 col-md-6 col-sm-12">
                                                <label for="cus_code">ชื่อลูกค้า</label>
                                                <select class="form-select" aria-label="Default select example" id="cus_code" name="cus_code" <?= $statusSelect ?>>
                                                    <option value="" selected disabled>--กรุณาเลือกจังหวัด--</option>
                                                    <?php
                                                    $cusName = mysqli_query($conn, "SELECT * FROM customer WHERE void= 0");
                                                    if (mysqli_num_rows($cusName) > 0) {
                                                        while ($row = mysqli_fetch_assoc($cusName)) {
                                                            $selected = ($project['cus_code'] == $row['cus_code']) ? "selected" : "";
                                                            echo "<option value=" . $row['cus_code'] . " " . $selected . ">" . $row['cus_name'] . " " . $row['surname'] . "</option>";
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="mb-3 col-lg-3 col-md-6 col-sm-12">
                                                <label for="emp_code">ผู้ดูแลโครงการ</label>
                                                <select class="form-select" aria-label="Default select example" id="emp_code" name="emp_code" <?= $statusSelect ?>>
                                                    <option value="" selected disabled>--กรุณาเลือกจังหวัด--</option>
                                                    <?php
                                                    $empName = mysqli_query($conn, "SELECT * FROM employee WHERE void= 0");
                                                    if (mysqli_num_rows($empName) > 0) {
                                                        while ($row = mysqli_fetch_assoc($empName)) {
                                                            $selected = ($project['emp_code'] == $row['emp_code']) ? "selected" : "";
                                                            echo "<option value=" . $row['emp_code'] . " " . $selected . ">" . $row['emp_name'] . " " . $row['surname'] . "</option>";
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="mb-3 col-lg-3 col-md-6 col-sm-12" <?= $case == 1 ? "hidden" : "" ?>>
                                                <label for="prj_void">สถานะโครงการ</label>
                                                <select class="form-select" aria-label="Default select example" id="prj_void" name="prj_void" <?= $statusSelect ?>>
                                                    <option value="0" <?= $project['void'] == 0 ? "selected" : "" ?>>ยกเลิก</option>
                                                    <option value="1" <?= $project['void'] == 1 ? "selected" : "" ?>>อยู่ระหว่างดำเนินการ</option>
                                                    <option value="2" <?= $project['void'] == 2 ? "selected" : "" ?>>ปิดโครงการ</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="mt-3 text-center" <?= $case == 4 ? "hidden" : "" ?>>
                                            <?php
                                            echo ($case == 1) ?
                                                '<button type="submit" name="btn_insert" class="btn btn-success">บันทึก</button>' : (($case == 2) ?
                                                    '<button type="submit" name="submit" class="btn btn-warning">แก้ไข</button>' : (($case == 3) ?
                                                        '<button type="submit" name="submit" class="btn btn-danger">ตกลง</button>' : ''))
                                            ?>
                                            <a href="projects-list.php" class="btn btn-secondary ms-3">ยกเลิก</a>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="card mt-3 pb-3" <?= $case == 1 ? "hidden" : "" ?>>
                                <div class="card-header text-center">
                                    <div class="row">
                                        <div class="col-4"></div>
                                        <div class="col-4 text-center">
                                            <h3>ค่าใช่จ่ายโครงการ</h3>
                                        </div>
                                        <div class="col-4 text-end">
                                            <a href="form-project-expenses.php?xCase=1&id=<?= $id ?>" name="btn_invoice" class="btn btn-primary edit_sale" <?= $case != 4 || $project['void'] == 0 ? 'hidden' : '' ?>>
                                                <i class='fas fa-file-invoice-dollar' style='font-size:18px'></i> เพิ่มค่าใช้จ่าย
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <table class="table table-striped table-hover" id="listProduct">
                                        <thead>
                                            <tr>
                                                <th class="text-center">จัดการ</th>
                                                <th class="text-center">ลำดับ</th>
                                                <th class="text-center">สถานะใบเสร็จ</th>
                                                <th class="text-center">เลขที่เอกสาร</th>
                                                <th class="text-center">วันที่เพิ่ม</th>
                                                <th class="text-center">เลขที่ใบเสร็จ</th>
                                                <th class="text-center">วันที่ใบเสร็จ</th>
                                                <th class="text-end">จำนวนเงิน</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $total = 0;
                                            if ($case != 1) {
                                                if (mysqli_num_rows($pay) > 0) {
                                                    $no = 1;
                                                    while ($row = mysqli_fetch_assoc($pay)) {
                                                        if ($row['status'] == 1) {
                                                            $total += $row['amount'];
                                                        }
                                            ?>
                                                        <tr <?= $row['amount'] != null ? "" : "hidden" ?>>
                                                            <td class="text-center">
                                                                <?php if ($case == 2) { ?>
                                                                    <a href="form-project-expenses.php?xCase=2&id=<?= $id ?>&docNo=<?= $row['doc_no'] ?>" class="btn btn-warning text-white btn-sm">แก้ไข</a>
                                                                    <a href="form-project-expenses.php?xCase=3&id=<?= $id ?>&docNo=<?= $row['doc_no'] ?>" class="btn btn-danger text-white btn-sm">ยกเลิก</a>
                                                                <?php } else { ?>
                                                                    <a href="form-project-expenses.php?xCase=4&id=<?= $id ?>&docNo=<?= $row['doc_no'] ?>" class="btn btn-info text-white btn-sm">ดูรายละเอียด</a>
                                                                <?php } ?>
                                                            </td>
                                                            <td class="text-center"><?= $no++ ?></td>
                                                            <td class="text-center fw-bold <?= $row['status'] == 0 ? "text-danger" : "text-success" ?>"><?= $row['status'] == 0 ? "ยกเลิก" : "ปกติ" ?></td>
                                                            <td class="text-center"><?= $row['doc_no'] ?></td>
                                                            <td class="text-center"><?= $row['date_at'] ?></td>
                                                            <td class="text-center"><?= $row['order_no'] ?></td>
                                                            <td class="text-center"><?= $row['order_date'] ?></td>
                                                            <td class="text-end"><?= number_format($row['amount']) ?> บาท</td>
                                                        </tr>
                                            <?php
                                                    }
                                                }
                                            }
                                            ?>
                                        </tbody>
                                        <tfooter>
                                            <tr>
                                                <td colspan="7"><b>รวมค่าใช้จ่าย</b></td>
                                                <td class="text-end"><span class="fw-bold"><?= $total == 0 ? 0 : number_format($total) ?> บาท</span></td>
                                            </tr>
                                        </tfooter>
                                    </table>
                                </div>
                                <div class="mt-3 text-center" <?= $case != 4 ? 'hidden' : '' ?>>
                                    <a href="projects-list.php" class="btn btn-secondary ms-3">ย้อนกลับ</a>
                                </div>
                            </div>
                        </div>
                        <!--/ Total Revenue -->
                    </div>
                </div>
                <!-- / Content -->
                <?php include('script.php'); ?>
                <script>
                    $(document).ready(function() {
                        $("#form_project").submit(function(e) {
                            e.preventDefault();

                            let formUrl = $(this).attr("action");
                            let reqMethod = $(this).attr("method");
                            let formData = $(this).serialize();

                            $.ajax({
                                url: formUrl,
                                type: reqMethod,
                                data: formData,
                                success: function(data) {
                                    let result = JSON.parse(data);
                                    if (result.status == "success") {
                                        Swal.fire({
                                            icon: result.status,
                                            title: result.title,
                                            text: result.msg,
                                            showConfirmButton: false,
                                            timer: 3000
                                        }).then(function() {
                                            window.location.href = "projects-list.php";
                                        });
                                    } else if (result.status == "error") {
                                        Swal.fire({
                                            icon: result.status,
                                            title: result.title,
                                            text: result.msg,
                                        })
                                    } else {
                                        Swal.fire({
                                            icon: "warning",
                                            title: result.title,
                                            text: result.msg,
                                        })
                                    }
                                }
                            })
                        })
                    })
                    $.extend(true, $.fn.dataTable.defaults, {
                        "language": {
                            "sProcessing": "กำลังดำเนินการ...",
                            "sLengthMenu": "แสดง _MENU_ แถว",
                            "sZeroRecords": "ไม่พบข้อมูล",
                            "sInfo": "แสดง _START_ ถึง _END_ จาก _TOTAL_ แถว",
                            "sInfoEmpty": "แสดง 0 ถึง 0 จาก 0 แถว",
                            "sInfoFiltered": "(กรองข้อมูล _MAX_ ทุกแถว)",
                            "sInfoPostFix": "",
                            "sSearch": "ค้นหา:",
                            "sUrl": "",
                            "oPaginate": {
                                "sFirst": "เิริ่มต้น",
                                "sPrevious": "ก่อนหน้า",
                                "sNext": "ถัดไป",
                                "sLast": "สุดท้าย"
                            }
                        },
                        "lengthMenu": [
                            [10, 15, 20],
                            [10, 15, 20],
                        ],
                    });
                    $('#listProduct').DataTable();
                </script>
                <!-- Footer -->
                <?php include("../component/footer.php"); ?>
                <!-- / Footer -->