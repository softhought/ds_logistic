$(document ).ready(function() {
    var basepath = $("#basepath").val();
   
   
    $(document).on('submit','#materialForm',function(e){
		e.preventDefault();


		if(validateMaterial())
		{

          
            var formDataserialize = $("#materialForm").serialize();
            formDataserialize = decodeURI(formDataserialize);
            console.log(formDataserialize);

            var formData = { formDatas: formDataserialize };
            var type = "POST"; //for creating new resource
            var urlpath = basepath + 'material/material_action';
            $("#materialsavebtn").css('display', 'none');
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
                        var addurl = basepath + "material/addMaterial";
                        var listurl = basepath + "material";
                        $("#responsemsg").text(result.msg_data);
                        $("#response_add_more").attr("href", addurl);
                        $("#response_list_view").attr("href", listurl);

                    } 
					else {
                        $("#project_response_msg").text(result.msg_data);
                    }
					
                    $("#loaderbtn").css('display', 'none');
					
                    $("#materialsavebtn").css({
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


    /* save/update material assign to project*/


    $(document).on('submit','#materialAssignForm',function(e){
        e.preventDefault();


        if(validateMaterialAssign())
        {

          
            var formDataserialize = $("#materialAssignForm").serialize();
            formDataserialize = decodeURI(formDataserialize);
            console.log(formDataserialize);

            var formData = { formDatas: formDataserialize };
            var type = "POST"; //for creating new resource
            var urlpath = basepath + 'material/materialassign_action';
            $("#matassignsavebtn").css('display', 'none');
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
                        var addurl = basepath + "material/addMaterialAssign";
                        var listurl = basepath + "material/materialassign";
                        $("#responsemsg").text(result.msg_data);
                        $("#response_add_more").attr("href", addurl);
                        $("#response_list_view").attr("href", listurl);

                    } 
                    else {
                        $("#materialass_response_msg").text(result.msg_data);
                    }
                    
                    $("#loaderbtn").css('display', 'none');
                    
                    $("#matassignsavebtn").css({
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
    
    



    $(document).on("click", ".materialstatus", function() {
        
		var uid = $(this).data("materialid");
        var status = $(this).data("setstatus");
        var url = basepath + 'material/setMaterialStatus';
        setActiveStatus(uid, status, url);

    });

   // change status of assign meterial to project  
    $(document).on("click", ".materialassignstatus", function() {
        
        var uid = $(this).data("assignid");
        var status = $(this).data("setstatus");
        var url = basepath + 'material/setMaterialAssignProjectStatus';
        setActiveStatus(uid, status, url);

    });




});/* document ready end */



function validateMaterial()
{
    
    var material = $("#material").val();
   

    $("#error_msg").text("").css("dispaly", "none").removeClass("form_error");

    if(material=="")
    {
        $("#material").focus();
        $("#error_msg")
        .text("Error : Enter material name")
        .addClass("form_error")
        .css("display", "block");
        return false;
    }




	return true;
}


function validateMaterialAssign()
{
    
    var project = $("#project").val();
    var material = $("#material").val();
    var cf = $("#cf").val();
   

    $("#error_msg").text("").css("dispaly", "none").removeClass("form_error");

    if(project=="0")
    {
        $("#project").focus();
        $("#error_msg")
        .text("Error : Select project")
        .addClass("form_error")
        .css("display", "block");
        return false;
    }

    if(material=="0")
    {
        $("#material").focus();
        $("#error_msg")
        .text("Error : Select material")
        .addClass("form_error")
        .css("display", "block");
        return false;
    }


    if(cf=="")
    {
        $("#cf").focus();
        $("#error_msg")
        .text("Error : Enter Conversation Factor")
        .addClass("form_error")
        .css("display", "block");
        return false;
    }




    return true;
}

