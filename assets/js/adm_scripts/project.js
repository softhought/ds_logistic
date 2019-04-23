$(document ).ready(function() {
    var basepath = $("#basepath").val();
   
   
    $(document).on('submit','#projectForm',function(e){
		e.preventDefault();


		if(validateProject())
		{

            if(confirmProjectCode()){
           
            var formDataserialize = $("#projectForm").serialize();
            formDataserialize = decodeURI(formDataserialize);
            console.log(formDataserialize);

            var formData = { formDatas: formDataserialize };
            var type = "POST"; //for creating new resource
            var urlpath = basepath + 'project/project_action';
            $("#projectsavebtn").css('display', 'none');
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
                        var addurl = basepath + "project/addProject";
                        var listurl = basepath + "project";
                        $("#responsemsg").text(result.msg_data);
                        $("#response_add_more").attr("href", addurl);
                        $("#response_list_view").attr("href", listurl);

                    } 
					else {
                        $("#project_response_msg").text(result.msg_data);
                    }
					
                    $("#loaderbtn").css('display', 'none');
					
                    $("#projectsavebtn").css({
                        "display": "block",
                        "margin": "0 auto"
                    });
                },
                error: function(jqXHR, exception) {
                    var msg = '';
                }
            });
            
            
             }//project code confirm
			
		}

    });
    




    //  Code

    $(document).on('keyup','#projectcode',function(e){
        e.preventDefault();
        
            var mode = $("#mode").val();
           

            var projectcode = $("#projectcode").val();
            var prvprojectcode = $("#prvprojectcode").val();


            if(projectcode==prvprojectcode && mode=="EDIT") {
                
            }
            else{
              
                $("#error_msg").text("").css("display", "none");
    
                var type = "POST"; 
                var urlpath = basepath + 'project/checkProjectCode';
                $.ajax({
                    type: type,
                    url: urlpath,
                    data: {projectcode:projectcode},
                    dataType: 'json',
                    contentType: "application/x-www-form-urlencoded; charset=UTF-8",
                    success: function(result) {
                        if(result.msg_status==1){
                            $("#error_msg")
                            .text("Error : Project Code already exist.Please check...")
                            .addClass("form_error")
                            .css("display", "block");
                            $("#projectsavebtn").attr('disabled',true);
                        }
                        else{
                            $("#error_msg").text("").css("display", "none");
                            $("#projectsavebtn").attr('disabled',false);
                        }
                    },
                    error: function(jqXHR, exception) {
                        var msg = '';
                    }
                });
                
           
            }
    });






    $(document).on("click", ".projectstatus", function() {
        
		var uid = $(this).data("projectid");
        var status = $(this).data("setstatus");
        var url = basepath + 'project/setProjectStatus';
        setActiveStatus(uid, status, url);

    });



});/* document ready end */



function validateProject()
{
    
    var projectname = $("#projectname").val();
    var projectcode = $("#projectcode").val();
    var location = $("#location").val();
    

    $("#error_msg").text("").css("dispaly", "none").removeClass("form_error");

    if(projectname=="")
    {
        $("#projectname").focus();
        $("#error_msg")
        .text("Error : Enter Project Name")
        .addClass("form_error")
        .css("display", "block");
        return false;
    }

    
    if(projectcode=="")
    {
        $("#projectcode").focus();
        $("#error_msg")
        .text("Error : Enter Project Code")
        .addClass("form_error")
        .css("display", "block");
        return false;
    }

    if(location=="0")
    {
        $("#location").focus();
        $("#error_msg")
        .text("Error : Select Location")
        .addClass("form_error")
        .css("display", "block");
        return false;
    }

	return true;
}


function confirmProjectCode(){

    var projectcode = $("#projectcode").val();
    var mode = $("#mode").val();

    if(mode=='ADD'){
        if (confirm('Confirm Project Code: '+projectcode)) {
            return true;
        } else {
            return false;
        }

    }else{
        return true;
    }
    

}