 <?php
    include('connect.php');

    if (isset($_POST['function']) && $_POST['function'] == 'provinces') {
        $province_code = $_POST['code'];
        $sql = "SELECT * FROM districts WHERE province_code='$province_code'";
        $province = mysqli_query($conn, $sql);
        echo '<option value="" selected disabled>-กรุณาเลือกอำเภอ-</option>';
        foreach ($province as $row1) {
            echo '<option value="' . $row1['code'] . '">' . $row1['name_th'] . '</option>';
        }
    }


    if (isset($_POST['function']) && $_POST['function'] == 'districts') {
        $district_code = $_POST['code'];
        $sql = "SELECT * FROM subdistricts WHERE district_code='$district_code'";
        $district = mysqli_query($conn, $sql);
        echo '<option value="" selected disabled>-กรุณาเลือกตำบล-</option>';
        foreach ($district as $row2) {
            echo '<option value="' . $row2['code'] . '">' . $row2['name_th'] . '</option>';
        }
    }

    if (isset($_POST['function']) && $_POST['function'] == 'subdistricts') {
        $subdistrict_code = $_POST['code'];
        $sql = "SELECT * FROM subdistricts WHERE code='$subdistrict_code'";
        $district01 = mysqli_query($conn, $sql);
        $result = mysqli_fetch_assoc($district01);
        echo $result['zip_code'];
        exit();
    }

    if (isset($_POST['function']) && $_POST['function'] == 'getData') {
        $prj_id = $_POST['id'];
        $sql = "SELECT project.*,cus_name,surname FROM project JOIN customer USING(cus_code) WHERE project_id='$prj_id'";
        $data = mysqli_query($conn, $sql);
        $result = mysqli_fetch_assoc($data);
        $id = $result['project_id'];
        $name = $result['cus_name'] . ' ' . $result['surname'];
        $datas = ['id' => $id, 'name' => $name];
        echo json_encode($datas);
        exit();
    }

    if (isset($_POST['function']) && $_POST['function'] == 'getProject') {
        $prj_id = $_POST['id'];
        $sql = "SELECT p.*,SUM(total_price) AS amount FROM projcost_hd ph JOIN projcost_desc pd ON ph.doc_no = pd.doc_no JOIN project p ON ph.project_id = p.project_id WHERE ph.project_id ='$prj_id'";
        $data = mysqli_query($conn, $sql);
        $result = mysqli_fetch_assoc($data);
        $price = $result['project_price'];
        $amount = $result['amount'];
        $emp_code = $result['emp_code'];
        $datas = ['price' => $price, 'amount' => $amount, 'emp_code' => $emp_code];
        echo json_encode($datas);
        exit();
    }

    if (isset($_POST['function']) && $_POST['function'] == 'getstockData') {
        $id = $_POST['id'];
        $sql = "SELECT * FROM stock WHERE  id='$id'";
        $data = mysqli_query($conn, $sql);
        $price = mysqli_fetch_assoc($data);
        // $unit_price = (float)$price['price'];

        echo json_encode($price);
        exit();
    }
    ?>