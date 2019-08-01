function createDriver(res){
    var mobile = document.getElementById("mobile").value;
    var phoneno = /^\d{10}$/;
    if(document.getElementById('driver_name').value == ''){
        alert('please enter name');
    }
    else if(document.getElementById('mobile').value == '' ){
        alert('please select mobile');
    }
    else if(document.getElementById('address').value == ''){
        alert('please enter address');
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
            backgroundPostData(url,data,'servicerDriver',{alert:false});  
        }
        else
        {           
            alert("Mobile number should be number");
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
    $('#myModal').modal('hide'); 
}



