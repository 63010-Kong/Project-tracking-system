<script type="text/javascript">
    $('#provinces').change(function() {
        var province_code = $(this).val();
        $.ajax({
            type: "POST",
            url: "ajax_db.php",
            data: {
                code: province_code,
                function: 'provinces'
            },
            success: function(data) {
                $('#districts').html(data);
                $('#subdistricts').html(' ');
                $('#subdistricts').val(' ');
                $('#zip_code').val(' ');
            }
        });
    });

    $('#districts').change(function() {
        var district_code = $(this).val();
        console.log(district_code);
        $.ajax({
            type: "POST",
            url: "ajax_db.php",
            data: {
                code: district_code,
                function: 'districts'
            },
            success: function(data) {
                $('#subdistricts').html(data);
            }
        });
    });

    $('#subdistricts').change(function() {
        var subdistrict_code = $(this).val();
        $.ajax({
            type: "POST",
            url: "ajax_db.php",
            data: {
                code: subdistrict_code,
                function: 'subdistricts'
            },
            success: function(data) {
                $('#zip_code').val(data)
            }
        });
    });

    $('#add_product_id').change(function() {
        var id = $(this).val();
        $.ajax({
            type: "POST",
            url: "ajax_db.php",
            data: {
                id: id,
                function: 'getstockData'
            },
            success: function(datas) {
                var data = JSON.parse(datas);
                $('#add_unit_price').val(data.price)
            }
        });
    });
</script>