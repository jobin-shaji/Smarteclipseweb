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
            url: 'gps-transfer-list-dealer',
            type: 'POST',
            data: {
                'data': data
            },
            headers: {
                'X-CSRF-Token': $('meta[name = "csrf-token"]').attr('content')
            }
        },
        createdRow: function ( row, data, index ) {
            if ( data['deleted_at'] ) {
                $('td', row).css('background-color', 'rgb(178, 178, 178)');
            }
            else if ( data['accepted_on'] ) {
                $('td', row).css('background-color', 'rgb(210, 239, 203)');
            }

        },
       
        fnDrawCallback: function (oSettings, json) {

        },
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', searchable: false},
            {data: 'from_user.username', name: 'from_user.username', orderable: false},
            {data: 'to_user.username', name: 'to_user.username', orderable: false},
            {data: 'dispatched_on', name: 'dispatched_on', orderable: false},
            {data: 'count', name: 'count'},
            {data: 'action', name: 'action', orderable: false, searchable: false}
            ],
        
        aLengthMenu: [[25, 50, 100, -1], [25, 50, 100, 'All']]
    });
}

function cancelDealerGpsTransfer(gps_transfer_id){
    if(confirm('Are you sure to cancel this?')){
        var url = 'gps-transfer-dealer/cancel';
        var data = {
            id : gps_transfer_id
        };
        backgroundPostData(url,data,'callBackDataTables',{alert:true}); 
    } 
}