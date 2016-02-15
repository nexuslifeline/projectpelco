
$(document).ready(function(){



    //initialize customer list
    var userListModule = (function(){
        var tbl_user_list;

        var bindEventHandlers=(function(){
            /**
             *
             *	fires when edit user button on selected row is clicked
             *
             */
            $('#tbl_user_list tbody').on('click','button[name="edit_user"]',function(){
                var row=$(this).closest('tr');
                userInfoModalModule.setMode("edit"); //set mode to editing
                userInfoModalModule.setSelectedID(row.find('td:eq(0) input[type="checkbox"]').val()); //what is the id of the user we are going to update
                userInfoModalModule.setSelectedRow(row); //remember the row we are going to update
                //object details of modal
                userInfoModalModule.setDetails({
                    "user_id"	    :		row.find('td:eq(0) input[type="checkbox"]').val(),
                    "username"	    :		row.find('td:eq(0) input[type="checkbox"]').attr('data-username'),
                    "password"	    :		row.find('td:eq(0) input[type="checkbox"]').attr('data-password'),
                    "email"	        :		row.find('td:eq(0) input[type="checkbox"]').attr('data-email'),
                    "firstname"	    :		row.find('td:eq(0) input[type="checkbox"]').attr('data-firstname'),
                    "middlename"	:		row.find('td:eq(0) input[type="checkbox"]').attr('data-middlename'),
                    "lastname"	    :		row.find('td:eq(0) input[type="checkbox"]').attr('data-lastname'),
                    "address"   	:		row.find('td:eq(0) input[type="checkbox"]').attr('data-address'),
                    "birthdate"	    :		row.find('td:eq(0) input[type="checkbox"]').attr('data-birthdate'),
                    "mobile"	    :		row.find('td:eq(0) input[type="checkbox"]').attr('data-mobile'),
                    "landline"	    :		row.find('td:eq(0) input[type="checkbox"]').attr('data-landline')


                });

                //show invoice info modal
                userInfoModalModule.showModal();

            });

            $('#tbl_user_list tbody').on('click','button[name="remove_user"]',function(){
                var row=$(this).closest('tr');
                userInfoModalModule.setMode("remove"); //set mode to editing
                userInfoModalModule.setSelectedID(row.find('td:eq(0) input[type="checkbox"]').val()); //what is the id of the user we are going to update
                userInfoModalModule.setSelectedRow(row); //remember the row we are going to update
                //object details of modal

                //show invoice info modal
                userInfoModalModule.showConfirmModal();
                $('#modal_mode').html("REMOVE ")
            });

        })();

        var initializeUserDatatable = (function(){
            tbl_user_list=$('#tbl_user_list').DataTable({
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
                            'data-username="'+data.split('|')[1]+'"' +
                            'data-password="'+data.split('|')[2]+'"' +
                            'data-email="'+data.split('|')[3]+'"' +
                            'data-firstname="'+data.split('|')[4]+'"' +
                            'data-middlename="'+data.split('|')[5]+'"' +
                            'data-lastname="'+data.split('|')[6]+'"' +
                            'data-address="'+data.split('|')[7]+'"' +
                            'data-birthdate="'+data.split('|')[8]+'"' +
                            'data-mobile="'+data.split('|')[9]+'"' +
                            'data-landline="'+data.split('|')[10]+'"' +
                            '>';
                        }
                    } ,
                    {
                        'targets': [6],
                        'render': function (data, type, full, meta){
                            var btn_edit='<button class="btn btn-white btn-sm" name="edit_user"  style="margin-left:-15px;" data-toggle="tooltip" data-placement="top" title="Edit User"><i class="fa fa-pencil"></i> </button>';
                            var btn_trash='<button class="btn btn-white btn-sm" name="remove_user" style="margin-right:-15px;" data-toggle="tooltip" data-placement="top" title="Move to trash"><i class="fa fa-trash-o"></i> </button>';
                            return '<center>'+btn_edit+btn_trash+'</center>';
                        }



                    }
                ]

            });
        })();
        // tbl user list datatable initialization

        var  showUserList=function(){

            $('#tbl_user_list tbody').html('<tr><td colspan="6" align="center"><img src="assets/img/ajax-loader-sm.gif" /></td></tr>');
            $.getJSON("UserManagementController/ActionGetUserList", function(response){
                tbl_user_list.clear().draw();
                console.log(response);

                $.each(response,function(index,value){
                    //alert(value.customer_id);
                    tbl_user_list.row.add([
                        value.hidden,
                        value.name,
                        value.address,
                        value.mobile,
                        value.email,
                        value.birthdate

                    ]);
                });

                tbl_user_list.draw();

            }).fail(function(xhr,stat,error){
                alert(xhr.responseText);
                console.log(xhr);
            });
        };



        var lastPage=function(){
            $('#tbl_user_list ul li:nth-last-child(2) a').click(); //trigger 2nd to the last link, the last page number
        };


        var addRow=function(data){
            tbl_user_list
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
            return tbl_user_list;
        };

        //update row
        var updateRow=function(row,data){
            tbl_user_list
                .row(row)
                .data(data)
                .draw();
        };

        var removeRow=function(row,data){
            tbl_user_list
                .row(row)
                .remove(data)
                .draw();
        };


        //return objects as functions
        return {
            getTableInstance : 		getTableInstance,
            createToolBarButton: 	createToolBarButton,
            showUserList:       showUserList,
            addRow: 				addRow,
            updateRow:				updateRow,
            removeRow:				removeRow,
            lastPage: 				lastPage
        };

    })();






    var userInfoModalModule=(function(){
        var _mode;		var _selectedID;	 var _selectedRow;
        //binds all events of invoice modal
        var bindEventHandlers=(function(){

            /**
             *
             * fires everytime the record invoice button on modal is clicked
             *
             **/
            $('#btn_create_user').click(function(){

                if(validateRequiredFields()){ //if true, all required fields are supplied
                        var pass = $('input[name="password"]').val();
                        var cpass= $('input[name="confirm_password"]').val();
                    if(pass==cpass){
                        if(_mode=="new"){ //if current mode is new
                        createNewUser()

                            .success(function(response){ //if request is successful
                                console.log(response);

                                PNotify.removeAll(); //remove all notifications
                                new PNotify({
                                    title: 'Success!',
                                    text:  response.msg,
                                    type:  response.stat
                                }); //create new notification base on server response

                                var row=response.row[0];
                                var data=[
                                    row.hidden,
                                    row.name,
                                    row.address,
                                    row.mobile,
                                    row.email,
                                    row.birthdate,
                                    ""
                                ];
                                userListModule.addRow(data); //add the info of recent invoice
                                userListModule.lastPage(); //go to last page
                                clearFields(); //clear fields

                            })
                            .error(function(xhr,stat,error){ //if error occurs
                                alert(xhr.responseText);
                                console.log(xhr);
                            });



                    }else{		//if current mode is update

                        updateUser()
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
                                    row.hidden,
                                    row.name,
                                    row.address,
                                    row.mobile,
                                    row.email,
                                    row.birthdate,""];
                                userListModule.updateRow(_selectedRow,data);
                                clearFields(); //clear fields


                            })
                            .error(function(xhr,stat,error){ //if error occurs
                                alert(xhr.responseText);
                                console.log(xhr);
                            });
                    }

                }



                    else{

                        PNotify.removeAll(); //remove all notifications
                        new PNotify({
                            title: 'Error!',
                            text:  'Password do not match',
                            type:  'error'
                        }); //create new notification base on server response

                    }

                }
            });



            $('#btn_yes').click(function(){
                removeUser()
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
                        var data=[
                            row.hidden,
                            row.name,
                            row.address,
                            row.mobile,
                            row.email,
                            row.birthdate,
                            ""];
                        userListModule.removeRow(_selectedRow,data);

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

        //add new user
        var createNewUser=function(){

            var serialData=$('#frm_user_info').serializeArray();

            return $.ajax({
                "dataType":"json",
                "type":"POST",
                "url":"UserManagementController/ActionSaveUserInfo",
                "data":serialData
            });


        }; //end of saveUserInfo

        //update user
        var updateUser=function(){

            var serialData=$('#frm_user_info').serializeArray();
            serialData.push({
                name:"id",value: _selectedID
            });



            console.log(serialData);

            return $.ajax({
                "dataType":"json",
                "type":"POST",
                "url":"UserManagementController/ActionUpdateUserInfo",
                "data":serialData
            });

        };

        //remove user
        var removeUser=function(){

            var serialData=$('#frm_user_info').serializeArray();
            serialData.push({
                name:"id",value: _selectedID
            });
            console.log(serialData);
            return $.ajax({
                "dataType":"json",
                "type":"POST",
                "url":"UserManagementController/ActionDeleteUserInfo",
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

        //set selected id, the user
        var setSelectedID=function(id){
            _selectedID=id;
        };

        //get selected id, the user
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
            $('#frm_user_info input,#frm_user_info textarea').val('');

        };


        var showModal=function(){
            $('#user_modal').modal('show');
        };

        var hideModal=function(){
            $('#user_modal').modal('hide');
        };


        var showConfirmModal=function(){
            $('#confirm_modal').modal('show');
        };

        var hideConfirmModal=function(){
            $('#confirm_modal').modal('hide');
        };

        //set invoice modal details
        var setUserModalDetails=function(data){
            $('input[name="firstname"]').val(data.firstname);
            $('input[name="middlename"]').val(data.middlename);
            $('input[name="lastname"]').val(data.lastname);
            $('input[name="lastname"]').val(data.lastname);
            $('input[name="birthdate"]').val(data.birthdate);
            $('textarea[name="address"]').html(data.address);
            $('input[name="mobile"]').val(data.mobile);
            $('input[name="landline"]').val(data.landline);
            $('input[name="username"]').val(data.username);
            $('input[name="password"]').val(data.password);
            $('input[name="confirm_password"]').val(data.password);
            $('input[name="email"]').val(data.email);
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

            setDetails: 	setUserModalDetails,
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

    var _btnNew='<button class="btn btn-white btn-sm"  id="btn_new_user" data-toggle="modal" data-target="#user_modal" data-placement="left" title="Create New User" ><i class="fa fa-users"></i> Create New User</button>';

    userListModule.createToolBarButton(_btnNew);
    userListModule.showUserList();


    $('#btn_new_user').click(function(){
        userInfoModalModule.setMode("new");
        userInfoModalModule.clearFields(); //clear fields
    });


    $('input[name="birthdate"]').daterangepicker({
        singleDatePicker: true,
        calender_style: "picker_4"
    }, function (start, end, label) {
        console.log(start.toISOString(), end.toISOString(), label);
    });
});

















