<?php
include('connect.php');
$sql = "SELECT c.*,s.name_th AS sdt_name, d.name_th AS dt_name, p.name_th AS pv_name FROM customer c JOIN subdistricts s ON c.subdistrict_code = s.code JOIN districts d ON c.district_code=d.code JOIN provinces p ON c.province_code = p.code WHERE c.void = 0";
$cus_datas = mysqli_query($conn, $sql);

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
                            <li class="breadcrumb-item">ข้อมูลลูกค้า</li>
                        </ol>
                    </div>
                    <!-- /.content-header -->
                    <div class="row">
                        <div class="col-12 order-2 order-md-3 order-lg-2 mb-4">
                            <div class="card">
                                <div class="card-header">
                                    <div class="row">
                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                            <a href="form-customers.php?xCase=1&cus_code=''" class="btn btn-primary"><i class="menu-icon fa-regular fa-file-plus"></i> เพิ่ม</a>
                                        </div>
                                        <!-- <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 text-end">
                                            <a href="../fpdf/reportCustomerPDF.php" class="btn btn-danger me-3" target="_blank"><i class="fa fa-file-pdf-o" style="font-size:24px"></i> PDF</a>
                                            <button type="button" class="btn btn-success" onclick="ExportToExcel('xlsx')"><i class="fa fa-file-excel-o" style="font-size:24px"></i> Excel</button>
                                        </div> -->
                                    </div>
                                </div>
                                <div class="card-body">
                                    <table id="myTable" class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th class="text-center" style="width: 50px;">รหัส</th>
                                                <th>ชื่อ-นามสกุล</th>
                                                <th>เบอร์โทรศัพท์</th>
                                                <th>ที่อยู่</th>
                                                <th>ตำบล</th>
                                                <th>อำเภอ</th>
                                                <th>จังหวัด</th>
                                                <th class="text-center" style="width: 180px;">จัดการ</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if (mysqli_num_rows($cus_datas) > 0) {
                                                while ($row = mysqli_fetch_assoc($cus_datas)) {
                                            ?>
                                                    <tr>
                                                        <th class="text-center"><?php echo $row['cus_code']; ?></th>
                                                        <td><?php echo $row['cus_name'], " ", $row['surname']; ?></td>
                                                        <td><?php echo $row['phone']; ?></td>
                                                        <td><?php echo $row['address']; ?></td>
                                                        <td><?php echo $row['sdt_name']; ?></td>
                                                        <td><?php echo $row['dt_name']; ?></td>
                                                        <td><?php echo $row['pv_name']; ?></td>
                                                        <td class="text-center">
                                                            <a href="form-customers.php?xCase=4&cus_code=<?php echo $row['cus_code'] ?>" name="btn_edit" class="btn btn-info edit_sale"><i class="fa-light fa-eye" style="font-size:16px"></i></a>
                                                            <a href="form-customers.php?xCase=2&cus_code=<?php echo $row['cus_code'] ?>" name="btn_edit" class="btn btn-warning edit_sale"><i class="fa-light fa-pencil" style="font-size:16px"></i></a>
                                                            <a href="form-customers.php?xCase=3&cus_code=<?php echo $row['cus_code'] ?>" name="btn_delete" class="btn btn-danger"><i class="fa-light fa-trash-can" style="font-size:16px"></i></a>
                                                        </td>
                                                    </tr>
                                            <?php
                                                }
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
            </script>

            <!-- Footer -->
            <?php include("../component/footer.php"); ?>
            <!-- / Footer -->