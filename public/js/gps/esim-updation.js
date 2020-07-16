$(document).ready(function() {
    $('.action-items,.refresh,.loader').hide();
    $('.upload_xl,.browse').show();
    $('#existing_color').hide();
    
});
    var  esim_upload_flag =1;
    var check_box = '';

    var uploadedFileContentsRaw         = null;         // raw file contents
    var uploadedFileContentsProcessed   = [];           // file contents as array
    var filteredFileContents            = null;         // based on user conditions
    var userSelectedItems               = [];           // IMSI numbers
    var uploadedFileTypes               = /^([a-zA-Z0-9\s_\\.\-:])+(.xls|.xlsx|.csv)$/;

    /**
     * 
     * 
     * 
     */
    function uploadFile()
    {
        var uploadedContent = document.getElementById("fileUpload");
        var file_name=uploadedContent.files[0].name;
        $.ajax({
            type:'POST',
            url: "esim-activation-file",
            data: { file_name:file_name},
            async: true,
            headers: {
                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (res) 
            {
                if(jQuery.parseJSON(res)==false)
                {
                    if(confirm('Already added file.Do you want to replace it')){
                        $(this).find('button[type="submit"]').prop( 'disabled', true );
                        uploadNewFile();
                    }
                    else{
                        refreshPage();
                    }

                }
                else
                {
                    uploadNewFile();
                }

            }
        });        
    }

    function refreshPage(){
        window.location.reload();
    } 

    $('#checkAll').click(function() 
    {
        userSelectedItems = [];
        if ($(this).prop('checked')) 
        {
            $('.check_uncheck').prop('checked', true);
            document.getElementById("check_uncheck_label").innerHTML = "Uncheck All";
            for (var i = 0; i < uploadedFileContentsProcessed.length; i++)
            {
                userSelectedItems.push(i);
            }
            
        } else {
            $('.check_uncheck').prop('checked', false);
            document.getElementById("check_uncheck_label").innerHTML = "Check All";
        }
    });
    /**
     * 
     * 
     */
    function processRawUploadedFileContents()
    {
      
        var workbook = XLSX.read(uploadedFileContentsRaw, {
            type: 'binary'
        });

        var sheetName   = workbook.SheetNames[0];
        var filename    = document.getElementById("fileUpload").files[0].name;
        // read all rows from first sheet into an JSON array.
        var excelRows = XLSX.utils.sheet_to_row_object_array(workbook.Sheets[sheetName]);
        // console.log(excelRows[0]["MSISDN"]);
        if((excelRows[0]["IMSI"]!= undefined )&& (excelRows[0]["MSISDN"]!= undefined) && ( excelRows[0]["Business Unit Name"] != undefined) && (excelRows[0]["Product Status"] != undefined) && (excelRows[0]["Product Type"] != undefined) && (excelRows[0]["PUK1"] != undefined) && (excelRows[0]["ICCID"]!= undefined))
        {
            for (var i = 0; i < excelRows.length; i++)
            {
                uploadedFileContentsProcessed.push({
                    'imsi'                  : excelRows[i]["IMSI"],
                    'msisdn'                : excelRows[i]["MSISDN"],
                    'business_unit_name'    : excelRows[i]["Business Unit Name"],
                    'product_status'        : excelRows[i]["Product Status"],
                    'product_type'          : excelRows[i]["Product Type"],
                    'puk'                   : excelRows[i]["PUK1"],
                    'iccid'                 : excelRows[i]["ICCID"],
                    'activation_date'       : (typeof excelRows[i]["Activation Date"] != 'undefined') ? excelRows[i]["Activation Date"] : ''
                });
            }
        }
        else
        {
            alert("Please Check the file");
            refreshPage();
        }
        $('#file_name').text('File:- '+filename);
    }

    /**
     * 
     * 
     * 
     */
    function listUploadedFileContents()
    {
        userSelectedItems  = [];
        $('.loader').hide();
        $('#checkAll').prop('checked', true);
        document.getElementById("check_uncheck_label").innerHTML = "Uncheck All";
        $("#uploaded-excel-details").html('');
        // alert(uploadedFileContentsProcessed.length);
        for (var i = 0; i < uploadedFileContentsProcessed.length; i++)
        {
            $("#uploaded-excel-details").append('<tr class = "text-center" id="checkbox-'+i+'"><td><input onclick="checkboxClicked('+i+')" type="checkbox" name="checkbox[]" class="check_uncheck" checked id="checkbox'+i+'" value="'+i+'"></td>'+ 
            '<td><label>'+uploadedFileContentsProcessed[i]["imsi"]+'</label></td>'+
            '<td><label>'+uploadedFileContentsProcessed[i]["msisdn"]+'</label></td>'+
            '<td><label>'+uploadedFileContentsProcessed[i]["iccid"]+'</label></td>'+
            '<td><label>'+uploadedFileContentsProcessed[i]["puk"]+'</label></td>'+
            '<td><label>'+uploadedFileContentsProcessed[i]["business_unit_name"]+'</label></td>'+
            '<td><label>'+uploadedFileContentsProcessed[i]["product_status"]+'</label></td>'+
            // '<td><label>'+uploadedFileContentsProcessed[i]["product_type"]+'</label></td>'+
            '<td><label>'+uploadedFileContentsProcessed[i]["activation_date"]+'</label></td>'+
            '</tr>');
            // items to update on database
            userSelectedItems.push(i);
            
        }
        $('#file_rows').text('Total no of rows uploaded:- '+uploadedFileContentsProcessed.length);
        // manage action items
        manageActionItems();

    }

    /**
     * 
     * 
     */
    function manageActionItems()
    {
        (userSelectedItems.length > 0) ? $('.action-items').show() : $('.action-items').hide();
    }

    /**
     * 
     * 
     * 
     */
    function checkboxClicked(clickedItemIndex)
    {
        if( $('#checkbox'+clickedItemIndex).is(':checked') )
        {
            userSelectedItems.push(clickedItemIndex);
            if(userSelectedItems.length == uploadedFileContentsProcessed.length)
            {
                $('#checkAll').prop('checked', true);
                document.getElementById("check_uncheck_label").innerHTML = "Uncheck All";
            }
        }
        else
        {
            userSelectedItems.splice(userSelectedItems.indexOf(clickedItemIndex), 1);
            $('#checkAll').prop('checked', false);
            document.getElementById("check_uncheck_label").innerHTML = "Check All";
        }
        // manageActionItems();
    }

    /**
     * 
     * 
     * 
     */
    function removeSelectedRows()
    {
        if( userSelectedItems.length == 0 )
        {
            alert('Please select a row to remove');
            return false;
        }
        else
        {
            if(!confirm('Do you want to remove selected items?'))
                return false;
            userSelectedItems.sort()           
            for(index = userSelectedItems.length - 1  ; index >= 0 ; index--)
            {
                uploadedFileContentsProcessed.splice(userSelectedItems[index], userSelectedItems.length );
            }
            listUploadedFileContents();
        }
    }

    /**
     * 
     * 
     */
    function filterUploadedFileContents()
    {

    }

    /**
     * 
     * 
     */
    function removeUncheckedFileContentsProcessed()
    {
        var checkedFileContent = []; 
        for(index = 0   ; index < userSelectedItems.length ; index++)
        {
            checkedFileContent.push(uploadedFileContentsProcessed[userSelectedItems[index]]);
        }
        return checkedFileContent;
    }

    /**
     * 
     * 
     * 
     */
    function updateEsimNumbersToDatabase()
    {        
        if(esim_upload_flag==1)
        {
            $('.loader').show();
            $('#esim_update').hide();
            $.ajax({
                type:'POST',
                url: "compare-esim-numbers",
                data: {selected_items: JSON.stringify(removeUncheckedFileContentsProcessed()) },
                async: true,
                headers: {
                    'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (res) 
                {
                    userSelectedItems  = [];
                    $('.loader').hide();
                    $('#esim_update').show();
                    $('#checkAll').prop('checked', true);
                    document.getElementById("check_uncheck_label").innerHTML = "Uncheck All";
                    $("#uploaded-excel-details").html('');
                    for (var i = 0; i < res.data.length; i++)
                    {
                        if(res.data[i].status==true)
                        {
                            color="#EB8B8B";
                        }
                        else{
                            color=""; 
                        } 
                        $("#uploaded-excel-details").append('<tr class = "text-center"  style="background-color:'+color+'" id="checkbox-'+i+'"><td><input onclick="checkboxClicked('+i+')" type="checkbox" name="checkbox[]" class="check_uncheck" checked id="checkbox'+i+'" value="'+i+'"></td>'+ 
                        '<td><label>'+res.data[i]["imsi"]+'</label></td>'+
                        '<td><label>'+res.data[i]["msisdn"]+'</label></td>'+
                        '<td><label>'+res.data[i]["iccid"]+'</label></td>'+
                        '<td><label>'+res.data[i]["puk"]+'</label></td>'+
                        '<td><label>'+res.data[i]["business_unit_name"]+'</label></td>'+
                        '<td><label>'+res.data[i]["product_status"]+'</label></td>'+
                        '<td><label>'+res.data[i]["activated_on"]+'</label></td>'+
                        '</tr>');
                        userSelectedItems.push(i);                        
                    }
                    $('#exist_count').text('Exist esim count:- '+res.exist);
                    $('#new_count').text('New esim Count:- '+res.new);
                    $('#existing_color').show();


                    esim_upload_flag=2;                                
                }
            });
        }
        else{
            updateEsim(); 
        }
             
    }
    function updateEsim()
    {
            $('.loader').show();
            $('#esim_update').hide();
        if( userSelectedItems.length == 0 )
            {
                alert('Please choose at least one row to update');
                return false;
            }
            else
            {
                $('.action-items').hide();
                $('.loader').show();
                $.ajax({
                    type:'POST',
                    url: "update-esim-numbers",
                    data: {selected_items: JSON.stringify(removeUncheckedFileContentsProcessed()) },
                    async: true,
                    headers: {
                        'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (res) 
                    {
                        $('.loader').hide();
                        $('#esim_update').show();
                        alert('Success Count -'+ res.success.length + ' Failed Count -'+  res.failed.length);
                        refreshPage();
                    
                    }
    
                });
            }  
    }

    function uploadNewFile()
    {
        var uploadedContent = document.getElementById("fileUpload");
         if (uploadedFileTypes.test(uploadedContent.value.toLowerCase()))
         {
             $('.loader').show();
             if (typeof (FileReader) != "undefined")
             {
                 var reader = new FileReader();
                 if (reader.readAsBinaryString)
                 {
                     reader.onload = function (e) {
                         uploadedFileContentsRaw = e.target.result;
                        
                         // process and list file contents
                         processRawUploadedFileContents();
                         listUploadedFileContents();
                     };
                    //  console.log(reader.readAsBinaryString(uploadedContent));
                     reader.readAsBinaryString(uploadedContent.files[0]);
                 } 
                 else 
                 {
                     reader.onload = function (e) {
                         var data    = "";
                         var bytes   = new Uint8Array(e.target.result);
                         for (var i = 0; i < bytes.byteLength; i++) 
                         {
                             data += String.fromCharCode(bytes[i]);
                         }
                         uploadedFileContentsRaw = data;
                         // process and list file contents
                         processRawUploadedFileContents();
                         listUploadedFileContents();
                     };
                     reader.readAsArrayBuffer(uploadedContent.files[0]);
                 }
                 
             } else {
                 alert("This browser does not support HTML5.");
             }
         } else {
             alert("Please upload a valid Excel file.");
         }
         $('.upload_xl,.browse').hide();
         $('.refresh').show();


























        
    }

    // function Upload() {
    //     //Reference the FileUpload element.
    //     var fileUpload = document.getElementById("fileUpload");      
    //     //Validate whether File is valid Excel file.
    //     var regex = /^([a-zA-Z0-9\s_\\.\-:])+(.xls|.xlsx|.csv)$/;
    //     if (regex.test(fileUpload.value.toLowerCase())) {
    //         if (typeof (FileReader) != "undefined") {
    //             var reader = new FileReader();
    //             //For Browsers other than IE.
    //             if (reader.readAsBinaryString) {
    //                 reader.onload = function (e) {
    //                     ProcessExcel(e.target.result);
    //                 };
    //                 reader.readAsBinaryString(fileUpload.files[0]);
    //             } else {
    //                 //For IE Browser.
    //                 reader.onload = function (e) {
    //                     var data = "";
    //                     var bytes = new Uint8Array(e.target.result);
    //                     for (var i = 0; i < bytes.byteLength; i++) {
    //                         data += String.fromCharCode(bytes[i]);
    //                     }
    //                     ProcessExcel(data);
    //                 };
    //                 reader.readAsArrayBuffer(fileUpload.files[0]);
    //             }
    //         } else {
    //             alert("This browser does not support HTML5.");
    //         }
    //     } else {
    //         alert("Please upload a valid Excel file.");
    //     }
    // };
    // function ProcessExcel(data) {    
    //     //Read the Excel File data.
    //     var workbook = XLSX.read(data, {
    //         type: 'binary'
    //     });
    //     //Fetch the name of First Sheet.
    //     var firstSheet = workbook.SheetNames[0];
    //     var filename = document.getElementById("fileUpload").files[0].name;
       
    //     //Read all rows from First Sheet into an JSON array.
    //     var excelRows = XLSX.utils.sheet_to_row_object_array(workbook.Sheets[firstSheet]);
    //     console.log(excelRows);
    //     for (var i = 0; i < excelRows.length; i++) {
    //         var j=i+1;

    //         var activationDate = (typeof excelRows[i]["Activation Date"] != 'undefined') ? excelRows[i]["Activation Date"] : '';
    //         var excel = '<tr id="check'+i+'"><td><input onclick="show_button()" type="checkbox" name="checkbox[]" id="checkbox'+i+'" value="'+i+'"></td>'+ 
    //         '<td><label  name="imsi[]" id="imsi'+i+'" >'+excelRows[i]["IMSI"]+'</label></td>'+
    //         '<td><label  name="msisdn[]" id="msisdn'+i+'" >'+excelRows[i]["MSISDN"]+'</label></td>'+
    //         '<td><label  >'+excelRows[i]["Business Unit Name"]+'</label></td>'+
    //         '<td><label  >'+excelRows[i]["Product Status"]+'</label></td>'+
    //         '<td><label  >'+activationDate+'</label></td>'+
    //         '</tr>';
    //         $("#uploaded-excel-details").append(excel);
            
    //     }
        
    //     $('table').show();
    //     $('#file_name').text(filename+',total no of rows uploaded :'+excelRows.length);
    // };
    // function show_button()
    // {
    //     var hidecheck = $('input[type=checkbox]').is(':checked');
    //     if(hidecheck == true)
    //     {
    //         document.getElementById("deletebutton").style.display = "block"; 
    //     }
    //     else
    //     {
    //         document.getElementById("deletebutton").style.display = "none";
    //     }

    // }
    // function deletedata(){
       
    //     var checkArray = new Array(); 
    //     arrays=[];
    //     $('input[type=checkbox]').each(function () {
    //         checkArray.push($(this).is(':checked'));
    //         for(var i=0;i<=checkArray.length;i++){
    //             if(checkArray[i] === true)
    //             {
    //                 $('#check'+i).remove();
    //             }
    //         }
    //     });

    // }