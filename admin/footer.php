</div> <!-- End of wrapper -->

<!-- Main Footer -->
<footer class="main-footer">
    <div class="pull-right hidden-xs">
        <b>Version</b> 1.0.0
    </div>
    <strong>&copy; 2024 <a href="#">Trovoria</a>.</strong> All rights reserved.
</footer>

<!-- JS Libraries -->
<script src="js/jquery-2.2.4.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/jquery.dataTables.min.js"></script>
<script src="js/dataTables.bootstrap.min.js"></script>
<script src="js/select2.full.min.js"></script>
<script src="js/jquery.inputmask.bundle.js"></script>
<script src="js/moment.min.js"></script>
<script src="js/bootstrap-datepicker.js"></script>
<script src="js/icheck.min.js"></script>
<script src="js/jquery.slimscroll.min.js"></script>
<script src="js/app.min.js"></script>
<script src="js/summernote.js"></script>

<script>
    $(document).ready(function () {
        // Initialize Select2 Elements
        $(".select2").select2();

        // Initialize Datepickers
        $('.datepicker').datepicker({
            autoclose: true,
            format: 'dd-mm-yyyy',
            todayBtn: 'linked'
        });

        // Initialize DataTables
        $("#example1").DataTable();

        // Fetch Categories
        fetchCategories();

        function fetchCategories() {
            $.ajax({
                url: "fetch-categories.php",
                method: "GET",
                success: function(data) {
                    let categories = JSON.parse(data);
                    $(".category-select").html("<option value=''>Select Category</option>");
                    categories.forEach(function(category) {
                        $(".category-select").append(`
                            <option value="${category.category_id}">${category.category_name}</option>
                        `);
                    });
                }
            });
        }
    });
</script>

</body>
</html>
