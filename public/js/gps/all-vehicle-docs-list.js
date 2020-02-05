$(document).ready(function () {
    callBackDataTable();
});

function check(){
 
    if(document.getElementById('vehicle').value == ''){
        alert('Please select vehicle');
    }else if(document.getElementById('status').value == ''){
        alert('Please select status');
    }else{
        var vehicle_id=$('#vehicle').val(); 
        var status=$('#status').val();      
        var client=$('meta[name = "client"]').attr('content');
        var data = {'vehicle_id':vehicle_id,'status':status,'client':client};
        callBackDataTable(data);        
    }
}

// function deleteAlert()
// {
    

//       alertify.confirm("Do you want to delete.",
//       function(){
//         alertify.success('Yes');
//         return true;
//       },
//       function(){
//         alertify.error('No');
//         return false;
//       });
//       return false;
// }

function callBackDataTable(data=null){

    $("#dataTable").DataTable({
        bStateSave: true,
        bDestroy: true,
        bProcessing: true,
        serverSide: true,
        deferRender: true,
        order: [[1, 'desc']],
        ajax: {
            url: 'all-vehicle-docs-list',
            type: 'POST',
            data: data,
            headers: {
                'X-CSRF-Token': $('meta[name = "csrf-token"]').attr('content')
            }
        },
        fnDrawCallback: function (oSettings, json) {

        },
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
            {data: 'document_type.name', name: 'document_type.name'},
            {data: 'vehicle.name', name: 'vehicle.name'},
            {data: 'vehicle.register_number', name: 'vehicle.register_number'},
            {data: 'updated_expiry_date', name: 'updated_expiry_date'},
            {data: 'status', name: 'status'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ],
        
        aLengthMenu: [[25, 50, 100, -1], [25, 50, 100, 'All']]
    });
}

function deleteDocumentFromAllDocumentList(doc_id){
    if(confirm('Are you sure to delete this document?')){
        var url = 'all-vehicle-doc/delete';
        var data = {
            id : doc_id
        };
        backgroundPostData(url,data,'callBackDataTables',{alert:true});  
    }
}







