
var tbl_payment_schedule_list; //Bos dens, nag global nako para mabilis.. hehe
var tbl_customer_ledger;
var selected_account_id;
var tbl_apprehended_consumer_list;
var tbl_deliquent_list;

var tbl_item_cart;

/**
 * returns specific dom element on item cart table
 * @type {{id: string, body: string, footer: string}}
 */
var oTable={
    "id"        :   "#tbl_item_cart",
    "body"      :   "#tbl_item_cart > tbody",
    "footer"    :   "#tbl_item_cart > tfoot"
};
/**
 * cell index of item cart details
 * @type {{desc: string, kwh: string, qty: string, hrs: string, total: string, action: string}}
 */
var oTBody={
    "desc"          :   "td:eq(0)",
    "kwh"           :   "td:eq(1)",
    "qty"           :   "td:eq(2)",
    "hrs"           :   "td:eq(3)",
    "total"         :   "td:eq(4)",
    "action"        :   "td:eq(5)"
};

/**
 * cell index of item cart list footer
 * @type {{amount: string, dp: string, days: string}}
 */
var oTFoot={
    "amount"        :   "tr:eq(0) > td:eq(1)",
    "totalKWH"      :   "tr:eq(0) > td:eq(3)",
    "dp"            :   "tr:eq(1) > td:eq(1)",
    "days"          :   "tr:eq(1) > td:eq(3)",
    "net"           :   "tr:eq(2) > td:eq(1)"
};


