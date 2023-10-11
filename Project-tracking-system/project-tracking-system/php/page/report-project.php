<?php
include('connect.php');
$projects = mysqli_query($conn, "SELECT * FROM project WHERE void != 0");
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
                            <li class="breadcrumb-item">ออกรายงานโครงการ</li>
                        </ol>
                    </div>
                    <!-- /.content-header -->
                    <div class="row">
                        <div class="col-12 order-2 order-md-3 order-lg-2 mb-4">
                            <div class="card" style="height:470px;">
                                <div class="card-header text-center">
                                    <h3>ออกรายงานโครงการ</h3>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-4"></div>
                                        <div class="col-4">
                                            <form action="../../fpdf/myPDF.php" method="post">
                                                <label for="project">โครงการ</label>
                                                <select class="form-select" aria-label="Default select example" id="project" name="project" required>
                                                    <option value="" disabled selected>-เลือกโครงการ-</option>
                                                    <?php
                                                    foreach ($projects as $row) {
                                                    ?>
                                                        <option value="<?= $row['project_id'] ?>"><?= $row['project_name'] ?></option>";
                                                    <?php } ?>
                                                </select>
                                                <div class="mt-5 text-center">
                                                    <button type="submit" class="btn btn-danger" name="btn_pdf" target="_blank"><i class="menu-icon fa fa-file-pdf-o"></i> PDF</button>
                                                    <!-- <button type="button" class="btn btn-success"><i class="menu-icon fa fa-file-excel-o"></i> Excel</button> -->
                                                </div>
                                            </form>
                                        </div>
                                        <div class="col-4"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--/ Total Revenue -->
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <?php include("../component/footer.php"); ?>
            <!-- / Footer -->