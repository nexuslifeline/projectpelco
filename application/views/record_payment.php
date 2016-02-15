<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>JCore v2</title>


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
                    <h2 style="block:inline;"><i class="fa fa-pencil-square-o"></i> Record Payment of Apprehended Consumer



                    </h2>

                </div>

                <div class="mail-box" style="padding-left:10px;padding-right:10px;">


                    <div class="panel-heading">
                        <div class="panel-options">
                            <ul class="nav nav-tabs">
                                <li class="active"><a data-toggle="tab" href="#tab-1">List of Payments</a></li>
                                <li class=""><a data-toggle="tab" href="#tab-2">Collection Report</a></li>
                            </ul>
                        </div>
                    </div>

                    <div class="panel-body">

                        <div class="tab-content">

                            <div id="tab-1" class="tab-pane active">
                                <div class="table-responsive">
                                    <table id="tbl_payment_list" class="table table-bordered">
                                    <thead>
                                    <tr>

                                        <td></td>
                                        <td>Date Paid</td>
                                        <td>Receipt #</td>
                                        <td>Account #</td>
                                        <td>Consumer</td>
                                        <td>Description</td>
										<td>Amount Paid</td>


                                    </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                                </div>
                            </div>

                            <div id="tab-2" class="tab-pane">
                                <br />
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="panel panel-default" style="padding:15px 10px 0px 10px;margin-top:-20px;">
                                            <div class="row">
                                                <div class="col-lg-3">
                                                        <label>Period Start</label>
                                                        <div class="input-group m-b">
                                                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                                            <input id="dt_start_date" name="start_date" type="text" value="<?php echo date("m/d/Y"); ?>" class="form-control has-feedback-left" aria-describedby="inputSuccess2Status3">
                                                        </div>
                                                </div>

                                                <div class="col-lg-3">
                                                    <label>Period End</label>
                                                    <div class="input-group m-b">
                                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                                        <input id="dt_end_date" name="end_date" type="text" value="<?php echo date("m/d/Y"); ?>" class="form-control has-feedback-left" aria-describedby="inputSuccess2Status3">
                                                    </div>
                                                </div>

                                                <div class="col-lg-6">

                                                    <div class="form-group">
                                                            <label>Search :</label>
                                                            <div class="input-group"><input type="text" id="txt_search" name="search" placeholder="Search" class="input-sm form-control"> <span class="input-group-btn">
                                                            <button id="btn_apply_filter" type="button" class="btn btn-sm btn-primary"> Refresh List</button> </span></div>
                                                    </div>
                                                </div>


                                            </div>



                                            <br />
                                        </div>
                                    </div>
                                </div>


                                <div class="table-responsive">
                                    <table id="tbl_collection_report" class="table table-bordered">
                                        <thead>
                                        <tr>


                                            <td>Date Paid</td>
                                            <td>Receipt #</td>
                                            <td>Account #</td>
                                            <td>Consumer</td>
                                            <td>Description</td>
                                            <td>Status</td>
                                            <td>Amount Paid</td>

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

            

        </div>
    </div><!-- /main content area -->


    <!---/invoice modal--->
    <div class="modal fade" id="payment_modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog"  style="width:70%;">
            <div class="modal-content animated bounceInRight">


                <div class="modal-body"><!--/modal body-->
                    <div class="row" style="margin-left:-25px;margin-right:-25px;"><!--/row-->
							<ul id="tab-content" class="nav nav-tabs" style="margin-left:10px;margin-right:10px;">
								<li class="active">
									<a href="#create_new_apprehended" data-toggle="tab">
										<label class="modal_label"><i class="fa fa-paste"></i> * Payment Details </span> ]</label>
									</a>
								</li>

							</ul>
													
							<div id="tabs" class="tab-content"  style="margin-left:10px;margin-right:10px;"><!-- /tab contents -->

								<div class="tab-pane fade in active" id="create_new_apprehended" style="border-bottom:1px solid #d5d4d4;border-right:1px solid #d5d4d4;border-left:1px solid #d5d4d4;padding:15px;">
									<div class="row"><!---/ row -->		
									
																
										<div class="col-lg-12"><!--column-->
											<div class="panel panel-default" style="padding:10px 10px 10px 10px;">

                                                <div class="row">





                                                    <div class="col-lg-6"><!--column-->
                                                        <div class="form-group">
                                                            <label>C<u>o</u>nsumer *</label>
                                                            <select id="cbo_consumer" style="color:white;" name="customer" class="selectpicker show-tick form-control" data-live-search="true"  data-message="Please make sure you enter Consumer name." title="Please select Consumer." required>



                                                                <?php foreach($consumers as $consumer){  ?>

                                                                    <option value="<?php echo $consumer->bill_account_id; ?>" data-consumer-id="<?php echo $consumer->consumer_id; ?>"><?php echo "[ ".$consumer->account_no." ] ".$consumer->consumer; ?></option>

                                                                <?php } ?>



                                                            </select>
                                                        </div>
                                                    </div>


                                                </div>
												

											</div>
										</div>
												

											
										
									</div>


									

									<div class="row">
										<div class="col-lg-12">
                                            <div class="table-responsive" style="overflow-y: scroll;height: 450px;">
											    <table id="tbl_item_schedule" class="table table-bordered">
																				<thead>
																					<tr>
                                                                                        <td></td>
																						<td>Due Date</td>
																						<td style="text-align:right">Due Amount</td>
																						<td><strong>* Receipt #</strong></td>
                                                                                        <td><strong>* Txn Date (mm/dd/yyyy)</strong></td>
																						<td style="text-align:right"><strong>* Payment Amount</strong></td>
																						<td>Action</td>
																					</tr>
																				</thead>
																				<tbody>

																				</tbody>
																				
																				<tfoot>
                                                                                    <tr>
                                                                                        <td colspan="5" align="right"><h3>Total</h3></td>
                                                                                        <td><h3>0.00</h3></td>
                                                                                    </tr>

																				</tfoot>
											</table>
                                            </div>
										</div>									
									</div>
								</div>


                            </div><!-- /tab contents -->
												
					</div>	
					
					
					
                </div><!--/modal body-->

                <div class="modal-footer">
                    <button id="btn_save_record" type="button" class="btn btn-primary"><i class="fa fa-save"></i> <u>S</u>ave this Record </button>
                    <button type="button" class="btn btn-white" data-dismiss="modal"><u>C</u>lose</button>
                </div>
            </div>
        </div>
    </div><!---/invoice modal--->


    <div id="confirm-modal" data-save-mode="" class="modal fade" tabindex="-1" role="dialog"><!--modal-->
        <div class="modal-dialog modal-sm">
            <div class="modal-content"><!---content--->
                <div class="modal-header">
                    <button type="button" class="close"   data-dismiss="modal" aria-hidden="true">X</button>
                    <h4 class="modal-title"><span id="modal_mode"> </span>Cancel OR</h4>

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


    <!-- /footer -->
    <?php $this->load->view('templates/footer'); ?>
    <!-- /footer -->


