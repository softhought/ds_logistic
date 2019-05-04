$(document).ready(function() {

    var basepath = $("#basepath").val();
   
/*=====================================================================================*/
/*------------------------Excavator Lead and lift report  ----------------------------*/
/*---------------------------- 03.05.2019 by Shankha  -------------------------------*/
/*==================================================================================*/  
    $('#excaLeadLiftReportBtn').on('click',function(e){
        e.preventDefault();

        if(validateLeadLift())
        {
            $('#loader').show();
            var formDataserialize = $("#ExcavatorLeadLiftReport").serialize();
            var urlpath = basepath + 'excavatoleadliftreport/excavatorLeadLiftReport';
            $("#excavatorLeadLiftReportView").html('');
            $.ajax({        
                type: "POST",
                url: urlpath,
                data:formDataserialize,
                dataType: "html",            
                success: function(result) {
                    $('#loader').hide();  
                    $("#excavatorLeadLiftReportView").html(result);

                var tripReportProject = $("#tripReportProject").val();

                 /*   $('#leadliftReportData').DataTable({
                        "dom": 'Bfrtip',

                        // "buttons": [
                        //     'csv', 'excel', 'pdf', 'print'
                        // ]
                        buttons: [{
                            extend: 'pdf',
                            title: tripReportProject
                          }, {
                            extend: 'excel',
                            title: tripReportProject
                          }, {
                            extend: 'csv'
                          },{
                            extend: 'print',
                            title: tripReportProject
                          }]
                    }); */
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



       $(document).on('click','#downloadxls',function(){

          $('#reporttable').tableExport({type:'excel',escape:'false',});
        // alert();
        
    });


   


/*.....................................................*/
});/* document ready end */


function validateLeadLift()
{
    $("#error_msg").text("").css("dispaly", "none").removeClass("form_error");
    var frmdt=$('#fromDate').val().replace('/', '-');
    var todt=$('#toDate').val().replace('/', '-');
    var project=$('#project').val();
    console.log(frmdt);
    console.log(todt);
    // if(frmdt > todt)
    // {
    //     $("#fromDate").focus();
    //     $("#error_msg")
    //     .text("Error : From Date Cannot be greater than To Date")
    //     .addClass("form_error")
    //     .css("display", "block");
    //     return false;

    // }  

    if(project=='0')
    {
        $("#project").focus();
        $("#error_msg")
        .text("Error : select Project")
        .addClass("form_error")
        .css("display", "block");
        return false;

    }  
    return true;
}

