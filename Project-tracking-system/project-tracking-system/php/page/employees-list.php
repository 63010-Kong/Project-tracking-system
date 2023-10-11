<?php
include('connect.php');
$sql = "SELECT emp.*,s.name_th AS sdt_name, d.name_th AS dt_name, p.name_th AS pv_name FROM employee emp JOIN subdistricts s ON emp.subdistrict_code = s.code JOIN districts d ON emp.district_code=d.code JOIN provinces p ON emp.province_code = p.code WHERE void = 0";
$emp_datas = mysqli_query($conn, $sql);

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
                            <li class="breadcrumb-item">ข้อมูลพนักงาน</li>
                        </ol>
                    </div>
                    <!-- /.content-header -->
                    <div class="row">
                        <div class="col-12 order-2 order-md-3 order-lg-2 mb-4">
                            <div class="card">
                                <div class="card-header">
                                    <div class="row">
                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                            <a href="form-employees.php?xCase=1&emp_code=''" class="btn btn-primary"><i class="menu-icon fa-regular fa-file-plus"></i> เพิ่ม</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <table id="myTable" class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th class="text-center" style="width: 50px;">รหส</th>
                                                <th>ตำแหน่งงาน</th>
                                                <th>ชื่อ-นามสกุล</th>
                                                <th>อีเมล</th>
                                                <th>เบอร์โทรศัพท์</th>
                                                <th>วันที่เริ่มงาน</th>
                                                <th class="text-center" style="width: 180px;">จัดการ</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if (mysqli_num_rows($emp_datas) > 0) {
                                                while ($row = mysqli_fetch_assoc($emp_datas)) {
                                            ?>
                                                    <tr>
                                                        <th class="text-center"><?php echo $row['emp_code']; ?></th>
                                                        <td><?php echo $row['job_position']; ?></td>
                                                        <td><?php echo $row['emp_name'], " ", $row['surname']; ?></td>
                                                        <td><?php echo $row['email']; ?></td>
                                                        <td><?php echo $row['phone']; ?></td>
                                                        <td><?php echo $row['work_start_date']; ?></td>
                                                        <td class="text-center">
                                                            <a href="form-employees.php?xCase=4&emp_code=<?php echo $row['emp_code'] ?>" name="btn_edit" class="btn btn-info edit_sale"><i class="fa-light fa-eye" style="font-size:16px"></i></a>
                                                            <a href="form-employees.php?xCase=2&emp_code=<?php echo $row['emp_code'] ?>" name="btn_edit" class="btn btn-warning edit_sale"><i class="fa-light fa-pencil" style="font-size:16px"></i></a>
                                                            <a href="form-employees.php?xCase=3&emp_code=<?php echo $row['emp_code'] ?>" name="btn_delete" class="btn btn-danger"><i class="fa-light fa-trash-can" style="font-size:16px"></i></a>
                                                        </td>
                                                    </tr>
                                                <?php
                                                }
                                            } else { ?>
                                                <tr>
                                                    <th colspan="9" class="text-center">ไม่พบข้อมูล</th>
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
                        sheet: "employee"
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