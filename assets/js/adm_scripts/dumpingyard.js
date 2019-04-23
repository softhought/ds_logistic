$(document ).ready(function() {
    var basepath = $("#basepath").val();
   
   
    $(document).on('submit','#yardForm',function(e){
		e.preventDefault();


		if(validateYard())
		{

           
           
            var formDataserialize = $("#yardForm").serialize();
            formDataserialize = decodeURI(formDataserialize);
            console.log(formDataserialize);

            var formData = { formDatas: formDataserialize };
            var type = "POST"; //for creating new resource
            var urlpath = basepath + 'dumpingyard/dumpingyard_action';
            $("#yardsavebtn").css('display', 'none');
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
                        var addurl = basepath + "dumpingyard/addYard";
                        var listurl = basepath + "dumpingyard";
                        $("#responsemsg").text(result.msg_data);
                        $("#response_add_more").attr("href", addurl);
                        $("#response_list_view").attr("href", listurl);

                    } 
					else {
                        $("#yard_response_msg").text(result.msg_data);
                    }
					
                    $("#loaderbtn").css('display', 'none');
					
                    $("#yardsavebtn").css({
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






    $(document).on("click", ".yardstatus", function() {
        
		var uid = $(this).data("yardid");
        var status = $(this).data("setstatus");
        var url = basepath + 'dumpingyard/setYardStatus';
        setActiveStatus(uid, status, url);

    });



});/* document ready end */



function validateYard()
{
    
    var yardname = $("#yardname").val();
    var project = $("#project").val();
    

    $("#error_msg").text("").css("dispaly", "none").removeClass("form_error");

    if(yardname=="")
    {
        $("#yardname").focus();
        $("#error_msg")
        .text("Error : Enter yard name")
        .addClass("form_error")
        .css("display", "block");
        return false;
    }

 

    if(project=="")
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


