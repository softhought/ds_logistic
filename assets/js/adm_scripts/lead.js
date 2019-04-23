$(document ).ready(function() {
    var basepath = $("#basepath").val();
   
   
    $(document).on('submit','#leadForm',function(e){
		e.preventDefault();


		if(validateLead())
		{

          
           
            var formDataserialize = $("#leadForm").serialize();
            formDataserialize = decodeURI(formDataserialize);
            console.log(formDataserialize);

            var formData = { formDatas: formDataserialize };
            var type = "POST"; //for creating new resource
            var urlpath = basepath + 'lead/lead_action';
            $("#leadsavebtn").css('display', 'none');
            $("#loaderbtn").css('display', 'block');

            $.ajax({
                type: type,
                url: urlpath,
                data: formData,
                dataType: 'json',
                contentType: "application/x-www-form-urlencoded; charset=UTF-8",
                success: function(result) {
					if (result.msg_status == 1) {
							
                        $("#suceessmodal").modal({
                            "backdrop": "static",
                            "keyboard": true,
                            "show": true
                        });
                        var addurl = basepath + "lead/addLead";
                        var listurl = basepath + "lead";
                        $("#responsemsg").text(result.msg_data);
                        $("#response_add_more").attr("href", addurl);
                        $("#response_list_view").attr("href", listurl);

                    } 
					else {
                        $("#lead_response_msg").text(result.msg_data);
                    }
					
                    $("#loaderbtn").css('display', 'none');
					
                    $("#leadsavebtn").css({
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
    




    //  Code

    $(document).on('keyup','#projectcode',function(e){
        e.preventDefault();
        
            var mode = $("#mode").val();
           

            var projectcode = $("#projectcode").val();
            var prvprojectcode = $("#prvprojectcode").val();


            if(projectcode==prvprojectcode && mode=="EDIT") {
                
            }
            else{
              
                $("#error_msg").text("").css("display", "none");
    
                var type = "POST"; 
                var urlpath = basepath + 'project/checkProjectCode';
                $.ajax({
                    type: type,
                    url: urlpath,
                    data: {projectcode:projectcode},
                    dataType: 'json',
                    contentType: "application/x-www-form-urlencoded; charset=UTF-8",
                    success: function(result) {
                        if(result.msg_status==1){
                            $("#error_msg")
                            .text("Error : Project Code already exist.Please check...")
                            .addClass("form_error")
                            .css("display", "block");
                            $("#projectsavebtn").attr('disabled',true);
                        }
                        else{
                            $("#error_msg").text("").css("display", "none");
                            $("#projectsavebtn").attr('disabled',false);
                        }
                    },
                    error: function(jqXHR, exception) {
                        var msg = '';
                    }
                });
                
           
            }
    });






    $(document).on("click", ".projectstatus", function() {
        
		var uid = $(this).data("projectid");
        var status = $(this).data("setstatus");
        var url = basepath + 'project/setProjectStatus';
        setActiveStatus(uid, status, url);

    });

    /* On change project change servier*/

        $(document).on("change", "#project", function() {

            getServier(basepath);
            getExcavator(basepath);
            getMaterial(basepath);
       });


    
   /* On change servier,shift,shiftdate get excavator */
    $(document).on("change", "#sel_servier,#sel_shift,#shiftdate", function() {

        getExcavator(basepath);
    });


   /* On select class  */
    $(document).on("change", "#listshiftdate", function() {

        var shiftdate = $("#listshiftdate").val();
       
        $("#leadlistdata").html('');
       
    $.ajax({
    type: "POST",
    url: basepath+'lead/getLeadListByDate',
    data: {shiftdate:shiftdate},
    
    success: function(data){
        $("#leadlistdata").html(data);
        $('#example').DataTable();
       
    },
    error: function (jqXHR, exception) {
                  var msg = '';
                    if (jqXHR.status === 0) {
                        msg = 'Not connect.\n Verify Network.';
                    } else if (jqXHR.status == 404) {
                        msg = 'Requested page not found. [404]';
                    } else if (jqXHR.status == 500) {
                        msg = 'Internal Server Error [500].';
                    } else if (exception === 'parsererror') {
                        msg = 'Requested JSON parse failed.';
                    } else if (exception === 'timeout') {
                        msg = 'Time out error.';
                    } else if (exception === 'abort') {
                        msg = 'Ajax request aborted.';
                    } else {
                        msg = 'Uncaught Error.\n' + jqXHR.responseText;
                    }
                   // alert(msg);  
                }



    });/*end ajax call*/

    });



});/* document ready end */



function validateLead()
{
    
    var project = $("#project").val();
    var sel_servier = $("#sel_servier").val();
    var sel_shift = $("#sel_shift").val();
    var shiftdate = $("#shiftdate").val();
    var sel_excavator = $("#sel_excavator").val();
    var material_type = $("#material_type").val();
    var lead = $("#lead").val();
    var rl_in_face = $("#rl_in_face").val();
    var rl_in_dump = $("#rl_in_dump").val();

    

    $("#error_msg").text("").css("dispaly", "none").removeClass("form_error");

    if(project=="0")
    {
        $("#project").focus();
        $("#error_msg")
        .text("Error : Select project")
        .addClass("form_error")
        .css("display", "block");
        return false;
    }

    if(sel_servier=="0")
    {
        $("#sel_shift").focus();
        $("#error_msg")
        .text("Error : Select servier")
        .addClass("form_error")
        .css("display", "block");
        return false;
    }


    if(sel_shift=="0")
    {
        $("#sel_shift").focus();
        $("#error_msg")
        .text("Error : Select shift")
        .addClass("form_error")
        .css("display", "block");
        return false;
    }


    if(shiftdate=="")
    {
        $("#shiftdate").focus();
        $("#error_msg")
        .text("Error : Select shift date")
        .addClass("form_error")
        .css("display", "block");
        return false;
    }

    if(sel_excavator=="0")
    {
        $("#sel_excavator").focus();
        $("#error_msg")
        .text("Error : Select excavator")
        .addClass("form_error")
        .css("display", "block");
        return false;
    }

    if(material_type=="0")
    {
        $("#material_type").focus();
        $("#error_msg")
        .text("Error : Select Carrying")
        .addClass("form_error")
        .css("display", "block");
        return false;
    }

    if(lead=="")
    {
        $("#lead").focus();
        $("#error_msg")
        .text("Error : Enter Lead")
        .addClass("form_error")
        .css("display", "block");
        return false;
    }

   if(rl_in_face=="")
    {
        $("#rl_in_face").focus();
        $("#error_msg")
        .text("Error : Enter Rl In Face")
        .addClass("form_error")
        .css("display", "block");
        return false;
    }

    if(rl_in_dump=="")
    {
        $("#rl_in_dump").focus();
        $("#error_msg")
        .text("Error : Enter Rl In Dump")
        .addClass("form_error")
        .css("display", "block");
        return false;
    }

	return true;
}


function confirmProjectCode(){

    var projectcode = $("#projectcode").val();
    var mode = $("#mode").val();

    if(mode=='ADD'){
        if (confirm('Confirm Project Code: '+projectcode)) {
            return true;
        } else {
            return false;
        }

    }else{
        return true;
    }
    

}


function getExcavator(basepath){

          var sel_servier=$('select[name=sel_servier]').val();
        var project=$('select[name=project]').val();
        var sel_shift = $("#sel_shift").val();
        var shiftdate = $("#shiftdate").val();
       

       
    $.ajax({
    type: "POST",
    url: basepath+'lead/getExcavatorByServier',
    data: {sel_servier:sel_servier,sel_shift:sel_shift,shiftdate:shiftdate,project:project},
    
    success: function(data){
        $("#excavator_dropdown").html(data);
        $('.selectpicker').selectpicker();
    },
    error: function (jqXHR, exception) {
                  var msg = '';
                    if (jqXHR.status === 0) {
                        msg = 'Not connect.\n Verify Network.';
                    } else if (jqXHR.status == 404) {
                        msg = 'Requested page not found. [404]';
                    } else if (jqXHR.status == 500) {
                        msg = 'Internal Server Error [500].';
                    } else if (exception === 'parsererror') {
                        msg = 'Requested JSON parse failed.';
                    } else if (exception === 'timeout') {
                        msg = 'Time out error.';
                    } else if (exception === 'abort') {
                        msg = 'Ajax request aborted.';
                    } else {
                        msg = 'Uncaught Error.\n' + jqXHR.responseText;
                    }
                   // alert(msg);  
                }



    });/*end ajax call*/

}


function getServier(basepath){

            var project=$('select[name=project]').val();
      
       

       
    $.ajax({
    type: "POST",
    url: basepath+'lead/getServierByProject',
    data: {project:project},
    
    success: function(data){
        $("#servier_dropdown").html(data);
      
        $('.selectpicker').selectpicker();
    },
    error: function (jqXHR, exception) {
                  var msg = '';
                    if (jqXHR.status === 0) {
                        msg = 'Not connect.\n Verify Network.';
                    } else if (jqXHR.status == 404) {
                        msg = 'Requested page not found. [404]';
                    } else if (jqXHR.status == 500) {
                        msg = 'Internal Server Error [500].';
                    } else if (exception === 'parsererror') {
                        msg = 'Requested JSON parse failed.';
                    } else if (exception === 'timeout') {
                        msg = 'Time out error.';
                    } else if (exception === 'abort') {
                        msg = 'Ajax request aborted.';
                    } else {
                        msg = 'Uncaught Error.\n' + jqXHR.responseText;
                    }
                   // alert(msg);  
                }



    });/*end ajax call*/

}

function getMaterial(basepath){

            var project=$('select[name=project]').val();
      
       

       
    $.ajax({
    type: "POST",
    url: basepath+'lead/getMaterialByProject',
    data: {project:project},
    
    success: function(data){
        $("#material_dropdown").html(data);
      
        $('.selectpicker').selectpicker();
    },
    error: function (jqXHR, exception) {
                  var msg = '';
                    if (jqXHR.status === 0) {
                        msg = 'Not connect.\n Verify Network.';
                    } else if (jqXHR.status == 404) {
                        msg = 'Requested page not found. [404]';
                    } else if (jqXHR.status == 500) {
                        msg = 'Internal Server Error [500].';
                    } else if (exception === 'parsererror') {
                        msg = 'Requested JSON parse failed.';
                    } else if (exception === 'timeout') {
                        msg = 'Time out error.';
                    } else if (exception === 'abort') {
                        msg = 'Ajax request aborted.';
                    } else {
                        msg = 'Uncaught Error.\n' + jqXHR.responseText;
                    }
                   // alert(msg);  
                }



    });/*end ajax call*/

}