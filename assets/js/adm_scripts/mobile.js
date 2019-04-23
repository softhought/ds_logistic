$( document ).ready(function() {
    var basepath = $("#basepath").val();

    $(document).on('submit','#MobileForm',function(e){
        e.preventDefault();    
        if(MobileFormValidation())
        {        
        
            var formDataserialize = $("#MobileForm").serialize();
            // alert(formDataserialize);
            // console.log(formDataserialize);
            var type = "POST"; //for creating new resource
            var urlpath = basepath + 'master/mobileIdAddEdit';
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
                        var addurl = basepath + "master/setMobileId";
                        var listurl = basepath + "master/mobile";
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

 


    
    $(document).on("click", ".mblstatus", function() {
        
		var uid = $(this).data("mobileid");
        var status = $(this).data("setstatus");
        var url = basepath + 'master/setMobileStatus';
        setActiveStatus(uid, status, url);

    });
    



});/* document ready end */




function MobileFormValidation()
{
    $("#clsmsg").text("").css("dispaly", "none").removeClass("form_error");
    $('#mobile_uuid_div').removeClass('has-error');

    if ($('#mobile_uuid').val()=="") {       
        $('#mobile_uuid_div').addClass('has-error');
        $("#clsmsg")
		.text("Error : Enter Mobile Id")
		.addClass("form_error")
        .css("display", "block");
        return false; 
    }
    return true;
}