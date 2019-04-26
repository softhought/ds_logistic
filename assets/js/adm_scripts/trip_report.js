$(document).ready(function() {

    var basepath = $("#basepath").val();
     
    $('#TripReportViewBtn').on('click',function(e){
        e.preventDefault();

        if(validate())
        {
            $('#loader').show();
            var formDataserialize = $("#TripReportForm").serialize();
            var urlpath = basepath + 'Tripreport/Tripreport';

            $.ajax({        
                type: "POST",
                url: urlpath,
                data:formDataserialize,
                dataType: "html",            
                success: function(result) {
                    $('#loader').hide();  
                    $("#TripReportView").html(result);

                    $('#TripReportData').DataTable({
                        "dom": 'Bfrtip',
                        "buttons": [
                            'csv', 'excel', 'pdf', 'print'
                        ]
                    });
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


function validate()
{
    $("#error_msg").text("").css("dispaly", "none").removeClass("form_error");
    var frmdt=$('#fromDate').val().replace('/', '-');
    var todt=$('#toDate').val().replace('/', '-');
    //alert(frmdt);
    if(frmdt > todt)
    {
        $("#fromDate").focus();
        $("#error_msg")
        .text("Error : From Date Cannot be greater than To Date")
        .addClass("form_error")
        .css("display", "block");
        return false;

    }    
    return true;
}