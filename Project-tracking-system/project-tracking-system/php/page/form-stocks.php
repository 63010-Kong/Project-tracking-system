<?php
include('connect.php');
include("../component/header.php");
$case = $_GET['xCase'];
if ($case == '1') {
    $header = 'เพิ่ม';
    $id = '';
} else if ($case == '2') {
    $header = 'แก้ไข';
    $id = $_GET['id'];
    $stock_data = mysqli_query($conn, "SELECT * FROM stock WHERE id='$id'");
    $stock = mysqli_fetch_assoc($stock_data);
} else if ($case == '3') {
    $header = 'ลบ';
    $id = $_GET['id'];
    $stock_data = mysqli_query($conn, "SELECT * FROM stock WHERE id='$id'");
    $stock = mysqli_fetch_assoc($stock_data);
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
                            <li class="breadcrumb-item active"><a href="stock-list.php" class="text-decolation">ข้อมูลสินค้า</a></li>
                            <li class="breadcrumb-item"><?php echo $header; ?>ข้อมูลสินค้า</li>
                        </ol>
                    </div>
                    <!-- /.content-header -->
                    <div class="row">
                        <div class="col-12 order-2 order-md-3 order-lg-2 mb-4">
                            <div class="card">
                                <div class="card-header text-center">
                                    <h3><?php echo $header; ?>ข้อมูลสินค้า</h3>
                                </div>
                                <div class="card-body">
                                    <form action="../../../API/stocks_api.php?xCase=<?php echo $case ?>&id=<?php echo $id ?>" id="form_stock" method="POST">
                                        <div class="row">
                                            <div class="mb-3 col-lg-8 col-md-6 col-sm-12">
                                                <label for="txt_name">ชื่อสินค้า</label>
                                                <input type="text" class="form-control" name="txt_name" id="txt_name" value="<?php echo ($case == 1) ? '' : $stock['name']; ?>" placeholder="กรอกชื่อสินค้า" <?php echo ($case == 3) ? 'readonly' : 'required'; ?>>
                                            </div>
                                            <div class="mb-3 col-lg-2 col-md-3 col-sm-12">
                                                <label for="txt_price">ราคา</label>
                                                <input type="number" class="form-control" name="txt_price" id="txt_price" min="0" value="<?php echo ($case == 1) ? '' : $stock['price']; ?>" placeholder="0" <?php echo ($case == 3) ? 'readonly' : 'required'; ?>>
                                            </div>
                                            <div class="mb-3 col-lg-2 col-md-3 col-sm-12">
                                                <label for="txt_unit">หน่วยนับ</label>
                                                <input type="text" class="form-control" name="txt_unit" id="txt_unit" min="0" value="<?php echo ($case == 1) ? '' : $stock['unit']; ?>" placeholder="กรอกหน่วยนับ" <?php echo ($case == 3) ? 'readonly' : 'required'; ?>>
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
                                            <a href="stocks-list.php" class="btn btn-secondary ms-3">ยกเลิก</a>
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
                        $("#form_stock").submit(function(e) {
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
                                            window.location.href = "stocks-list.php";
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