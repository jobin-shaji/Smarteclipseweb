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
            url: 'traffic-rule-list',
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
                $('td', row).css('background-color', 'rgb(243, 204, 204)');
            }
        },
       
        fnDrawCallback: function (oSettings, json) {

        },
        columns: [
            {data: 'DT_RowIndex', name: 'DT_Row_Index', orderable: false, searchable: false},
            {data: 'speed', name: 'speed'},
            {data: 'state.name', name: 'state.name'},
            {data: 'country.name', name: 'country.name'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ],
        
        aLengthMenu: [[25, 50, 100, -1], [25, 50, 100, 'All']]
    });
}

function deleteTrafficRule(id){
    var url = 'traffic-rule/delete';
    var data = {
        id : id
    };
    backgroundPostData(url,data,'callBackDataTables',{alert:true});  
}

function activateTrafficRule(id){
    var url = 'traffic-rule/activate';
    var data = {
        id : id
    };
    backgroundPostData(url,data,'callBackDataTables',{alert:true});  
}



