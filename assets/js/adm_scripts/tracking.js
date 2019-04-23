



$(document ).ready(function() {
    var basepath = $("#basepath").val();
    getTrackingDetailData(basepath);

    $(document).on('click','#trackingSearchBtn',function(e){
             e.preventDefault();    
             getTrackingDetailData(basepath);
    });




});/* document ready end */



function getTrackingDetailData(basepath){

    $("#loader").css("display","block");
    $("#trackingListView").css('display', 'none');

   // $("#loader").css("display","none");

    var formDataserialize = $("#trackingSearchForm").serialize();
           
    var type = "POST"; //for creating new resource
    var urlpath = basepath + 'tracking/getTrackingList';

  

    $.ajax({
        type: type,
        url: urlpath,
        data: {formDataserialize:formDataserialize},
        success: function(result) {

            $("#loader").css('display', 'none');
            $("#trackingListView").css('display', 'block');

            // alert(result.msg_status);
            $("#trackingListView").html(result);
            $('#trackinglist').DataTable({
                "dom": 'Bfrtip',
                "buttons": [
                    'csv', 'excel', 'pdf', 'print'
                ]
            });
            //$("#loaderbtn").css('display', 'none');
            
           
        },
        error: function(jqXHR, exception) {
            var msg = '';
        }
    });
}