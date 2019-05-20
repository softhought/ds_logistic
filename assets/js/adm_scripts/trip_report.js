$(document).ready(function() {

    var basepath = $("#basepath").val();
     
    $('#TripReportViewBtn').on('click',function(e){
        e.preventDefault();

        if(validate())
        {
            $('#loader').show();
            var formDataserialize = $("#TripReportForm").serialize();
            var urlpath = basepath + 'Tripreport/Tripreport';

            $.ajax({        
                type: "POST",
                url: urlpath,
                data:formDataserialize,
                dataType: "html",            
                success: function(result) {
                    $('#loader').hide();  
                    $("#TripReportView").html(result);

                var tripReportProject = $("#tripReportProject").val();

                    $('#TripReportData').DataTable({
                        "dom": 'Bfrtip',

                        // "buttons": [
                        //     'csv', 'excel', 'pdf', 'print'
                        // ]
                        buttons: [{
                            extend: 'pdf',
                            title: tripReportProject
                          }, {
                            extend: 'excel',
                            title: tripReportProject
                          }, {
                            extend: 'csv'
                          },{
                            extend: 'print',
                            title: tripReportProject
                          }]
                    });
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


/*=====================================================================================*/
/*--------------------------Quantity report shift wise  ------------------------------*/
/*---------------------------- 29.04.2019 by Shankha  -------------------------------*/
/*==================================================================================*/

    $('#quantityTripReportBtn').on('click',function(e){
        e.preventDefault();

        if(validateQuantity())
        {
            $('#loader').show();
            var formDataserialize = $("#QuantityReportForm").serialize();
            var urlpath = basepath + 'Tripreport/quantityReport';


            $.ajax({        
                type: "POST",
                url: urlpath,
                data:formDataserialize,
                dataType: "html",            
                success: function(result) {
                    $('#loader').hide();  
                    $("#quantityreportView").html(result);

                var QuantityReportProject = $("#tripReportProject").val();

                    $('#TripReportData').DataTable({
                        "dom": 'Bfrtip',
                        // "buttons": [
                        //     'csv', 'excel', 'pdf', 'print'
                        // ]
                        // buttons: [{
                        //     extend: 'pdf',
                        //     title: QuantityReportProject
                        //   }, {
                        //     extend: 'excel',
                        //     title: QuantityReportProject
                        //   }, {
                        //     extend: 'csv'
                        //   },{
                        //     extend: 'print',
                        //     title: QuantityReportProject
                        //   }],

                 "buttons": [{
                    "extend": 'excel',

                    "header":false,
                    customize: function ( xlsx ) {
                        var sheet = xlsx.xl.worksheets['sheet1.xml'];
                        //Bold Header Row
                        $('row[r=3] c', sheet).attr( 's', '2' );
                        //Make You Input Cells Bold Too
                        $('c[r=A1]', sheet).attr( 's', '2' );
                        $('c[r=A2]', sheet).attr( 's', '2' );
                    },

                      customizeData: function(data){
                   
                    var desc = [
                        ['ID','TEST ID'],
                        ['Report Date',' TEST Report Date']
                    ];
                    data.body.unshift(data.header);
                    for (var i = 0; i < desc.length; i++) {
                        data.body.unshift(desc[i]);
                    };
                }

                  
                   
                    
                  
 
 
                        }]



 
                    });
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


/*======================================================================================*/
/*-------------------------- Excavator Wise Trip Report  ------------------------------*/
/*----------------------------- 29.04.2019 by Shankha  -------------------------------*/
/*===================================================================================*/


    $('#excavatorReportBtn').on('click',function(e){
        e.preventDefault();

        if(validateExcavatorRep())
        {
            $('#loader').show();
            var formDataserialize = $("#ExcavatorWiseReport").serialize();
            var urlpath = basepath + 'excavatorreport/excavatorWisereport';
             $("#excavatorwiseReportView").html('');
            $.ajax({        
                type: "POST",
                url: urlpath,
                data:formDataserialize,
                dataType: "html",            
                success: function(result) {
                    $('#loader').hide();  
                    $("#excavatorwiseReportView").html(result);

                var Project = $("#tripReportProject").val();

                    $('#excavatorreport').DataTable({
                        "dom": 'Bfrtip',
                         "paging": false,
                         "autoWidth": true,
                         "targets": 'no-sort',
                        "bSort": false,
                        "order": [],

                        // "buttons": [
                        //     'csv', 'excel', 'pdf', 'print'
                        // ]
                        buttons: [{
                            extend: 'pdf',
                            title: Project
                          }, {
                            extend: 'excel',
                            title: Project
                          }, {
                            extend: 'csv'
                          },{
                            extend: 'print',
                            title: Project
                          }]
                    });
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




/*======================================================================================*/
/*-------------------------- Excavator Wise Quantity Report  ------------------------------*/
/*----------------------------- 30.04.2019 by Shankha  -------------------------------*/
/*===================================================================================*/


    $('#excaQuantityReportBtn').on('click',function(e){
        e.preventDefault();

        if(validateExcavatorQtyRep())
        {
            $('#loader').show();
            var formDataserialize = $("#ExcavatorWiseQuantityReport").serialize();
            var urlpath = basepath + 'excavatorreport/excavatorWiseQuantityReport';
             $("#excaQtyReportView").html('');
            $.ajax({        
                type: "POST",
                url: urlpath,
                data:formDataserialize,
                dataType: "html",            
                success: function(result) {
                    $('#loader').hide();  
                    $("#excaQtyReportView").html(result);

                var Project = $("#tripReportProject").val();

                    $('#excavatorreport').DataTable({
                        "dom": 'Bfrtip',
                         "paging": false,
                         "autoWidth": true,
                         "targets": 'no-sort',
                        "bSort": false,
                        "order": [],

                        // "buttons": [
                        //     'csv', 'excel', 'pdf', 'print'
                        // ]
                        buttons: [{
                            extend: 'pdf',
                            title: Project
                          }, {
                            extend: 'excel',
                            title: Project
                          }, {
                            extend: 'csv'
                          },{
                            extend: 'print',
                            title: Project
                          }]
                    });
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



/*======================================================================================*/
/*-------------------------- Tripper Wise Trip Report  ------------------------------*/
/*----------------------------- 30.04.2019 by Shankha  -------------------------------*/
/*===================================================================================*/


    $('#tipperReportBtn').on('click',function(e){
        e.preventDefault();

        if(validateTripperRep())
        {
            $('#loader').show();
            var formDataserialize = $("#TipperWiseReport").serialize();
            var urlpath = basepath + 'tipperreport/tipperWisereport';
             $("#tipperwiseReportView").html('');
            $.ajax({        
                type: "POST",
                url: urlpath,
                data:formDataserialize,
                dataType: "html",            
                success: function(result) {
                    $('#loader').hide();  
                    $("#tipperwiseReportView").html(result);

                var Project = $("#tripReportProject").val();

                    $('#tipperreport').DataTable({
                        "dom": 'Bfrtip',
                         "paging": false,
                         "autoWidth": true,
                         "targets": 'no-sort',
                        "bSort": false,
                        "order": [],

                        // "buttons": [
                        //     'csv', 'excel', 'pdf', 'print'
                        // ]
                        buttons: [{
                            extend: 'pdf',
                            title: Project
                          }, {
                            extend: 'excel',
                            title: Project
                          }, {
                            extend: 'csv'
                          },{
                            extend: 'print',
                            title: Project
                          }]
                    });
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





/*========================================================================================*/
/*-------------------------- Tripper Wise Quantity Report  ------------------------------*/
/*----------------------------- 01.05.2019 by Shankha  -------------------------------*/
/*===================================================================================*/


    $('#tipperQuantityReportBtn').on('click',function(e){
        e.preventDefault();

        if(validateTripperQtyRep())
        {
            $('#loader').show();
            var formDataserialize = $("#TipperWiseQuantityReport").serialize();
            var urlpath = basepath + 'tipperreport/tipperWiseQuantityreport';
             $("#tipperQtyReportView").html('');
            $.ajax({        
                type: "POST",
                url: urlpath,
                data:formDataserialize,
                dataType: "html",            
                success: function(result) {
                    $('#loader').hide();  
                    $("#tipperQtyReportView").html(result);

                var Project = $("#tripReportProject").val();

                    $('#tipperreport').DataTable({
                        "dom": 'Bfrtip',
                         "paging": false,
                         "autoWidth": true,
                         "targets": 'no-sort',
                        "bSort": false,
                        "order": [],

                        // "buttons": [
                        //     'csv', 'excel', 'pdf', 'print'
                        // ]
                        buttons: [{
                            extend: 'pdf',
                            title: Project
                          }, {
                            extend: 'excel',
                            title: Project
                          }, {
                            extend: 'csv'
                          },{
                            extend: 'print',
                            title: Project
                          }]
                    });
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









/*.....................................................*/
});/* document ready end */


function validate()
{
    $("#error_msg").text("").css("dispaly", "none").removeClass("form_error");
    var frmdt=$('#fromDate').val().replace('/', '-');
    var todt=$('#toDate').val().replace('/', '-');
    //alert(frmdt);
    if(frmdt > todt)
    {
        $("#fromDate").focus();
        $("#error_msg")
        .text("Error : From Date Cannot be greater than To Date")
        .addClass("form_error")
        .css("display", "block");
        return false;

    }    
    return true;
}


function validateQuantity()
{ 
    $("#error_msg").text("").css("dispaly", "none").removeClass("form_error");
    var projectid=$('#project').val();
    var frmdt=$('#fromDate').val().replace('/', '-');
    var todt=$('#toDate').val().replace('/', '-');
    //alert(frmdt);


    // if(frmdt > todt)
    // {
    //     $("#fromDate").focus();
    //     $("#error_msg")
    //     .text("Error : From Date Cannot be greater than To Date")
    //     .addClass("form_error")
    //     .css("display", "block");
    //     return false;

    // }

    if(projectid=='0')
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


function validateExcavatorRep()
{ 
    $("#error_msg").text("").css("dispaly", "none").removeClass("form_error");
    var projectid=$('#project').val();
    var frmdt=$('#fromDate').val().replace('/', '-');
    var todt=$('#toDate').val().replace('/', '-');
    //alert(frmdt);


    // if(frmdt > todt)
    // {
    //     $("#fromDate").focus();
    //     $("#error_msg")
    //     .text("Error : From Date Cannot be greater than To Date")
    //     .addClass("form_error")
    //     .css("display", "block");
    //     return false;

    // }

    if(projectid=='0')
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


function validateExcavatorQtyRep()
{ 
    $("#error_msg").text("").css("dispaly", "none").removeClass("form_error");
    var projectid=$('#project').val();
    var frmdt=$('#fromDate').val().replace('/', '-');
    var todt=$('#toDate').val().replace('/', '-');
    //alert(frmdt);


    // if(frmdt > todt)
    // {
    //     $("#fromDate").focus();
    //     $("#error_msg")
    //     .text("Error : From Date Cannot be greater than To Date")
    //     .addClass("form_error")
    //     .css("display", "block");
    //     return false;

    // }

    if(projectid=='0')
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



function validateTripperRep()
{ 
    $("#error_msg").text("").css("dispaly", "none").removeClass("form_error");
    var projectid=$('#project').val();
    var frmdt=$('#fromDate').val().replace('/', '-');
    var todt=$('#toDate').val().replace('/', '-');
    //alert(frmdt);


    // if(frmdt > todt)
    // {
    //     $("#fromDate").focus();
    //     $("#error_msg")
    //     .text("Error : From Date Cannot be greater than To Date")
    //     .addClass("form_error")
    //     .css("display", "block");
    //     return false;

    // }

    if(projectid=='0')
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



function validateTripperQtyRep()
{ 
    $("#error_msg").text("").css("dispaly", "none").removeClass("form_error");
    var projectid=$('#project').val();
    var frmdt=$('#fromDate').val().replace('/', '-');
    var todt=$('#toDate').val().replace('/', '-');
    //alert(frmdt);


    // if(frmdt > todt)
    // {
    //     $("#fromDate").focus();
    //     $("#error_msg")
    //     .text("Error : From Date Cannot be greater than To Date")
    //     .addClass("form_error")
    //     .css("display", "block");
    //     return false;

    // }

    if(projectid=='0')
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


  var _customizeExcelOptions = function (xlsx) {
                var sheet = xlsx.xl.worksheets['sheet1.xml'];
                var numrows = 3;
                var clR = $('row', sheet);

                //update Row
                clR.each(function () {
                    var attr = $(this).attr('r');
                    var ind = parseInt(attr);
                    ind = ind + numrows;
                    $(this).attr("r",ind);
                });

                // Create row before data
                $('row c ', sheet).each(function () {
                    var attr = $(this).attr('r');
                    var pre = attr.substring(0, 1);
                    var ind = parseInt(attr.substring(1, attr.length));
                    ind = ind + numrows;
                    $(this).attr("r", pre + ind);
                });

                function Addrow(index,data) {
                    msg='<row r="'+index+'">'
                    for(i=0;i<data.length;i++){
                        var key=data[i].key;
                        var value=data[i].value;
                        msg += '<c t="inlineStr" r="' + key + index + '">';
                        msg += '<is>';
                        msg +=  '<t>'+value+'</t>';
                        msg+=  '</is>';
                        msg+='</c>';
                    }
                    msg += '</row>';
                    return msg;
                }


                //insert
                var r1 = Addrow(1, [{ key: 'A', value: '' }, { key: 'B', value: '' }]);
                var r2 = Addrow(2, [{ key: 'A', value: '' }, { key: 'B', value: '' }]);
                var r3 = Addrow(3, [{ key: 'A', value: '' }, { key: 'B', value: '' }]);

                sheet.childNodes[0].childNodes[1].innerHTML = r1 + r2+ r3+ sheet.childNodes[0].childNodes[1].innerHTML;
            }