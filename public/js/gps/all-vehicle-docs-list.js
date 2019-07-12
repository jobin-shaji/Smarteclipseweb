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
            {data: 'DT_RowIndex', name: 'DT_Row_Index', orderable: false, searchable: false},
            {data: 'document_type.name', name: 'document_type.name'},
            {data: 'vehicle.name', name: 'vehicle.name'},
            {data: 'vehicle.register_number', name: 'vehicle.register_number'},
            {data: 'expiry_date', name: 'expiry_date'},
            {data: 'status', name: 'status'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ],
        
        aLengthMenu: [[25, 50, 100, -1], [25, 50, 100, 'All']]
    });
 }







