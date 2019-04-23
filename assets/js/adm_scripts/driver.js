$(document ).ready(function() {
    var basepath = $("#basepath").val();
   
    $(document).on('submit','#driverForm',function(e){
		e.preventDefault();


		if(validateDriver())
		{
           
            var formDataserialize = $("#driverForm").serialize();
            formDataserialize = decodeURI(formDataserialize);
            console.log(formDataserialize);

            var formData = { formDatas: formDataserialize };
            var type = "POST"; //for creating new resource
            var urlpath = basepath + 'driver/driver_action';
            $("#driversavebtn").css('display', 'none');
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
                        var addurl = basepath + "driver/addDriver";
                        var listurl = basepath + "driver";
                        $("#responsemsg").text(result.msg_data);
                        $("#response_add_more").attr("href", addurl);
                        $("#response_list_view").attr("href", listurl);

                    } 
					else {
                        $("#driver_response_msg").text(result.msg_data);
                    }
					
                    $("#loaderbtn").css('display', 'none');
					
                    $("#driversavebtn").css({
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
    




    $(document).on('keyup','#driverpassword',function(e){
        e.preventDefault();
        
            var mode = $("#mode").val();
           

            var pass = $("#driverpassword").val();
            var prevPass = $("#prvpassword").val();


            if(prevPass==pass && mode=="EDIT") {
                
            }
            else{
                if(pass.length>= 4 ){

                    $("#loader_search").css("display","block");
                    $("#already_used").css("display","none");
                    $("#available").css("display","none");
    
                var type = "POST"; //for creating new resource
                var urlpath = basepath + 'driver/checkPassword';
               // $("#driversavebtn").css('display', 'none');
               // $("#loaderbtn").css('display', 'block');
    
                $.ajax({
                    type: type,
                    url: urlpath,
                    data: {pass:pass},
                    dataType: 'json',
                    contentType: "application/x-www-form-urlencoded; charset=UTF-8",
                    success: function(result) {
                        if(result.msg_status==1){
                            $("#loader_search").css("display","none");
                            $("#already_used").css("display","block");
                            $("#available").css("display","none");
                            $("#driversavebtn").attr('disabled',true);
                        }
                        else{
                            $("#loader_search").css("display","none");
                            $("#already_used").css("display","none");
                            $("#available").css("display","block");
                            $("#driversavebtn").attr('disabled',false);
                        }
                    },
                    error: function(jqXHR, exception) {
                        var msg = '';
                    }
                });
                
            }
            else{
                $("#loader_search").css("display","none");
                $("#already_used").css("display","none");
                $("#available").css("display","none");
                $("#driversavebtn").attr('disabled',false);
            }
            }

		

    });
    


    //  Code

    $(document).on('keyup','#drivercode',function(e){
        e.preventDefault();
        
            var mode = $("#mode").val();
           

            var drivercode = $("#drivercode").val();
            var prevdrivrecode = $("#prvdrivercode").val();


            if(drivercode==prevdrivrecode && mode=="EDIT") {
                
            }
            else{
              
                $("#error_msg").text("").css("display", "none");
    
                var type = "POST"; 
                var urlpath = basepath + 'driver/checkDriverCode';
                $.ajax({
                    type: type,
                    url: urlpath,
                    data: {drivercode:drivercode},
                    dataType: 'json',
                    contentType: "application/x-www-form-urlencoded; charset=UTF-8",
                    success: function(result) {
                        if(result.msg_status==1){
                            $("#error_msg")
                            .text("Error : This driver code already exist.Please check...")
                            .addClass("form_error")
                            .css("display", "block");
                            $("#driversavebtn").attr('disabled',true);
                        }
                        else{
                            $("#error_msg").text("").css("display", "none");
                            $("#driversavebtn").attr('disabled',false);
                        }
                    },
                    error: function(jqXHR, exception) {
                        var msg = '';
                    }
                });
                
           
            }

		

    });
    

    
    $(document).on("click", ".driverstatus", function() {
        
		var uid = $(this).data("driverid");
        var status = $(this).data("setstatus");
        var url = basepath + 'driver/setStatus';
        setActiveStatus(uid, status, url);

    });



});/* document ready end */



function validateDriver()
{
    
    var drivercode = $("#drivercode").val();
    var drivername = $("#drivername").val();
    var vehicleType = $("#vehicleType").val();
    var driverpassword = $("#driverpassword").val();
    var workingproject = $("#workingproject").val();
    

    $("#error_msg").text("").css("dispaly", "none").removeClass("form_error");

    if(drivercode=="")
    {
        $("#drivercode").focus();
        $("#error_msg")
        .text("Error : Enter Driver Code")
        .addClass("form_error")
        .css("display", "block");
        return false;
    }

    if(drivername=="")
    {
        $("#drivername").focus();
        $("#error_msg")
        .text("Error : Enter Driver Name")
        .addClass("form_error")
        .css("display", "block");
        return false;
    }

    if(workingproject=="0")
    {
        $("#workingproject").focus();
        $("#error_msg")
        .text("Error : Select Project")
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

    if(driverpassword=="")
    {
        $("#driverpassword").focus();
        $("#error_msg")
        .text("Error : Enter Driver Password")
        .addClass("form_error")
        .css("display", "block");
        return false;
    }

    if(driverpassword.length <4 )
    {
        $("#driverpassword").focus();
        $("#error_msg")
        .text("Error : Enter 4 digit pin")
        .addClass("form_error")
        .css("display", "block");
        return false;
    }
    
	return true;
}