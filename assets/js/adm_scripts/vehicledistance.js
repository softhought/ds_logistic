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



/*=====================================================================================*/
/*---------------------- vehicle distance report project wise  -----------------------*/
/*---------------------------- 16.05.2019 by Shankha  -------------------------------*/
/*==================================================================================*/

    $('#vehicledistanceReportBtn').on('click',function(e){
        e.preventDefault();

        if(1)
        {
            $('#loader').show();
            var formDataserialize = $("#VehicleDistanceReport").serialize();
            var urlpath = basepath + 'vehicledistance/vehicleDistanceReportData';

            $.ajax({        
                type: "POST",
                url: urlpath,
                data:formDataserialize,
                dataType: "html",            
                success: function(result) {
                    $('#loader').hide();  
                    $("#distancereportView").html(result);

                var distanceReportProject = $("#distanceReportProject").val();

                    // $('#DistanceReportData').DataTable({
                    //     "dom": 'Bfrtip',
                    //      "ordering": false,
                    //     // "buttons": [
                    //     //     'csv', 'excel', 'pdf', 'print'
                    //     // ]
                    //     buttons: [{
                    //         extend: 'pdf',
                    //         title: distanceReportProject
                    //       }, {
                    //         extend: 'excel',
                    //         title: distanceReportProject
                    //       }, {
                    //         extend: 'csv'
                    //       },{
                    //         extend: 'print',
                    //         title: distanceReportProject
                    //       }]
                    // });
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

    $(document).on('click','#downloadxls',function(){

          $('#DistanceReportData').tableExport({type:'excel',escape:'false'});
      
        
    });


/* calculate differance km */


$(document).on('input','.startKM,.endKM',function(){
  //  $(this).val() // get the current value of the input field.
        var currRowID = $(this).attr('id');
        var rowDtlNo = currRowID.split('_');
        

        var start_distance = $('#start_km_'+rowDtlNo[2]).val();
        console.log(start_distance);
        var end_distance = $('#end_km_'+rowDtlNo[2]).val();
         console.log(end_distance);
        if (start_distance=='') {start_distance=0;}
        if (end_distance=='') {end_distance=0;}

        var differ = (end_distance-start_distance);


        //$('#km_differ_'+rowDtlNo[2]).val(differ);

        $('#km_differ_'+rowDtlNo[2]).val(differ.toFixed(2));



   // console.log($(this).val());
});




/* calculate differance hour */


$(document).on('input','.startHour,.endHour',function(){
  //  $(this).val() // get the current value of the input field.
        var currRowID = $(this).attr('id');
        var rowDtlNo = currRowID.split('_');
        
        $('.diffTime').removeClass('inputerror');
        $("#error_msg_distance").text("").css("dispaly", "none").removeClass("form_error");
        $("#distancesavebtn").show();

        var start_hour = $('#start_hour_'+rowDtlNo[2]).val();
        console.log(start_hour);
        var end_hour = $('#end_hour_'+rowDtlNo[2]).val();
         console.log(end_hour);
        if (start_hour=='') {start_hour=0;}
        if (end_hour=='') {end_hour=0;}

        var differ = (end_hour-start_hour);


       // $('#time_differ_'+rowDtlNo[2]).val(differ); 
        $('#time_differ_'+rowDtlNo[2]).val(differ.toFixed(2)); 

        if (differ>8 || differ<-8) {

            var slno =parseInt(rowDtlNo[2])+1;
            $('#time_differ_'+rowDtlNo[2]).addClass('inputerror');
             $("#distancesavebtn").hide();
             $("#error_msg_distance")
            .text("Error : Time difference greater than 8 hours.Check Sl No :" +slno)
            .addClass("form_error")
            .css("display", "block");
        }

        

   // console.log($(this).val());
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