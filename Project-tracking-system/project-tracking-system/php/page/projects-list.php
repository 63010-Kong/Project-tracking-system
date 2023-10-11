<?php
include('connect.php');
$sql = "SELECT project.*, emp.emp_name, emp.surname AS emp_surname, cus.cus_name, cus.surname AS cus_surname FROM project JOIN employee emp USING(emp_code) JOIN customer cus USING(cus_code)";
$project_datas = mysqli_query($conn, $sql);

include("../component/header.php");
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
                            <!-- <li class="breadcrumb-item">Manage User</li> -->
                            <li class="breadcrumb-item">ข้อมูลโครงการ</li>
                        </ol>
                    </div>
                    <!-- /.content-header -->
                    <div class="row">
                        <div class="col-12 order-2 order-md-3 order-lg-2 mb-4">
                            <div class="card">
                                <div class="card-header">
                                    <div class="row">
                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                            <a href="form-projects.php?xCase=1&id=''" class="btn btn-primary"><i class="menu-icon fa-regular fa-file-plus"></i> เพิ่ม</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <table id="myTable" class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th class="text-center" style="width: 50px;">ลำดับ</th>
                                                <th style="width: 100px;">วันที่เริ่มโครงการ</th>
                                                <th>ชื่อโครงการ</th>
                                                <th style="width: 90px;">มูลค่าโครงการ</th>
                                                <th style="width: 110px;">ผู้ดูแลโครงการ</th>
                                                <th class="text-center" style="width: 130px;">สถานะโครงการ</th>
                                                <th class="text-center" style="width: 200px;">จัดการ</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if (mysqli_num_rows($project_datas) > 0) {
                                                $no = 0;
                                                while ($row = mysqli_fetch_assoc($project_datas)) {
                                                    $status = $row['void'] == 0 ? '<b class="text-danger">ยกเลิก</b>' : ($row['void'] == 1 ? '<b class="text-warning">อยู่ระหว่างดำเนินการ</b>' : '<b class="text-success">ปิดโครงการ</b>');
                                            ?>
                                                    <tr>
                                                        <th class="text-center"><?php echo $no += 1; ?></th>
                                                        <td><?php echo $row['start_date']; ?></td>
                                                        <td><?php echo $row['project_name']; ?></td>
                                                        <td><?php echo $row['project_price']; ?></td>
                                                        <td><?php echo $row['emp_name'] . " " . $row['emp_surname'] ?></td>
                                                        <td class="text-center"><?php echo $status ?></td>
                                                        <td class="text-center">
                                                            <a href="form-projects.php?xCase=4&id=<?php echo $row['project_id'] ?>" name="btn_view" class="btn btn-info"><i class="fa-light fa-eye" style="font-size:18px"></i></a>
                                                            <a href="form-projects.php?xCase=2&id=<?php echo $row['project_id'] ?>" name="btn_edit" class="btn btn-warning"><i class="fa-light fa-pencil" style="font-size:18px"></i></a>
                                                            <?php if ($row['void'] == 1) { ?>
                                                                <a href="form-projects.php?xCase=3&id=<?php echo $row['project_id'] ?>" name="btn_cancle" class="btn btn-danger"><i class="fa-solid fa-xmark" style="font-size:18px"></i></a>
                                                            <?php } else { ?>
                                                                <button type="button" name="btn_cancle" class="btn btn-danger" onClick="cancleProject(<?= $row['void'] ?>)"><i class="fa-solid fa-xmark" style="font-size:18px"></i></button>
                                                            <?php } ?>
                                                        </td>
                                                    </tr>
                                                <?php
                                                }
                                            } else { ?>
                                                <tr>
                                                    <th colspan="6" class="text-center">ไม่พบข้อมูล</th>
                                                </tr>
                                            <?php
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!--/ Total Revenue -->
                    </div>
                </div>
            </div>
            <script>
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
                        [5, 10, 15, 20],
                        [5, 10, 15, 20],
                    ],
                });
                $('#myTable').DataTable();

                function ExportToExcel(type, fn, dl) {
                    var elt = document.getElementById('myTable');
                    var wb = XLSX.utils.table_to_book(elt, {
                        sheet: "sheet1"
                    });
                    return dl ?
                        XLSX.write(wb, {
                            bookType: type,
                            bookSST: true,
                            type: 'base64'
                        }) :
                        XLSX.writeFile(wb, fn || ('MyExport.' + (type || 'xlsx')));
                }

                function cancleProject(status) {
                    if (status === 2) {
                        Swal.fire({
                            icon: "warning",
                            title: "Warning!",
                            text: "โครงการนี้ถูกปิดไปแล้ว!",
                        })
                    } else {
                        Swal.fire({
                            icon: "warning",
                            title: "Warning!",
                            text: "โครงการนี้ถูกยกเลิกแล้ว!",
                        })
                    }
                }
            </script>

            <!-- Footer -->
            <?php include("../component/footer.php"); ?>
            <!-- / Footer -->