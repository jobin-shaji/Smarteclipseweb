 function searchData(){
    
     if(imei == ''){
        alert('please enter imei');
    }
    else{    

    // var url = '/device-reassign';
      var imei = document.getElementById('imei').value;
      var data = {
          'imei':imei
      };
      callBackDataTable(data);
    }
  }
  function callBackDataTable(data=null){   

  // console.log(data); 
    $("#dataTable").DataTable({
        bStateSave: true,
        bDestroy: true,
        bProcessing: true,
        serverSide: true,
        deferRender: true,
        order: [[1, 'desc']],
        ajax: {
            url: 'device-reassign',
            type: 'POST',
             data:data,
            headers: {
                'X-CSRF-Token': $('meta[name = "csrf-token"]').attr('content')
            }
        },
       
        fnDrawCallback: function (oSettings, json) {

        },
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
            {data: 'name', name: 'name'},
            {data: 'register_number', name: 'register_number'} ,
            // {data: 'gps.imei', name: 'gps.imei'} ,    
            {data: 'action', name: 'action', orderable: false, searchable: false},       
        ],
        
        // aLengthMenu: [[25, 50, 100, -1], [25, 50, 100, 'All']]
    });
}