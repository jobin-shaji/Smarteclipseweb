$(document).ready(function() {
    $('table').hide();
    // document.getElementById("deletebutton").style.display = "none"; 
});
var check_box = '';
    function Upload() {
        //Reference the FileUpload element.
        var fileUpload = document.getElementById("fileUpload");      
        //Validate whether File is valid Excel file.
        var regex = /^([a-zA-Z0-9\s_\\.\-:])+(.xls|.xlsx|.csv)$/;
        if (regex.test(fileUpload.value.toLowerCase())) {
            if (typeof (FileReader) != "undefined") {
                var reader = new FileReader();
                //For Browsers other than IE.
                if (reader.readAsBinaryString) {
                    reader.onload = function (e) {
                        ProcessExcel(e.target.result);
                    };
                    reader.readAsBinaryString(fileUpload.files[0]);
                } else {
                    //For IE Browser.
                    reader.onload = function (e) {
                        var data = "";
                        var bytes = new Uint8Array(e.target.result);
                        for (var i = 0; i < bytes.byteLength; i++) {
                            data += String.fromCharCode(bytes[i]);
                        }
                        ProcessExcel(data);
                    };
                    reader.readAsArrayBuffer(fileUpload.files[0]);
                }
            } else {
                alert("This browser does not support HTML5.");
            }
        } else {
            alert("Please upload a valid Excel file.");
        }
    };
    function ProcessExcel(data) {    
        //Read the Excel File data.
        var workbook = XLSX.read(data, {
            type: 'binary'
        });
        //Fetch the name of First Sheet.
        var firstSheet = workbook.SheetNames[0];
        var filename = document.getElementById("fileUpload").files[0].name;
       
        //Read all rows from First Sheet into an JSON array.
        var excelRows = XLSX.utils.sheet_to_row_object_array(workbook.Sheets[firstSheet]);
        for (var i = 0; i < excelRows.length; i++) {
            var j=i+1;
            var excel = '<tr><td><input type="checkbox" name="checkbox[]" id="checkbox'+i+'" value="'+i+'"></td>'+ 
            '<td><label  name="imsi[]" id="imsi'+i+'" >'+excelRows[i]["IMSI"]+'</label></td>'+
            '<td><label  name="msisdn[]" id="msisdn'+i+'" >'+excelRows[i]["MSISDN"]+'</label></td>'+
                
            '</tr>';
            $("#dvExcel").append(excel);
            
        }
        // var checkboxes = document.getElementsByName("checkbox");
        //     if(checkboxes.checked == true)
        //     {
        //         check_box = true;
        //     }
       
        $('table').show();
        $('#file_name').text(filename+',total no of rows uploaded :'+excelRows.length);
    };
    
    function deletedata(){
       
        var checkArray = new Array(); 
        arrays=[];
        $('input[type=checkbox]').each(function () {
            checkArray.push($(this).is(':checked'));
           if(checkArray){
            arrays[]= $(this).val();
           }
            // this.checked ? checkArray.push("1") : checkArray.push("0");
        });
//         var checkArray = [];

// $('input.publish').each(function () {
//    checkArray.push($(this).is(':checked'));
// });


alert(arrays);
    }