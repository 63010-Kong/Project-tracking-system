<?php
include('connect.php');
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

                    <div class="row">
                        <div class="col-lg-3 col-md-4 col-6">
                            <div class="small-box bg-light-blue">
                                <div class="inner text-white">
                                    <h1 class="text-white fw-bold">
                                        <?php
                                        $sql = "SELECT * FROM employee WHERE void='0'";
                                        $query = $conn->query($sql);
                                        echo "$query->num_rows";
                                        ?>
                                    </h1>
                                    <p>พนักงาน</p>
                                </div>
                                <div class="icon middle-cntent-center">
                                    <i class="ion ion-person-add"></i>
                                    <!-- <i class="fa-solid fa-users-gear"></i> -->
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-4 col-6">
                            <div class="small-box bg-maroon">
                                <div class="inner text-white">
                                    <h1 class="text-white fw-bold">
                                        <?php
                                        $sql = "SELECT * FROM customer WHERE void='0'";
                                        $query = $conn->query($sql);
                                        echo "$query->num_rows";
                                        ?>
                                    </h1>
                                    <p>ลูกค้า</p>
                                </div>
                                <div class="icon middle-cntent-center">
                                    <i class="ion ion-ios-people"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-4 col-6">
                            <div class="small-box bg-green">
                                <div class="inner text-white">
                                    <h1 class="text-white fw-bold">
                                        <?php
                                        $sql = "SELECT * FROM stock";
                                        $query = $conn->query($sql);
                                        echo "$query->num_rows";
                                        ?>
                                    </h1>
                                    <p>สินค้า</p>
                                </div>
                                <div class="icon middle-cntent-center">
                                    <i class="ion ion-cube"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-4 col-6">
                            <div class="small-box bg-yellow">
                                <div class="inner text-white">
                                    <h1 class="text-white fw-bold">
                                        <?php
                                        $sql = "SELECT * FROM project";
                                        $query = $conn->query($sql);
                                        echo "$query->num_rows";
                                        ?>
                                    </h1>
                                    <p>โครงการ</p>
                                </div>
                                <div class="icon middle-cntent-center">
                                    <i class="ion ion-ios-paper"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Footer -->
            <?php include("../component/footer.php"); ?>
            <!-- / Footer -->