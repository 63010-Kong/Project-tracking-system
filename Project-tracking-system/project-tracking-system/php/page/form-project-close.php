<?php
include('connect.php');
include("../component/header.php");
$case = $_GET['xCase'];
if ($case == '1') {
    $header = 'ปิด';
    $id = '';
    $date = date('Y-m-d');
    $prj = mysqli_query($conn, "SELECT * FROM project WHERE void = 1");
    $readonly = '';
} else {
    $header = 'ข้อมูลการปิด';
    $id = $_GET['id'];
    $data = mysqli_query($conn, "SELECT * FROM project_close WHERE doc_no = '" . $id . "'");
    $close_prj = mysqli_fetch_assoc($data);
    $prj = mysqli_query($conn, "SELECT * FROM project");
    $readonly = 'readonly';
}
$data_provinces = mysqli_query($conn, "SELECT * FROM provinces");
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
                            <li class="breadcrumb-item active"><a href="project-close-list.php" class="text-decolation">ข้อมูลโครงการ</a></li>
                            <li class="breadcrumb-item"><?php echo $header; ?>โครงการ</li>
                        </ol>
                    </div>
                    <!-- /.content-header -->
                    <div class="row">
                        <div class="col-12 order-2 order-md-3 order-lg-2 mb-4">
                            <div class="card">
                                <div class="card-header text-center">
                                    <h3><?php echo $header; ?>โครงการ</h3>
                                </div>
                                <div class="card-body">
                                    <form action="../../../API/project_close_api.php?xCase=<?php echo $case ?>&id=<?php echo $id ?>" id="form_project_close" method="POST">
                                        <div class="row">
                                            <div class="mb-3 col-lg-4 col-md-4 col-sm-12">
                                                <label for="date_close">วันที่ปิดโครงการ</label>
                                                <input type="date" class="form-control" name="date_close" id="date_close" value="<?= ($case == 2) ? $close_prj['date_close'] : $date ?>" readonly>
                                            </div>
                                            <div class="mb-3 col-lg-8 col-md-8 col-sm-12">
                                                <label for="project_id">ชื่อโครงการ</label>
                                                <select class="form-select" aria-label="Default select example" id="project_id" name="project_id" <?php echo ($case == 1) ? 'required' : 'disabled'; ?>>
                                                    <option value="" selected disabled>--กรุณาเลือกโครงการ--</option>
                                                    <?php
                                                    if (mysqli_num_rows($prj) > 0) {
                                                        while ($row = mysqli_fetch_assoc($prj)) {
                                                            $selected = ($close_prj['project_id'] == $row['project_id']) ? "selected" : "";
                                                            echo "<option value=" . $row['project_id'] . " " . $selected . ">" . $row['project_name'] . "</option>";
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="mb-3 col-lg-4 col-md-6 col-sm-12">
                                                <label for="cost">ต้นทุน</label>
                                                <input type="number" class="form-control" name="cost" id="cost" value="<?= ($case == 2) ? $close_prj['cost'] : '' ?>" placeholder="0" readonly>
                                            </div>
                                            <div class="mb-3 col-lg-4 col-md-6 col-sm-12">
                                                <label for="expenses">ค่าใช้จ่าย</label>
                                                <input type="number" class="form-control" name="expenses" id="expenses" value="<?= ($case == 2) ? $close_prj['expenses'] : '' ?>" placeholder="0" readonly>
                                            </div>
                                            <div class="mb-3 col-lg-4 col-md-6 col-sm-12">
                                                <label for="emp_code">รหัสพนักงาน</label>
                                                <input type="text" class="form-control" name="emp_code" id="emp_code" value="<?= ($case == 2) ? $close_prj['emp_code'] : '' ?>" placeholder="รหัสพนักงาน" readonly>
                                            </div>
                                            <div class="mb-3 col-lg-12 col-md-12 col-sm-12">
                                                <label for="comments">หมายเหตุ</label>
                                                <textarea class="form-control" name="comments" id="comments" cols="30" rows="5" <?= $readonly ?>><?= ($case == 2) ? $close_prj['comments'] : '' ?></textarea>
                                            </div>
                                        </div>
                                        <div class="mt-3 text-center">
                                            <button type="submit" name="btn_insert" class="btn btn-success" <?= $case == '1' ? '' : 'hidden' ?>>บันทึก</button>
                                            <a href="project-close-list.php" class="btn btn-secondary ms-3"><?= $case == '1' ? 'ยกเลิก' : 'ย้อนกลับ' ?></a>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!--/ Total Revenue -->
                    </div>
                </div>
                <!-- / Content -->
                <?php include('script.php'); ?>
                <script>
                    $('#project_id').change(function() {
                        var prj_id = $(this).val();
                        $.ajax({
                            type: "POST",
                            url: "ajax_db.php",
                            data: {
                                id: prj_id,
                                function: 'getProject'
                            },
                            success: function(data) {
                                var prj_data = JSON.parse(data);
                                $('#cost').val(prj_data.price)
                                $('#expenses').val(prj_data.amount)
                                $('#emp_code').val(prj_data.emp_code)
                            }
                        });
                    });

                    $(document).ready(function() {
                        $("#form_project_close").submit(function(e) {
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
                                            window.location.href = "project-close-list.php";
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
                </script>
                <!-- Footer -->
                <?php include("../component/footer.php"); ?>
                <!-- / Footer -->