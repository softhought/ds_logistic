$(document ).ready(function() {
    var basepath = $("#basepath").val();


   /* On select date and project  */
    $(document).on("change", "#project", function() {

       var project=$('select[name=project]').val();
        
       
        $("#leadlistdata").html('');
       
    $.ajax({
    type: "POST",
    url: basepath+'vehicledistance/getObserverByProject',
    data: {project:project},
    
    success: function(data){
         $("#observer_dropdown").html(data);
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

    });


        $('#vehicledistanceBtn').on('click',function(e){
        e.preventDefault();

        if(validate())
        { 
            $('#loader').show();
            var formDataserialize = $("#VehicleDistanceForm").serialize();
            var urlpath = basepath + 'vehicledistance/distanceAddEdit';
            $("#vecicleDistanceAddEditView").html('');

            $.ajax({        
                type: "POST",
                url: urlpath,
                data:formDataserialize,
                dataType: "html",            
                success: function(result) {

                    $('#loader').hide();  
                    $("#vecicleDistanceAddEditView").html(result);
                     //Timepicker
				     $('.timepicker').timepicker({
				      
				      defaultTime:'',
				      minuteStep:1
				    })

            
                     allInputReadonly();
                 
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


/* save vehicle distance data*/

	$(document).on('submit','#VehicleDistDetails',function(e){
		e.preventDefault();
		

	
		//	$("#areamsg").css("display","none")

			var formDataserialize = $("#VehicleDistDetails" ).serialize();
			formDataserialize = decodeURI(formDataserialize);
			console.log(formDataserialize);

			var formData = {formDatas: formDataserialize};
			var type = "POST"; //for creating new resource
			var urlpath = basepath+'vehicledistance/vehicle_details_action';
            $("#distancesavebtn").addClass('nonclick');
            $("#loaderbtn").show();
			$("#distancesavebtn").hide();
			$.ajax({
				type: type,
	            url: urlpath,
	            data: formData,
	            dataType: 'json',
	            contentType: "application/x-www-form-urlencoded; charset=UTF-8", 
				success: function (result) {
				$("#distancesavebtn").removeClass('nonclick');		
                $("#loaderbtn").hide();
				if(result.msg_status==1)
				{ 
					$("#distancesavebtn").hide();	

					$("#response_message").html('<span class="glyphicon glyphicon-ok"></span> '+result.msg_data);
					
					
					
				}
				if(result.msg_status==0)
				{
					$("#response_message").html('<span class="glyphicon glyphicon-remove"></span> There is some problem.Try again');
				}

				
				}, 
				error: function (jqXHR, exception) {
					var msg = '';
					}
				}); /*end ajax call*/
		

	});







});/* document ready end */


function validate()
{ 
    $("#error_msg").text("").css("dispaly", "none").removeClass("form_error");
    var projectid=$('#project').val();
    var sel_observer=$('#sel_observer').val();
  


    if(projectid=='0')
    {
        $("#project").focus();
        $("#error_msg")
        .text("Error : Select project")
        .addClass("form_error")
        .css("display", "block");
        return false;

    }    

    if(sel_observer=='0')
    {
        $("#sel_observer").focus();
        $("#error_msg")
        .text("Error : Select observer")
        .addClass("form_error")
        .css("display", "block");
        return false;

    } 
    return true;
}


function numericFilter(txb) {
   txb.value = txb.value.replace(/[^\0-9]/ig, "");
}


function resetInput(idtag,row){
	//alert(idtag+row);
console.log('blank');
	$('#'+idtag+row).val('');
}

function allInputReadonly(){

    var allinputreadonly=$('#allinputreadonly').val();

    if (allinputreadonly=='Y') {
      // $('#VehicleDistDetails input').attr('readonly', 'readonly');
        $("#VehicleDistDetails :input").attr("disabled", true);
        console.log('readonly all');
        $("#VehicleDistDetails input").addClass('readonly'); 
        $("#distancesavebtn").hide();
        $(".reset").hide();
    }

}