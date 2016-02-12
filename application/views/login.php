
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/html">


<!-- Mirrored from webapplayers.com/inspinia_admin-v2.0/login_two_columns.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 24 Apr 2015 10:53:24 GMT -->
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Pelco</title>


    <?php include('assets/includes/global_css.html'); ?>

    <!-- Checkbox / Radio -->
    <link href="assets/css/plugins/iCheck/custom.css" rel="stylesheet">


    <!-- Dropdown / Select picker-->
    <link href="assets/css/dropdown-enhance/dist/css/bootstrap-select.min.css" rel="stylesheet">

    <!-- Datepicker --->
    <link href="assets/css/plugins/datapicker/datepicker3.css" rel="stylesheet">

    <!-- Data Tables -->
    <link href="assets/css/plugins/dataTables/dataTables.bootstrap.css" rel="stylesheet">
    <link href="assets/css/plugins/dataTables/dataTables.responsive.css" rel="stylesheet">
    <link href="assets/css/plugins/dataTables/dataTables.tableTools.min.css" rel="stylesheet">
    <link href="assets/js/plugins/notify/pnotify.core.css" rel="stylesheet">



    <style>
        .toolbar{
            float: left;
        }

        .tools {
            float: left;
            margin-bottom:5px;
        }

        [contenteditable="true"]:active,
        [contenteditable="true"]:focus{
            border:3px solid #F5C116;
            outline:none;

            background: white;
        }
    </style>
</head>

<body class="gray-bg">


<div class="loginColumns animated fadeInDown">
    <div class="row">


        <div class="col-md-6">
            <h2 class="font-bold">Welcome to Project P_ v0.x </h2>
            <img style="border-radius: 3px" src="
            http://cdn-5.famouslogos.us/images/microsoft-new-logo.jpg" class="img-responsive" alt="" />

            <p>

            </p>

            <p>
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut sit amet cursus metus. Pellentesque a posuere nisi. Phasellus tempus nibh urna, at laoreet nisl hendrerit sagittis. Aenean rutrum nisi in elementum elementum. Phasellus ultrices congue enim vel imperdiet. Mauris erat nulla, pharetra nec luctus et, lobortis eu nisl. Nullam semper ipsum sit amet massa convallis fermentum. Sed pretium nulla vitae dolor pharetra, quis posuere diam dignissim. Mauris lobortis quam et scelerisque varius. Nulla bibendum ligula ut risus lacinia tincidunt. Donec tristique rutrum nunc, semper ultricies urna sagittis eu. Fusce ac porttitor nisi. Phasellus eget turpis scelerisque, porta turpis non, tincidunt ante. Nulla facilisi</p>



        </div>
        <div class="col-md-6">
            <div class="ibox-content">





                    <?php echo validation_errors(); ?>
                    <?php echo form_open('VerifyLogin'); ?>
                <div class="form-group">
                    <input type="text"  size="20" id="username" name="username" class="form-control" placeholder="Username" required=""/>
                </div>

                <div class="form-group">
                    <input type="password" size="20" id="password" name="password" class="form-control" placeholder="Password" required=""/>
                   </div>
                    <input type="submit" value="Login" class="btn btn-primary block full-width m-b"/>
                </form>



                <a href="#">
                    <small>Forgot password?</small>
                </a>

                <p class="m-t">
                    <small>&copy; 2014</small>
                </p>



            </div>
        </div>
    </div>
    <hr/>
    <div class="row">
        <div class="col-md-6">
            Copyright Example Company
        </div>
        <div class="col-md-6 text-right">
            <small>© 2014-2015</small>
        </div>
    </div>
</div>


<?php include('assets/includes/global_js.php'); ?>

<!--- Dropdown / Selectpicker --->
<script src="assets/css/dropdown-enhance/dist/js/bootstrap-select.min.js"></script>
<script src="assets/js/plugins/typehead/bootstrap3-typeahead.js"></script>

<!-- iCheck -->
<script src="assets/js/plugins/iCheck/icheck.min.js"></script>

<!-- Datepicker -->
<script src="assets/js/plugins/datapicker/bootstrap-datepicker.js"></script>

<!-- PNotify -->
<script type="text/javascript" src="assets/js/plugins/notify/pnotify.core.js"></script>
<script type="text/javascript" src="assets/js/plugins/notify/pnotify.buttons.js"></script>
<script type="text/javascript" src="assets/js/plugins/notify/pnotify.nonblock.js"></script>



<!-- Data Tables -->
<script src="assets/js/plugins/dataTables/jquery.dataTables.js"></script>
<script src="assets/js/plugins/dataTables/dataTables.bootstrap.js"></script>
<script src="assets/js/plugins/dataTables/dataTables.responsive.js"></script>
<script src="assets/js/plugins/dataTables/dataTables.tableTools.min.js"></script>

<!-- sparkline -->
<script src="assets/js/plugins/sparkline/jquery.sparkline.min.js"></script>

<!-- Peity -->
<script src="assets/js/plugins/peity/jquery.peity.min.js"></script>

<script src="assets/js/defined/user.management.event.handlers.js"></script>

</body>
</html>
