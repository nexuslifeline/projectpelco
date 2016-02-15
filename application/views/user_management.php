<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/html">

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

    <link href="assets/js/plugins/datepicker/daterangepicker.css" rel="stylesheet">



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

<body>

<div id="wrapper">
    <!-- /left navigation -->
    <?php $this->load->view('templates/left_navigation.php'); ?>
    <!-- /left navigation -->



    <div id="page-wrapper" class="gray-bg">
        <div class="row border-bottom">
            <!-- /top navigation -->
            <?php $this->load->view('templates/top_navigation.php'); ?>
            <!-- /top navigation -->
        </div>




        <div class="wrapper wrapper-content"><!-- /main content area -->
            <div class="row">

                <div class="col-lg-12 animated fadeInRight">
                    <div class="mail-box-header" style="margin-bottom:-25px;">
                        <h2 style="block:inline;"><i class="fa fa-users"></i> User Management </h2>

                    </div>

                    <div class="mail-box" style="padding-left:10px;padding-right:10px;">


                        <div class="panel-heading">
                            <div class="panel-options">
                                <ul class="nav nav-tabs">

                                    <li class="active"><a data-toggle="tab" href="#tab-1">List of User</a></li>

                                </ul>
                            </div>
                        </div>

                        <div class="panel-body">

                            <div class="tab-content">
                                <div id="tab-1" class="tab-pane active">
                                    <table id="tbl_user_list" class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <td></td>
                                            <td>Name</td>
                                            <td>Address</td>
                                            <td>Mobile/</td>
                                            <td>Email</td>
                                            <td>Birthdate</td>
                                            <td>Action</td>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>


                            </div>
                        </div>
                    </div>

                </div>


            </div>
        </div><!-- /main content area -->

        <!-- /footer -->
        <?php $this->load->view('templates/footer'); ?>
        <!-- /footer -->


    </div>
</div>


