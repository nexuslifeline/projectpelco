
$(document).ready(function(){
    //initialize customer list
        var itemListModule = (function(){
            var tbl_item_list;

            var bindEventHandlers=(function(){
                /**
                 *
                 *	fires when edit consumer button on selected row is clicked
                 *
                 */
                $('#tbl_item_list tbody').on('click','button[name="edit_item"]',function(){
                    var row=$(this).closest('tr');
                    itemInfoModalModule.setMode("edit"); //set mode to editing
                    itemInfoModalModule.setSelectedID(row.find('td:eq(0) input[type="checkbox"]').val()); //what is the id of the consumer we are going to update
                    itemInfoModalModule.setSelectedRow(row); //remember the row we are going to update
                    //object details of modal
                    itemInfoModalModule.setDetails({
                        "unit_id"	:		row.find('td:eq(0) input[type="checkbox"]').val(),
                        "unit_description"	:		row.find('td:eq(0) input[type="checkbox"]').attr('data-unit-description'),
                        "brand_name"	        :		row.find('td:eq(0) input[type="checkbox"]').attr('data-brand-name'),
                        "model_name"	:		row.find('td:eq(0) input[type="checkbox"]').attr('data-model-name'),
                        "estimated_kwh"	    :		row.find('td:eq(0) input[type="checkbox"]').attr('data-estimated-kwh'),
                        "amount_consumption"	    :		row.find('td:eq(0) input[type="checkbox"]').attr('data-amount-consumption')
                    });

                    //show invoice info modal
                    itemInfoModalModule.showModal();

                });

                $('#tbl_item_list tbody').on('click','button[name="remove_item"]',function(){
                    var row=$(this).closest('tr');
                    itemInfoModalModule.setMode("remove"); //set mode to editing
                    itemInfoModalModule.setSelectedID(row.find('td:eq(0) input[type="checkbox"]').val()); //what is the id of the consumer we are going to update
                    itemInfoModalModule.setSelectedRow(row); //remember the row we are going to update
                    //object details of modal

                    //show item info modal
                    itemInfoModalModule.showConfirmModal();
                    $('#modal_mode').html("REMOVE ")
                });

            })();

            var initializeConsumerDatatable = (function(){
                            tbl_item_list=$('#tbl_item_list').DataTable({
                                "iDisplayLength":15,
                                "bLengthChange":false,
                                "order": [[ 0, "desc" ]],
                                "oLanguage": {
                                    "sSearch": "Search: ",
                                    "sProcessing": "Please wait..."
                                },
                                "dom": '<"toolbar">frtip',
                                "columnDefs": [
                                    {
                                        'bSortable': false,
                                        'targets': [0],
                                        'width':'4%',
                                        'render': function(data, type, full, meta){
                                            return '<input type="checkbox" onclick="fnChecked(this)" class="tableflat" ' +
                                            'value="'+data.split('|')[0]+'"' +
                                            'data-unit-description="'+data.split('|')[1]+'"' +
                                            'data-brand-name="'+data.split('|')[2]+'"' +
                                            'data-model-name="'+data.split('|')[3]+'"' +
                                            'data-estimated-kwh="'+data.split('|')[4]+'"' +
                                            'data-amount-consumption="'+data.split('|')[5]+'"' +

                                            '>';
                                        }
                                    } ,
                                    {
                                        'targets': [6],
                                        'width':'10%',
                                        'render': function (data, type, full, meta){
                                            var btn_edit='<button class="btn btn-white btn-sm" name="edit_item"  style="margin-left:-15px;" data-toggle="tooltip" data-placement="top" title="Edit Item"><i class="fa fa-pencil"></i> </button>';
                                            var btn_trash='<button class="btn btn-white btn-sm" name="remove_item" style="margin-right:-15px;" data-toggle="tooltip" data-placement="top" title="Move to trash"><i class="fa fa-trash-o"></i> </button>';
                                            return '<center>'+btn_edit+btn_trash+'</center>';
                                        }



                                    }
                                ]

                            });
                        })();
                        // tbl consumer list datatable initialization

            var  showItemList=function(){

                $('#tbl_item_list tbody').html('<tr><td colspan="6" align="center"><img src="assets/img/ajax-loader-sm.gif" /></td></tr>');
                $.getJSON("ItemManagementController/ActionGetItemList", function(response){
                        tbl_item_list.clear().draw();
                        console.log(response);

                        $.each(response,function(index,value){
                            //alert(value.customer_id);
                            tbl_item_list.row.add([
                                value.hidden,
                                value.unit_description,
                                value.brand_name,
                                value.model_name,
                                value.estimated_kwh,
                                value.amount_consumption,

                            ]);
                        });

                        tbl_item_list.draw();

                    }).fail(function(xhr,stat,error){
                        alert(xhr.responseText);
                        console.log(xhr);
                    });
            };



            var lastPage=function(){
                $('#tbl_item_list ul li:nth-last-child(2) a').click(); //trigger 2nd to the last link, the last page number
            };


            var addRow=function(data){
                tbl_item_list
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
                return tbl_item_list;
            };

            //update row
            var updateRow=function(row,data){
                tbl_item_list
                    .row(row)
                    .data(data)
                    .draw();
            };

            var removeRow=function(row,data){
                tbl_item_list
                    .row(row)
                    .remove(data)
                    .draw();
            };


            //return objects as functions
            return {
                getTableInstance : 		getTableInstance,
                createToolBarButton: 	createToolBarButton,
                showItemList:       showItemList,
                addRow: 				addRow,
                updateRow:				updateRow,
                removeRow:				removeRow,
                lastPage: 				lastPage
            };

        })();






    var itemInfoModalModule=(function(){
        var _mode;		var _selectedID;	 var _selectedRow;
        //binds all events of invoice modal
        var bindEventHandlers=(function(){

            /**
             *
             * fires everytime the record invoice button on modal is clicked
             *
             **/
            $('#btn_create_unit').click(function(){

                if(validateRequiredFields()){ //if true, all required fields are supplied

                    if(_mode=="new"){ //if current mode is new
                        createNewItem()

                            .success(function(response){ //if request is successful
                                console.log(response);

                                PNotify.removeAll(); //remove all notifications
                                new PNotify({
                                    title: 'Success!',
                                    text:  response.msg,
                                    type:  response.stat
                                }); //create new notification base on server response

                                var row=response.row[0];
                                var data=[row.hidden,row.unit_description,row.brand_name,row.model_name,row.estimated_kwh,row.amount_consumption];
                                itemListModule.addRow(data); //add the info of recent invoice
                                itemListModule.lastPage(); //go to last page
                                clearFields(); //clear fields

                            })
                            .error(function(xhr,stat,error){ //if error occurs
                                alert(xhr.responseText);
                                console.log(xhr);
                            });



                    }else{		//if current mode is update

                        updateItem()
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
                                var data=[row.hidden,row.unit_description,row.brand_name,row.model_name,row.estimated_kwh,row.amount_consumption];
                                itemListModule.updateRow(_selectedRow,data);
                                clearFields(); //clear fields


                            })
                            .error(function(xhr,stat,error){ //if error occurs
                                alert(xhr.responseText);
                                console.log(xhr);
                            });
                    }

                }

            });



            $('#btn_yes').click(function(){
                        removeItem()
                            .success(function(response){ //if request is successful
                                //console.log(response);
                                //alert(response.test);
                                hideConfirmModal();
                                PNotify.removeAll(); //remove all notifications
                                new PNotify({
                                    title: 'Success!',
                                    text:  response.msg,
                                    type:  response.stat
                                }); //create new notification base on server response

                                var row=response.row[0];
                                var data=[row.hidden,row.unit_description,row.brand_name,row.model_name,row.estimated_kwh,row.amount_consumption];
                                itemListModule.removeRow(_selectedRow,data);

                            })
                            .error(function(xhr,stat,error){ //if error occurs
                                alert(xhr.responseText);
                                console.log(xhr);
                            });




            });




        })();




        //function that validates all required fields, returns true if all required fields are supplied
        var validateRequiredFields=function(){
            var	stat=1;

            $('input[required]').each(function(){
                if($(this).val()==""){

                    $(this).focus()
                        .tooltip('show');

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
            return stat; //this will always be executed and return current state
        }; //end of validateRequiredFields

        //add new item
        var createNewItem=function(){

            var serialData=$('#frm_item_info').serializeArray();

            return $.ajax({
                "dataType":"json",
                "type":"POST",
                "url":"ItemManagementController/ActionSaveItemInfo",
                "data":serialData
            });


        }; //end of saveItemInfo

        //update item
        var updateItem=function(){

            var serialData=$('#frm_item_info').serializeArray();
            serialData.push({
                name:"id",value: _selectedID
            });



            console.log(serialData);

            return $.ajax({
                "dataType":"json",
                "type":"POST",
                "url":"ItemManagementController/ActionUpdateItemInfo",
                "data":serialData
            });

        };

        //remove consumer
        var removeItem=function(){

            var serialData=$('#frm_item_info').serializeArray();
            serialData.push({
                name:"id",value: _selectedID
            });
            console.log(serialData);
            return $.ajax({
                "dataType":"json",
                "type":"POST",
                "url":"ItemManagementController/ActionDeleteItemInfo",
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

        //set selected id, the consumer
        var setSelectedID=function(id){
            _selectedID=id;
        };

        //get selected id, the consumer
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

            $('#frm_item_info input').val('');

        };


        var showModal=function(){
            $('#item_modal').modal('show');
        };

        var hideModal=function(){
            $('#item_modal').modal('hide');
        };


        var showConfirmModal=function(){
            $('#confirm_modal').modal('show');
        };

        var hideConfirmModal=function(){
            $('#confirm_modal').modal('hide');
        };

        //set invoice modal details
        var setItemModalDetails=function(data){
            $('input[name="unit_description"]').val(data.unit_description);
            $('input[name="brand_name"]').val(data.brand_name);
            $('input[name="model_name"]').val(data.model_name);
            $('input[name="estimated_kwh"]').val(data.estimated_kwh);
            $('input[name="amount_consumption"]').val(data.amount_consumption);
        };









        //return value of this invoice modal object module
        return {
            setMode: 		setCurrentMode,
            getMode:		getCurrentMode,
            clearFields: 	clearFields,
            showModal: 		showModal,
            hideModal:		hideModal,
            showConfirmModal: 		showConfirmModal,
            hideConfirmModal:		hideConfirmModal,

            setDetails: 	setItemModalDetails,
            setSelectedID: 	setSelectedID,
            getSelectedID: 	getSelectedID,
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





    /************************************************************************************/

    var _btnNew='<button class="btn btn-white btn-sm"  id="btn_new_item" data-toggle="modal" data-target="#item_modal" data-placement="left" title="Create New Item" ><i class="fa fa-users"></i> Create New Item</button>';

    itemListModule.createToolBarButton(_btnNew);
    itemListModule.showItemList();


    $('#btn_new_item').click(function(){
        itemInfoModalModule.setMode("new");
        itemInfoModalModule.clearFields(); //clear fields
    });
});

















