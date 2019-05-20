$(document ).ready(function() {
    var basepath = $("#basepath").val();

/*=====================================================================================*/
/*--------------------------------Tipper Delay Report  -------------------------------*/
/*---------------------------- 17.05.2019 by Shankha  -------------------------------*/
/*==================================================================================*/  

        $('#tipperDelayReportBtn').on('click',function(e){
        e.preventDefault();

        if(1)
        { 
            $('#loader').show();
            var formDataserialize = $("#tipperDelayReport").serialize();
            var urlpath = basepath + 'delayreport/tipperDelayreportData';
           
            $("#tipperdelayreportView").html('');

            $.ajax({        
                type: "POST",
                url: urlpath,
                data:formDataserialize,
                dataType: "html",            
                success: function(result) {

                    $('#loader').hide();  
                    $("#tipperdelayreportView").html(result);
                  
            
                     allInputReadonly();
                 
                },
                error: function(jqXHR, exception) {
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
            });
        }        
    });


 /*=====================================================================================*/
/*--------------------------------Excavator Delay Report  -------------------------------*/
/*---------------------------- 17.05.2019 by Shankha  -------------------------------*/
/*==================================================================================*/  

        $('#excavatorDelayReportBtn').on('click',function(e){
        e.preventDefault();

        if(1)
        { 
            $('#loader').show();
            var formDataserialize = $("#excavatorDelayReport").serialize();
          	 var urlpath = basepath + 'delayreport/excavatorDelayreportData';
            $("#excavatordelayreportView").html('');

            $.ajax({        
                type: "POST",
                url: urlpath,
                data:formDataserialize,
                dataType: "html",            
                success: function(result) {

                    $('#loader').hide();  
                    $("#excavatordelayreportView").html(result);
                  
            
                     allInputReadonly();
                 
                },
                error: function(jqXHR, exception) {
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
            });
        }        
    });



});/* document ready end */