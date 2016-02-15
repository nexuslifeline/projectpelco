
var tbl_item_schedule;
var tbl_collection_report;

var oSchedTable={
            "body"          :       "#tbl_item_schedule > tbody",
            "icon"          :       "td:eq(0)",
            "due_date"      :       "td:eq(1)",
            "due_amount"    :       "td:eq(2)",
            "receipt_no"    :       "td:eq(3)",
            "txn_date"      :       "td:eq(4)",
            "pay_amount"    :       "td:eq(5)",
            "action"        :       "td:eq(6)"

};



var tbl_payment_list;

var oPaymentList={
    "body"          :       "#tbl_payment_list > tbody",
    "status"          :       "td:eq(0)",
    "date_paid"      :       "td:eq(1)",
    "receipt_no"    :       "td:eq(2)",
    "account_no"    :       "td:eq(3)",
    "consumer"      :       "td:eq(4)",
    "description"    :       "td:eq(5)",
    "amount_paid"      :       "td:eq(6)"

};




$(document).ready(function(){



    /**
     * list of payments/History
     */
    var dtPaymentList=(function(){



            var initializePaymentListDatatable=(function(){
                tbl_payment_list=$('#tbl_payment_list').DataTable({
                    "bLengthChange": false,
                    "order": [[0, "asc"]],
                    "dom": '<"toolbar">frtip',
                    "oLanguage": {
                        "sSearch": "Search: ",
                        "sProcessing": "Please wait..."
                    },

                    "columnDefs": [
                        //column 1
                        {

                            'targets':[0]
                            ,
                            'render': function(data, type, full, meta){
                                if(data==1){

                                    return "<center><a href='#' ><i  class='fa fa-check' style='color: green;'></i></a></center>";

                                }else{

                                    return "<center><a href='#' ><i  class='fa fa-remove' style='color: red;'></i></a></center>";
                                }
                            }

                        }
                    ]


                    ,
                    "rowCallback":function( row, data, index ){
                        $(oPaymentList.amount_paid,row).attr({
                            "align":"right"
                        });
                    }

                });

            })();


        var bindEventHandlers=(function(){
            /**
             *
             *	fires when edit invoice button on selected row is clicked
             *
             */


            $('#tbl_payment_list tbody').on('click','a[href="#"]',function(){
                var row=$(this).closest('tr');
                var stat = row.find('i');
                var receipt_no = row.find('td').eq(2).text();
                if(stat.hasClass('fa-check')) {
                    cancelEntry.showCancelModal();
                    $('#btn_yes').click(function(){
                        $.ajax({
                            "dataType":"JSON",
                            "type":"POST",
                            "url":"RecordPaymentController/ActionCancelReceipt",
                            "data": {receipt_no:receipt_no}
                        })
                        .success(function(response){ //if request is successful
                            if(response.stat=='success'){
                                stat.removeClass('fa-check');
                                stat.addClass('fa-remove')
                                stat.attr('style',"color:red");
                            };

                        })
                            .error(function(xhr,stat,error){ //if error occurs
                                alert(xhr.responseText);
                                console.log(xhr);
                            });


                    });

                }
            });






        })();

        var showPaymentList=(function(){
                $('#tbl_payment_list tbody').html('<tr><td colspan="7" align="center"><img src="assets/img/ajax-loader-sm.gif" /></td></tr>');

                $.getJSON('RecordPaymentController/ActionShowPaymentList', function(response){
                    //console.log(response);
                    tbl_payment_list.clear().draw();
                    $.each(response,function(index,value){

                        tbl_payment_list.row.add([
                            value.is_active,
                            value.date_paid,
                            value.receipt_no,
                            value.account_no,
                            value.consumer_name,
                            value.item_description,
                            value.payment_amount
                        ]).draw();

                    });

                });
            })();



            var createToolBarButton=(function(){
                var _btnNew='<button class="btn btn-white btn-sm"  id="btn-new" data-toggle="tooltip" data-placement="left" title="Record Payment" ><i class="fa fa-paste"></i> Record Payment</button>';
                $("div.toolbar").html(_btnNew);
            })();




    })();





    /**
     * payment entry modal
     */
    var modalPaymentEntry=(function(){

        var showModal=function(){
            $('#payment_modal').modal('show');
        };

        return {
            showModal       :       showModal
        };

    })();







    var cancelEntry=(function(){
        var showCancelModal=function(){
            $('#confirm-modal').modal('show');
        };

        return {
            showCancelModal       :       showCancelModal
        };

    })();

    /**
     * item schedule list on modal
     */
    var dtItemScheduleList=(function(){

        var iconInvalid="<i class='fa fa-exclamation-triangle' style='color: #ff0000;padding-right:10px;'></i>";

        var bindEventHandlers=(function(){

            /**
             * fires when Editable cell has key being pressed
             */
            $(oSchedTable.body).on(
                'keypress',
                'td',
                function(event) {


                    //payment amount
                    if($(this).index()==getCellIndex(oSchedTable.pay_amount)){
                        if(event.keyCode==13){ //if enter is pressed
                            //make sure unformatted number is updated to cached data
                            updateCachedData(tbl_item_schedule,this); //update cached data of payment cell

                                $(this).html(
                                    accounting.formatNumber($(this).text(),2)
                                ).blur();



                        }else{
                            return isNumber(event,this);
                        }
                    }

                    //txn date
                    if($(this).index()==getCellIndex(oSchedTable.txn_date)){
                        if(event.keyCode==13){ //if enter is pressed
                            //make sure unformatted number is updated to cached data
                            updateCachedData(tbl_item_schedule,this); //update cached data of payment cell
                            $(this).blur();
                        }else{
                            return isDateFormat(event,this);
                        }
                    }


                    //receipt
                    if($(this).index()==getCellIndex(oSchedTable.receipt_no)){
                        if(event.keyCode==13){ //if enter is pressed
                            //make sure unformatted number is updated to cached data
                            updateCachedData(tbl_item_schedule,this); //update cached data of payment cell
                            $(this).blur();
                            return false;
                        }else{
                            return true;
                        }
                    }







                }
            );





            $(oSchedTable.body).on(
                'blur',
                'td',
                function(event) {
                    var row=$(this).closest("tr");
                    updateCachedData(tbl_item_schedule,this);

                    //if one of the cell is not empty
                    if($(oSchedTable.receipt_no,row).text()!=""||$(oSchedTable.txn_date,row).text()!=""||parseFloat($(oSchedTable.pay_amount,row).text())>0){
                        $([oSchedTable.receipt_no,oSchedTable.txn_date,oSchedTable.pay_amount].join(),row).each(function(){

                                if($(this).text()==""){ //if current cell is empty show invalid icon
                                    $(this).html(iconInvalid);

                                }else{ //if current cell is not empty

                                    if($(this).index()==getCellIndex(oSchedTable.pay_amount)) {
                                        var dueAmount = parseFloat(accounting.unformat($(oSchedTable.due_amount, row).text()));
                                        var payAmount = parseFloat(accounting.unformat($(this).text()));

                                        if (dueAmount < payAmount) {
                                            $(this).html(
                                                iconInvalid +
                                                accounting.formatNumber(payAmount, 2)
                                            );
                                        } else {
                                            $(this).html(
                                                accounting.formatNumber(payAmount, 2)
                                            );
                                        }
                                    }else if($(this).index()==getCellIndex(oSchedTable.txn_date)){
                                            if(isValidDateFormat($(this).text())){
                                                $(this).html(
                                                    $(this).text()
                                                );
                                            }else{
                                                $(this).html(
                                                    iconInvalid +
                                                    $(this).text()
                                                );
                                            }
                                    }else{
                                        if($(this).find("i").length>0){ //if icon is already shown, remove it because cell is not empty
                                            $(this).html($(this).text());
                                        }else{

                                        }
                                    }



                                }
                        });

                    }else{ //this means all cells are empty, but the user had done changes on editable cells
                        //so make sure editables is empty and no icon is shown
                        $([oSchedTable.receipt_no,oSchedTable.txn_date,oSchedTable.pay_amount].join(),row).each(function(){
                            $(this).html("");
                        });
                    }


                    //
                    //
                    // updateCachedData(tbl_item_schedule,this);

                }
            );

        })();



        var initializeItemScheduleList=(function(){
            tbl_item_schedule=$('#tbl_item_schedule').DataTable({
                "bPaginate":false,
                "bLengthChange": false,

                "dom": '<"toolbar">frtip',
                "oLanguage": {
                    "sSearch": "Search: ",
                    "sProcessing": "Please wait..."
                },
                "rowCallback":function( row, data, index ){


                    $([oSchedTable.due_amount,oSchedTable.pay_amount].join(),row).attr({
                        "align":"right"
                    });

                    $([oSchedTable.receipt_no,oSchedTable.pay_amount,oSchedTable.txn_date].join(),row).attr(
                        {"contenteditable": "true"}
                    );

                    $(oSchedTable.action,row)
                        .html('<button class="btn btn-success">Enter Exact</button><span> </span><button class="btn btn-warning">Clear</button>')
                        .attr({
                            "align":"center"
                        });

                }
            });

        })();



    })();


    /**
     * collection report datatable
     */
    var dtCollectionReportList=(function(){

        var initializeCollectionDatatable=(function(){
            tbl_collection_report=$('#tbl_collection_report').DataTable({
                "bFilter":false,
                "bPaginate": false,
                "bLengthChange": false,
                "dom": '<"print_collection">frtip',
                "oLanguage": {
                    "sSearch": "Search: ",
                    "sProcessing": "Please wait..."
                },
                "rowCallback":function( row, data, index ){
                    $("td:eq(6)",row).attr({
                        "align":"right"
                    });
                }
            });
        })();


        var createToolBarButton=(function(){
            var _btnPrint='<a href="RecordPaymentController/ActionPreviewCollectionReport" target="_blank"><button class="btn btn-white btn-sm"  id="btn_print_collection" data-toggle="tooltip" data-placement="left" title="Print Collection" ><i class="fa fa-paste"></i> Print Collection Report</button></a>';
            $("div.print_collection").html(_btnPrint);
        })();



    })();


    $(document).on('click','#btn_print_collection',function(){

        var _start=$('#dt_start_date').val();
        var _end=$('#dt_end_date').val();
        var _param=$('#txt_search').val();

        $(this).closest("a").attr("href","RecordPaymentController/ActionPreviewCollectionReport?start="+_start+"&end="+_end+"&param="+_param);
    });


    $('#cbo_consumer').change(function(){
        $('#tbl_item_schedule tbody').html('<tr><td colspan="7" align="center"><img src="assets/img/ajax-loader-sm.gif" /></td></tr>');

        var consumer_id=$(this).val();

        $.getJSON('RecordPaymentController/ActionShowScheduleBalances',{id:consumer_id}, function(response){

            //console.log(response);
            tbl_item_schedule.clear().draw();

            $.each(response,function(index,data){
               //alert(data.item_id)
                tbl_item_schedule.row.add([

                    data.item_id,
                    data.sched_payment_date,
                    accounting.formatNumber(data.Remaining,2),

                    "",
                    "",
                    "",
                    ""
                ]).draw();
            });

        });
    });


    $('#btn-new').click(function(){
        modalPaymentEntry.showModal();
    });


    $('#btn_save_record').click(function(){
        savePayment().success(function(response){

            var resultset=response.rows;

            PNotify.removeAll(); //remove all notifications
            new PNotify({
                title: 'Success!',
                text:  response.msg,
                type:  response.stat
            }); //create new notification base on server response

            $("#cbo_consumer").selectpicker('deselectAll')
                .val('')
                .selectpicker('refresh'); //refresh and render changes
            tbl_item_schedule.clear().draw();


            $.each(resultset,function(index,value){

                tbl_payment_list.row.add([
                    value.is_active,
                    value.date_paid,
                    value.receipt_no,
                    value.account_no,
                    value.consumer_name,
                    value.item_description,
                    value.payment_amount
                ]).draw();

            });




        });
    });


    $('#payment_modal').on('hidden.bs.modal', function() {
        $("#cbo_consumer").selectpicker('deselectAll')
            .val('')
            .selectpicker('refresh'); //refresh and render changes
        tbl_item_schedule.clear().draw();
    });


    $('#dt_end_date,#dt_start_date').daterangepicker({
        singleDatePicker: true,
        calender_style: "picker_4"
    }, function (start, end, label) {
        console.log(start.toISOString(), end.toISOString(), label);
    });

    /**
     * User defined Functions
      * @param evt
     * @param element
     * @returns {boolean}
     */

    //function that returns true if element character is valid(number and 1 decimal point)
    var isNumber=function (evt, element) {
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if(
            /*(charCode != 45 || $(element).text().indexOf('-') != -1) &&      */
        (charCode != 46 || $(element).text().indexOf('.') != -1) &&      // “.” check DOT, and only one
        (charCode < 48 || charCode > 57)) {
            return false;
        } else {
            return true;
        }
    };

    var isDateFormat=function (evt, element) {
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if(
            /*(charCode != 45 || $(element).text().indexOf('-') != -1) &&      */
        (charCode != 46 || $(element).text().indexOf('.') != -1) &&      // “.” check DOT, and only one
        (charCode < 48 || charCode > 57) && (charCode!=47)) { //check if "/" is pressed
            return false;
        } else {
            return true;
        }
    };

    var updateCachedData=function(dtInstance,cell){
        dtInstance
            .cell(  $(cell) )
            .data(  $(cell).text()  );
    };

    var getCellIndex=function(cell){
        return $( cell ).index();
    };

    var isValidDateFormat=function(dateSerial){
        return true;// this is temporary
    };


    var savePayment=function(){
        var serialData=[];

        tbl_item_schedule.rows().eq(0).each(function(index){
            var row = tbl_item_schedule.row(index);
            var data = row.data();

            if(parseFloat(data[getCellIndex(oSchedTable.pay_amount)])>0){
                serialData.push(
                    {"name"  :  "itemid[]"   ,"value"   :   data[getCellIndex(oSchedTable.icon)]   },
                    {"name"  :  "description[]"   ,"value"   :   data[getCellIndex(oSchedTable.due_date)]   },
                    {"name"  :  "payamount[]"   ,"value"   :   parseFloat(data[getCellIndex(oSchedTable.pay_amount)])   },
                    {"name"  :  "txndate[]"   ,"value"      :      data[getCellIndex(oSchedTable.txn_date)]   },
                    {"name"  :  "receiptno[]"   ,"value"   :      parseFloat(data[getCellIndex(oSchedTable.receipt_no)])   },
                    {"name"  :  "dueamount[]"   ,"value"   :      parseFloat(data[getCellIndex(oSchedTable.due_amount)])   }
                );
            }

        });

        serialData.push({
            "name"  : "accountid",
            "value" :  $("#cbo_consumer").val()
        });




        return $.ajax({
            "dataType":"json",
            "type":"POST",
            "url":"RecordPaymentController/ActionSaveNewPayment",
            "data":serialData
        });

    };




    var showCollectionReportList=(function(){
        $('#tbl_collection_report tbody').html('<tr><td colspan="7" align="center"><img src="assets/img/ajax-loader-sm.gif" /></td></tr>');

        var startDate=$('#dt_start_date').val();
        var endDate=$('#dt_end_date').val();
        var param=$('#txt_search').val();

        $.getJSON('RecordPaymentController/ActionShowCollectionList',{start:startDate,end:endDate,param:param}, function(response){
            //console.log(response);
            tbl_collection_report.clear().draw();

            $.each(response,function(index,value){
                tbl_collection_report.row.add([
                    value.date_paid,
                    value.receipt_no,
                    value.account_no,
                    value.consumer_name,
                    value.description,
                    value.is_active,
                    accounting.formatNumber(value.amount_paid,2)
                ]).draw();

            });

        });
    });

    showCollectionReportList();

    $('#btn_apply_filter').click(function(){
        showCollectionReportList();
    });


});

