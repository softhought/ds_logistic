$( document ).ready(function() {
    var basepath = $("#basepath").val();

    $(document).on('submit','#SupervisorForm',function(e){
        e.preventDefault();    
        if(SupervisorValidation())
        {        
        
            var formDataserialize = $("#SupervisorForm").serialize();
            // alert(formDataserialize);
            // console.log(formDataserialize);
            var type = "POST"; //for creating new resource
            var urlpath = basepath + 'master/supervisor_action';
            $("#supervisorsavebtn").css('display', 'none');
                $("#loaderbtn").css('display', 'block');
    
            $.ajax({
                type: type,
                url: urlpath,
                data: formDataserialize,
                success: function(result) {
                    // alert(result.msg_status);
                    if (result.msg_status == 200) {
                            
                        $("#suceessmodal").modal({
                            "backdrop": "static",
                            "keyboard": true,
                            "show": true
                        });
                        var addurl = basepath + "master/addSupervisor";
                        var listurl = basepath + "master/supervisor";
                        $("#responsemsg").text(result.msg_data);
                        $("#response_add_more").attr("href", addurl);
                        $("#response_list_view").attr("href", listurl);
    
                    } 
                    else {
                        $("#cas_response_msg").text(result.msg_data);
                    }
                    
                    $("#loaderbtn").css('display', 'none');
                    
                    $("#supervisorsavebtn").css({
                        "display": "block",
                        "margin": "0 auto"
                    });
                },
                error: function(jqXHR, exception) {
                    var msg = '';
                }
            });
            
            
        }
    
    });

 


    
    $(document).on("click", ".superstatus", function() {
       
		var uid = $(this).data("supervisorid");
        var status = $(this).data("setstatus");
        var url = basepath + 'master/setSupervisorStatus';
        setActiveStatus(uid, status, url);

    });


        //  Code check supervisor pin

    $(document).on('keyup','#supervisorpin',function(e){
        e.preventDefault();
        
            var mode = $("#mode").val();
           
            $("#clsmsg").text("").css("display", "none").removeClass("form_error");

            var supervisorpin = $("#supervisorpin").val();
            var presupervisorpin = $("#presupervisorpin").val();


            if(supervisorpin==presupervisorpin && mode=="EDIT") {
                
            }
            else{
              
                $("#error_msg").text("").css("display", "none");
    
                var type = "POST"; 
                var urlpath = basepath + 'master/checkSupervisorPin';
                $.ajax({
                    type: type,
                    url: urlpath,
                    data: {supervisorpin:supervisorpin},
                    dataType: 'json',
                    contentType: "application/x-www-form-urlencoded; charset=UTF-8",
                    success: function(result) {
                        if(result.msg_status==1){
                            $("#error_msg")
                            .text("Error : Pin already exist.Please check...")
                            .addClass("form_error")
                            .css("display", "block");
                            $("#supervisorsavebtn").attr('disabled',true);
                        }
                        else{
                            $("#error_msg").text("").css("display", "none");
                            $("#supervisorsavebtn").attr('disabled',false);
                        }
                    },
                    error: function(jqXHR, exception) {
                        var msg = '';
                    }
                });
                
           
            }
    });



            //  Code check supervisor Employee Code

            $(document).on('keyup','#emp_code',function(e){
                e.preventDefault();
                
                    var mode = $("#mode").val();
                   
                    $("#clsmsg").text("").css("display", "none").removeClass("form_error");
        
                    var emp_code = $("#emp_code").val();
                    var preemp_code = $("#preemp_code").val();
        
        
                    if(emp_code==preemp_code && mode=="EDIT") {
                        
                    }
                    else{
                      
                        $("#error_msg").text("").css("display", "none");
            
                        var type = "POST"; 
                        var urlpath = basepath + 'master/checkSupervisorEmployeeCode';
                        $.ajax({
                            type: type,
                            url: urlpath,
                            data: {emp_code:emp_code},
                            dataType: 'json',
                            contentType: "application/x-www-form-urlencoded; charset=UTF-8",
                            success: function(result) {
                                if(result.msg_status==1){
                                    $("#error_msg")
                                    .text("Error : Employee Code already exist.Please check...")
                                    .addClass("form_error")
                                    .css("display", "block");
                                    $("#supervisorsavebtn").attr('disabled',true);
                                }
                                else{
                                    $("#error_msg").text("").css("display", "none");
                                    $("#supervisorsavebtn").attr('disabled',false);
                                }
                            },
                            error: function(jqXHR, exception) {
                                var msg = '';
                            }
                        });
                        
                   
                    }
            });
    



});/* document ready end */




function SupervisorValidation()
{
    $("#clsmsg").text("").css("display", "none").removeClass("form_error");
    $('#sel_employee_div,#supervisor_div,#empcode_div,#pin_div,#project_div').removeClass('has-error');
   

    if ($('#sel_employee_type').val()=="0") {       
        $('#sel_employee_div').addClass('has-error');
        $("#clsmsg")
        .text("Error : Select Employee Type")
        .addClass("form_error")
        .css("display", "block");
        return false; 
    }
    if ($('#spname').val()=="") {       
        $('#supervisor_div').addClass('has-error');
        $("#clsmsg")
		.text("Error : Enter Supervisor Name")
		.addClass("form_error")
        .css("display", "block");
        return false; 
    }

    if ($('#emp_code').val()=="") {       
        $('#empcode_div').addClass('has-error');
        $("#clsmsg")
        .text("Error : Enter Employee Code")
        .addClass("form_error")
        .css("display", "block");
        return false; 
    }

    if ($('#supervisorpin').val()=="") {       
        $('#pin_div').addClass('has-error');
        $("#clsmsg")
        .text("Error : Enter Pin")
        .addClass("form_error")
        .css("display", "block");
        return false; 
    }

      if ($('#project').val()=="") {       
        $('#project_div').addClass('has-error');
        $("#clsmsg")
        .text("Error : Select project")
        .addClass("form_error")
        .css("display", "block");
        return false; 
    }

    return true;
}