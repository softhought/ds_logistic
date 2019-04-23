$(document ).ready(function() {
    var basepath = $("#basepath").val();

    $('.timepickers').pickatime();
   
    $(document).on('submit','#vehicleForm',function(e){
		e.preventDefault();


		if(validateVehicle())
		{
           
            var formDataserialize = $("#vehicleForm").serialize();
            formDataserialize = decodeURI(formDataserialize);
            console.log(formDataserialize);

            var formData = { formDatas: formDataserialize };
            var type = "POST"; //for creating new resource
            var urlpath = basepath + 'vehicle/vehicle_action';
            $("#vehiclesavebtn").css('display', 'none');
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
                        var addurl = basepath + "vehicle/addVehicle";
                        var listurl = basepath + "vehicle";
                        $("#responsemsg").text(result.msg_data);
                        $("#response_add_more").attr("href", addurl);
                        $("#response_list_view").attr("href", listurl);

                    } 
					else {
                        $("#vehicle_response_msg").text(result.msg_data);
                    }
					
                    $("#loaderbtn").css('display', 'none');
					
                    $("#vehiclesavebtn").css({
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



function validateVehicle()
{
    
    var equipmentid = $("#equipmentid").val();
    var eqpname = $("#eqpname").val();
    var eqpmodel = $("#eqpmodel").val();
    var vehicleType = $("#vehicleType").val();
    var project = $("#project").val();
    

    $("#error_msg").text("").css("dispaly", "none").removeClass("form_error");

    if(equipmentid=="")
    {
        $("#equipmentid").focus();
        $("#error_msg")
        .text("Error : Enter Equipment ID")
        .addClass("form_error")
        .css("display", "block");
        return false;
    }

    if(eqpname=="")
    {
        $("#eqpname").focus();
        $("#error_msg")
        .text("Error : Enter Equipment Name")
        .addClass("form_error")
        .css("display", "block");
        return false;
    }

    if(eqpmodel=="")
    {
        $("#eqpmodel").focus();
        $("#error_msg")
        .text("Error : Enter Equipment Model")
        .addClass("form_error")
        .css("display", "block");
        return false;
    }

	if(vehicleType=="0")
	{
		$("#vehicleType").focus();
		$("#error_msg")
		.text("Error : Select Vehicle Type")
		.addClass("form_error")
        .css("display", "block");
		return false;
	}

    if(project=="0")
    {
        $("#project").focus();
        $("#error_msg")
        .text("Error : Enter Driver Password")
        .addClass("form_error")
        .css("display", "block");
        return false;
    }

	return true;
}