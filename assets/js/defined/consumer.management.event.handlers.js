
$(document).ready(function(){
    //initialize customer list
        var consumerListModule = (function(){
            var tbl_consumer_list;

            var bindEventHandlers=(function(){
                /**
                 *
                 *	fires when edit consumer button on selected row is clicked
                 *
                 */
                $('#tbl_consumer_list tbody').on('click','button[name="edit_consumer"]',function(){
                    var row=$(this).closest('tr');
                    consumerInfoModalModule.setMode("edit"); //set mode to editing
                    consumerInfoModalModule.setSelectedID(row.find('td:eq(0) input[type="checkbox"]').val()); //what is the id of the consumer we are going to update
                    consumerInfoModalModule.setSelectedRow(row); //remember the row we are going to update
                    //object details of modal
                    consumerInfoModalModule.setDetails({
                        "consumer_id"	:		row.find('td:eq(0) input[type="checkbox"]').val(),
                        "consumer_name"	:		row.find('td').eq(1).text(),
                        "contact_no"	:		row.find('td:eq(0) input[type="checkbox"]').attr('data-contact-no'),
                        "email"	        :		row.find('td:eq(0) input[type="checkbox"]').attr('data-email'),
                        "second_address"	:		row.find('td:eq(0) input[type="checkbox"]').attr('data-second-address'),
                        "meter_no"	    :		row.find('td:eq(0) input[type="checkbox"]').attr('data-meter-no'),
                        "house_no"	    :		row.find('td:eq(0) input[type="checkbox"]').attr('data-house-no'),
                        "street_no"	    :		row.find('td:eq(0) input[type="checkbox"]').attr('data-street-no'),
                        "barangay"	    :		row.find('td:eq(0) input[type="checkbox"]').attr('data-barangay'),
                        "municipality"	:		row.find('td:eq(0) input[type="checkbox"]').attr('data-municipality'),
                        "zipcode"	    :		row.find('td:eq(0) input[type="checkbox"]').attr('data-zipcode'),
                        "province"	    :		row.find('td:eq(0) input[type="checkbox"]').attr('data-province')
                    });

                    //show invoice info modal
                    consumerInfoModalModule.showModal();

                });

                $('#tbl_consumer_list tbody').on('click','button[name="remove_consumer"]',function(){
                    var row=$(this).closest('tr');
                    consumerInfoModalModule.setMode("remove"); //set mode to editing
                    consumerInfoModalModule.setSelectedID(row.find('td:eq(0) input[type="checkbox"]').val()); //what is the id of the consumer we are going to update
                    consumerInfoModalModule.setSelectedRow(row); //remember the row we are going to update
                    //object details of modal

                    //show invoice info modal
                    consumerInfoModalModule.showConfirmModal();
                    $('#modal_mode').html("REMOVE ")
                });

            })();

            var initializeConsumerDatatable = (function(){
                            tbl_consumer_list=$('#tbl_consumer_list').DataTable({
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
                                            'data-contact-no="'+data.split('|')[1]+'"' +
                                            'data-email="'+data.split('|')[2]+'"' +
                                            'data-second-address="'+data.split('|')[3]+'"' +
                                            'data-meter-no="'+data.split('|')[4]+'"' +
                                            'data-house-no="'+data.split('|')[5]+'"' +
                                            'data-street-no="'+data.split('|')[6]+'"' +
                                            'data-barangay="'+data.split('|')[7]+'"' +
                                            'data-municipality="'+data.split('|')[8]+'"' +
                                            'data-zipcode="'+data.split('|')[9]+'"' +
                                            'data-province="'+data.split('|')[10]+'"' +
                                            '>';
                                        }
                                    } ,
                                    {
                                        'targets': [4],
                                        'render': function (data, type, full, meta){
                                            var btn_edit='<button class="btn btn-white btn-sm" name="edit_consumer"  style="margin-left:-15px;" data-toggle="tooltip" data-placement="top" title="Edit Customer"><i class="fa fa-pencil"></i> </button>';
                                            var btn_trash='<button class="btn btn-white btn-sm" name="remove_consumer" style="margin-right:-15px;" data-toggle="tooltip" data-placement="top" title="Move to trash"><i class="fa fa-trash-o"></i> </button>';
                                            return '<center>'+btn_edit+btn_trash+'</center>';
                                        }



                                    }
                                ]

                            });
                        })();
                        // tbl consumer list datatable initialization

            var  showConsumerList=function(){

                $('#tbl_consumer_list tbody').html('<tr><td colspan="6" align="center"><img src="assets/img/ajax-loader-sm.gif" /></td></tr>');
                $.getJSON("ConsumerManagementController/ActionGetConsumerList", function(response){
                        tbl_consumer_list.clear().draw();
                        console.log(response);

                        $.each(response,function(index,value){
                            //alert(value.customer_id);
                            tbl_consumer_list.row.add([
                                value.hidden,
                                value.consumer_name,
                                value.address,
                                '0'

                            ]);
                        });

                        tbl_consumer_list.draw();

                    }).fail(function(xhr,stat,error){
                        alert(xhr.responseText);
                        console.log(xhr);
                    });
            };



            var lastPage=function(){
                $('#tbl_consumer_list ul li:nth-last-child(2) a').click(); //trigger 2nd to the last link, the last page number
            };


            var addRow=function(data){
                tbl_consumer_list
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
                return tbl_consumer_list;
            };

            //update row
            var updateRow=function(row,data){
                tbl_consumer_list
                    .row(row)
                    .data(data)
                    .draw();
            };

            var removeRow=function(row,data){
                tbl_consumer_list
                    .row(row)
                    .remove(data)
                    .draw();
            };


            //return objects as functions
            return {
                getTableInstance : 		getTableInstance,
                createToolBarButton: 	createToolBarButton,
                showConsumerList:       showConsumerList,
                addRow: 				addRow,
                updateRow:				updateRow,
                removeRow:				removeRow,
                lastPage: 				lastPage
            };

        })();






    var consumerInfoModalModule=(function(){
        var _mode;		var _selectedID;	 var _selectedRow;
        //binds all events of invoice modal
        var bindEventHandlers=(function(){

            /**
             *
             * fires everytime the record invoice button on modal is clicked
             *
             **/
            $('#btn_create_consumer').click(function(){

                if(validateRequiredFields()){ //if true, all required fields are supplied

                    if(_mode=="new"){ //if current mode is new
                        createNewConsumer()

                            .success(function(response){ //if request is successful
                                console.log(response);

                                PNotify.removeAll(); //remove all notifications
                                new PNotify({
                                    title: 'Success!',
                                    text:  response.msg,
                                    type:  response.stat
                                }); //create new notification base on server response

                                var row=response.row[0];
                                var data=[row.hidden,row.consumer_name,row.address,"0"];
                                consumerListModule.addRow(data); //add the info of recent invoice
                                consumerListModule.lastPage(); //go to last page
                                clearFields(); //clear fields

                            })
                            .error(function(xhr,stat,error){ //if error occurs
                                alert(xhr.responseText);
                                console.log(xhr);
                            });



                    }else{		//if current mode is update

                        updateConsumer()
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
                                var data=[row.hidden,row.consumer_name,row.address,""];
                                consumerListModule.updateRow(_selectedRow,data);
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
                        removeConsumer()
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
                                var data=[row.hidden,row.consumer_name,row.address,""];
                                consumerListModule.removeRow(_selectedRow,data);

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

        //add new consumer
        var createNewConsumer=function(){

            var serialData=$('#frm_consumer_info').serializeArray();

            return $.ajax({
                "dataType":"json",
                "type":"POST",
                "url":"ConsumerManagementController/ActionSaveConsumerInfo",
                "data":serialData
            });


        }; //end of saveConsumerInfo

        //update consumer
        var updateConsumer=function(){

            var serialData=$('#frm_consumer_info').serializeArray();
            serialData.push({
                name:"id",value: _selectedID
            });



            console.log(serialData);

            return $.ajax({
                "dataType":"json",
                "type":"POST",
                "url":"ConsumerManagementController/ActionUpdateConsumerInfo",
                "data":serialData
            });

        };

        //remove consumer
        var removeConsumer=function(){

            var serialData=$('#frm_consumer_info').serializeArray();
            serialData.push({
                name:"id",value: _selectedID
            });
            console.log(serialData);
            return $.ajax({
                "dataType":"json",
                "type":"POST",
                "url":"ConsumerManagementController/ActionDeleteConsumerInfo",
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
            $('#frm_consumer_info input,#frm_consumer_info textarea').val('');

        };


        var showModal=function(){
            $('#consumer_modal').modal('show');
        };

        var hideModal=function(){
            $('#consumer_modal').modal('hide');
        };


        var showConfirmModal=function(){
            $('#confirm_modal').modal('show');
        };

        var hideConfirmModal=function(){
            $('#confirm_modal').modal('hide');
        };

        //set invoice modal details
        var setConsumerModalDetails=function(data){
            $('input[name="consumer_name"]').val(data.consumer_name);
            $('input[name="contact_no"]').val(data.contact_no);
            $('input[name="email"]').val(data.email);
            $('input[name="house_no"]').val(data.house_no);
            $('input[name="street"]').val(data.street_no);
            $('input[name="barangay"]').val(data.barangay);
            $('input[name="municipality"]').val(data.municipality);
            $('input[name="province"]').val(data.province);
            $('input[name="zipcode"]').val(data.zipcode);
            $('textarea[name="second_address"]').html(data.second_address);
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

            setDetails: 	setConsumerModalDetails,
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

    var _btnNew='<button class="btn btn-white btn-sm"  id="btn_new_consumer" data-toggle="modal" data-target="#consumer_modal" data-placement="left" title="Create New Consumer" ><i class="fa fa-users"></i> Create New Consumer</button>';

    consumerListModule.createToolBarButton(_btnNew);
    consumerListModule.showConsumerList();


    $('#btn_new_consumer').click(function(){
        consumerInfoModalModule.setMode("new");
        consumerInfoModalModule.clearFields(); //clear fields
    });
});

















