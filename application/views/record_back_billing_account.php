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




    <style>
        .toolbar{
            float: left;
        }


        .tools,.print_ledger {
            float: left;
            margin-bottom:5px;
        }

        [contenteditable="true"]:active,
        [contenteditable="true"]:focus{
            border:3px solid #F5C116;
            outline:none;

            background: white;
        }


        #tbl_apprehended_consumer_list > tbody > tr:hover { cursor: pointer; cursor: hand; }

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
                    <h2 style="block:inline;"><i class="fa fa-users"></i> Record Apprehended Consumer Account </h2>

                </div>

                <div class="mail-box" style="padding-left:10px;padding-right:10px;">


                    <div class="panel-heading">
                        <div class="panel-options">
                            <ul class="nav nav-tabs">
                                <li class="active"><a data-toggle="tab" href="#tab-1">Apprehended Account(s)</a></li>
                                <li class=""><a data-toggle="tab" href="#tab-2">Account Info</a></li>
                                <li class=""><a data-toggle="tab" href="#tab-3">Consumer Ledger</a></li>
                                <li class=""><a data-toggle="tab" href="#tab-4">Deliquent Consumer List</a></li>
                            </ul>
                        </div>
                    </div>

                    <div class="panel-body">
                        <div class="tab-content">
                            <!--/tab 1-->
                            <div id="tab-1" class="tab-pane active">
                                <div class=" table-responsive">
                                <table id="tbl_apprehended_consumer_list" class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <td></td>
                                        <td>Reference #</td>
                                        <td>Account #</td>
                                        <td>Consumer</td>  
										<td>Contact No</td>  
										<td>Payable Period</td>
                                        <td style="text-align:right;">Amount</td>
                                        <td style="text-align:right;">Total Balance</td>
                                        <td>Action</td>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                                </div>
                            </div><!--/tab 1-->

                            <!--/tab 2-->
                            <div id="tab-2" class="tab-pane">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <b>Apprehended Account Information</b>
                                            </div>
                                            <div class="panel-body">
                                                <table  width="100%" style="font-size: 14px;" cellpadding="10">
                                                    <tr>
                                                        <td width="10%"><b>Reference # : </b></td>
                                                        <td id="cell_referebce_no" width="40%" style="padding-left:40px;" >1211111</td>
                                                        <td width="10%"><b>Account # : </b></td>
                                                        <td id="cell_account_no" width="40%" style="padding-left:40px;">AC1211111</td>
                                                    </tr>

                                                    <tr>
                                                        <td><b>Consumer   : </b></td>
                                                        <td id="cell_consumer" style="padding-left:40px;">Paul Christian Rueda</td>
                                                        <td><b>Duration   : </b></td>
                                                        <td id="cell_duration" style="padding-left:40px;">10 months</td>
                                                    </tr>

                                                    <tr>
                                                        <td><b>Start Date : </b></td>
                                                        <td id="cell_start_date" style="padding-left:40px;">01/28/2016</td>
                                                        <td><b>Total Amount : </b></td>
                                                        <td id="cell_total_amount" style="padding-left:40px;color: red;">1,500.00</td>
                                                    </tr>
                                                </table>

                                            </div>







                                        </div>
                                    </div>
                                </div>
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <b>Schedule of Payment</b>
                                    </div>
                                    <div class="panel-body">

                                        <table id="tbl_payment_schedule_list" class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <td>Payment Schedule</td>
                                        <td>Descriptoin</td>
                                        <td style="text-align:right;">Amount Due</td>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php for($i=0;$i<=10;$i++){ ?>
                                        <tr>
                                            <td>January 1, 2015</td>
                                            <td>August 2014</td>
											<td align="right">2,100.00</td>
                                        </tr>
                                    <?php } ?>
                                    </tbody>
									<tfoot>
										<tr>
											<td colspan="2" align="right"><h3>Total Back Bill Amount</h3></td>
											<td id="cell_total_back_bill_amount" align="right" style="color:red;"><strong>24,000.00</strong></td>
										</tr>
									</tfoot>
                                </table>
                                    </div>

                                </div>

                            </div><!--/tab 2-->


                            <div id="tab-3" class="tab-pane">
                                <table id="tbl_customer_ledger" class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <td>Date</td>
                                        <td>Account #</td>
                                        <td>Receipt #</td>
                                        <td>Description</td>
                                        <td>Debit</td>
                                        <td>Credit</td>
                                        <td>Balance</td>
                                    </tr>
                                    </thead>

                                    <tbody>

                                    </tbody>


                                </table>

                            </div>


							<div id="tab-4" class="tab-pane">
								<table id="tbl_receivables_aging" class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <td>Account #</td>
										<td>Consumer</td>
                                        <td style="text-align:right;">Apprehended Amount</td>
                                        <td style="text-align:right;">Total Paid</td>
                                        <td style="text-align:right;">Total Balance</td>
                                        <td style="text-align:right;"># of Payments Made</td>
                                        <td style="text-align:right;"># of Month(s) Delayed</td>
                                        <td style="text-align:right;">Previous Balance</td>

                                    </tr>
                                    </thead>

                                    <tbody>
                                    <?php for($i=0;$i<=10;$i++){ ?>
                                        <tr>
                                            <td>AC12000</td>
											<td>Paul Christian Rueda</td>
                                            <td align="right">22,600</td>
                                            <td align="right">1,000</td>
                                            <td align="right">21,600</td>
                                            <td align="right">5</td>
                                            <td align="right">3</td>
                                            <td align="right">1,900.00</td>
                                        </tr>
                                    <?php } ?>
                                    </tbody>


                                </table>

							</div>

                        </div>
                    </div>
                </div>

            </div>

            

        </div>
    </div><!-- /main content area -->


    <!---/invoice modal--->
    <div class="modal fade" id="apprehended_consumer_modal" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" >
        <div class="modal-dialog"  style="width:70%;">
            <div class="modal-content animated bounceInRight">


                <div class="modal-body"><!--/modal body-->
                    <div class="row" style="margin-left:-25px;margin-right:-25px;"><!--/row-->
							<ul id="tab-content" class="nav nav-tabs" style="margin-left:10px;margin-right:10px;">
								<li class="active">
									<a href="#create_new_apprehended" data-toggle="tab">
										<label class="modal_label"><i class="fa fa-paste"></i> * Account Information [ <span class="text-navy"><u>Step 1</u></span> ]</label>
									</a>
								</li>
                                <li class="">
                                    <a href="#create_payment_schedule" data-toggle="tab">
                                        <label class="modal_label"><i class="fa fa-calendar"></i> * Payment Schedule [ <span class="text-navy"><u>Step 2</u></span> ]</label>
                                    </a>
                                </li>
							</ul>
													
							<div id="tabs" class="tab-content"  style="margin-left:10px;margin-right:10px;"><!-- /tab contents -->

								<div class="tab-pane fade in active" id="create_new_apprehended" style="border-bottom:1px solid #d5d4d4;border-right:1px solid #d5d4d4;border-left:1px solid #d5d4d4;padding:15px;">
									<div class="row"><!---/ row -->		
									<form id="frm_account_details">
										<div class="col-lg-4"><!--column-->	
											<div class="panel panel-default" style="padding:10px 10px 10px 10px;">
												<div class="form-group">
															<label>Reference #</label>
															<input class="form-control" type="text" name="reference_no" placeholder=""  data-container="body" data-trigger="manual" data-toggle="tooltip" title="Employee number is required.">
												</div>
											
												<div class="form-group">
															<label>Account No *</label>
															<input class="form-control" type="text" name="account_no"  data-container="body" data-trigger="manual" data-toggle="tooltip" title="Employee number is required.">
												</div>

                                                <div class="form-group">
                                                    <label> <input type="checkbox" value="1" checked="checked" name="chk_is_active"> Active</label>
                                                </div>

                                                <br />
												

											</div>
										</div>
												
										<div class="col-lg-8">
												
												<ul id="tab-content-2" class="nav nav-tabs" style="margin-left:10px;margin-right:10px;">
													<li class="active">
														<a href="#tab-consumer-info" data-toggle="tab">
															<label class="modal_label">Consumer Info *</label>
														</a>
													</li>
													
													<li class="">
														<a href="#tab-consumer-address-2" data-toggle="tab">
															<label class="modal_label">Consumer Address *</label>
														</a>
													</li>
												</ul>
												
												
												
												<div id="tabs-consumer" class="tab-content"  style="margin-left:10px;margin-right:10px;"><!-- /tab contents -->

                                                    <div class="tab-pane fade in active" id="tab-consumer-info" style="border-bottom:1px solid #d5d4d4;border-right:1px solid #d5d4d4;border-left:1px solid #d5d4d4;padding:15px;">
                                                        <div class="row">
                                                            <div class="col-lg-12">
                                                                <div class="form-group">
                                                                    <label>Consumer Name *</label>
                                                                    <input type="text" name="consumer_name" class="form-control"  data-message="Please make sure you enter Consumer name." data-container="body" data-trigger="manual" data-toggle="tooltip" title="Enter Consumer name here." required>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-lg-6">
                                                                <div class="form-group">
                                                                    <label>Mobile #</label>
                                                                    <input type="text" name="contact_no" class="form-control">
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-6">
                                                                <div class="form-group">
                                                                    <label>Email</label>
                                                                    <input type="text" name="email" class="form-control">
                                                                </div>
                                                            </div>

                                                        </div>


                                                    </div>
                                                    <div class="tab-pane" id="tab-consumer-address-2" style="border-bottom:1px solid #d5d4d4;border-right:1px solid #d5d4d4;border-left:1px solid #d5d4d4;padding:15px;">


                                                        <div class="row">
                                                            <div class="col-lg-6">
                                                                <div class="form-group">
                                                                    <label>House #</label>
                                                                    <input type="text" name="house_no" class="form-control">
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-6">
                                                                <div class="form-group">
                                                                    <label>Street</label>
                                                                    <input type="text" name="street_no" class="form-control">
                                                                </div>
                                                            </div>

                                                        </div>

                                                        <div class="row">
                                                            <div class="col-lg-6">
                                                                <div class="form-group">
                                                                    <label>Barangay *</label>
                                                                    <input type="text" name="barangay" class="form-control">
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-6">
                                                                <div class="form-group">
                                                                    <label>Municipality *</label>
                                                                    <input type="text" name="municipality" class="form-control">
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
										</div>
                                    </form>

									</div>
										<br />
									<div class="row">
											<div class="col-lg-12">
												<div class="panel panel-default" style="padding:15px 10px 0px 10px;margin-top:-20px;">
													<div class="form-group">																		
														<div class="input-group">																			
															<input type="text" id="plu_typehead" data-provide="typeahead" class="form-control" placeholder="Search Unit here"> 
																<span class="input-group-btn">																				
																<button type="button" class="btn btn-primary">Browse List</button>
															</span>
																					
														</div>
													</div>
												</div>
											</div>
									</div>
									

									<div class="row">
										<div class="col-lg-12">
											<table id="tbl_item_cart" class="table table-bordered">
																				<thead>
																					<tr>																					
																						<td>Unit Description</td>
																						<td style="text-align:right">KWH</td>
																						<td style="text-align:right">Unit Qty</td>
																						<td style="text-align:right">Hour(s)</td>	
																						<td style="text-align:right">Total KWH</td>
																						<td>Action</td>
																					</tr>
																				</thead>
																				<tbody>

																				</tbody>
																				
																				<tfoot>
																					<tr>
																						<td colspan="2" align="right"><strong>Amount per KWH</strong></td>
																						<td align="right" style="color:red;"  contenteditable="true"><strong>9.00</strong></td>
																						<td align="right"><strong>Total KWH</strong></td>
																						<td align="right" style="color:red;"><strong>0</strong></td>
																						<td>KWH</td>
																					</tr>
																					<tr>
																						<td colspan="2" align="right"><strong>Downpayment</strong></td>
																						<td align="right" style="color:red;" contenteditable="true"><strong>0.00</strong></td>
																						<td align="right"><strong>No. of Day(s)</strong></td>
																						<td align="right" style="color:red;"  contenteditable="true"><strong>0</strong></td>
																						<td>Day(s)</td>
																					</tr>
																					<tr>
																						<td colspan="4" align="right"><h3>Net Amount</h3></td>
																						<td colspan="2" align="right" style="color:red"><h3>0.00</h3></td>
																					</tr>
																				</tfoot>
											</table>
										</div>									
									</div>
								</div>



                                <div class="tab-pane" id="create_payment_schedule" style="border-bottom:1px solid #d5d4d4;border-right:1px solid #d5d4d4;border-left:1px solid #d5d4d4;padding:15px;">
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <form id="frm_payment_sched_details">
                                            <div class="panel panel-default" style="padding: 10px;">
                                                <div class="form-group">
                                                    <label>* Payment Start Date</label>
                                                    <input id="payment_start" type="text" name="payment_start" class="form-control" value="12/06/2015">
                                                </div>

                                                <div class="form-group">
                                                    <label>* Duration (Month(s))</label>
                                                    <input id="txt_duration" class="form-control" type="number" name="duration"  data-container="body" data-trigger="manual" data-toggle="tooltip" title="Employee number is required.">
                                                </div>
                                            </div>

                                            <div class="panel panel-default" style="padding: 10px;">
                                                <div class="form-group">
                                                    <label>Remarks </label>
                                                   <textarea name="payment_schedule_remarks" class="form-control"></textarea>
                                                </div>
                                            </div>
                                            </form>
                                        </div>

                                        <div class="col-lg-8">
                                            <div class="row">

                                                <div class="col-lg-12">
                                                    <div class="panel panel-default" style="padding: 10px;">
                                                        <table id="tbl_payment_schedule" class="table table-bordered">
                                                            <thead>
                                                            <tr>
                                                                <td>Txn Date</td>
                                                                <td style="text-align:right;">Amount</td>
                                                                <td>Notes</td>
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

                            </div><!-- /tab contents -->
												
					</div>	
					
					
					
                </div><!--/modal body-->

                <div class="modal-footer">
                    <button id="btn_create_app_account" type="button" class="btn btn-primary"><i class="fa fa-save"></i> <u>S</u>ave this Record </button>
                    <button type="button" class="btn btn-white" data-dismiss="modal"><u>C</u>lose</button>
                </div>
            </div>
        </div>
    </div><!---/invoice modal--->



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
<script src="assets/js/plugins/datapicker/bootstrap-datepicker.js"></script>

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

<!-- PNotify -->
<script type="text/javascript" src="assets/js/plugins/notify/pnotify.core.js"></script>
<script type="text/javascript" src="assets/js/plugins/notify/pnotify.buttons.js"></script>
<script type="text/javascript" src="assets/js/plugins/notify/pnotify.nonblock.js"></script>



<script src="assets/js/plugins/date/date.js"></script>

<script src="assets/js/plugins/formatter/accounting.js"></script>

<script src="assets/js/defined/billing.account.event.handlers.js"></script>

</body>

</html>
