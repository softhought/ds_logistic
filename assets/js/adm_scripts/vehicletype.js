$(document ).ready(function() {
    var basepath = $("#basepath").val();
   
    $(document).on('submit','#vehicletypeForm',function(e){
		e.preventDefault();


		if(validateVehicleType())
		{
           
            var formDataserialize = $("#vehicletypeForm").serialize();
            formDataserialize = decodeURI(formDataserialize);
            console.log(formDataserialize);

            var formData = { formDatas: formDataserialize };
            var type = "POST"; //for creating new resource
            var urlpath = basepath + 'vehicletype/vehicletype_action';
            $("#vehicletypesavebtn").css('display', 'none');
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
                        var addurl = basepath + "vehicletype/addVehicletype";
                        var listurl = basepath + "vehicletype";
                        $("#responsemsg").text(result.msg_data);
                        $("#response_add_more").attr("href", addurl);
                        $("#response_list_view").attr("href", listurl);

                    } 
					else {
                        $("#vehicletype_response_msg").text(result.msg_data);
                    }
					
                    $("#loaderbtn").css('display', 'none');
					
                    $("#vehicletypesavebtn").css({
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
    




   



});/* document ready end */



function validateVehicleType()
{
    
    var vehicletype = $("#vehicletype").val();
    $("#error_msg").text("").css("dispaly", "none").removeClass("form_error");
    if(vehicletype=="")
    {
        $("#vehicletype").focus();
        $("#error_msg")
        .text("Error : Enter Vehicle Type")
        .addClass("form_error")
        .css("display", "block");
        return false;
    }

    return true;
}