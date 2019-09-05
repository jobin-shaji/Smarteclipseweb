

 $(document).ready(function(){
    	callBackDataTable();

        $('.branch_check_box input[type="checkbox"]').click(function(){
        	 var $box = $(this);
             var group = ".branch_check_box input:checkbox[name='" + $box.attr("name") + "']";
             $(group).prop("checked", false);
              $box.prop("checked", true);

            if($(this).prop("checked") == true){

               var batch=this.value;
               var selected_studets=[];
			    var data={ batch : batch };
			    if(batch) {
			      $.ajax({
			        type:'POST',
			        url: '/student/get-studen-from-batch',
			        data:data ,
			        async: true,
			        headers: {
			          'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
			        },
			        success:function(data) {
			        if(data){
			         $("#students_data").val(data.studets).trigger('change'); 
			        }
			       }
			      });
			    } 
            }else if($(this).prop("checked") == false){
                var unchecked_branch=this.value;
               $("#students_data").val('').trigger("change");
            }
        });
    });

 function callBackDataTable(data=null){
    // var  data = {
    
    // }; 

    $("#dataTable").DataTable({
        bStateSave: true,
        bDestroy: true,
        bProcessing: true,
        serverSide: true,
        deferRender: true,
        order: [[1, 'desc']],
        ajax: {
            url: 'student-notification/list',
            type: 'POST',
            data:data,
            headers: {
                'X-CSRF-Token': $('meta[name = "csrf-token"]').attr('content')
            }
        },
       
        fnDrawCallback: function (oSettings, json) {

        },
        columns: [
            {data: 'DT_RowIndex', name: 'DT_Row_Index', orderable: false, searchable: false},
            {data: 'mobile', name: 'mobile'},
            {data: 'message', name: 'message'},
            {data: 'date', name: 'date'}         
        ],
        aLengthMenu: [[25, 50, 100, -1], [25, 50, 100, 'All']]
    });
}