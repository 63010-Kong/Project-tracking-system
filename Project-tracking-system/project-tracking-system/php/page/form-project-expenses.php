<?php
include('connect.php');
include("../component/header.php");

$case = $_GET['xCase'];
$id = $_GET['id'];
$res = "";
if ($case == '1') {
    $header = 'บันทึก';
    $doc_no = '';
    $data = mysqli_query($conn, "SELECT prj.*, CONCAT(cus.cus_name,' ',cus.surname) AS cus_name FROM project prj JOIN customer cus ON prj.cus_code = cus.cus_code WHERE prj.project_id = '" . $id . "'");
    $prj_data = mysqli_fetch_assoc($data);
    $res = "required";
} else if ($case == '2') {
    $header = 'รายละเอียด';
    $doc_no = $_GET['docNo'];
    $prj_pay = mysqli_query($conn, "SELECT prj.*,ph.*, CONCAT(cus.cus_name,' ',cus.surname) AS cus_name FROM project prj JOIN customer cus ON prj.cus_code = cus.cus_code JOIN projcost_hd ph ON prj.project_id = ph.project_id WHERE prj.project_id = '" . $id . "'");
    $prj_hd = mysqli_fetch_assoc($prj_pay);
    $prj_pays = mysqli_query($conn, "SELECT pd.*, s.name AS product_name, s.unit FROM projcost_hd ph JOIN projcost_desc pd ON ph.doc_no = pd.doc_no JOIN stock s ON pd.product_id = s.id WHERE ph.doc_no ='$doc_no'");
    $res = "required";
} else if ($case == '3') {
    $header = 'ยกเลิก';
    $doc_no = $_GET['docNo'];
    $prj_pay = mysqli_query($conn, "SELECT prj.*,ph.*, CONCAT(cus.cus_name,' ',cus.surname) AS cus_name FROM project prj JOIN customer cus ON prj.cus_code = cus.cus_code JOIN projcost_hd ph ON prj.project_id = ph.project_id WHERE prj.project_id = '" . $id . "'");
    $prj_hd = mysqli_fetch_assoc($prj_pay);
    $prj_pays = mysqli_query($conn, "SELECT pd.*,s.name AS product_name, s.unit FROM projcost_hd ph JOIN projcost_desc pd ON ph.doc_no = pd.doc_no JOIN stock s ON pd.product_id = s.id WHERE ph.doc_no = '" . $doc_no . "'");
    $res = "readonly";
} else if ($case == '4') {
    $header = 'รายการ';
    $doc_no = $_GET['docNo'];
    $prj_pay = mysqli_query($conn, "SELECT prj.*,ph.*, CONCAT(cus.cus_name,' ',cus.surname) AS cus_name FROM project prj JOIN customer cus ON prj.cus_code = cus.cus_code JOIN projcost_hd ph ON prj.project_id = ph.project_id WHERE prj.project_id = '" . $id . "'");
    $prj_hd = mysqli_fetch_assoc($prj_pay);
    $prj_pays = mysqli_query($conn, "SELECT pd.*,s.name AS product_name, s.unit FROM projcost_hd ph JOIN projcost_desc pd ON ph.doc_no = pd.doc_no JOIN stock s ON pd.product_id = s.id WHERE ph.doc_no = '" . $doc_no . "'");
    $res = "readonly";
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
                            <li class="breadcrumb-item active"><a href="stock-list.php" class="text-decolation">ข้อมูลค่าใช้จ่ายโครงการ</a></li>
                            <li class="breadcrumb-item"><?php echo $header; ?>ค่าใช้จ่ายโครงการ</li>
                        </ol>
                    </div>
                    <!-- /.content-header -->
                    <div class="row">
                        <div class="col-12 order-2 order-md-3 order-lg-2 mb-4">
                            <form action="../../../API/project_expenses_api.php?xCase=<?php echo $case ?>&id=<?php echo $id ?>&doc_no=<?php echo $doc_no ?>" id="form_project_expense" method="POST">
                                <div class="card">
                                    <div class="card-header text-center">
                                        <h3><?php echo $header; ?>ค่าใช้จ่ายโครงการ</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="mb-3 col-lg-4 col-md-4 col-sm-6">
                                                <label for="date_at">วันที่บันทึก</label>
                                                <input type="date" class="form-control" name="date_at" id="date_at" value="<?php echo ($case == 1) ? '' : $prj_hd['date_at']; ?>" <?= $res ?>>
                                            </div>
                                            <div class="mb-3 col-lg-4 col-md-4 col-sm-6">
                                                <label for="order_no">เลขที่ใบเสร็จ</label>
                                                <input type="text" class="form-control" name="order_no" id="order_no" value="<?php echo ($case == 1) ? '' : $prj_hd['order_no']; ?>" placeholder="เลขที่ใบเสร็จ" <?= $res ?>>
                                            </div>
                                            <div class="mb-3 col-lg-4 col-md-4 col-sm-6">
                                                <label for="order_date">วันที่ใบเสร็จ</label>
                                                <input type="date" class="form-control" name="order_date" id="order_date" value="<?php echo ($case == 1) ? '' : $prj_hd['order_date']; ?>" <?= $res ?>>
                                            </div>
                                            <div class="mb-3 col-lg-4 col-md-4 col-sm-6">
                                                <label for="project_id">รหัสโครงการ</label>
                                                <input type="number" class="form-control" name="project_id" id="project_id" placeholder="รหัสโครงการ" value="<?php echo ($case == 1) ? $prj_data['project_id'] : $prj_hd['project_id']; ?>" readonly>
                                            </div>
                                            <div class="mb-3 col-lg-8 col-md-8 col-sm-12">
                                                <label for="project_name">ชื่อโครงการ</label>
                                                <input type="text" class="form-control" name="project_name" id="project_name" placeholder="ชื่อโครงการ" value="<?php echo ($case == 1) ? $prj_data['project_name'] : $prj_hd['project_name']; ?>" readonly>
                                            </div>
                                            <div class="mb-3 col-lg-4 col-md-4 col-sm-6">
                                                <label for="cus_name">ชื่อลูกค้า</label>
                                                <input type="text" class="form-control" name="cus_name" id="cus_name" value="<?php echo ($case == 1) ? $prj_data['cus_name'] : $prj_hd['cus_name']; ?>" placeholder="ชื่อลูกค้า" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card mt-3 pb-3">
                                    <?php
                                    if ($case == 1) {
                                    ?>
                                        <div class="card-body">
                                            <table class="table table-bordered" id="table_field">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center">จัดการ</th>
                                                        <th class="text-center">รหัสสินค้า</th>
                                                        <th class="text-center">ราคา/หน่วย</th>
                                                        <th class="text-center">จำนวน</th>
                                                        <th class="text-center">จำนวนเงิน</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr class="productItem">
                                                        <td class="text-center"><button type="button" class="btn btn-sm btn-warning" name="add" id="add"><i class="fa-solid fa-plus"></i></button></td>
                                                        <td><input type="text" class="form-control product" name="product_id[]" placeholder="รหัสสินค้า"></td>
                                                        <td><input type="number" class="form-control text-end price" name="unit_price[]" min="0" placeholder="0" readonly></td>
                                                        <td><input type="number" class="form-control text-center qty" name="qty[]" min="0" placeholder="0" value="1"></td>
                                                        <td><input type="text" class="form-control text-end total" name="total_price[]" min="0" placeholder="0" readonly></td>
                                                    </tr>
                                                </tbody>
                                                <tfooter class="amount">
                                                    <tr>
                                                        <td colspan="4"><b>รวมมูลค่าสินค้า</b></td>
                                                        <td class="text-end"><span class="fw-bold" id="totalSum">0 บาท</span></td>
                                                    </tr>
                                                </tfooter>

                                            </table>
                                            <div class="mt-3 text-center">
                                                <button type="submit" name="btn_insert" class="btn btn-success me-2">บันทึก</button>
                                                <a href="form-projects.php?xCase=4&id=<?php echo $id ?>" class="btn btn-secondary">ยกเลิก</a>
                                            </div>
                                        </div>
                                    <?php } else { ?>
                                        <div class="card-body">
                                            <table class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center" style="width:80px;">ลำดับ</th>
                                                        <th class="text-center">รหัสสินค้า</th>
                                                        <th class="text-start">ชื่อ</th>
                                                        <th class="text-end">ราคา/หน่วย</th>
                                                        <th class="text-end">จำนวน</th>
                                                        <th class="text-end">จำนวนเงิน</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $amount = 0;
                                                    if (mysqli_num_rows($prj_pays) > 0) {
                                                        $no = 1;
                                                        while ($row = mysqli_fetch_assoc($prj_pays)) {
                                                            $amount += $row['total_price'];
                                                    ?>
                                                            <tr>
                                                                <th class="text-center"><?= $no++ ?></th>
                                                                <td class="text-center"><?= $row['product_id'] ?></td>
                                                                <td class="text-start"><?= $row['product_name'] ?></td>
                                                                <td class="text-end"><?= number_format($row['unit_price']) ?> บาท</td>
                                                                <td class="text-end"><?= $row['qty'] . " " . $row['unit'] ?></td>
                                                                <td class="text-end"><?= number_format($row['total_price']) ?> บาท</td>
                                                            </tr>
                                                    <?php
                                                        }
                                                    }
                                                    ?>
                                                </tbody>
                                                <tfooter>
                                                    <tr>
                                                        <td colspan="5"><b>รวมมูลค่าสินค้า</b></td>
                                                        <td class="text-end"><span class="fw-bold"><?= number_format($amount) ?> บาท</span></td>
                                                    </tr>
                                                </tfooter>
                                            </table>
                                            <div class="mt-3 text-center">
                                                <?php
                                                echo (($case == 1) ?
                                                    '<button type="submit" name="btn_insert" class="btn btn-success me-2">บันทึก</button>' : (($case == 2) ?
                                                        '<button type="submit" name="btn_insert" class="btn btn-warning me-2">แก้ไข</button>' : (($case == 3) ?
                                                            '<button type="submit" name="btn_insert" class="btn btn-danger me-2">ตกลง</button>' : '')))
                                                ?>
                                                <a href="form-projects.php?xCase=<?= ($case == 3) ? 2 : $case ?>&id=<?= $id ?>" class="btn btn-secondary">ยกเลิก</a>
                                            </div>
                                        </div>
                                    <?php  } ?>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!--/ Total Revenue -->
                </div>
            </div>
            <!-- / Content -->
            <script>
                $('#project_name').change(function() {
                    var prj_id = $(this).val();
                    $.ajax({
                        type: "POST",
                        url: "ajax_db.php",
                        data: {
                            id: prj_id,
                            function: 'getData'
                        },
                        success: function(data) {
                            var prj_data = JSON.parse(data);
                            $('#project_id').val(prj_data.id)
                            $('#cus_name').val(prj_data.name)
                        }
                    });
                });

                $(document).ready(function() {

                    var min = 1;
                    var max = 10;
                    $("#add").click(function() {
                        var rowCount = $('#table_field tbody tr').length;
                        var html = `<tr class="row${rowCount}">
                                    <td class="text-center"><button type="button" class="btn btn-sm btn-danger" name="remove" id="remove"><i class="fa-solid fa-x"></i></button></td>
                                    <td><input type="text" class="form-control product" name="product_id[]" placeholder="รหัสสินค้า" required></td>
                                    <td><input type="number" class="form-control text-end price" name="unit_price[]" min="0" placeholder="0" readonly>
                                    <td><input type="number" class="form-control text-center qty" name="qty[]" min="0" placeholder="0" value="1" required></td>
                                    </td><td><input type="number" class="form-control text-end total" name="total_price[]" min="0" placeholder="0" readonly></td>
                                </tr>`;
                        if (min <= max) {
                            $("#table_field").append(html);
                            min++;
                            $(".row" + rowCount).find(".qty").on('change', function() {
                                if ($(".row" + rowCount).find(".qty").val() != "" && $(".row" + rowCount).find(".price").val() != "") {
                                    var sum = $(".row" + rowCount).find(".qty").val() * $(".row" + rowCount).find(".price").val();
                                    $(".row" + rowCount).find(".total").val(sum);
                                    totalSum();
                                }
                            });
                            $(".row" + rowCount).find(".product").on('change', function() {
                                $.get("../../../API/stocks_api.php?xCase=4&id=" + $(this).val(), function(res) {
                                    var data = JSON.parse(res);
                                    $(".row" + rowCount).find(".price").val(data.price);

                                    if ($(".row" + rowCount).find(".qty").val() != "" && $(".row" + rowCount).find(".price").val() != "") {
                                        var sum = $(".row" + rowCount).find(".qty").val() * $(".row" + rowCount).find(".price").val();
                                        $(".row" + rowCount).find(".total").val(sum);
                                        totalSum();
                                    }
                                });
                            });
                        }
                    });
                    $("#table_field").on('click', '#remove', function() {
                        $(this).closest('tr').remove();
                        min--;
                        totalSum();
                    });
                    $(".productItem").find(".qty").on('change', function() {
                        if ($(".productItem").find(".qty").val() != "" && $(".productItem").find(".price").val() != "") {
                            var sum = $(".productItem").find(".qty").val() * $(".productItem").find(".price").val();
                            $(".productItem").find(".total").val(sum);
                            totalSum();
                        }
                    });
                    $(".productItem").find(".product").on('change', function() {
                        $.get("../../../API/stocks_api.php?xCase=4&id=" + $(this).val(), function(res) {
                            var data = JSON.parse(res);
                            $(".productItem").find(".price").val(data.price.toLocaleString("en-US"));

                            if ($(".productItem").find(".qty").val() != "" && $(".productItem").find(".price").val() != "") {
                                var sum = $(".productItem").find(".qty").val() * $(".productItem").find(".price").val();
                                $(".productItem").find(".total").val(sum);
                                totalSum();
                            }
                        });
                    });

                    function totalSum() {
                        var sum = 0;
                        $('.total').each(function() {
                            sum += +$(this).val();
                        })
                        // $('.totalSum').val(sum.toLocaleString("en-US"));
                        document.getElementById('totalSum').innerHTML = sum.toLocaleString("en-US") + " บาท";
                    }
                    $("#form_project_expense").submit(function(e) {
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
                                        window.location.href = `form-projects.php?xCase=${result.data.case}&id=${result.data.id}`;
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