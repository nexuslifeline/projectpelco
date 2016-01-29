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
        var tbl_item_schedule;

        var initializeItemScheduleList=(function(){
            tbl_item_schedule=$('#tbl_item_schedule').DataTable({
                "bLengthChange": false,
                "order": [[0, "desc"]],
                "dom": '<"toolbar">frtip',
                "oLanguage": {
                    "sSearch": "Search: ",
                    "sProcessing": "Please wait..."
                }
            });

        })();



    })();






    $('#btn-new').click(function(){
        modalPaymentEntry.showModal();
    });



});