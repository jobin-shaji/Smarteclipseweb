$(document).ready(function () {
    callBackDataTable();
});


function callBackDataTable(){
    var  data = {
    
    }; 

    $("#dataTable").DataTable({
        bStateSave: true,
        bDestroy: true,
        bProcessing: true,
        serverSide: true,
        deferRender: true,
        order: [[1, 'desc']],
        ajax: {
            url: 'gps-new-list',
            type: 'POST',
            data: {
                'data': data
            },
            headers: {
                'X-CSRF-Token': $('meta[name = "csrf-token"]').attr('content')
            }
        },
        createdRow: function ( row, data, index ) {
            if ( data['accepted_on'] ) {
                $('td', row).css('background-color', 'rgb(210, 239, 203)');
            }
        },
       
        fnDrawCallback: function (oSettings, json) {

        },
        columns: [
            {data: 'DT_RowIndex', name: 'DT_Row_Index', orderable: false, searchable: false},
            {data: 'from_user.username', name: 'from_user.username', searchable: false},
            {data: 'dispatched_on', name: 'dispatched_on'},
            {data: 'action', name: 'action', orderable: false, searchable: false}
        ],
        
        aLengthMenu: [[25, 50, 100, -1], [25, 50, 100, 'All']]
    });
}

function acceptGpsTransfer(gps_transfer_id){
    if(confirm('Are you sure want to accept this?')){
        var url = 'gps-transfer/accept';
        var data = {
            id : gps_transfer_id
        };
        backgroundPostData(url,data,'callBackDataTables',{alert:true});  
    }
}




