<?php
$url =  "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$file_name = basename(parse_url($url, PHP_URL_PATH));
?>
<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="home.php" class="app-brand-link">
            <img src="../../assets/img/logo-icon.png" style="width: 35px; height: 35px;" alt="">
            <span class="app-brand-text demo menu-text fw-bolder ms-3">ระบบติดตามโครงการ</span>
        </a>
    </div>
    <!-- <hr> -->
    <!-- <div class="menu-inner-shadow">

    </div> -->

    <ul class="menu-inner py-2">
        <!-- Home -->
        <li class="menu-item <?php echo ($file_name == "home.php") ? "active" : ""; ?>">
            <a href="home.php" class="menu-link">
                <i class="menu-icon fa-regular fa-gauge-min"></i>
                <div data-i18n="Analytics">ภาพรวม</div>
            </a>
        </li>
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">จัดการข้อมูลพนักงาน</span>
        </li>
        <li class="menu-item <?php echo ($file_name == "employees-list.php" || $file_name == "form-employees.php") ? "active" : ""; ?>">
            <a href="employees-list.php" class="menu-link">
                <i class="menu-icon fa-regular fa-users-gear"></i>
                <div data-i18n="Analytics">ข้อมูลพนักงาน</div>
            </a>
        </li>
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">จัดการข้อมูลลูกค้า</span>
        </li>
        <li class="menu-item <?php echo ($file_name == "customers-list.php" || $file_name == "form-customers.php") ? "active" : ""; ?>">
            <a href="customers-list.php" class="menu-link">
                <i class="menu-icon fa-regular fa-users"></i>
                <div data-i18n="Analytics">ข้อมูลลูกค้า</div>
            </a>
        </li>
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">จัดการข้อมูลสินค้า</span>
        </li>
        <li class="menu-item <?php echo ($file_name == "stocks-list.php" || $file_name == "form-stocks.php") ? "active" : ""; ?>">
            <a href="stocks-list.php" class="menu-link">
                <i class="menu-icon fa-regular fa-box-taped"></i>
                <div data-i18n="Analytics">ข้อมูลสินค้า</div>
            </a>
        </li>
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">จัดการข้อมูลโครงการ</span>
        </li>
        <li class="menu-item <?php echo ($file_name == "projects-list.php" || $file_name == "form-projects.php" || $file_name == "form-project-expenses.php") ? "active" : ""; ?>">
            <a href="projects-list.php" class="menu-link">
                <i class="menu-icon fa-regular fa-file-contract"></i>
                <div data-i18n="Analytics">ข้อมูลโครงการ</div>
            </a>
        </li>
        <li class="menu-item <?php echo ($file_name == "project-close-list.php" || $file_name == "form-project-close.php") ? "active" : ""; ?>">
            <a href="project-close-list.php" class="menu-link">
                <i class="menu-icon fa-regular fa-file-check"></i>
                <div data-i18n="Analytics">บันทึกปิดโครงการ</div>
            </a>
        </li>
        <li class="menu-item <?php echo ($file_name == "report-project.php") ? "active" : ""; ?>">
            <a href="report-project.php" class="menu-link">
                <i class="menu-icon fa-light fa-file-invoice"></i>
                <div data-i18n="Analytics">ออกรายงาน</div>
            </a>
        </li>
    </ul>
</aside>