$(document).ready(function() {

    var basepath = $("#basepath").val();


   /* On select date and project  */
    $(document).on("change", "#project", function() {

       var project=$('select[name=project]').val();
        
       
        $("#leadlistdata").html('');
       
    $.ajax({
    type: "POST",
    url: basepath+'dumpreport/getTipperByProject',
    data: {project:project},
    
    success: function(data){
         $("#tipper_dropdown").html(data);
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

    });


        $('#tipperDumpReportBtn').on('click',function(e){
        e.preventDefault();

        if(validate())
        { 
            $('#loader').show();
            var formDataserialize = $("#TipperDumpReport").serialize();
            var urlpath = basepath + 'dumpreport/tipperdumpreport';
            $("#tipperDumpReportView").html('');

            $.ajax({        
                type: "POST",
                url: urlpath,
                data:formDataserialize,
                dataType: "html",            
                success: function(result) {
                    $('#loader').hide();  
                    $("#tipperDumpReportView").html(result);

                var tipperdumpReport = $("#tipperdumpReport").val();

                    $('#TripReportData').DataTable({
                        "dom": 'Bfrtip',

                        // "buttons": [
                        //     'csv', 'excel', 'pdf', 'print'
                        // ]
                        buttons: [{
                            extend: 'pdf',
                            title: tipperdumpReport
                          }, {
                            extend: 'excel',
                            title: tipperdumpReport
                          }, {
                            extend: 'csv'
                          },{
                            extend: 'print',
                            title: tipperdumpReport
                          }]
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

}); // end of document ready


function validate()
{ 
    $("#error_msg").text("").css("dispaly", "none").removeClass("form_error");
    var projectid=$('#project').val();
  


    if(projectid=='0')
    {
        $("#project").focus();
        $("#error_msg")
        .text("Error : Select project")
        .addClass("form_error")
        .css("display", "block");
        return false;

    }    
    return true;
}