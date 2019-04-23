$(document ).ready(function() {
    var basepath = $("#basepath").val();


$("#loader").css('display', 'none');

    
   
    $(document).on('submit','#BreakdownForm',function(e){
		e.preventDefault();


		if(validateBreakDown())
		{

          
           
            var formDataserialize = $("#BreakdownForm").serialize();
            formDataserialize = decodeURI(formDataserialize);
            console.log(formDataserialize);

            var formData = { formDatas: formDataserialize };
            var type = "POST"; //for creating new resource
            var urlpath = basepath + 'breakdown/breakdown_action';
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
							
                   
                     window.location.href = basepath+'breakdown';

                    } 
					else {
                       // $("#lead_response_msg").text(result.msg_data);
                    }
					
                    $("#loaderbtn").css('display', 'none');
					
                   
                },
                error: function(jqXHR, exception) {
                    var msg = '';
                }
            });
            
            
           
			
		}

    });

    /*  save/update break down cause */


        $(document).on('submit','#breakdownCauseForm',function(e){
        e.preventDefault();


        if(validateBreakDowncause())
        {

          
           
            var formDataserialize = $("#breakdownCauseForm").serialize();
            formDataserialize = decodeURI(formDataserialize);
            console.log(formDataserialize);

            var formData = { formDatas: formDataserialize };
            var type = "POST"; //for creating new resource
            var urlpath = basepath + 'breakdown/breakdowncause_action';
            $("#breakdowncausesavebtn").css('display', 'none');
            $("#loaderbtn").css('display', 'block');

            $.ajax({
                type: type,
                url: urlpath,
                data: formData,
                dataType: 'json',
                contentType: "application/x-www-form-urlencoded; charset=UTF-8",
                success: function(result) {
                    if (result.msg_status == 1) {
                            
                   
                     window.location.href = basepath+'master/breakdowncause';

                    } 
                    else {
                       // $("#lead_response_msg").text(result.msg_data);
                    }
                    
                    $("#loaderbtn").css('display', 'none');
                    
                   
                },
                error: function(jqXHR, exception) {
                    var msg = '';
                }
            });
            
            
           
            
        }

    });
    

    
   /* On change breakdown date  */
    $(document).on("change", "#breakdowndate", function() {

        var breakdowndate = $("#breakdowndate").val();
       
       $("#breakdownlistdata").html('');
       
    $.ajax({
    type: "POST",
    url: basepath+'breakdown/getBreakdownlistbydate',
    data: {breakdowndate:breakdowndate},
    
    success: function(data){
        $("#breakdownlistdata").html(data);
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



   /* On change breakdown history date  */
    $(document).on("change", "#breakhistorydate", function() {

        var breakhistorydate = $("#breakhistorydate").val();
      
       $("#breakdownhistorylistdata").html('');
        $("#loader").css('display', 'block');

       
    $.ajax({
    type: "POST",
    url: basepath+'breakdown/getBreakdownHistorylistbydate',
    data: {breakhistorydate:breakhistorydate},
    
    success: function(data){
          $("#loader").css('display', 'none');
        $("#breakdownhistorylistdata").html(data);
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

    $(document).on("click", ".breakdownstatus", function() {
        
        var uid = $(this).data("breakdownid");
        var status = $(this).data("setstatus");
        var url = basepath + 'breakdown/setBreakdownStatus';
        setActiveStatus(uid, status, url);

    });

// change status of breakdown cause
     $(document).on("click", ".brkcausestatus", function() {
        
        var uid = $(this).data("brkcauseid");
        var status = $(this).data("setstatus");
        var url = basepath + 'breakdown/setBreakdownCauseStatus';
        setActiveStatus(uid, status, url);

    });


});/* document ready end */



function validateBreakDown()
{
    
    var start_time = $("#start_time").val();
    var end_time = $("#end_time").val();
    var breakdown_cause = $("#breakdown_cause").val();
    var narration = $("#narration").val();


    

    $("#error_msg").text("").css("dispaly", "none").removeClass("form_error");

    if(start_time=="")
    {
        $("#start_time").focus();
        $("#error_msg")
        .text("Error : select breakdown start time")
        .addClass("form_error")
        .css("display", "block");
        return false;
    }

    if(end_time=="")
    {
        $("#end_time").focus();
        $("#error_msg")
        .text("Error : select breakdown end time")
        .addClass("form_error")
        .css("display", "block");
        return false;
    }

     if(breakdown_cause=="0")
    {
        $("#breakdown_cause").focus();
        $("#error_msg")
        .text("Error : Select breakdown cause")
        .addClass("form_error")
        .css("display", "block");
        return false;
    }

     if(narration=="")
    {
        $("#narration").focus();
        $("#error_msg")
        .text("Error : Enter narration")
        .addClass("form_error")
        .css("display", "block");
        return false;
    }

	return true;
}



/* validate breakdown cause */


function validateBreakDowncause()
{
    

    var breakdowncause = $("#breakdowncause").val();


    

    $("#error_msg").text("").css("dispaly", "none").removeClass("form_error");



     if(breakdowncause=="")
    {
        $("#breakdowncause").focus();
        $("#error_msg")
        .text("Error : Enter cause")
        .addClass("form_error")
        .css("display", "block");
        return false;
    }

    return true;
}