$(document).ready(function(){
    /**********************************************************************************************************************************************************/
    //consumer apprehended list module and table
    var apprehendedConsumerModule=(function(){

        var bindEventHandlers=(function(){
            /**
             *
             *	fires when edit invoice button on selected row is clicked
             *
             */
            $('#tbl_apprehended_consumer_list tbody').on('dblclick','tr',function(){
                $(this).find('button[name="edit_account"]').click();
            });


            $('#tbl_apprehended_consumer_list tbody').on('click','button[name="edit_account"]',function(){
                var row=$(this).closest('tr');

                apprehendedInfoModalModule.setMode("edit"); //set mode to editing
                //alert(row.find('td:eq(0) input[type="checkbox"]').val());
                apprehendedInfoModalModule.setSelectedID(row.find('td:eq(0) input[type="checkbox"]').val()); //what is the id of the invoice we are going to update
                apprehendedInfoModalModule.setConsumerID(row.find('td').eq(3).attr('data-consumer-id')); //what is the id of the invoice we are going to update
                apprehendedInfoModalModule.setSelectedRow(row); //remember the row we are going to update


                //object details of modal
                apprehendedInfoModalModule.setDetails({
                    "bill_account_id"	:		row.find('td:eq(0) input[type="checkbox"]').val(),
                    "house_no"	:		row.find('td:eq(0) input[type="checkbox"]').attr('data-house-no'),
                    "street_no"	:		row.find('td:eq(0) input[type="checkbox"]').attr('data-street-no'),
                    "barangay"	:		row.find('td:eq(0) input[type="checkbox"]').attr('data-barangay'),
                    "municipality"	:		row.find('td:eq(0) input[type="checkbox"]').attr('data-municipality'),
                    "zip_code"	:		row.find('td:eq(0) input[type="checkbox"]').attr('data-zip-code'),
                    "province"	:		row.find('td:eq(0) input[type="checkbox"]').attr('data-province'),
                    "email"	:		row.find('td:eq(0) input[type="checkbox"]').attr('data-email'),
                    "down_payment"	:		row.find('td:eq(0) input[type="checkbox"]').attr('data-down-payment'),
                    "no_of_days"	:		row.find('td:eq(0) input[type="checkbox"]').attr('data-no-of-days'),
                    "payment_start_date"	:		row.find('td:eq(0) input[type="checkbox"]').attr('data-payment-start-date'),
                    "duration"	:		row.find('td:eq(0) input[type="checkbox"]').attr('data-duration'),
                    "payment_schedule_remarks"	:		row.find('td:eq(0) input[type="checkbox"]').attr('data-payment-schedule-remarks'),

                    "amount_kwh"	:		row.find('td:eq(0) input[type="checkbox"]').attr('data-amount-kwh'),

                    /***
                     * WRONG ACCESS NAME!
                     * ***/
                    //"total_back_bill_amount"	:		row.find('td:eq(0) input[type="checkbox"]').attr('data-total-bill-amount'),
                    "total_back_bill_amount"	:		row.find('td:eq(0) input[type="checkbox"]').attr('data-total-back-bill_amount'),
                    "total_account_kwh"	:		row.find('td:eq(0) input[type="checkbox"]').attr('data-total-account-kwh'),
                    "reference_no"	    :		row.find('td').eq(1).text(),
                    "account_no"		    :		row.find('td').eq(2).text(),
                    "consumer_id"	    :		row.find('td').eq(3).attr('data-consumer-id'),
                    "consumer_name"		    :		row.find('td').eq(3).text(),
                    "contact_no"		    :		row.find('td').eq(4).text()
                });

                //show invoice info modal
                apprehendedInfoModalModule.showModal();



            });




            $('#tbl_apprehended_consumer_list tbody').on('click','tr',function(){


                highlightRow(this);

                var row=$(this);
                var checbox= row.find('td:eq(0) input[type="checkbox"]');
                selected_account_id=checbox.val();
                showPaymentSchedule(selected_account_id);
                showConsumerLedger();

                $('#cell_reference_no').text(
                    row.find('td').eq(1).text()
                );

                $('#cell_account_no').text(
                    row.find('td').eq(2).text()
                );


                $('#cell_consumer').text(
                    row.find('td').eq(3).text()
                );

                $('#cell_total_amount').text(
                    row.find('td').eq(6).text()
                );

                $('#cell_start_date').text(
                    row.find('td:eq(0) input[type="checkbox"]').attr('data-payment-start-date')
                );

                $('#cell_duration').text(
                    row.find('td:eq(0) input[type="checkbox"]').attr('data-duration')+" month(s)"
                );

                $('#btn_print_ledger,#print_schedule').prop('disabled',false);

            });



        })();



        var showPaymentSchedule=function(account_id){
            $('a[href="#tab-2"]').html(" <span> [ Loading details... <img src='assets/img/ajax-loader-arrow.gif'> ]</span>" );


            $('#tbl_payment_schedule_list tbody').html('<tr><td colspan="8" align="center"><img src="assets/img/ajax-loader-sm.gif"></td></tr>');

            $.getJSON('ApprehendedConsumerController/ActionGetCurrentAccountSchedule',{"id":account_id}, function(response){
                //tbl_apprehended_consumer_list.clear().draw(); //make sure apprehended consumer datatable has no rows
                //console.log(response);
                var total=0;
                tbl_payment_schedule_list.clear().draw(); //to make sure old rows are cleared

                $.each(response,function(index,value){
                    tbl_payment_schedule_list.row.add([
                            value.sched_payment_date,
                            value.bill_description,
                            accounting.formatNumber(value.due_amount,4)
                    ]).draw();

                    total+=parseFloat(value.due_amount);

                });

                $('#cell_total_back_bill_amount').html('<h3>'+accounting.formatNumber(total,2)+'</h3>');
                var account_no=$('#tbl_apprehended_consumer_list > tbody tr.active').find('td:eq(2)').text();
                $('a[href="#tab-2"]').html("<i class='fa fa-user text-navy'></i> Account Info [ Account No : <b><span class='text-navy'>"+account_no+"</span></b> ]");

                //$('a[href="#tab-2"]').html("Account Info");

            });
        };





        var highlightRow=function(row){
            $(row).siblings()
                .removeClass('active')
                .find('td:eq(0) input[type="checkbox"]')
                .prop('checked',false); //remove highlights of other rows

            $(row).attr('class','active')
                .find('td:eq(0) input[type="checkbox"]')
                .prop('checked',true); //highlight the row that fires the event
        };

        var initializeApprehendedConsumerDatatable=(function(){
            tbl_apprehended_consumer_list=$('#tbl_apprehended_consumer_list').DataTable({
                "bLengthChange":false,
                "order": [[ 0, "desc" ]],
                "oLanguage": {
                    "sSearch": "Search: ",
                    "sProcessing": "Please wait..."
                },
                "dom": '<"toolbar">frtip',
                "columnDefs": [
                    {//column 1
                        'bSortable': false,
                        'targets': [0],
                        'render': function(data, type, full, meta){
                            var _arrData=data.split('|');
                            return '<input type="checkbox" value="'+_arrData[0]+'"' +
                            'data-consumer-id="'+_arrData[1]+'"' +
                            'data-house-no="'+_arrData[2]+'"' +
                            'data-street-no="'+_arrData[3]+'"' +
                            'data-barangay="'+_arrData[4]+'"' +
                            'data-municipality="'+_arrData[5]+'"' +
                            'data-zip-code="'+_arrData[6]+'"' +
                            'data-province="'+_arrData[7]+'"' +
                            'data-email="'+_arrData[8]+'"' +
                            'data-down-payment="'+_arrData[9]+'"' +
                            'data-no-of-days="'+_arrData[10]+'"' +
                            'data-payment-start-date="'+_arrData[11]+'"' +
                            'data-duration="'+_arrData[12]+'"' +
                            'data-payment-schedule-remarks="'+_arrData[13]+'"' +
                            'data-amount-kwh="'+_arrData[14]+'"' +
                            'data-total-back-bill_amount="'+_arrData[15]+'"' +
                            'data-total-account-kwh="'+_arrData[16]+'"' +
                            '>';
                        }
                    },//column 1
                    {//column 3

                        'bSortable': false,
                        'targets': [3],
                        'render': function(data, type, full, meta){
                            return data.split('|')[1];
                        }
                    },//column 3,

                  {//column 7

                        'bSortable': false,
                        'targets': [8],
                        'render': function(data, type, full, meta){
                            var btn_edit='<button name="edit_account" class="btn btn-default btn-sm" style="margin-left:-15px;" data-toggle="tooltip" data-placement="top" title="Adjust Invoice"><i class="fa fa-file-text-o"></i> </button>';
                            var btn_trash='<button name="remove_account" class="btn btn-default btn-sm" style="margin-right:-15px;" data-toggle="tooltip" data-placement="top" title="Move to trash"><i class="fa fa-trash-o"></i> </button>';

                            return '<center>'+btn_edit+btn_trash+'</center>';
                        }
                    }//column 7
                ],
                "rowCallback":function( row, data, index ){

                    $('td:eq(6),td:eq(7)',row).attr({
                        "align":"right"
                    });

                    $(row).find('td').eq(3).attr({
                        "data-consumer-id": data[3].split('|')[0]
                    });
                }


            });

        })();


        var showApprehendedConsumerList=function(){
            $('#tbl_apprehended_consumer_list tbody').html('<tr><td colspan="9" align="center"><img src="assets/img/ajax-loader-sm.gif"></td></tr>');
            $.getJSON('ApprehendedConsumerController/ActionGetApprehendedConsumerList', function(response){
                tbl_apprehended_consumer_list.clear().draw(); //make sure apprehended consumer datatable has no rows
                //console.log(response);
                $.each(response,function(index,value){
                    tbl_apprehended_consumer_list.row.add([
                        value.record_info,
                        value.reference_no,
                        value.account_no,
                        value.consumer,
                        value.contact_no,
                        value.period,
                        accounting.formatNumber(value.total_back_bill_amount,2),
                        accounting.formatNumber(value.TotalBalance,2),
                        ""
                    ]).draw();
                });

            });
        };


        var lastPage=function(){
            $('#tbl_apprehended_consumer_list ul li:nth-last-child(2) a').click(); //trigger 2nd to the last link, the last page number
        };


        var addRow=function(data){
            tbl_apprehended_consumer_list
                .row
                .add(data)
                .draw();
        };

        //create toolbar buttons
        var createToolBarButton=function(_buttons){
            $("div.toolbar").html(_buttons);
        };

        //get the invoice table object instance
        var getTableInstance=function(){
            return tbl_apprehended_consumer_list;
        };

        //update row
        var updateRow=function(row,data){
            tbl_apprehended_consumer_list
                .row(row)
                .data(data)
                .draw();
        };



        //return objects as functions
        return {
            getTableInstance            : 	getTableInstance,
            createToolBarButton         : 	createToolBarButton,
            showApprehendedConsumerList :   showApprehendedConsumerList,
            addRow                      : 	addRow,
            updateRow                   :	updateRow,
            lastPage                    : 	lastPage
        };


    })();
    /**********************************************************************************************************************************************************/

    var dtDeliquentList=(function(){

        var bindEventHandlers=function(){
            $(document).on('click','#btn_refresh_deliquent',function(){
                showDelinquentList();
            });
        }();

        var initializeCustomerLedger=(function(){
            tbl_deliquent_list=$('#tbl_deliquent_list').DataTable({
                "bLengthChange": false,
                "bPaginate":false,
                "dom": '<"print_deliquent">frtip',
                "rowCallback":function( row, data, index ){
                    $('td:eq(2),td:eq(3),td:eq(4),td:eq(5),td:eq(6),td:eq(7)',row).attr({
                        "align" :   "right"
                    });

                }
            });
        })();


        var createPrintButton=(function(){
            var _btnPrint='<a href="ApprehendedConsumerController/ActionPreviewDelinquent" target="_blank"><button class="btn btn-default btn-sm"  id="btn_print_deliquent" data-placement="left" data-toggle="modal" title="Print Deliquent Consumer" ><i class="fa fa-print"></i> Print Delinquent Consumer</button></a>';
            var _btnRefresh='<button class="btn btn-default btn-sm"  id="btn_refresh_deliquent" data-placement="left" data-toggle="modal" title="Print Deliquent Consumer" ><i class="fa fa-refresh"></i> Refresh</button>';
            $("div.print_deliquent").html(_btnPrint+_btnRefresh);
        })();

    })();

    var dtAccountInfoSchedule=(function(){

        var initializeAccountInfoScheduleDatatable=(function(){
            tbl_payment_schedule_list=$('#tbl_payment_schedule_list').DataTable({
                "bLengthChange": false,
                "order": [[0, "asc"]],
                "dom": '<"print_schedule">frtip',
                "oLanguage": {
                    "sSearch": "Search: ",
                    "sProcessing": "Please wait..."
                },

                "rowCallback":function( row, data, index ){

                    $(row).find('td').eq(2).attr({
                        "align":"right"
                    });


                }

            });
        })();

        var createPrintButton=(function(){
            var _btnPrint='<a href="#" target="_blank"><button class="btn btn-default btn-sm"  id="print_schedule" data-placement="left" data-toggle="modal" title="Print Consumer Payment Schedule" ><i class="fa fa-print"></i> Print Payment Schedule</button></a>';
            $("div.print_schedule").html(_btnPrint);
        })();



    })();


    var dtCustomerLedger=(function(){

        var initializeCustomerLedger=(function(){
            tbl_customer_ledger=$('#tbl_customer_ledger').DataTable({
                "bLengthChange": false,
                "bPaginate":false,
                "dom": '<"print_ledger">frtip',
                "rowCallback":function( row, data, index ){
                    $('td:eq(4),td:eq(5),td:eq(6)',row).attr({
                        "align" :   "right"
                    });

                }
            });
        })();


        var createPrintButton=(function(){
            var _btnPrint='<a href="ApprehendedConsumerController/ActionPreviewConsumerLedger" target="_blank"><button class="btn btn-default btn-sm"  id="btn_print_ledger" data-placement="left" data-toggle="modal" title="Print Consumer Ledger" ><i class="fa fa-print"></i> Print Consumer Ledger</button></a>';
            $("div.print_ledger").html(_btnPrint);
        })();


    })();


    var dtItemCartModule=(function(){

        var bindEventHandlers=(function(){

            /**
             * fires everytime kwh, qty, hours cell has key being pressed
             */
            $(oTable.body).on(
                'keypress',
                'td',
                function(event) {

                    if(event.keyCode==13){ //if enter is pressed
                        $('#plu_typehead').focus();

                        var row=$(this).closest('tr');
                        updateCachedData(this); //update cached data of current cell
                        setLineTotal(row);
                        reComputeDetails();
                    }else{
                        return isNumber(event,this);
                    }

                }
            );

            /**
             * fires everytime kwh, qty, hours cell has lost focus
             */
            $(oTable.body).on(
                'blur',
                'td',
                function(event) {
                    var row=$(this).closest('tr');
                    updateCachedData(this); //update cached data of current cell
                    setLineTotal(row);
                    reComputeDetails();
                }
            );


            /**
             * initialize default attributes of footer details
             */
            $([oTFoot.amount,oTFoot.days,oTFoot.dp].join(),oTable.footer)
                .attr({
                    "align"             :   "right",
                    "contenteditable"   :   "true"
                });

            /**
             * restrict invalid characters
             */
            $(oTable.footer).on('keypress',[oTFoot.amount,oTFoot.days,oTFoot.dp].join(), function(event){
                if(event.keyCode==13){
                    $('#plu_typehead').focus();
                    $('#txt_downpayment').val($(oTFoot.dp,oTable.footer).text());
                    reComputeDetails();

                    return false;
                }else{
                    return isNumber(event,this);
                }
            });

            $([oTFoot.amount,oTFoot.days,oTFoot.dp].join(),oTable.footer).blur(function(){
                $('#txt_downpayment').val($(oTFoot.dp,oTable.footer).text());
                reComputeDetails();
            });


            /**
             * fires everytime 'trash' button on selected row is clicked
             */
            $(oTable.body).on('click','button[name="remove_row"]',function(){

                var row=$(this).closest('tr');
                remove( row ); //remove row
                reComputeDetails(); //recompute details

            });

            /**********************ERROR FOUND: 2 event listeners on Save Button***********************************/
            /*$('#btn_create_app_account').click(function(){
                tbl_item_cart.rows().eq(0).each(function(index){
                    var row = tbl_item_cart.row(index);
                    var data = row.data();


                    alert(data[getCellIndex(oTBody.total)]);

                });
            });*/


        })();



        //initialization of item cart
        var initItemCartTable=(function(){
            tbl_item_cart=$('#tbl_item_cart').DataTable({
                "iDisplayLength":7,
                "bLengthChange":false,
                "bFilter":false,
                "order": [[ 0, "desc" ]],
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
                            return data.split('|')[1];
                        }

                    },
                    {//column 6
                        'bSortable': false,
                        'targets': [5],
                        'render': function(data, type, full, meta){

                            var btn_trash='<button name="remove_row" class="btn btn-white btn-sm" style="margin-right:-15px;" data-toggle="tooltip" data-placement="top" title="Move to trash"><i class="fa fa-trash-o"></i> </button>';

                            return '<center>'+btn_trash+'</center>';
                        }
                    }//column 6
                ],
                "rowCallback":function( row, data, index ){

                    //align and set each column to editable and format column
                    $(([oTBody.kwh,oTBody.qty,oTBody.hrs]).join(),row)
                        .attr({
                            "align": "right",
                            "contenteditable": "true"
                        }).each(function(){
                            $(this).html(
                                accounting.formatNumber(
                                    data[
                                        getCellIndex($(this)) //returns index of column
                                        ], 2)
                            );
                        });



                    //align and format total column, not editable
                    $(oTBody.total,row)
                        .attr({
                            "align": "right"
                        })
                        .html(
                        accounting.formatNumber(
                            data[
                                getCellIndex($(oTBody.total)) //returns index of column(object total)
                                ], 2)
                    );

                }

            });
        })();


        var remove=function(row){
            tbl_item_cart.row( row ).remove().draw();
        };

        /**
         * returns the index of td cell pass as argument
         * @param cell
         * @returns {*|jQuery}
         */
        var getCellIndex=function(cell){
            return $( cell,oTable.body ).index();
        };

        var reComputeDetails=function(){
            var _totalKWH=0;

            tbl_item_cart.rows().eq(0).each(function(index){
                var row = tbl_item_cart.row(index);
                var data = row.data();
                _totalKWH+= parseFloat(data[
                    getCellIndex(  $(oTBody.total)  )
                    ]);
            });

            var _amountPerHour=parseFloat( accounting.unformat($(oTFoot.amount,oTable.footer).text()) );
            var _daysNo=parseFloat( accounting.unformat($(oTFoot.days,oTable.footer).text()) );
            var _downpayment=parseFloat( accounting.unformat( $(oTFoot.dp,oTable.footer).text() ) );
            var _grossAmount=_amountPerHour*_daysNo*_totalKWH;
            var _netAmount=_grossAmount-_downpayment;

            //set total KWH on footer
            $(oTFoot.totalKWH,oTable.footer).html(  accounting.formatNumber(_totalKWH,2)  );
            //set net amount
            $(oTFoot.net,oTable.footer).html(  '<h3>'+accounting.formatNumber( _netAmount,2 )+'</h3>'  );
            //always recreate schedule when net changes
            dtPaymentScheduleModule.createSchedule();

        };

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

        var setLineTotal=function(row){
            var _totalAmount=parseFloat(accounting.unformat($(oTBody.kwh,row).text()))*parseFloat(accounting.unformat($(oTBody.qty,row).text()))*parseFloat(accounting.unformat($(oTBody.hrs,row).text()));

            $(oTBody.total,row).html( _totalAmount ); //write total amount

            updateCachedData( $(oTBody.total,row) ); //update line total on cached data
        };

        var addRow=function(data){
            tbl_item_cart.row.add(data).draw();
        };



        var removeRows=function(){
            tbl_item_cart.clear().draw();
        };

        var updateCachedData=function(cell){
            tbl_item_cart
                .cell($(cell))
                .data( accounting.unformat( $(cell).text() ) );
        };



        return {

            addRow : addRow,
            reComputeDetails    :       reComputeDetails,
            getNetAmount        :       function(){
                return accounting.unformat($(oTFoot.net,oTable.footer).text());
            },

            getItemCartInstance : function(){
                return tbl_item_cart;
            },

            removeRows: removeRows

        };

    })();


    var dtPaymentScheduleModule=(function(){
        var tbl_payment_schedule;

        var oTable={
            'id'        :   '#tbl_payment_schedule',
            'body'      :   '#tbl_payment_schedule > tbody',
            'footer'    :   '#tbl_payment_schedule > tfoot'
        };

        var oTBody={
            "date"      :       "td:eq(0)",
            "amount"    :       "td:eq(1)",
            "notes"     :       "td:eq(2)"
        };


        var bindEventHandlers=(function(){
            $(oTable.body).on(
                'keypress',
                'td',
                function(event) {
                    if(event.keyCode==13){ //if enter is pressed
                        updateCachedData(this); //update cached data of current cell
                    }
                }
            );

            /**
             * fires everytime editable cell lost focus
             */
            $(oTable.body).on(
                'blur',
                'td',
                function(event) {
                    updateCachedData(this); //update cached data of current cell
                }
            );


        })();


        var initPaymentTable=(function(){
            tbl_payment_schedule=$('#tbl_payment_schedule').DataTable({
                "iDisplayLength": 7,
                "bLengthChange": false,
                "bPaginate":true,
                "bSortable":false,
                "oLanguage": {
                    "sSearch": "Search: ",
                    "sProcessing": "Please wait..."
                },
                "columnDefs": [
                    {'bSortable': false, 'targets': [0], 'width':'25%'} ,
                    {'bSortable': false, 'targets': [1], 'width':'25%'} ,
                    {'bSortable': false, 'targets': [2]}

                ],
                "rowCallback":function( row, data, index ){
                    $(oTBody.notes,row).attr({
                        "align"                 :       "left",
                        "contenteditable"       :       "true"
                    });
                }
            });

        })();


        var createSchedule=function(){
            var _max=parseFloat( $('#txt_duration').val() );

            var _netAmount=parseFloat(dtItemCartModule.getNetAmount());
            var _installment=_netAmount/_max;

            var _startDate=new Date(  $('#payment_start').val()  );
            var _momentDate = moment(_startDate);

            clear(); //clear rows of schedule table
            _momentDate.add('months',-1);
            for(var i=0;i<=_max-1;i++){
                addRow(
                    [
                        _momentDate.add('months',1).format('MM/DD/YYYY'),
                        accounting.formatNumber(_installment,4),
                        ""
                    ]
                );
            }
        };

        var updateCachedData=function(cell){

            tbl_payment_schedule
                .cell($(cell))
                .data( $(cell).text() );
        };

        var clear=function() {
            tbl_payment_schedule
                .clear()
                .draw();
        };

        var addRow=function(data){
            tbl_payment_schedule.row.add( data ).draw();
        };




        var removeRows=function(){
            tbl_payment_schedule.clear().draw();
        };


        return {
            addRow          :       addRow,
            clear           :       clear,
            createSchedule  :   createSchedule,
            getPaymentScheduleInstance : function(){
                return tbl_payment_schedule;},
            removeRows: removeRows

        };

    })();


    var typeHeadPLUmodule=(function(){
        /***********************typehead*************************/
        var $input = $('#plu_typehead');
        var initPLUTypeHead=(function(){
            //get product list
            $.get('ApprehendedConsumerController/ActionGetUnitItemList', function(response){
                //console.log(response);
                //initialize typehead after data request is completed
                $input.typeahead({
                    source:response,
                    updater: function(data){
                        //alert(data.id);
                        dtItemCartModule.addRow([
                            data.id+"|"+data.description,
                            data.kwh,1,8,
                            data.kwh*8,""
                        ]);
                        dtItemCartModule.reComputeDetails();
                        return "";
                    }
                });
            },'json').fail(function(xhr){
                //console.log(xhr);
            });
        })();
    })();

    /**********************************************************************************************************************************************************/

    var apprehendedInfoModalModule=(function(){
        var _mode;		var _selectedID;	 var _selectedRow;  var _consumerID;

        //binds all events of invoice modal
        var bindEventHandlers=(function(){

            /**
             *
             * fires everytime the record invoice button on modal is clicked
             *
             **/
            $('#btn_create_app_account').click(function(){

                if(validateRequiredFields()){ //if true, all required fields are supplied

                    if(_mode=="new"){ //if current mode is new

                        createApprehendedConsumerAccount()
                            .success(function(response){ //if request is successful
                                //console.log(response);

                                PNotify.removeAll(); //remove all notifications
                                new PNotify({
                                    title: 'Success!',
                                    text:  response.msg,
                                    type:  response.stat
                                }); //create new notification base on server response

                                var row=response.row[0];
                                var data=[
                                    row.record_info,
                                    row.reference_no,
                                    row.account_no,
                                    row.consumer,
                                    row.contact_no,
                                    row.period,
                                    accounting.formatNumber(row.total_back_bill_amount,2),
                                    accounting.formatNumber(row.TotalBalance,2),
                                    ""];
                                apprehendedConsumerModule.addRow(data); //add the info of recent invoice
                                apprehendedConsumerModule.lastPage(); //go to last page

                                dtItemCartModule.removeRows(); //remove all rows of cart datatable
                                clearFields(); //clear fields

                            })
                            .error(function(xhr,stat,error){ //if error occurs
                                alert(xhr.responseText);
                                //console.log(xhr);
                            });



                    }else{		//if current mode is update
                        //alert("Update Account!");
                        updateApprehendedAccount()
                            .success(function(response){ //if request is successful
                                //console.log(response);
                                //alert(response.test);
                                hideModal();

                                PNotify.removeAll(); //remove all notifications
                                new PNotify({
                                    title: 'Success!',
                                    text:  response.msg,
                                    type:  response.stat
                                }); //create new notification base on server response

                                var row=response.row[0];
                                var data=[
                                        row.record_info,
                                        row.reference_no,
                                        row.account_no,
                                        row.consumer,
                                        row.contact_no,
                                        row.period,
                                        accounting.formatNumber(row.total_back_bill_amount,2),
                                        ""];
                                apprehendedConsumerModule.updateRow(_selectedRow,data);

                                dtItemCartModule.removeRows(); //remove all rows of cart datatable
                                clearFields(); //clear fields


                            })
                            .error(function(xhr,stat,error){ //if error occurs
                                //alert(xhr.responseText);
                                //console.log(xhr);
                            });
                    }

                }

            });

            /**
             *
             * fires everytime the modal is shown
             *
             **/
            $('#invoice_modal').on('shown.bs.modal', function() {
                $('#plu_typehead').focus();
            });



        })();








        //function that validates all required fields, returns true if all required fields are supplied
        var validateRequiredFields=function(){
            var	stat=1;

            $('input[required]').each(function(){
                if($(this).val()==""){

                    $(this).focus();
                       // .tooltip('show');

                    PNotify.removeAll();
                    new PNotify({
                        title: 'Missing!',
                        text: $(this).data('message'),
                        type: 'error'
                    });

                    stat=0;
                    return false; //this will exit on function inside 'each'
                }
            });

            if(stat==0){
                return 0;
            }

            if($('input[name="receipt_no"]').val()!="" &&(parseFloat($('#txt_downpayment').val())==0 ||$('#txt_downpayment').val()=="")){

                $('a[href="#tab-downpayment-info"]').click();

                $('#txt_downpayment').focus();
                PNotify.removeAll();
                new PNotify({
                    title: 'Missing!',
                    text: 'Down Payment is required',
                    type: 'error'
                });
                stat=0;
                return false;
            }

            if(stat==0){
                return 0;
            }


            if(parseFloat($('#txt_downpayment').val())>0 && $('input[name="receipt_no"]').val()==""){

                $('a[href="#tab-downpayment-info"]').click();

                $('input[name="receipt_no"]').focus();
                PNotify.removeAll();
                new PNotify({
                    title: 'Missing!',
                    text: 'Receipt No #  is required',
                    type: 'error'
                });
                stat=0;
                return false;
            }

            if(stat==0){
                return 0;
            }

            $('textarea[required]').each(function(){ //selectpicker does not support tooltip, just show notification
                if($(this).val()==""){
                    $(this).focus();

                    PNotify.removeAll();
                    new PNotify({
                        title: 'Missing!',
                        text: $(this).data('message'),
                        type: 'error'
                    });

                    stat=0;
                    return false; //this will exit on function inside 'each'
                }
            });

            if(stat==0){
                return 0;
            }

            var rowCount = dtItemCartModule.getItemCartInstance().rows()[0].length;
            var paymentSched = dtPaymentScheduleModule.getPaymentScheduleInstance().rows()[0].length;

            if(rowCount==0){ //if not item in cart
                PNotify.removeAll();
                new PNotify({
                    title: 'Missing!',
                    text: 'No item found. Please enter atleast one item.',
                    type: 'error'
                });
                stat=0;
            }

            if(stat==0){
                return 0;
            }

            if(paymentSched==0){ //if not item in cart
                $('a[href="#create_payment_schedule"]').click();

                PNotify.removeAll();
                new PNotify({
                    title: 'Missing!',
                    text: 'Please create the schedule of payment.',
                    type: 'error'
                });
                stat=0;
                $('#txt_duration').focus();
            }




            return stat; //this will always be executed and return current state
        }; //end of validateRequiredFields


        //add new invoice
        var createApprehendedConsumerAccount=function(){

            var _cartTable=dtItemCartModule.getItemCartInstance(); //intance of datatable
            var _paymentTable = dtPaymentScheduleModule.getPaymentScheduleInstance()

            var amount_kwh=$("#tbl_item_cart > tfoot tr:eq(0) > td:eq(1)").text();
            var total_kwh=$("#tbl_item_cart > tfoot tr:eq(0) > td:eq(3)").text();
            var down_payment=$("#tbl_item_cart tfoot   > tr:eq(1) > td:eq(1)").text();
            var no_of_days =$("#tbl_item_cart tfoot > tr:eq(1) > td:eq(3)").text();
            var total_back_bill_amount=$("#tbl_item_cart tfoot > tr:eq(2) > td:eq(1)").text();




            var serialData=$('#frm_account_details,#frm_payment_sched_details').serializeArray();

            console.log(serialData);

            _cartTable.rows().eq(0).each(function(index){
                var row = _cartTable.row(index);
                var data = row.data();
                serialData.push(
                    {name:"unit_id[]",value:data[0].split("|")[0]},
                    {name:"line_kwh[]",value:accounting.unformat(data[1])},
                    {name:"unit_qty[]",value:accounting.unformat(data[2])},
                    {name:"hours[]",value:accounting.unformat(data[3])}
                );

            });

            _paymentTable.rows().eq(0).each(function(index){
                var row = _paymentTable.row(index);
                var data = row.data();



                serialData.push(
                    {name:"sched_payment_date[]",value:data[0]},
                    {name:"due_amount[]",value:accounting.unformat(data[1])},
                    {name:"bill_description[]",value:data[2]}
                );


                serialData.push(
                    {name:"amount_kwh",value:amount_kwh},
                    {name:"down_payment",value:accounting.unformat(down_payment)},
                    {name:"total_back_bill_amount",value:accounting.unformat(total_back_bill_amount)},
                    {name:"no_of_days",value:no_of_days},
                    {name:"total_kwh",value:total_kwh}
                );


            });
            //console.log(serialData);
            return $.ajax({
                "dataType":"json",
                "type":"POST",
                "url":"ApprehendedConsumerController/ActionSaveApprehendedConsumerInfo",
                "data":serialData
            });


        }; //end of saveInvoiceInfo

        //update invoice
        var updateApprehendedAccount=function(){
            var _cartTable=dtItemCartModule.getItemCartInstance(); //intance of datatable
            var _paymentTable = dtPaymentScheduleModule.getPaymentScheduleInstance();
            var serialData=$('#frm_account_details,#frm_payment_sched_details').serializeArray();


            //console.log(serialData);
            var amount_kwh=$("#tbl_item_cart > tfoot tr:eq(0) > td:eq(1)").text();
            var total_kwh=$("#tbl_item_cart > tfoot tr:eq(0) > td:eq(3)").text();
            var down_payment=$("#tbl_item_cart tfoot   > tr:eq(1) > td:eq(1)").text();
            var no_of_days =$("#tbl_item_cart tfoot > tr:eq(1) > td:eq(3)").text();
            var total_back_bill_amount=$("#tbl_item_cart tfoot > tr:eq(2) > td:eq(1)").text();



            /*****ERROR FOUND! Wrong Push Object Syntax*****/
            /*serialData.push({
                name:"id",value: _selectedID,
                name:"consumer_id",value:_consumerID
            });*/



            serialData.push(
                {name:"id",value: _selectedID},
                {name:"consumer_id",value:_consumerID}
            )

            //console.log(serialData);

            _cartTable.rows().eq(0).each(function(index){
                var row = _cartTable.row(index);
                var data = row.data();
                serialData.push(
                    {name:"unit_id[]",value:data[0].split("|")[0]},
                    {name:"line_kwh[]",value:accounting.unformat(data[1])},
                    {name:"unit_qty[]",value:accounting.unformat(data[2])},
                    {name:"hours[]",value:accounting.unformat(data[3])}
                );

            });
                _paymentTable.rows().eq(0).each(function(index){
                    var row = _paymentTable.row(index);
                    var data = row.data();
                    serialData.push(
                        {name:"sched_payment_date[]",value:data[0]},
                        {name:"due_amount[]",value:accounting.unformat(data[1])},
                        {name:"bill_description[]",value:data[2]}
                    );

                    /**
                     * MISSING! total kwh
                     */
                    serialData.push(
                        {name:"amount_kwh",value:amount_kwh},
                        {name:"down_payment",value:accounting.unformat(down_payment)},
                        {name:"total_back_bill_amount",value:accounting.unformat(total_back_bill_amount)},
                        {name:"no_of_days",value:no_of_days},
                        {name:"total_kwh",value:total_kwh}
                    );



                });






        //console.log(serialData);

            return $.ajax({
                "dataType":"json",
                "type":"POST",
                "url":"ApprehendedConsumerController/ActionUpdateApprehendedAccountInfo",
                "data":serialData
            });

        };

        //set mode of modal, are we going to add new or update??
        var setCurrentMode=function(status){
            _mode=status.toLowerCase();
        };

        //returns the current mode of the modal, add new or update
        var getCurrentMode=function(){
            return _mode;
        };

        //set selected id, the invoice
        var setSelectedID=function(id){
            _selectedID=id;
        };

        var setConsumerID=function(id){
            _consumerID=id;
        };
        //get selected id, the invoice
        var getSelectedID=function(){
            return _selectedID;
        };

        //set selected row, the tr element
        var setSelectedRow=function(row){
            _selectedRow=row;
        };

        //get selected row, the tr element
        var getSelectedRow=-function(){
            return _selectedRow;
        }

        var clearFields=function(){
            $('#plu_head').val('');


            $('#frm_account_details input:not([id="dt_end_date"]) ,#frm_payment_sched_details input:not([id="payment_start"])').val('');

            $('#frm_account_details textarea,#frm_payment_sched_details textarea').val('');

            $('#payment_start').val(Date.today().toString("MM/dd/yyyy"));
        };


        var showModal=function(){
            $('#apprehended_consumer_modal').modal('show');
        };

        var hideModal=function(){
            $('#apprehended_consumer_modal').modal('hide');
        };

        //set invoice modal details
        var setApprehendedModalDetails=function(data){

            $( "input[name='reference_no']").val(data.reference_no);
            $( "input[name='account_no']").val(data.account_no);
            $( "input[name='consumer_name']").val(data.consumer_name);
            $( "input[name='contact_no']").val(data.contact_no);
            $( "input[name='email']").val(data.email);
            $( "input[name='house_no']").val(data.house_no);
            $( "input[name='street_no']").val(data.street_no);
            $( "input[name='barangay']").val(data.barangay);
            $( "input[name='municipality']").val(data.municipality);
            $( "input[name='email']").val(data.email);
            $( "input[name='payment_start']").val(data.payment_start_date);
            $( "input[name='duration']").val(data.duration);
            $( "textarea[name='payment_schedule_remarks']").val(data.payment_schedule_remarks);

            /**
             * FOOTER DETAILS!
             */
            //alert(data.amount_kwh);
            $("#tbl_item_cart > tfoot tr:eq(0) > td:eq(1)").text(data.amount_kwh);

            $("#tbl_item_cart > tfoot tr:eq(0) > td:eq(3)").text(
                accounting.formatNumber(data.total_account_kwh,2)
            );

            $("#tbl_item_cart tfoot   > tr:eq(1) > td:eq(1)").text(data.down_payment);
            $("#tbl_item_cart tfoot > tr:eq(1) > td:eq(3)").text(data.no_of_days);
            //alert(data.total_back_bill_amount);
            $("#tbl_item_cart tfoot > tr:eq(2) > td:eq(1)").text(
                accounting.formatNumber(data.total_back_bill_amount,2)
            );

            //set  cart items

            $('#tbl_item_cart tbody').html('<tr><td colspan="6" align="center"><img src="assets/img/ajax-loader-sm.gif" /></td></tr>');

            $.getJSON('ApprehendedConsumerController/ActionGetAccountCartItems',{id:data.bill_account_id}, function(response){
                //console.log(response);
                dtItemCartModule.removeRows(); //remove rows
                $.each(response,function(index,data){
                        dtItemCartModule.addRow([
                        data.item,
                        data.estimated_kwh,
                        data.unit_qty,
                        data.hours,
                        data.line_total
                    ]);

                });

            });

            $.getJSON('ApprehendedConsumerController/ActionGetPaymentScheduleItem',{id:data.bill_account_id}, function(response){
                //console.log(response);
                dtPaymentScheduleModule.removeRows(); //remove rows
                $.each(response,function(index,data){
                    dtPaymentScheduleModule.addRow([
                        data.sched_payment_date,
                        accounting.formatNumber(data.due_amount,2),
                        data.bill_description
                    ]);

                });

            });

        };









        //return value of this invoice modal object module
        return {
            setMode: 		setCurrentMode,
            getMode:		getCurrentMode,
            clearFields: 	clearFields,
            showModal: 		showModal,
            hideModal:		hideModal,
            setDetails: 	setApprehendedModalDetails,
            setSelectedID: 	setSelectedID,
            getSelectedID: 	getSelectedID,
            setConsumerID: 	setConsumerID,
            setSelectedRow: setSelectedRow

        }; //end of return value



    })();



    //sparkline graph
    $("#sparkline8").sparkline([2,5, 6, 7, 2, 0, 4, 2, 4, 5, 7, 2, 4, 12, 14, 4, 2, 14, 12, 7,5,4,3,4], {
        type: 'bar',
        barWidth: 8,
        height: '80px',
        barColor: '#1ab394',
        negBarColor: '#c6c6c6'
    });


    $('#btn_print_ledger,#print_schedule').prop('disabled',true);



    //write toolbar on datatable
    var _btnNew='<button class="btn btn-white btn-sm"  id="btn_new" data-placement="left" data-toggle="modal" data-target="#apprehended_consumer_modal" title="Record Back Bill Account" ><i class="fa fa-paste"></i> Record Back Bill Account</button>';
    $("div.toolbar").html(_btnNew);



    $(document).on('click','#btn_print_ledger',function(){
        $(this).closest('a').attr('href',"ApprehendedConsumerController/ActionPreviewConsumerLedger?accid="+selected_account_id);
    });

    $(document).on('click','#print_schedule',function(){
        $(this).closest('a').attr('href',"ApprehendedConsumerController/ActionPreviewSchedule?accid="+selected_account_id);
    });



    $('#txt_duration').keyup(function(){
        dtPaymentScheduleModule.createSchedule();
    });

    $('#txt_duration').change(function(){
        $('#txt_duration').trigger('keyup');
    });


    /**************fires element with required attribute when key is no longer being pressed*******************/
    $('input[required]').keyup(function(){
        $(this).tooltip('destroy');
    });

    $('#payment_start').change(function(){

        dtPaymentScheduleModule.createSchedule();

    })



    /**********************************************************************************************************************************************************/


    apprehendedConsumerModule.showApprehendedConsumerList();



    //new apprehended account
    $('#btn_new').click(function(){
        apprehendedInfoModalModule.setMode("new");

        apprehendedInfoModalModule.clearFields(); //clear fields
        dtItemCartModule.removeRows(); //remove all rows of cart datatable
        dtPaymentScheduleModule.removeRows();

    });

    $('#txt_downpayment').change(function(event){
        $(oTFoot.dp,oTable.footer).html($(this).val()).blur();

    });


    $('#dt_end_date,#payment_start').daterangepicker({
        singleDatePicker: true,
        calender_style: "picker_4"
    }, function (start, end, label) {
        console.log(start.toISOString(), end.toISOString(), label);
    });


    var showConsumerLedger=function(){
        $('a[href="#tab-3"]').html(" <span> [ Loading details... <img src='assets/img/ajax-loader-arrow.gif'> ]</span>" );
        $('#tbl_customer_ledger tbody').html('<tr><td colspan="8" align="center"><img src="assets/img/ajax-loader-sm.gif"></td></tr>');
        $.getJSON('ApprehendedConsumerController/ActionGetConsumerLedger',{"id":selected_account_id}, function(response){
            tbl_customer_ledger.clear().draw(); //make sure apprehended consumer datatable has no rows
            //console.log(response);
            $.each(response,function(index,value){
                tbl_customer_ledger.row.add([
                    value.TransDate,
                    value.account_no,
                    value.receipt_no,
                    value.Description,
                    accounting.formatNumber(value.Debit,4),
                    accounting.formatNumber(value.Credit,4),
                    accounting.formatNumber(value.Balance,4)
                ]).draw();
            });

            var consumer=$('#tbl_apprehended_consumer_list > tbody tr.active').find('td:eq(3)').text();
            $('a[href="#tab-3"]').html("<i class='fa fa-user text-navy'></i> Consumer Ledger [ Name : <b><span class='text-navy'>"+consumer+"</span></b> ]");
        });
    };



    var showDelinquentList=function(){

        $('#tbl_deliquent_list tbody').html('<tr><td colspan="8" align="center"><img src="assets/img/ajax-loader-sm.gif"></td></tr>');

        $.getJSON('ApprehendedConsumerController/ActionGetDelinquentList', function(response){
            tbl_deliquent_list.clear().draw(); //make sure apprehended consumer datatable has no rows
            //console.log(response);
            $.each(response,function(index,value){
                tbl_deliquent_list.row.add([
                    value.account_no,
                    value.consumer_name,
                    accounting.formatNumber(value.ApprehendedAmount,2),
                    accounting.formatNumber(value.TotalPayment,4),
                    accounting.formatNumber(value.TotalBalance,4),
                    accounting.formatNumber(value.PaymentsMade,0),
                    accounting.formatNumber(value.DelayedMonths,0),
                    accounting.formatNumber(value.PreviousBalance,4)
                ]).draw();
            });


        });
    };

    showDelinquentList();
    /************************************************************************************/



});



















