function createDriver(res){
    var mobile = document.getElementById("mobile").value;
    var phoneno = /^\d{10}$/;
    if(document.getElementById('driver_name').value == ''){
         alert("please enter name");
        // alertify.confirm('please enter name', function(){ alertify.success('Ok') });
        // var closable = alertify.alert().setting('closable');
        // alertify.alert()
        // .setting({'label':'OK','message': 'Please enter name'}).show();
    }
    else if(document.getElementById('mobile').value == '' ){
        alert("please enter mobile number");
        //  var closable = alertify.alert().setting('closable');
        // alertify.alert()
        // .setting({'label':'OK','message': 'Please enter mobile number'}).show();
        
    }
    else if(document.getElementById('address').value == ''){
         alert("please enter Address ");
        // var closable = alertify.alert().setting('closable');
        // alertify.alert()
        // .setting({'label':'OK','message': 'please enter address'}).show();    
   
    }
     else{
        if(mobile.match(phoneno))
        {
            var driver_name=$('#driver_name').val();
            var mobile=$('#mobile').val();
            var address=$('#address').val();
            var client_id=$('#client_id').val(); 
            // alert(res);
            var url = 'servicer-driver-create';
            var data = {
                 servicer_job_id : res,
                 driver_name : driver_name,
                 mobile : mobile,
                 address : address,
                 client_id : client_id 
            };   
            backgroundPostData(url,data,'servicerDriver',{alert:true});  
        }
        else
        { 
            // var closable = alertify.alert().setting('closable');
            // alertify.alert()
            // .setting({'label':'OK','message': 'Mobile should be number'}).show();              
            alert("Please enter proper mobile number");
        // return false;
        }    
    }          
}
function servicerDriver(res)
{     
    var driver_id=res.driver_id;
    var driver_name=res.driver_name;
    var driver='  <option value="'+driver_id+'"  >'+driver_name+'</option>';  
    $("#driver").append(driver);  
    $("#driver").val(driver_id);
    $("#driver_name").val("");
    $("#mobile").val("");
    $("#address").val("");
    $('#myModal').modal('hide'); 
}



