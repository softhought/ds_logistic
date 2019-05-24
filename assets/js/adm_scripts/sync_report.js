$(document ).ready(function() {
    var basepath = $("#basepath").val();

        /* On change project change servier*/

        $(document).on("change", "#project", function() {
            getTipper(basepath);
           
       });


            $('#syncReportBtn').on('click',function(e){
        e.preventDefault();

       if (validate()) {
            $('#loader').show();
            var formDataserialize = $("#syncReport").serialize();
            var urlpath = basepath + 'syncreport/tipperWiseSyncreport';

            $.ajax({        
                type: "POST",
                url: urlpath,
                data:formDataserialize,
                dataType: "html",            
                success: function(result) {
                    $('#loader').hide();  
                    $("#sqncreportView").html(result);

               


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

          $('#SyncReportData').tableExport({type:'excel',escape:'false'});
      
        
    });





});// end of document ready



function getTipper(basepath){

        var project=$('select[name=project]').val();
       
       

       
    $.ajax({
    type: "POST",
    url: basepath+'syncreport/getTipperByProject',
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

}



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
   