<!---/user modal--->
<div class="modal fade" id="user_modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog"  style="width:50%;">
        <div class="modal-content animated bounceInRight">



            <div class="modal-body"><!--/modal body-->
                <div class="row" style="margin-left:-25px;margin-right:-25px;"><!--/row-->
                    <div class="col-lg-12">
                        <div class="panel panel-default" style="margin-bottom:-20px;border-radius:0px;">
                            <div class="ibox float-e-margins">
                                <div class="ibox-title">
                                    <h5>User Management<small class="m-l-sm">Please enter User Information.</small></h5>
                                    <div class="ibox-tools">
                                        <a class="collapse-link">
                                            <i class="fa fa-chevron-up"></i>
                                        </a>
                                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                            <i class="fa fa-wrench"></i>
                                        </a>

                                        <a class="close-link">
                                            <i class="fa fa-times"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="ibox-content">
                                    <div class="row">
                                        <form id="frm_user_info">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label>Firstname</label>
                                                    <input class="form-control" type="text" name="firstname" placeholder="Firstname"  data-container="body" data-trigger="manual" data-toggle="tooltip" title="Firstname is required."data-message="Please make sure you enter Firstname." required>
                                                </div>
                                                <div class="form-group">
                                                    <label>Middlename</label>
                                                    <input class="form-control" type="text" name="middlename" placeholder="Middlename"  data-container="body" data-trigger="manual" data-toggle="tooltip" title="Middlename is required."data-message="Please make sure you enter Middlename." required>
                                                </div>
                                                <div class="form-group">
                                                    <label>Lastname</label>
                                                    <input class="form-control" type="text" name="lastname" placeholder="Lastname"  data-container="body" data-trigger="manual" data-toggle="tooltip" title="Lastname is required."data-message="Please make sure you enter Lastname." required>
                                                </div>
                                                <div class="form-group">
                                                    <label>Birthdate</label>
                                                    <input class="form-control" type="text" name="birthdate" placeholder="YYYY/MM/DD"  data-container="body" data-trigger="manual" data-toggle="tooltip" title="Birthdate is required."data-message="Please make sure you enter Birthdate." required>
                                                </div>


                                                <div class="form-group">
                                                    <label>Complete Address </label><br/>
                                                    <textarea name="address" class="form-control" rows="5" >

                                                    </textarea>
                                                    <!--<input class="form-control" type="text" name="second_address" placeholder="Second Address"  data-container="body" data-trigger="manual" data-toggle="tooltip" title="Employee number is required.">-->
                                                </div>


                                            </div>

                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label>Mobile No</label>
                                                    <input class="form-control" type="text" name="mobile" placeholder="Mobile #"  data-container="body" data-trigger="manual" data-toggle="tooltip" title="Mobile No# is required." data-message="Please make sure you enter Mobile No#." required >
                                                </div>
                                                <div class="form-group">
                                                    <label>Landline No</label>
                                                    <input class="form-control" type="text" name="landline" placeholder="Landline #"  data-container="body" data-trigger="manual" data-toggle="tooltip" title="Landline No is required." data-message="Please make sure you enter Landline No." required >
                                                </div>

                                                <div class="form-group">
                                                    <label>Username </label>
                                                    <input class="form-control" type="text" name="username" placeholder="Username"  data-container="body" data-trigger="manual" data-toggle="tooltip" title="Username is required."data-message="Please make sure you enter Username." required >
                                                </div>

                                                <div class="form-group">
                                                    <label>Password</label>
                                                    <input class="form-control" type="password" name="password" placeholder="Password"  data-container="body" data-trigger="manual" data-toggle="tooltip" title="Password is required."data-message="Please make sure you enter Password." required >
                                                </div>
                                                <div class="form-group">
                                                    <label>Confirm Password</label>
                                                    <input class="form-control" type="password" name="confirm_password" placeholder="Confirm Password"  data-container="body" data-trigger="manual" data-toggle="tooltip" title="Confirm Password is required."data-message="Please make sure you enter Confirm Password." required >
                                                </div>

                                                <div class="form-group">
                                                    <label>Email Address </label>
                                                    <input class="form-control" type="text" name="email" placeholder="Email Address"  data-container="body" data-trigger="manual" data-toggle="tooltip" title="Email Address is required."data-message="Please make sure you enter Email Address." required >
                                                </div>

                                            </div>
                                    </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>	<!--/row-->
            </div><!--/modal body-->

            <div class="modal-footer">
                <button id="btn_create_user" type="button" class="btn btn-primary"><i class="fa fa-save"></i> <u>R</u>ecord User </button>
                <button type="button" class="btn btn-white" data-dismiss="modal"><u>C</u>lose</button>
            </div>
        </div>
    </div>
</div><!---/user modal--->





<!-- delete modal-->
<div id="confirm_modal" data-save-mode="" class="modal fade" tabindex="-1" role="dialog"><!--modal-->
    <div class="modal-dialog modal-sm">
        <div class="modal-content"><!---content--->
            <div class="modal-header">
                <button type="button" class="close"   data-dismiss="modal" aria-hidden="true">X</button>
                <h4 class="modal-title"><span id="modal_mode"> </span>RECORD</h4>

            </div>

            <div class="modal-body">
                <p id="modal-body-message">Are you sure ?</p>
            </div>

            <div class="modal-footer">
                <button id="btn_yes" type="button" class="btn btn-danger" data-dismiss="modal">Yes</button>
                <button id="btn-close" type="button" class="btn btn-default" data-dismiss="modal">No</button>
            </div>
        </div><!---content---->
    </div>
</div><!---modal-->


<?php include('assets/includes/global_js.php'); ?>

<!--- Dropdown / Selectpicker --->
<script src="assets/css/dropdown-enhance/dist/js/bootstrap-select.min.js"></script>
<script src="assets/js/plugins/typehead/bootstrap3-typeahead.js"></script>

<!-- iCheck -->
<script src="assets/js/plugins/iCheck/icheck.min.js"></script>

<!-- Datepicker -->


<!-- Datepicker -->
<script src="assets/js/plugins/moment.min2.js"></script>
<script src="assets/js/plugins/datepicker/daterangepicker.js"></script>


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
