
function send(id)
      {

       /* var url = 'servicer-job-complete';*/
       var url = 'servicer-job-complete';
     
        var comment = document.getElementById('comment').value;
     var data = {  'comment':comment,'id':id
     
     };


      backgroundPostData(url,data,'jobsComplete',{alert:true});
      }

      function jobsComplete(){
      		alert('Job Completed Successfully');
             window.location.href = "/service-job-list";
      }