</div>
</div>



<?php include('assets/includes/global_js.php'); ?>

<!--- Dropdown / Selectpicker --->
<script src="assets/css/dropdown-enhance/dist/js/bootstrap-select.min.js"></script>
<script src="assets/js/plugins/typehead/bootstrap3-typeahead.js"></script>

<!-- iCheck -->
<script src="assets/js/plugins/iCheck/icheck.min.js"></script>



<!-- Datepicker -->
<script src="assets/js/plugins/moment.min2.js"></script>
<script src="assets/js/plugins/datepicker/daterangepicker.js"></script>


<!-- Data Tables -->
<script src="assets/js/plugins/dataTables/jquery.dataTables.js"></script>
<script src="assets/js/plugins/dataTables/dataTables.bootstrap.js"></script>
<script src="assets/js/plugins/dataTables/dataTables.responsive.js"></script>
<script src="assets/js/plugins/dataTables/dataTables.tableTools.min.js"></script>

<!-- sparkline -->
<script src="assets/js/plugins/sparkline/jquery.sparkline.min.js"></script>

<!-- i checks -->
<script src="assets/js/plugins/iCheck/icheck.min.js"></script>

<!-- Peity -->
<script src="assets/js/plugins/peity/jquery.peity.min.js"></script>
<!-- date -->
<script src="assets/js/plugins/date/date.js"></script>

<!-- PNotify -->
<script type="text/javascript" src="assets/js/plugins/notify/pnotify.core.js"></script>
<script type="text/javascript" src="assets/js/plugins/notify/pnotify.buttons.js"></script>
<script type="text/javascript" src="assets/js/plugins/notify/pnotify.nonblock.js"></script>

<script src="assets/js/plugins/formatter/accounting.js"></script>

<script src="assets/js/defined/record.payment.event.handlers.js"></script>

</body>

</html>
