<?php
include('connect.php');
include("../component/header.php");
$case = $_GET['xCase'];
if ($case == '1') {
    $header = 'เพิ่ม';
    $cus_code = '';
    $statusInput = 'required';
    $statusSelect = 'required';
} else if ($case == '2') {
    $header = 'แก้ไข';
    $cus_code = $_GET['cus_code'];
    $cus_data = mysqli_query($conn, "SELECT * FROM customer WHERE cus_code='$cus_code'");
    $customer = mysqli_fetch_assoc($cus_data);
    $statusInput = 'required';
    $statusSelect = 'required';
} else if ($case == '3') {
    $header = 'ลบ';
    $cus_code = $_GET['cus_code'];
    $cus_data = mysqli_query($conn, "SELECT * FROM customer WHERE cus_code='$cus_code'");
    $customer = mysqli_fetch_assoc($cus_data);
    $statusInput = 'readonly';
    $statusSelect = 'disabled';
} else {
    $header = '';
    $cus_code = $_GET['cus_code'];
    $cus_data = mysqli_query($conn, "SELECT * FROM customer WHERE cus_code='$cus_code'");
    $customer = mysqli_fetch_assoc($cus_data);
    $statusInput = 'readonly';
    $statusSelect = 'disabled';
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
                            <li class="breadcrumb-item active"><a href="customers-list.php" class="text-decolation">ข้อมูลลูกค้า</a></li>
                            <li class="breadcrumb-item"><?= $header; ?>ข้อมูลลูกค้า</li>
                        </ol>
                    </div>
                    <!-- /.content-header -->
                    <div class="row">
                        <div class="col-12 order-2 order-md-3 order-lg-2 mb-4">
                            <div class="card">
                                <div class="card-header text-center">
                                    <h3><?= $header; ?>ข้อมูลลูกค้า</h3>
                                </div>
                                <div class="card-body">
                                    <form action="../../../API/customers_api.php?xCase=<?= $case ?>&cus_code=<?= $cus_code ?>" id="form_customer" method="POST">
                                        <div class="row">
                                            <div class="mb-3 col-lg-3 col-md-3 col-sm-12">
                                                <label for="txt_name">ชื่อ</label>
                                                <input type="text" class="form-control" name="txt_name" id="txt_name" value="<?= ($case == 1) ? '' : $customer['cus_name']; ?>" placeholder="กรอกชื่อ" <?= $statusInput ?>>
                                            </div>
                                            <div class="mb-3 col-lg-3 col-md-3 col-sm-12">
                                                <label for="txt_surname">นามสกุล</label>
                                                <input type="text" class="form-control" name="txt_surname" id="txt_surname" value="<?= ($case == 1) ? '' : $customer['surname']; ?>" placeholder="กรอกนามสกุล" <?= $statusInput ?>>
                                            </div>
                                            <div class="mb-3 col-lg-3 col-md-3 col-sm-12">
                                                <label for="txt_phone">เบอร์โทรติดต่อ</label>
                                                <input type="text" class="form-control" name="txt_phone" id="txt_phone" value="<?= ($case == 1) ? '' : $customer['phone']; ?>" placeholder="กรอกเบอร์โทรติดต่อ" <?= $statusInput ?>>
                                            </div>
                                            <div class="mb-3 col-lg-3 col-md-3 col-sm-12">
                                                <label for="txt_email">อีเมล</label>
                                                <input type="email" class="form-control" name="txt_email" id="txt_email" value="<?= ($case == 1) ? '' : $customer['email']; ?>" placeholder="กรอกอีเมล" <?= $statusInput ?>>
                                            </div>
                                            <div class="mb-3 col-lg-2 col-md-3 col-sm-12">
                                                <label for="txt_address">ที่อยู่</label>
                                                <input type="text" class="form-control" name="txt_address" id="txt_address" value="<?= ($case == 1) ? '' : $customer['address']; ?>" placeholder="กรอกที่อยู่" <?= $statusInput ?>>
                                            </div>
                                            <div class="mb-3 col-lg-3 col-md-3 col-sm-12">
                                                <label for="provinces">จังหวัด</label>
                                                <select class="form-select" aria-label="Default select example" id="provinces" name="ddl_province" <?= $statusSelect ?>>
                                                    <option value="" selected disabled>--กรุณาเลือกจังหวัด--</option>
                                                    <?php
                                                    $query = mysqli_query($conn, "SELECT * FROM provinces");
                                                    foreach ($query as $row) {
                                                        $selected = ($customer['province_code'] == $row['code']) ? "selected" : "";
                                                    ?>
                                                        <option value="<?= $row['code'] ?>" <?= $selected ?>><?= $row['name_th'] ?></option>";
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <div class="mb-3 col-lg-3 col-md-3 col-sm-12">
                                                <label for="districts">อำเภอ</label>
                                                <select class="form-select" aria-label="Default select example" id="districts" name="ddl_district" <?= $statusSelect ?>>
                                                    <?php
                                                    $datas = mysqli_query($conn, "SELECT * FROM districts");
                                                    foreach ($query as $row) {
                                                        $selected = ($customer['district_code'] == $row['code']) ? "selected" : "";
                                                    ?>
                                                        <option value="<?= $row['code'] ?>" <?= $selected ?>><?= $row['name_th'] ?></option>";
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <div class="mb-3 col-lg-3 col-md-3 col-sm-12">
                                                <label for="subdistricts">ตำบล</label>
                                                <select class="form-select" aria-label="Default select example" id="subdistricts" name="ddl_subdistrict" <?= $statusSelect ?>>
                                                    <?php
                                                    $datas = mysqli_query($conn, "SELECT * FROM subdistricts");
                                                    foreach ($query as $row) {
                                                        $selected = ($customer['subdistrict_code'] == $row['code']) ? "selected" : "";
                                                    ?>
                                                        <option value="<?= $row['code'] ?>" <?= $selected ?>><?= $row['name_th'] ?></option>";
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <div class="mb-3 col-lg-1 col-md-3 col-sm-12">
                                                <label for="zip_code">ไปรษณีย์</label>
                                                <?php
                                                if ($case == 1) {
                                                    echo "<input type='text' class='form-control' name='txt_zip_code' value='' id='zip_code' readonly required>";
                                                } else {
                                                    $subdistrict_code = $customer['subdistrict_code'];
                                                    $datas = "SELECT * FROM subdistricts WHERE code = $subdistrict_code ";
                                                    $data = mysqli_query($conn, $datas);
                                                    $result = mysqli_fetch_assoc($data);
                                                    echo "<input type='text' class='form-control' name='txt_zip_code' value='" . $result['zip_code'] . "' id='zip_code' readonly required>";
                                                }
                                                ?>
                                            </div>
                                        </div>
                                        <div class="mt-3 text-center">
                                            <?php
                                            echo ($case == '1') ?
                                                '<button type="submit" name="btn_insert" class="btn btn-success">บันทึก</button>' : (($case == '2') ?
                                                    '<button type="submit" name="submit" class="btn btn-warning">แก้ไข</button>' : (($case == '3') ?
                                                        '<button type="submit" name="submit" class="btn btn-danger">ลบ</button>' : ''))
                                            ?>
                                            <!-- <button type="submit" name="submit" class="btn btn-success">บันทึก</button> -->
                                            <a href="customers-list.php" class="btn btn-secondary ms-3">ยกเลิก</a>
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
                    $(document).ready(function() {
                        $("#form_customer").submit(function(e) {
                            e.preventDefault();

                            let formUrl = $(this).attr("action");
                            let reqMethod = $(this).attr("method");
                            let formData = $(this).serialize();

                            $.ajax({
                                url: formUrl,
                                type: reqMethod,
                                data: formData,
                                success: function(data) {
                                    // console.log("Success", data);
                                    let result = JSON.parse(data);

                                    if (result.status == "success") {
                                        // console.log("Success", result);
                                        Swal.fire({
                                            icon: result.status,
                                            title: result.title,
                                            text: result.msg,
                                            showConfirmButton: false,
                                            timer: 3000
                                        }).then(function() {
                                            window.location.href = "customers-list.php";
                                        });
                                    } else {
                                        Swal.fire({
                                            icon: result.status,
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