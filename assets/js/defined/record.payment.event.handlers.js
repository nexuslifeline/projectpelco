var tbl_item_schedule;
var oSchedTable={
            "icon"          :       "td:eq(0)",
            "due_date"      :       "td:eq(1)",
            "due_amount"    :       "td:eq(2)",
            "receipt_no"    :       "td:eq(3)",
            "txn_date"      :       "td:eq(4)",
            "pay_amount"    :       "td:eq(5)",
            "action"        :       "td:eq(6)"

};


$(document).ready(function(){


    /**
     * list of payments/History
     */
    var dtPaymentList=(function(){
            var tbl_payment_list;

            var initializePaymentListDatatable=(function(){
                tbl_payment_list=$('#tbl_payment_list').DataTable({
                    "bLengthChange": false,
                    "order": [[0, "desc"]],
                    "dom": '<"toolbar">frtip',
                    "oLanguage": {
                        "sSearch": "Search: ",
                        "sProcessing": "Please wait..."
                    }
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


    /**
     * item schedule list on modal
     */
    var dtItemScheduleList=(function(){


        var initializeItemScheduleList=(function(){
            tbl_item_schedule=$('#tbl_item_schedule').DataTable({
                "bLengthChange": false,
                "order": [[0, "desc"]],
                "dom": '<"toolbar">frtip',
                "oLanguage": {
                    "sSearch": "Search: ",
                    "sProcessing": "Please wait..."
                },
                "rowCallback":function( row, data, index ){

                    $(oSchedTable.due_amount,row).attr({
                        "align":"right"
                    });

                    $([oSchedTable.receipt_no,oSchedTable.pay_amount,oSchedTable.txn_date].join(),row).attr(
                        {"contenteditable": "true"}
                    );

                    $(oSchedTable.action,row)
                        .html('<button class="btn btn-success">Pay</button><span> </span><button class="btn btn-warning">Clear</button>')
                        .attr({
                            "align":"center"
                        });

                }
            });

        })();



    })();



    $('#cbo_consumer').change(function(){
        $('#tbl_item_schedule tbody').html('<tr><td colspan="7" align="center"><img src="assets/img/ajax-loader-sm.gif" /></td></tr>');

        $.getJSON('RecordPaymentController/ActionShowScheduleBalances',{id:41}, function(response){
            //console.log(response);
            tbl_item_schedule.clear().draw();

            $.each(response,function(index,data){
               //alert(data.item_id)
                tbl_item_schedule.row.add([
                    "",
                    data.sched_payment_date,
                    data.due_amount,
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



});