<?php
include('connect.php');
$sql = "SELECT project_close.*,project_name,emp_name,surname FROM project_close JOIN project USING(project_id) JOIN employee ON project_close.emp_code=employee.emp_code WHERE project_close.void=1";
$project_close = mysqli_query($conn, $sql);

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
                            <li class="breadcrumb-item">ข้อมูลสินค้า</li>
                        </ol>
                    </div>
                    <!-- /.content-header -->
                    <div class="row">
                        <div class="col-12 order-2 order-md-3 order-lg-2 mb-4">
                            <div class="card">
                                <div class="card-header">
                                    <div class="row">
                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                            <a href="form-project-close.php?xCase=1&id=''" class="btn btn-primary"><i class="menu-icon fa-regular fa-file-check"></i> ปิดโครงการ</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <table id="myTable" class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th class="text-center" style="width: 50px;">ลำดับ</th>
                                                <th style="width: 120px;">วันที่ปิดโครงการ</th>
                                                <th>โครงการ</th>
                                                <th style="width: 110px;">ต้นทุน</th>
                                                <th style="width: 100px;">ค่าใช้จ่าย</th>
                                                <th style="width: 120px;">รหัสพนักงาน</th>

                                                <th class="text-center" style="width: 145px;">จัดการ</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if (mysqli_num_rows($project_close) > 0) {
                                                $no = 0;
                                                while ($row = mysqli_fetch_assoc($project_close)) {
                                            ?>
                                                    <tr>
                                                        <th class="text-center"><?php echo $no += 1; ?></th>
                                                        <td><?php echo $row['date_close']; ?></td>
                                                        <td><?php echo $row['project_name']; ?></td>
                                                        <td><?php echo $row['cost']; ?></td>
                                                        <td><?php echo $row['expenses']; ?></td>
                                                        <td><?php echo $row['emp_name'] . " " . $row['surname']; ?></td>
                                                        <td class="text-center">
                                                            <a href="form-project-close.php?xCase=2&id=<?php echo $row['doc_no'] ?>" name="btn_edit" class="btn btn-info edit_sale"><i class="fa-light fa-eye" style="font-size:18px"></i></a>
                                                        </td>
                                                    </tr>
                                            <?php
                                                }
                                            } ?>
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
            </script>

            <!-- Footer -->
            <?php include("../component/footer.php"); ?>
            <!-- / Footer -->