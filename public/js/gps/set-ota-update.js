$('#gps_id').change(function(){
    var url = 'select-ota-params';
    var gps_id=this.value;
  var data = {
  				gps_id:gps_id
  			 };
  backgroundPostData(url, data, 'setOtaParams', {
    alert: false
   });

});  

function setOtaParams(res){
	if(res.status==1){
		
	}
}