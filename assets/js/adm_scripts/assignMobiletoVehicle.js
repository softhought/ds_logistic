$( document ).ready(function() {
    var basepath = $("#basepath").val();

    $(document).on('submit','#assignMobiletoVehicle',function(e){
        e.preventDefault();    
        if(Validation())
        {        
        
            var formDataserialize = $("#assignMobiletoVehicle").serialize();
            // alert(formDataserialize);
            // console.log(formDataserialize);
            var type = "POST"; //for creating new resource
            var urlpath = basepath + 'master/assignMobileAddEdit';
            $("#cassavebtn").css('display', 'none');
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
                        var addurl = basepath + "master/assignMobiletoVehicle";
                        var listurl = basepath + "master/assignMobiletoVehicleList";
                        $("#responsemsg").text(result.msg_data);
                        $("#response_add_more").attr("href", addurl);
                        $("#response_list_view").attr("href", listurl);
    
                    } 
                    else {
                        $("#cas_response_msg").text(result.msg_data);
                    }
                    
                    $("#loaderbtn").css('display', 'none');
                    
                    $("#cassavebtn").css({
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

// deactive assign mobile to veichel 25.03.2019

$(document).on("click", ".assignstatus", function() {

    var result = confirm("Are you sure to change ?");
    if (result) {
        var uid = $(this).data("vehicleid");
        var status = $(this).data("setstatus");
        var url = basepath + 'master/resetMobileToVehicle';
        setActiveStatus(uid, status, url);
    }
        


});






});/* document ready end */


function Validation()
{
    $("#clsmsg").text("").css("dispaly", "none").removeClass("form_error");
    $('#mobile_id_dropdown').removeClass('has-error');
    $('#vehicle_id_dropdown').removeClass('has-error');

    if ($('#mobile_id option:selected').val()=="0") {       
        $('#mobile_id_dropdown').addClass('has-error');
        $("#clsmsg")
		.text("Error : Select a Mobile")
		.addClass("form_error")
        .css("display", "block");
        return false; 
    }
    if ($('#vehicle_id option:selected').val()=="0") {       
        $('#vehicle_id_dropdown').addClass('has-error');
        $("#clsmsg")
		.text("Error : Select a Vehicle")
		.addClass("form_error")
        .css("display", "block");
        return false; 
    }
    return true;
}