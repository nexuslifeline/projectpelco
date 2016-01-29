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

                <div class="col-lg-8 animated fadeInRight">
                    <div class="mail-box-header" style="margin-bottom:-25px;">
                        <h2 style="block:inline;"><i class="fa fa-users"></i> Item Management </h2>

                    </div>

                    <div class="mail-box" style="padding-left:10px;padding-right:10px;">


                        <div class="panel-heading">
                            <div class="panel-options">
                                <ul class="nav nav-tabs">
                                    <li class="active"><a data-toggle="tab" href="#tab-1">List of Consumer</a></li>
                                    <li class=""><a data-toggle="tab" href="#tab-2">Consumer History</a></li>
                                </ul>
                            </div>
                        </div>

                        <div class="panel-body">

                            <div class="tab-content">
                                <div id="tab-1" class="tab-pane active">
                                    <table id="tbl_item_list" class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <td></td>
                                            <td>Unit Description</td>
                                            <td>Brand Name</td>
                                            <td>Model Name</td>
                                            <td>Estimated Kwh</td>
                                            <td>Amount Consumption</td>
                                            <td></td>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>

                                <div id="tab-2" class="tab-pane">
                                    <table id="tbl_consumer_history" class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <td>Txn Date</td>
                                            <td>Reference #</td>
                                            <td>Receipt #</td>
                                            <td>Amount Due</td>
                                            <td>Amount Paid</td>
                                            <td>Balance</td>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php for($i=0;$i<=10;$i++){ ?>
                                            <tr>
                                                <td>Nov 20, 2015</td>
                                                <td>2015101000001</td>
                                                <td>11000001</td>
                                                <td>1,200.00</td>
                                                <td>0.00</td>
                                                <td>1,200.00</td>
                                            </tr>
                                        <?php } ?>
                                        </tbody>
                                    </table>
                                </div>


                            </div>
                        </div>
                    </div>

                </div>

                <div class="col-lg-4">
                    <div class="contact-box  animated fadeInRight">
                        <a href="#">
                            <div class="col-sm-4">
                                <div class="text-center">
                                    <img alt="image" class="img-circle m-t-xs img-responsive" src="assets/img/profile_small.jpg">
                                    <div class="m-t-xs font-bold">Software Developer</div>
                                </div>
                            </div>
                            <div class="col-sm-8">
                                <h3><strong>Christian Rueda</strong></h3>
                                <p><i class="fa fa-archive"></i> JDEV IT Business Solution</p><br>

                                <address>
                                    <i class="fa fa-map-marker"></i> San Jose, San Simon, Pampanga<br>
                                    <i class="fa fa-map-marker"></i> chrisrueda14@yahoo.com<br>
                                    <i class="fa fa-list-alt"></i> 322-3542<br>
                                </address>
                            </div>

                            <div class="text-right">
                                <a class="btn btn-xs btn-white"><i class="fa fa-pencil"></i> Edit Customer Info </a>
                                <a id="btn-post-payment" class="btn btn-xs btn-white"><i class="fa fa-credit-card"></i> Post Payment </a>
                            </div>


                        </a>
                    </div>

                </div>

                <div class="col-lg-4">
                    <div class="contact-box  animated fadeInRight" style="padding:10px;">

                        <div class="panel-heading">
                            <div class="panel-options">
                                <ul class="nav nav-tabs">
                                    <li class="active"><a data-toggle="tab" href="#tab-invoice-1">Account Receivable</a></li>

                                </ul>
                            </div>
                        </div>

                        <div class="panel-body">
                            <div class="tab-content">
                                <div id="tab-invoice-1" class="tab-pane active">
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <span>Current Receivable</span>
                                            <h2>$ 1,231,809.00</h2>
                                            <div class="text-center m">
                                                <span id="sparkline8"></span>
                                            </div>
                                        </div>
                                    </div>

                                    <br />

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


<!---/consumer modal--->
<div class="modal fade" id="item_modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog"  style="width:50%;">
        <div class="modal-content animated bounceInRight">



            <div class="modal-body"><!--/modal body-->
                <div class="row" style="margin-left:-25px;margin-right:-25px;"><!--/row-->
                    <div class="col-lg-12">
                        <div class="panel panel-default" style="margin-bottom:-20px;border-radius:0px;">
                            <div class="ibox float-e-margins">
                                <div class="ibox-title">
                                    <h5>Item Management<small class="m-l-sm">Please enter Item Information.</small></h5>
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
                                        <form id="frm_item_info">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label>Unit Description *</label>
                                                    <input class="form-control" type="text" name="unit_description" placeholder="Unit Description"  data-container="body" data-trigger="manual" data-toggle="tooltip" title="Employee number is required.">
                                                </div>

                                                <div class="form-group">
                                                    <label>Brand Name</label>
                                                    <input class="form-control" type="text" name="brand_name" placeholder="Brand Name"  data-container="body" data-trigger="manual" data-toggle="tooltip" title="Employee number is required.">
                                                </div>

                                                <div class="form-group">
                                                    <label>Model Name *</label>
                                                    <input class="form-control" type="text" name="model_name" placeholder="Barangay"  data-container="body" data-trigger="manual" data-toggle="tooltip" title="Employee number is required.">
                                                </div>
                                            </div>

                                            <div class="col-lg-6">

                                                <div class="form-group">
                                                    <label>Estimated Kwh</label>
                                                    <input class="form-control" type="text" name="estimated_kwh" placeholder="Estimated KHW"  data-container="body" data-trigger="manual" data-toggle="tooltip" title="Employee number is required.">
                                                </div>
                                                <div class="form-group">
                                                    <label>Amount Consumption </label>
                                                    <input class="form-control" type="text" name="amount_consumption" placeholder="Amount Consumption"  data-container="body" data-trigger="manual" data-toggle="tooltip" title="Employee number is required.">
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
                <button id="btn_create_unit" type="button" class="btn btn-primary"><i class="fa fa-save"></i> <u>R</u>ecord Unit </button>
                <button type="button" class="btn btn-white" data-dismiss="modal"><u>C</u>lose</button>
            </div>
        </div>
    </div>
</div><!---/consumer modal--->





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

<script src="assets/js/defined/item.management.event.handlers.js"></script>

</body>

</html>
